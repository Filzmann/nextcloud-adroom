# Manuelles Abnahmeformular – AD Raumplaner

Dieses Formular dokumentiert die fachliche, visuelle und sicherheitsbezogene
Abnahme des AD Raumplaners auf einem realitätsnahen Staging-System. Pro
Prüffall wird genau ein Ergebnis markiert und unter
„Warum/Beleg/Abweichung“ knapp festgehalten, was beobachtet wurde.

Keine personenbezogenen Echtdaten, vertraulichen Besprechungstitel,
Zugangsdaten oder internen Kennungen eintragen. Ausschließlich neutrale
Testkonten, synthetische Räume und unverfängliche Buchungstitel verwenden.

## Kopfdaten

| Feld | Eintrag |
|---|---|
| Datum und Uhrzeit | |
| Prüfer*in | |
| Umgebung und URL | |
| AD-Raumplaner-Version | |
| Nextcloud-Version | |
| Browser und Version | |
| Fenstergröße / Zoom | |
| Neutrale Benutzer- und Admin-Konten | |
| Synthetische Testräume | |
| Kalenderregion und fachliche Zeitzone | |

Ergebniskennzeichnung: `[ ] erfolgreich` / `[ ] nicht erfolgreich` /
`[ ] nicht geprüft`. Bei „nicht erfolgreich“ oder „nicht geprüft“ ist eine
Begründung verpflichtend.

## A. Einstieg und Monatsansicht

| ID | Was wird geprüft? | Auszuführende Schritte | Erwartetes Ergebnis | Ergebnis | Warum/Beleg/Abweichung |
|---|---|---|---|---|---|
| A1 | Standalone-Einstieg | AD Raumplaner ohne aktive OrgSuite öffnen. | Ein eigener Nextcloud-Einstieg ist vorhanden und der Raumkalender wird ohne andere Fachapps geladen. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A2 | Suite-Einstieg | Mit aktiver OrgSuite über den AD-Einstieg öffnen und zwischen aktivierten AD-Apps wechseln. | Es gibt keinen doppelten Haupteinstieg; der Raumplaner ist im gemeinsamen Menü korrekt markiert. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A3 | Monatsnavigation | Vorherigen und nächsten Monat sowie einen Monat über die direkte Auswahl öffnen. | Überschrift, Tage und Buchungen gehören stets zum gewählten Monat. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A4 | Gemeinsame Zeitachse | In mehreren Räumen Buchungen mit unterschiedlichen Zeiten und Lücken am selben Tag anzeigen. | Räume bilden Spalten; Buchungen sind vertikal zeitlich vergleichbar und Lücken erzeugen nachvollziehbaren Abstand. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A5 | Wochenenden und Feiertage | Samstag, Sonntag und gesetzlichen Feiertag der konfigurierten Region prüfen. | Alle Sondertage sind optisch und zusätzlich textlich beziehungsweise zugänglich gekennzeichnet. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A6 | Fachliche Zeitzone | Mit abweichender persönlicher Nextcloud-Zeitzone Monatsgrenze und Testbuchung prüfen. | Fachlicher Buchungstag und erlaubter Zeitraum folgen der zentralen Organisationszeitzone; nur die individuelle Anzeige darf abweichen. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| A7 | Scrollen und kleines Fenster | Viele Räume und Buchungen bei kleinem Fenster anzeigen und horizontal sowie vertikal scrollen. | Nur die Monatsmatrix scrollt horizontal; App-Navigation und Aktionen bleiben erreichbar. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |

## B. Buchungsworkflow und Validierung

| ID | Was wird geprüft? | Auszuführende Schritte | Erwartetes Ergebnis | Ergebnis | Warum/Beleg/Abweichung |
|---|---|---|---|---|---|
| B1 | Eigene Buchung | Als normales Testkonto Raum, Datum, Zeitraum, Standardzweck und neutralen Titel speichern. | Genau eine eigene Buchung erscheint im richtigen Raum und Zeitabschnitt. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B2 | Freier Zweck | Einen nicht in der Vorschlagsliste enthaltenen neutralen Zweck eingeben. | Der freie Zweck wird akzeptiert und verständlich angezeigt. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B3 | Änderung und Raumwechsel | Eigene Buchung zeitlich ändern, in einen anderen Raum verschieben und neu laden. | Derselbe Datensatz erscheint mit den neuen Werten; es entsteht kein Duplikat. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B4 | Angrenzende Buchungen | Im selben Raum eine Buchung exakt bis zum Beginn beziehungsweise ab dem Ende einer bestehenden Buchung anlegen. | Beide angrenzenden Buchungen sind zulässig. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B5 | Überschneidung | Teilweise und vollständig überlappende Buchungen im selben Raum versuchen. | Beide Versuche werden verständlich abgewiesen; bestehende Buchungen bleiben unverändert. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B6 | Parallel in anderem Raum | Für denselben Zeitraum in einem anderen Raum buchen. | Die parallele Buchung ist zulässig und bleibt dem anderen Raum zugeordnet. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B7 | Zeitgrenzen und Raster | Vor 06:00, nach 21:00, über Tagesgrenze und außerhalb des 15-Minuten-Rasters buchen. | Ungültige Zeiten werden serverseitig abgewiesen; es entsteht kein Teilstand. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| B8 | Eigene Löschung | Eine entbehrliche eigene Testbuchung löschen und neu laden. | Nur diese Buchung verschwindet; andere Buchungen bleiben erhalten. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |

## C. Besitz- und Administrationsrechte

| ID | Was wird geprüft? | Auszuführende Schritte | Erwartetes Ergebnis | Ergebnis | Warum/Beleg/Abweichung |
|---|---|---|---|---|---|
| C1 | Fremde Buchung lesen | Mit einem zweiten angemeldeten Testkonto die Monatsansicht öffnen. | Räume und Buchungsbelegung sind gemäß Fachvertrag lesbar. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| C2 | Fremde Buchung ändern | Als normales Konto eine fremde Buchung über UI und direkten API-Aufruf ändern, verschieben und löschen. | Alle schreibenden Versuche werden serverseitig abgewiesen; die Buchung bleibt unverändert. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| C3 | Besitzer aus Sitzung | Beim Anlegen per direktem Request eine fremde Besitzer-UID mitsenden. | Der Server verwendet das angemeldete Konto und vertraut der übermittelten UID nicht. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| C4 | Adminzugriff | Als Nextcloud-Admin eine fremde synthetische Buchung ändern und löschen. | Der Admin kann die vorgesehenen Verwaltungsaktionen ausführen. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| C5 | CSRF-Schutz | Einen schreibenden Buchungsrequest mit Sitzung, aber ohne gültiges Requesttoken senden. | Der Request wird abgewiesen und verändert keine Buchung. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |

## D. Raumverwaltung und Demo-Pack

| ID | Was wird geprüft? | Auszuführende Schritte | Erwartetes Ergebnis | Ergebnis | Warum/Beleg/Abweichung |
|---|---|---|---|---|---|
| D1 | Adminabschnitt | Als Admin einen synthetischen Raum mit Name, Beschreibung und Reihenfolge anlegen; als Nichtadmin denselben Weg versuchen. | Nur der Admin kann Räume verwalten; Nichtadmin-Requests verändern nichts. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| D2 | Raumdaten und Reihenfolge | Namen, Beschreibungen und Reihenfolge mehrerer Testräume ändern und neu laden. | Monatsansicht und Auswahllisten folgen dem gültigen Adminstand; vorhandene Buchungen bleiben dem richtigen Raum zugeordnet. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| D3 | Löschbestätigung | Einen ausschließlich für die Abnahme vorgesehenen Raum mit Testbuchung löschen, die erste Warnung abbrechen und danach bewusst bestätigen. | Abbruch verändert nichts; Bestätigung nennt die Auswirkung deutlich und entfernt Raum samt zugehöriger Testbuchung. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| D4 | CSRF-Schutz der Raumverwaltung | Raumlöschung mit angemeldeter Adminsitzung, aber ohne gültiges Requesttoken versuchen. | Der Vorgang wird abgewiesen; Raum und Buchungen bleiben erhalten. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| D5 | Demo-Pack-Schutz | Demo-Pack ohne Bestätigung versuchen und anschließend nur in einer vorgesehenen Testumgebung bestätigen. | Ohne Bestätigung bleibt die Aktion gesperrt; ausschließlich synthetische Räume, Buchungen und ein explizites lokales Demokonto werden verwendet. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |

## E. Standalone-Betrieb und Bedienbarkeit

| ID | Was wird geprüft? | Auszuführende Schritte | Erwartetes Ergebnis | Ergebnis | Warum/Beleg/Abweichung |
|---|---|---|---|---|---|
| E1 | Ohne AD Kalender | AD Kalender deaktivieren und Monatsansicht sowie Buchungsworkflow wiederholen. | Der manuelle Raumplaner bleibt vollständig nutzbar. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| E2 | Ohne AdPlaner | AdPlaner deaktivieren und denselben Kernablauf wiederholen. | Fehlende Assistenzplanung blockiert keine Raumbuchung. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| E3 | Kalenderkontext nicht verfügbar | Einen LocalBase-Kalenderfehler in isolierter Testumgebung simulieren. | Die App behauptet keine falschen Feiertage; Buchungsrechte und führende Buchungsdaten werden nicht erweitert oder gelöscht. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| E4 | Tastatur und Fokus | Monatsnavigation, Buchungsdialog und Adminformular nur mit Tastatur bedienen; Dialog mit Escape schließen. | Alle Funktionen sind erreichbar, Fokus ist sichtbar und der Dialog erzeugt keine Tastaturfalle. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| E5 | Verständliche Fehler | Kollision, ungültige Zeit, fehlenden Titel und fehlenden Raum nacheinander auslösen. | Fehler werden im passenden Kontext verständlich angezeigt; gültige Eingaben und bestehende Daten bleiben erhalten. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |
| E6 | Datensparsame Abnahme | Formular und Screenshots prüfen. | Es wurden nur synthetische Räume, Buchungen und Konten dokumentiert; keine vertraulichen Titel oder Zugangsdaten sind enthalten. | [ ] erfolgreich [ ] nicht erfolgreich [ ] nicht geprüft | |

## Abschlussentscheidung

| Feld | Eintrag |
|---|---|
| Anzahl erfolgreich | |
| Anzahl nicht erfolgreich | |
| Anzahl nicht geprüft | |
| Kritische Abweichungen / Ticketreferenzen | |
| Erneute Prüfung erforderlich bis | |
| Gesamtentscheidung | [ ] abgenommen [ ] mit Auflagen abgenommen [ ] nicht abgenommen |
| Begründung der Gesamtentscheidung | |
| Name / Datum | |
