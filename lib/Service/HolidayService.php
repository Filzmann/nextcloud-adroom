<?php

declare(strict_types=1);

namespace OCA\AdRoom\Service;

use DateTimeImmutable;
use DateTimeZone;

/** Zweck: Liefert die fuer Berlin geltenden Feiertage ohne externen Laufzeitdienst. */
final class HolidayService {
    /** @return array<string,string> */
    public function forMonth(int $year, int $month): array {
        $tz = new DateTimeZone('Europe/Berlin');
        $easter = (new DateTimeImmutable(sprintf('%04d-03-21',$year),$tz))->modify('+' . easter_days($year) . ' days');
        $dates = [
            sprintf('%04d-01-01',$year)=>'Neujahr',
            sprintf('%04d-03-08',$year)=>'Internationaler Frauentag',
            $easter->modify('-2 days')->format('Y-m-d')=>'Karfreitag',
            $easter->modify('+1 day')->format('Y-m-d')=>'Ostermontag',
            sprintf('%04d-05-01',$year)=>'Tag der Arbeit',
            $easter->modify('+39 days')->format('Y-m-d')=>'Christi Himmelfahrt',
            $easter->modify('+50 days')->format('Y-m-d')=>'Pfingstmontag',
            sprintf('%04d-10-03',$year)=>'Tag der Deutschen Einheit',
            sprintf('%04d-12-25',$year)=>'1. Weihnachtstag',
            sprintf('%04d-12-26',$year)=>'2. Weihnachtstag',
        ];
        return array_filter($dates,static fn(string $name,string $date): bool => (int)substr($date,5,2)===$month,ARRAY_FILTER_USE_BOTH);
    }
}

