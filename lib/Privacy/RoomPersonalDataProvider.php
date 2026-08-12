<?php

declare(strict_types=1);

namespace OCA\AdRoom\Privacy;

use OCA\AdRoom\AppInfo\AppId;
use OCA\AdRoom\Model\Booking;
use OCA\AdRoom\Repository\BookingRepository;
use OCA\AdRoom\Repository\RoomRepository;
use OCA\AdRoom\Service\RoomRetentionPolicyService;
use OCA\LocalBase\Calendar\CalendarContextSettingsService;
use OCA\LocalBase\Privacy\PersonalDataItem;
use OCA\LocalBase\Privacy\PersonalDataProvider;
use OCA\LocalBase\Privacy\PersonalDataProcessingInfo;
use OCA\LocalBase\Privacy\PersonalDataReport;
use OCA\LocalBase\Privacy\PersonalDataRequest;
use OCA\LocalBase\Privacy\PersonalDataSubject;

final class RoomPersonalDataProvider implements PersonalDataProvider {
    public function __construct(
        private BookingRepository $bookings,
        private RoomRepository $rooms,
        private RoomRetentionPolicyService $retentionPolicy,
        private CalendarContextSettingsService $calendarContext,
    ) {}
    public function appId(): string { return AppId::VALUE; }
    public function supportedSubjectTypes(): array { return [PersonalDataSubject::NEXTCLOUD_USER]; }

    public function collect(PersonalDataRequest $request): PersonalDataReport {
        $policy = $this->retentionPolicy->policy();
        $timezone = $this->calendarContext->context()->timezone();
        $roomNames = [];
        foreach ($this->rooms->findAll() as $room) $roomNames[$room->id()] = $room->name();
        $bookings = $this->bookings->findByUserUid($request->subject()->id(), $request->limit());
        $limited = count($bookings) >= $request->limit();
        $items = array_map(
            static fn(Booking $booking): PersonalDataItem => new PersonalDataItem('booking', sprintf(
                '%s, %s bis %s Uhr – %s',
                self::germanDate($booking->startsAt()->setTimezone($timezone)),
                $booking->startsAt()->setTimezone($timezone)->format('H:i'),
                $booking->endsAt()->setTimezone($timezone)->format('H:i'),
                $roomNames[$booking->roomId()] ?? 'nicht mehr vorhandener Raum',
            ), 'booking:' . (string)$booking->id(), [
                'Raum' => $roomNames[$booking->roomId()] ?? 'nicht mehr vorhandener Raum',
                'Zweck' => $booking->purpose(),
                'Titel' => $booking->title(),
                'Beginn' => self::germanDateTime($booking->startsAt()->setTimezone($timezone)),
                'Ende' => self::germanDateTime($booking->endsAt()->setTimezone($timezone)),
            ],
                'Planung der Raumnutzung und Vermeidung von Doppelbelegungen',
                self::retentionFor($booking, $policy, $timezone),
                'Folgende Raumbuchungen sind mit deinen Daten gespeichert:',
                dataType: 'Raumbuchung',
            ),
            $bookings,
        );
        return new PersonalDataReport($items, new PersonalDataProcessingInfo(
            purposes: ['Raumbuchungen planen und verwalten', 'Raumbelegung und Buchungskonflikte transparent darstellen'],
            categories: ['Nextcloud-Kennung der buchenden Person', 'Buchungszweck und freier Titel', 'Raum- und Zeitangaben'],
            recipients: ['Alle angemeldeten Nutzer*innen der Instanz', 'Nextcloud-Administrator*innen mit Verwaltungsrechten'],
            source: 'Eingaben der buchenden Person oder einer berechtigten administrierenden Person',
            retentionCriteria: $this->retentionPolicy->retentionCriteria(),
            thirdCountryTransfers: 'Durch AD Raumplaner sind keine Drittlandübermittlungen vorgesehen.',
            automatedDecisionMaking: 'Die automatische Kollisionsprüfung verhindert Doppelbelegungen; sie trifft keine Entscheidung mit rechtlicher oder vergleichbar erheblicher Wirkung.',
        ), complete: !$limited, limitations: $limited ? ['Ausgabelimit erreicht; weitere Raumbuchungen können vorhanden sein.'] : [], appName: 'AD Raumplaner');
    }

    private static function retentionFor(Booking $booking, array $policy, \DateTimeZone $timezone): string {
        if (!$policy['enabled']) return 'Keine feste Löschfrist festgelegt; die administrative Retention-Prüfung ist derzeit deaktiviert.';
        $reviewAt = $booking->endsAt()->modify('+' . $policy['reviewAfterDays'] . ' days');
        return sprintf('Keine feste Löschfrist festgelegt; ab %s zur administrativen Prüfung vorgesehen. Es erfolgt keine automatische Löschung.', self::germanDate($reviewAt->setTimezone($timezone)));
    }

    private static function germanDate(\DateTimeImmutable $date): string { return $date->format('d.m.y'); }

    private static function germanDateTime(\DateTimeImmutable $date): string {
        return self::germanDate($date) . ', ' . $date->format('H:i') . ' Uhr';
    }
}
