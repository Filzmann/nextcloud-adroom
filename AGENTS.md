# AGENTS.md - AD Raumplaner

## Projekt

Nextcloud-App `adroom` fuer die gemeinsame Buchung und Verwaltung von Besprechungsraeumen.

Lokale App-URL:

    https://nextcloud-dev.ddev.site/apps/adroom/

Nextcloud-App-ID:

    adroom

## Fachvertrag

- Der Monatsplan zeigt Tage als Zeilen und aktive Räume als Spalten. Innerhalb jedes Tages teilen sich alle Raumspalten eine vertikale Zeitachse: aufeinanderfolgende Buchungen stehen untereinander, zeitliche Lücken erzeugen Abstand und Buchungen verschiedener Räume bleiben zeitlich vergleichbar ausgerichtet.
- Buchungen bestehen aus Raum, Beginn, Ende, standardisiertem Zweck, frei benennbarem Titel und der Nextcloud-UID der buchenden Person. Der Titel bezeichnet zum Beispiel ASN, Gremium oder Fortbildungsthema.
- Als häufige Zwecke werden AT, Sitzung, BQ, Fortbildung, SV, HB und LG angeboten; die Liste bleibt durch die freie Texteingabe erweiterbar.
- Buchungen liegen innerhalb eines Kalendertags, verwenden 15-Minuten-Schritte und sind zwischen 06:00 und 21:00 Uhr erlaubt.
- Buchungen desselben Raums duerfen sich nicht ueberschneiden. Angrenzende Buchungen sind erlaubt.
- Alle angemeldeten Nutzer*innen duerfen Raeume und Buchungen lesen sowie eigene Buchungen anlegen, bearbeiten, in andere Raeume verschieben und loeschen.
- Nextcloud-Admins duerfen alle Buchungen und die Raumliste verwalten.
- Raumloeschungen loeschen die zugehoerigen Buchungen. Die UI muss diese Auswirkung vor der Aktion deutlich bestaetigen.
- Samstage, Sonntage und gesetzliche Feiertage in Berlin werden in der Monatsansicht textlich und optisch gekennzeichnet.
- Der WordPress-Raumplaner ist nur fachliche Referenz. WordPress-IDs, Capabilities, Nonces, Shortcodes und Tabellen werden nicht uebernommen.

## Architektur und Sicherheit

- Controller bleiben duenn. Validierung und Kollisionspruefung liegen im `BookingService`, Rechte im `RoomAccessService`, Datenzugriff in Repositories.
- Deny by default: Jede schreibende API prueft die angemeldete Person und die Zielbuchung serverseitig.
- Der Browser uebermittelt bei eigenen Buchungen keine vertrauenswuerdige Besitzer-UID; der Server setzt die UID aus der Session.
- GET-Routen sind CSRF-frei, schreibende Routen behalten den Nextcloud-CSRF-Schutz.
- Persistente Modelle bieten `get(...)`, `get_all([...])` und `toArray()`; direkte Modellpersistenz ist nicht erlaubt.
- QueryBuilder-Parameter werden gebunden. Keine SQL-Fragmente aus Requests.
- Der App-Root erfuellt den Nextcloud-Scrollvertrag; nur die Monatsmatrix scrollt horizontal.
- Die Raumverwaltung betrifft ausschließlich den AD Raumplaner und liegt deshalb in dessen eigenem Nextcloud-Adminabschnitt `AD Raumplaner`. Der Raumkalender enthält nur fachliche Buchungsfunktionen; künftige persönliche Einstellungen gehören in einen eigenen App-Tab.

## Gemeinsame Suite-Navigation

- Ohne aktive OrgSuite registriert AD Raumplaner einen eigenen Nextcloud-Hauptnavigationseintrag. Ab zwei AD-Produkten ersetzt `orgsuite` diesen durch den gemeinsamen Einstieg `AD`.
- Das Template stellt den optionalen Menühost mit `data-suite="ad"` und `data-current-app="adroom"` bereit, lädt aber keine OrgSuite-Assets direkt.
- Ohne Kalender oder Assistenzplanung bleiben Raumbuchungen vollständig manuell nutzbar; optionale Direktbuchungen dürfen nicht als harte Abhängigkeit modelliert werden.
- Menuesichtbarkeit ist keine Berechtigung.

## Git, DDEV und Tests

- Eigenstaendiges Git-Repository; Dateien gezielt stagen, niemals `git add .`.
- Vor Commits Status, Diff-Statistik und Dateiliste pruefen.
- DDEV-Mount: `/var/www/html/html/custom_apps/adroom`.
- Migrationen laufen ueber `occ app:enable adroom` beziehungsweise `occ upgrade`.
- Schnelle Tests: `php tests/run.php` und `node tests/run-js.mjs`.
- Controller-, DI- und Migrationsaenderungen zusaetzlich in DDEV pruefen.
