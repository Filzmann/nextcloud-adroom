# AD Raumplaner

Monatliche, zeitlich ausgerichtete Raumbelegung mit kollisionsfreien Buchungen, Buchungstiteln und standardisierten Zwecken.

## Staging-Kompatibilität

- Nextcloud 34
- PHP 8.3 oder neuer innerhalb des von Nextcloud 34 unterstützten Bereichs
- Laufzeitbasis: `localbase`; `orgsuite` ist ab zwei AD-Fachprodukten optional aktiv
- App-ID und Installationsordner: `adroom`

## Installation

Für Staging und Auslieferung das Produktbundle `ad-product-adroom-<release>.tar.gz` und dessen enthaltenes `install.sh` verwenden. Es prüft und installiert LocalBase automatisch; ab dem zweiten AD-Fachprodukt aktiviert es OrgSuite.

AD Raumplaner funktioniert einzeln; Buchungen bleiben ohne Kalender oder Assistenzplanung manuell nutzbar.

Räume werden nach der Aktivierung im eigenen Nextcloud-Adminabschnitt `AD Raumplaner` eingerichtet. `adroom:demo:seed` ist ausschließlich für synthetische Testdaten bestimmt.

## Roadmap

Geplante Erweiterungen und offene Produktentscheidungen stehen in der [Roadmap](ROADMAP.md).

Installations-, Betriebs- und Abnahmeunterlagen stehen im öffentlichen [AD-Suite-Projekt](https://github.com/Filzmann/ad-suite).
