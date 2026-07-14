# AD Raumplaner

Monatliche, zeitlich ausgerichtete Raumbelegung mit kollisionsfreien Buchungen, Buchungstiteln und standardisierten Zwecken.

## Staging-Kompatibilität

- Nextcloud 34
- PHP 8.3 oder neuer innerhalb des von Nextcloud 34 unterstützten Bereichs
- Abhängigkeiten: `localbase`, `orgsuite`
- App-ID und Installationsordner: `adroom`

## Installation

```bash
sudo -u www-data php occ app:enable localbase
sudo -u www-data php occ app:enable orgsuite
sudo -u www-data php occ app:enable adroom
```

Räume werden nach der Aktivierung im Nextcloud-Adminbereich der OrgSuite eingerichtet. `adroom:demo:seed` ist ausschließlich für synthetische Testdaten bestimmt.
