<?php

declare(strict_types=1);

namespace OCP\EventDispatcher {
    class Event { public function __construct() {} }
    interface IEventListener { public function handle(Event $event): void; }
}
namespace OCP {
    interface IAppConfig {
        public function getValueString(string $appId, string $key, string $default = ''): string;
        public function setValueString(string $appId, string $key, string $value): void;
    }
}
namespace OCP\AppFramework\Utility { interface ITimeFactory { public function getTime(): int; } }

namespace OCA\AdRoom\Repository {
    use OCA\AdRoom\Model\Booking;
    use OCA\AdRoom\Model\Room;
    class BookingRepository {
        /** @var list<Booking> */ public array $items = [];
        public int $deleteCalls = 0;
        public function findByUserUid(string $uid, int $limit): array {
            return array_slice(array_values(array_filter($this->items, static fn(Booking $booking): bool => $booking->userUid() === $uid)), 0, $limit);
        }
        public function findEndedByUserUid(string $uid, \DateTimeImmutable $cutoff, int $limit): array {
            return array_slice(array_values(array_filter($this->items, static fn(Booking $booking): bool => $booking->userUid() === $uid && $booking->endsAt() <= $cutoff)), 0, $limit);
        }
        public function delete(int $id): void { $this->deleteCalls++; }
    }
    class RoomRepository {
        /** @return list<Room> */
        public function findAll(): array { return [Room::get(['id' => 2, 'name' => 'Besprechung 1', 'description' => '', 'sortOrder' => 1])]; }
    }
}

namespace {
    use OCA\AdRoom\Model\Booking;
    use OCA\AdRoom\Privacy\RoomPersonalDataProvider;
    use OCA\AdRoom\Privacy\RoomPrivacyProviderListener;
    use OCA\AdRoom\Privacy\RoomRetentionProvider;
    use OCA\AdRoom\Repository\BookingRepository;
    use OCA\AdRoom\Repository\RoomRepository;
    use OCA\AdRoom\Service\RoomRetentionPolicyService;
    use OCA\LocalBase\Calendar\CalendarContextSettingsService;
    use OCA\LocalBase\Privacy\PersonalDataProviderRegistryEvent;
    use OCA\LocalBase\Privacy\PersonalDataRequest;
    use OCA\LocalBase\Privacy\PersonalDataSubject;
    use OCA\LocalBase\Privacy\RetentionPreviewRequest;
    use OCA\LocalBase\Privacy\RetentionProviderRegistryEvent;

    $repository = new BookingRepository();
    $repository->items = [
        Booking::get(['id' => 1, 'roomId' => 2, 'userUid' => 'user-17', 'purpose' => 'Sitzung', 'title' => 'Team', 'startsAt' => '2026-08-02T01:05:00+00:00', 'endsAt' => '2026-08-02T01:10:00+00:00']),
        Booking::get(['id' => 2, 'roomId' => 3, 'userUid' => 'foreign', 'purpose' => 'BQ', 'title' => 'Fremd', 'startsAt' => '2026-08-03T08:00:00+00:00', 'endsAt' => '2026-08-03T09:00:00+00:00']),
    ];
    $subject = new PersonalDataSubject(PersonalDataSubject::NEXTCLOUD_USER, 'user-17');
    $config = new class implements OCP\IAppConfig {
        public array $values = [];
        public function getValueString(string $appId, string $key, string $default = ''): string { return $this->values[$appId][$key] ?? $default; }
        public function setValueString(string $appId, string $key, string $value): void { $this->values[$appId][$key] = $value; }
    };
    $policy = new RoomRetentionPolicyService($config);
    $policy->save(['enabled' => true, 'reviewAfterDays' => 5, 'action' => 'REVIEW']);
    $clock = new class implements OCP\AppFramework\Utility\ITimeFactory { public function getTime(): int { return strtotime('2026-08-12T12:00:00+00:00'); } };
    $personal = new RoomPersonalDataProvider($repository, new RoomRepository(), $policy, new CalendarContextSettingsService($config));
    $report = $personal->collect(new PersonalDataRequest($subject, 'de', PersonalDataRequest::PURPOSE_SELF_SERVICE, 20));
    if (count($report->items()) !== 1) throw new RuntimeException('Provider liefert fremde Buchungen oder lässt eigene aus.');
    $item = $report->items()[0]->toArray();
    if ($item['reference'] !== 'booking:1' || $item['attributes']['Titel'] !== 'Team' || isset($item['attributes']['userUid']) || str_contains(json_encode($item, JSON_THROW_ON_ERROR), 'Fremd')) throw new RuntimeException('Providerbericht ist nicht referenzierbar, datensparsam oder nicht subjectgebunden.');
    foreach (['Raum', 'Zweck', 'Titel', 'Beginn', 'Ende'] as $label) if (!array_key_exists($label, $item['attributes'])) throw new RuntimeException("Deutsche Detailbezeichnung fehlt: {$label}");
    foreach (['purpose', 'title', 'startsAt', 'endsAt'] as $technical) if (array_key_exists($technical, $item['attributes'])) throw new RuntimeException("Technischer Feldname ist sichtbar: {$technical}");
    foreach (['Folgende Raumbuchungen', '02.08.26', '03:05 bis 03:10 Uhr', 'Wofür'] as $expected) {
        $haystack = $expected === 'Wofür' ? 'Wofür: ' . ($item['purpose'] ?? '') : json_encode($item, JSON_THROW_ON_ERROR);
        if (!str_contains($haystack, $expected)) throw new RuntimeException("Menschenlesbare Raumbuchung fehlt: {$expected}");
    }
    if (!str_contains($item['retention'] ?? '', '07.08.26')) throw new RuntimeException('Datensatzbezogenes Retention-Datum fehlt.');
    $processing = $report->processing()->toArray();
    if (!in_array('Raumbuchungen planen und verwalten', $processing['purposes'], true)
        || !in_array('Alle angemeldeten Nutzer*innen der Instanz', $processing['recipients'], true)
        || !str_contains($processing['retentionCriteria'], '5 Tage')
        || !str_contains($processing['automatedDecisionMaking'], 'Kollisionsprüfung')) {
        throw new RuntimeException('Art.-15-Verarbeitungsangaben des Raumplaners fehlen oder sind unzutreffend.');
    }
    $limitedReport = $personal->collect(new PersonalDataRequest($subject, 'de', PersonalDataRequest::PURPOSE_SELF_SERVICE, 1));
    if ($limitedReport->isComplete()) throw new RuntimeException('Begrenzter Raumbuchungsbericht behauptet Vollständigkeit.');

    $retention = new RoomRetentionProvider($repository, $policy, $clock);
    $preview = $retention->preview(new RetentionPreviewRequest($subject, 20));
    if (count($preview->candidates()) !== 1 || $preview->candidates()[0]->toArray()['action'] !== 'REVIEW') throw new RuntimeException('Retention-Dry-Run fehlt.');
    if ($repository->deleteCalls !== 0) throw new RuntimeException('Retention-Preview verändert Buchungen.');
    $policy->save(['enabled' => false, 'reviewAfterDays' => 0, 'action' => 'REVIEW']);
    if ($retention->preview(new RetentionPreviewRequest($subject, 20))->candidates() !== []) throw new RuntimeException('Deaktivierte Retention liefert Kandidaten.');

    $listener = new RoomPrivacyProviderListener($personal, $retention);
    $personalRegistry = new PersonalDataProviderRegistryEvent();
    $listener->handle($personalRegistry);
    $retentionRegistry = new RetentionProviderRegistryEvent();
    $listener->handle($retentionRegistry);
    if (array_keys($personalRegistry->providers()) !== ['adroom'] || array_keys($retentionRegistry->providers()) !== ['adroom']) throw new RuntimeException('AD Raumplaner registriert seine Privacy-Provider nicht.');

    echo "AD Raumplaner privacy provider test passed\n";
}
