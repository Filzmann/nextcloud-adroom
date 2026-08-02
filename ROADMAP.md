# Roadmap – AD Raumplaner

Diese Datei bündelt geplante Erweiterungen und offene Produktentscheidungen. Verbindliche Fach-, Sicherheits- und Architekturregeln stehen in `AGENTS.md`.

## Freigegebene Umsetzungsaufgaben

### ROOM-L10N – AD Raumplaner vollständig lokalisieren

Status: bereit nach festgelegtem l10n-Pilotvertrag

- Monats-/Wochentagsnamen und sichtbare UI-, Admin-, Validierungs- und
  Fehlermeldungen auf aktive Nextcloud-Locale und Nextcloud-l10n umstellen.
- ISO-Zeiträume, 15-Minuten-Raster, Buchungszweck-Schlüssel, Raum-IDs und
  API-Werte unverändert lassen; konfigurierte Titel und Raumnamen nicht
  automatisch übersetzen.
- Deutsche Ausgabe, eine weitere Locale, Fallback, Monats-/Jahresgrenzen,
  Pluralformen, Platzhalter, Escaping sowie zugängliche Wochenend- und
  Feiertagsbeschriftungen testen.
- Erst nach vollständiger Migration einen Rohtext-Check für AD Raumplaner
  verbindlich schalten.

## Aktueller Fokus

- Die manuellen Prüfungen werden im ausfüllbaren
  [`docs/manual-acceptance.md`](docs/manual-acceptance.md) dokumentiert.
- Monatsansicht, Kollisionsschutz, eigene Buchungsrechte und administrative Raumverwaltung auf einem realitätsnahen Staging fachlich abnehmen.
- Löschbestätigung, Zeitraster, Wochenenden und die Feiertage der administrativ gewählten Organisationsregion sichtbar und barrierefrei prüfen.

## Geplante Erweiterungen

- Persönliche Einstellungen erhalten erst bei einem konkreten dauerhaften Nutzerwert einen eigenen App-Tab.
- Optionale Direktbuchungen aus Kalender oder Assistenzplanung können nach einem konkreten Anwendungsfall ergänzt werden; der manuelle Standalone-Betrieb bleibt erhalten.

## Vor der Umsetzung zu klären

- Fachlicher Auslöser, Zielraum, Zeitraum und Besitzer*in einer Direktbuchung.
- Serverseitige Rechte, Konfliktverhalten und Rückmeldung an die aufrufende App.
- Kleiner optionaler Integrationsvertrag ohne direkten Zugriff auf fremde Tabellen oder Assets.
