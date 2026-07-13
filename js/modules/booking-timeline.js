(function() {
    'use strict';

    /**
     * Zweck: Berechnet die gemeinsamen Zeitpunkte, Rasterhöhen und Grid-Linien eines Buchungstags.
     * Zusammenspiel: MonthCalendar verwendet dieselbe Instanz für alle Raumspalten eines Tages.
     * Vertrag: Der sichtbare Tag reicht von 06:00 bis 21:00 Uhr; jede Buchungsgrenze wird zu einer gemeinsamen Grid-Linie.
     */
    class BookingTimeline {
        constructor(dayStart = 360, dayEnd = 1260) {
            this.dayStart = dayStart;
            this.dayEnd = dayEnd;
        }

        points(bookings) {
            const bookingPoints = bookings.flatMap(booking => [this.minute(booking.startsAt), this.minute(booking.endsAt)]);
            return [...new Set([this.dayStart, this.dayEnd, ...bookingPoints])].sort((a, b) => a - b);
        }

        rows(points) {
            return points.slice(0, -1).map((start, index) => {
                const minutes = points[index + 1] - start;
                const height = Math.max(6, Math.min(36, Math.round(minutes / 5)));
                return `minmax(${height}px, auto)`;
            }).join(' ');
        }

        line(points, minute) {
            return Math.max(1, points.indexOf(minute) + 1);
        }

        minute(value) {
            const date = new Date(value);
            return date.getHours() * 60 + date.getMinutes();
        }
    }

    window.AdRoom = window.AdRoom || {};
    window.AdRoom.BookingTimeline = BookingTimeline;
}());
