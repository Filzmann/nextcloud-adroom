<?php

declare(strict_types=1);

namespace OCP { interface IUserManager { public function get(string $uid); } }
namespace OCA\AdRoom\Repository {
    class BookingRepository {
        public bool $overlap=false; public ?\OCA\AdRoom\Model\Booking $saved=null;
        public function overlaps(int $roomId,\DateTimeImmutable $start,\DateTimeImmutable $end,?int $excludeId=null): bool { return $this->overlap; }
        public function save(\OCA\AdRoom\Model\Booking $booking): int { $this->saved=$booking; return 7; }
        public function find(int $id): ?\OCA\AdRoom\Model\Booking { return null; }
        public function delete(int $id): void {}
        public function findRange(\DateTimeImmutable $start,\DateTimeImmutable $end): array { return []; }
    }
}
namespace OCA\AdRoom\Service {
    class RoomService { public function get(int $id): ?object { return $id===1 ? (object)['id'=>1] : null; } public function all(): array { return []; } }
}
namespace {
    require __DIR__.'/../../lib/Model/Booking.php';
    require __DIR__.'/../../lib/Exception/BookingConflictException.php';
    require __DIR__.'/../../lib/Service/HolidayService.php';
    require __DIR__.'/../../lib/Service/BookingService.php';
    $repo=new OCA\AdRoom\Repository\BookingRepository();
    $users=new class implements OCP\IUserManager { public function get(string $uid){ return null; } };
    $service=new OCA\AdRoom\Service\BookingService($repo,new OCA\AdRoom\Service\RoomService(),$users,new OCA\AdRoom\Service\HolidayService());
    if ($service->create(1,'2026-07-13T08:00','2026-07-13T09:00','Sitzung','admin')!==7) throw new RuntimeException('Gueltige Buchung wurde nicht gespeichert.');
    if ($repo->saved?->startsAt()->format('H:i')!=='06:00') throw new RuntimeException('Berliner Sommerzeit wurde nicht nach UTC normalisiert.');
    $repo->overlap=true;
    try { $service->create(1,'2026-07-13T08:00','2026-07-13T09:00','Sitzung','admin'); throw new RuntimeException('Ueberschneidung wurde nicht blockiert.'); } catch (OCA\AdRoom\Exception\BookingConflictException) {}
    $repo->overlap=false;
    foreach ([['2026-07-13T08:07','2026-07-13T09:00'],['2026-07-13T05:45','2026-07-13T07:00'],['2026-07-13T09:00','2026-07-14T10:00']] as [$start,$end]) {
        try { $service->create(1,$start,$end,'Sitzung','admin'); throw new RuntimeException('Ungueltige Zeit wurde akzeptiert.'); } catch (InvalidArgumentException) {}
    }
    echo "AD Raumplaner booking service tests passed\n";
}
