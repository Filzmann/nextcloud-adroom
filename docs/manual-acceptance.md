# Manuelles Abnahmeprotokoll – AD Raumplaner

## Kopfdaten

| Feld | Wert |
|---|---|
| Prüfer | Simon |
| Datum | 08.08.2026 |
| Anwendung | AD Raumplaner |
| App-Version | `0.10.0-rc.1` |
| URL | `https://nextcloud-dev.ddev.site/index.php/apps/adroom/` |
| Nextcloud | Nextcloud Hub 26 Spring – `34.0.2` |
| Browser | Google Chrome `150.0.7871.186`, 64-Bit, Ubuntu |
| Fenster / Zoom | ca. 2/3 von 1920 px Breite, 100 % |
| Admin-Testkonto | `admin` |
| Nicht-Admin-Testkonto | `adc-demo-bl-now` |
| Kalenderregion | `de_DE` |
| Fachliche Zeitzone | `Europe/Berlin` |
| Testdaten | ausschließlich synthetische Räume, Buchungen und Demo-Konten |

### Relevante App-Versionen im wiederhergestellten Normalzustand

| App | Version |
|---|---|
| `adcalendar` | `0.13.0-rc.5` |
| `adplaner` | `0.3.0-rc.2` |
| `adroom` | `0.10.0-rc.1` |
| `adurlaub` | `0.6.0-rc.2` |
| `localbase` | `0.10.0-rc.1` |
| `orgsuite` | `0.4.0-rc.1` |

## Gesamtergebnis

| Status | Anzahl |
|---|---:|
| Erfolgreich | **24** |
| Nicht erfolgreich | **5** |
| Nicht geprüft | **2** |
| Offen | **0** |
| Gesamt | **31** |

**Abnahmeurteil:** Noch nicht vollständig abnahmefähig.

Die Kernfunktionalität des Raumplaners sowie die geprüften serverseitigen Berechtigungs- und CSRF-Schutzmechanismen funktionieren weitgehend korrekt. Die noch offenen Abnahmehindernisse konzentrieren sich auf kleine Viewports/Scrolling, die Darstellung von Fehlermeldungen, Tastaturbedienung sowie das fachlich geänderte Soll für Zeitgrenzen und Zeitraster.

---

# A – Einstieg, Darstellung und Navigation

## A1 – Standalone-Einstieg ohne OrgSuite

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** OrgSuite wurde deaktiviert. Der eigene Nextcloud-Einstieg des Raumplaners war weiterhin vorhanden und nutzbar.

**Feststellungen:**
- Monatsansicht vollständig geladen.
- Räume und vorhandene Buchungen sichtbar.
- Buchungsablauf ohne OrgSuite funktionsfähig.
- Keine Abhängigkeit vom Suite-Einstieg für die Kernfunktion.

---

## A2 – Einstieg über OrgSuite

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** OrgSuite wurde aktiviert und der gemeinsame AD-Einstieg verwendet.

**Feststellungen:**
- Raumplaner über den gemeinsamen Einstieg erreichbar.
- Raumplaner eindeutig als solcher gekennzeichnet.
- Kein doppelter bzw. konkurrierender Einstieg.
- Wechsel zwischen den Apps funktioniert.

---

## A3 – Monatsnavigation

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Vorheriger Monat funktioniert.
- Nächster Monat funktioniert.
- Direkte Monatsauswahl funktioniert.
- Tage und Buchungen werden nach dem Wechsel korrekt dargestellt.

**Hinweis:** Es gibt keine separate Monatsüberschrift; der Monatsname wird in der direkten Monatsauswahl angezeigt. Das wurde nicht als Abnahmefehler bewertet.

---

## A4 – Gemeinsame Zeitachse

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Räume werden als getrennte Spalten dargestellt.
- Zeitachse ist vertikal zwischen den Räumen ausgerichtet.
- Freie Zeiträume und Belegungen sind vergleichbar.
- Buchungen verschiedener Räume können unmittelbar zeitlich gegenübergestellt werden.

---

## A5 – Wochenenden und Feiertage

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Samstage und Sonntage optisch gekennzeichnet.
- Feiertage optisch und textlich erkennbar.
- Darstellung grundsätzlich verständlich und zugänglich.

**Verbesserungsvorschlag:** Feiertage könnten deutlicher hervorgehoben werden, z. B. durch eine stärkere Hintergrundmarkierung analog zum Sonntag.

**Möglicher Ticket-Titel:** `Feiertagsmarkierung im Raumplaner deutlicher hervorheben`

---

## A6 – Fachliche Zeitzone

**Ergebnis:** ⏸️ Nicht geprüft

**Begründung:** Es wurde kein Benutzerkonto mit einer von `Europe/Berlin` abweichenden persönlichen Zeitzone eingerichtet. Der Test wurde wegen geringer Priorität nicht durchgeführt.

---

## A7 – Scrolling und kleiner Viewport

**Ergebnis:** ❌ Nicht erfolgreich

**Feststellungen:**
- Horizontaler Scroll innerhalb der Raum-Matrix funktioniert grundsätzlich.
- Vertikaler Scroll funktioniert grundsätzlich.
- Monatsnavigation/Aktionen bleiben bei kleinem Viewport nicht ausreichend erreichbar.
- Es erscheint zusätzlich ein zweiter horizontaler Seiten-Scrollbar.
- Der horizontale Scrollbar der Matrix ist erst am Ende des Inhalts sichtbar und steht während des normalen Scrollens nicht dauerhaft am unteren Viewportrand zur Verfügung.

**Erwartete Korrekturen:**
- Monatsnavigation sticky ausführen.
- Zweiten horizontalen Seiten-Scrollbar entfernen.
- Horizontalen Scrollbar der Matrix am unteren Viewportrand sichtbar/sticky halten, analog zur gewünschten Bedienung im AD Kalender.

**Möglicher Ticket-Titel:** `Raumplaner: Scrollcontainer und sticky Navigation für kleine Viewports korrigieren`

---

# B – Buchungen

## B1 – Eigene Buchung anlegen

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Eine eigene Buchung konnte angelegt werden.
- Die Buchung erschien korrekt und blieb persistent.
- Keine Abweichungen gemeldet.

---

## B2 – Freier Zweck / Freitext

**Ergebnis:** ✅ Erfolgreich

**Testkonto:** `admin`
**Testraum:** Besprechungsraum Nord

**Feststellungen:**
- Freier Zweck/Freitext wird akzeptiert.
- Wert bleibt nach dem Speichern erhalten.
- Wert ist lesbar.
- Wert bleibt auch beim späteren Bearbeiten erhalten.

---

## B3 – Buchung ändern und Raum wechseln

**Ergebnis:** ✅ Erfolgreich

**Testkonto:** `admin`

**Feststellungen:**
- Buchung von Besprechungsraum Nord nach Besprechungsraum Süd verschoben.
- Zeitraum geändert.
- Alte Darstellung verschwand.
- Neue Darstellung blieb nach dem Speichern bestehen.
- Keine doppelte Buchung erzeugt.

---

## B4 – Direkt angrenzende Buchungen

**Ergebnis:** ✅ Erfolgreich

**Testkonto:** `admin`

**Prüfszenario:**
- bestehende Buchung: 10:00–12:00
- angrenzende Buchung davor: 08:00–10:00
- angrenzende Buchung danach: 12:00–14:00

**Feststellungen:**
- Beide angrenzenden Buchungen wurden akzeptiert.
- Keine falsche Überschneidungswarnung.
- Alle Buchungen blieben persistent.

**Verbesserungsvorschlag:** Nach Auswahl der Startzeit sollte die Endzeit automatisch etwa eine Stunde später vorbelegt werden und anschließend frei änderbar bleiben.

**Möglicher Ticket-Titel:** `Buchungsdialog: Endzeit automatisch eine Stunde nach Beginn vorbelegen`

---

## B5 – Überschneidungen

**Ergebnis:** ❌ Nicht erfolgreich

**Feststellungen:**
- Teilweise Überschneidung wird serverseitig korrekt abgewiesen.
- Vollständige Überschneidung wird korrekt abgewiesen.
- Eine die bestehende Buchung vollständig umfassende Überschneidung wird korrekt abgewiesen.
- Bestehende Buchung bleibt unverändert.
- Kein unvollständiger bzw. teilgespeicherter Zustand.
- **Fehlermeldung liegt jedoch hinter dem geöffneten Buchungsformular und ist dadurch für den Benutzer nicht sichtbar.**

**Möglicher Ticket-Titel:** `Validierungs- und Kollisionsmeldungen oberhalb des Buchungsdialogs anzeigen`

---

## B6 – Parallele Buchung in anderem Raum

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Gleichzeitige Buchungen in Besprechungsraum Nord und Besprechungsraum Süd wurden akzeptiert.
- Beide Buchungen blieben bestehen.
- Raumzuordnung korrekt.
- Keine fälschliche raumübergreifende Kollisionsprüfung.

---

## B7 – Zeitgrenzen und Zeitraster

**Ergebnis:** ❌ Nicht erfolgreich

**Ursprüngliches Testsoll:** Buchungen vor 06:00 Uhr, nach 21:00 Uhr, über Nacht bzw. außerhalb des vorgesehenen Rasters sollten abgewiesen werden.

**Während der Abnahme fachlich angepasstes Soll:**
- Keine generelle Begrenzung auf 06:00–21:00 Uhr.
- Buchungen sollen auch nachts möglich sein, z. B. für Homeoffice-/Überstunden-Szenarien.
- Falls ein Zeitraster verwendet wird, soll dieses höchstens ca. 5 Minuten betragen.
- UI-Auswahl und serverseitige Validierung müssen konsistent sein.
- Zeiten, die das UI anbietet, dürfen anschließend nicht vom Server als unzulässig zurückgewiesen werden.
- Umgang mit Buchungen über Mitternacht ist noch fachlich endgültig festzulegen.

**Ist-Verhalten:**
- vor 06:00 Uhr nicht möglich.
- nach 21:00 Uhr nicht möglich.
- über Nacht nicht möglich.
- Rasterprüfung vorhanden.
- Keine inkonsistenten Teilzustände.
- Rasterfehler sichtbar.

**Bewertung:** Das Ist-Verhalten entspricht nicht dem im Test aktualisierten fachlichen Soll.

**Mögliche Tickets:**
- `Raumplaner: Harte Buchungsgrenze 06:00–21:00 entfernen`
- `Raumplaner: Zeitraster zwischen UI und Server vereinheitlichen`

---

## B8 – Eigene Buchung löschen

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Eigene Buchung konnte gelöscht werden.
- Keine Abweichungen gemeldet.

---

# C – Berechtigungen und Sicherheit bei Buchungen

## C1 – Fremde Buchung lesen

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** Fremde Buchung eines anderen Kontos wurde mit dem Nicht-Admin-Testkonto `adc-demo-bl-now` betrachtet.

**Feststellungen:**
- Fremde Buchung sichtbar.
- Zeit sichtbar.
- Titel/Zweck sichtbar.
- Eigentümerinformation sichtbar.
- Leserechte entsprechen dem fachlichen Modell.

---

## C2 – Fremde Buchung verändern

**Ergebnis:** ✅ Erfolgreich

**UI-Prüfung:**
- Nicht-Admin konnte fremde Buchung weder bearbeiten noch verschieben noch löschen.

**Direkte API-Prüfung mit `adc-demo-bl-now`:**
- `PUT` zum Bearbeiten einer fremden Buchung: **HTTP 403**
- `PUT` zum Verschieben in einen anderen Raum: **HTTP 403**
- `DELETE` der fremden Buchung: **HTTP 403**
- Antwort jeweils sinngemäß: `Keine Berechtigung.`

**Feststellung:** Die Buchung blieb unverändert. Die Berechtigung wird nicht nur im Frontend, sondern serverseitig durchgesetzt.

---

## C3 – Besitzer aus Sitzung statt Requestdaten

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** Als `adc-demo-bl-now` wurde per direktem API-Request eine Buchung erzeugt und im Payload versucht, `userUid: admin` mitzugeben.

**Ergebnis:**
- Server legte die Buchung erfolgreich an.
- Eigentümer wurde trotzdem das tatsächlich angemeldete Konto `adc-demo-bl-now`.
- Der manipulierte `userUid` aus dem Request wurde nicht als Besitzer übernommen.

**Bewertung:** Besitzerzuordnung erfolgt vertrauenswürdig aus der Sitzung.

---

## C4 – Administratorzugriff auf fremde Buchungen

**Ergebnis:** ✅ Erfolgreich

**Feststellung:** `admin` durfte eine Buchung bearbeiten, die dem Nicht-Admin-Testkonto `adc-demo-bl-now` gehörte.

**Hinweis:** Einzelne Unterpunkte wie administratives Löschen wurden nicht separat protokolliert; bestätigt wurde die administrative Bearbeitbarkeit und damit das vorgesehene Admin-Rechtemodell.

---

## C5 – CSRF-Schutz bei Buchungen

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** Schreibender `PUT`-Request auf eine Buchung ohne Requesttoken.

**Ergebnis:**
- HTTP **412 Precondition Failed**
- Antwort: `{"message":"CSRF check failed"}`
- Bestehende Buchung blieb unverändert.

**Bewertung:** Serverseitiger CSRF-Schutz für Buchungsänderungen wirksam.

---

# D – Raumverwaltung und Demo-Daten

## D1 – Adminbereich / Raumverwaltung

**Ergebnis:** ✅ Erfolgreich

**Prüfung als Admin:**
- Synthetischer Raum angelegt.
- Raum nach Reload weiterhin vorhanden.
- Raum in Monatsansicht sichtbar.

**Prüfung als Nicht-Admin:**
- Raumadministration in der Oberfläche nicht verfügbar.
- Direkter `PUT`-Request als `adc-demo-bl-now` auf einen Raum mit gültigem Requesttoken: **HTTP 403**
- Antwort: `{"message":"Das angemeldete Konto muss ein Administrator sein"}`
- Raum blieb unverändert.

**Bewertung:** Adminrechte werden UI-seitig und serverseitig korrekt durchgesetzt.

---

## D2 – Raumdaten und Reihenfolge

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Namen mehrerer synthetischer Räume geändert.
- Beschreibungen geändert.
- `sortOrder` verändert.
- Änderungen nach Neuladen korrekt übernommen.
- Monatsansicht folgte der neuen Reihenfolge.
- Raumauswahl im Buchungsdialog folgte der neuen Reihenfolge.
- Bestehende Buchungen blieben dem richtigen Raum zugeordnet.
- Keine Buchung wurde allein durch Umbenennung oder Sortierung verschoben.
- Keine Abweichungen gemeldet.

---

## D3 – Löschbestätigung

**Ergebnis:** ✅ Erfolgreich

**Testraum:** `sem 2`

**Feststellungen:**
- Testraum enthielt eine Testbuchung.
- Erste Löschwarnung wurde abgebrochen.
- Raum blieb nach Abbruch erhalten.
- Buchung blieb nach Abbruch erhalten.
- Löschwirkung wurde verständlich angekündigt.
- Löschung anschließend bewusst bestätigt.
- Raum wurde entfernt.
- Zugehörige Testbuchung wurde entfernt.
- Andere Räume und Buchungen blieben unverändert.

---

## D4 – CSRF-Schutz der Raumverwaltung

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** Schreibender `PUT`-Request auf die Raumverwaltung ohne Requesttoken.

**Ergebnis:**
- HTTP **412 Precondition Failed**
- Antwort: `{"message":"CSRF check failed"}`

**Hinweis:** Eine zusätzliche Sichtkontrolle des Raumzustands wurde nach diesem Request nicht separat protokolliert. Die serverseitige Ablehnung des schreibenden Requests ist eindeutig nachgewiesen.

---

## D5 – Demo-Pack-Schutz

**Ergebnis:** ✅ Erfolgreich

**Feststellungen:**
- Installation ohne erforderliche Bestätigung blockiert.
- Ohne Bestätigung wurden keine Daten erzeugt.
- Installation nach ausdrücklicher Bestätigung möglich.
- Nur synthetische Räume erzeugt.
- Nur synthetische Buchungen erzeugt.
- Lokales Demokonto synthetisch.
- Bestehende Daten unverändert.
- Erneute Installation sicher behandelt; keine unkontrollierte Duplizierung gemeldet.

---

# E – Robustheit, Bedienbarkeit und Datenminimierung

## E1 – Betrieb ohne AD Kalender

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** `adcalendar` vorübergehend deaktiviert.

**Feststellungen:**
- Monatsansicht vollständig geladen.
- Räume und vorhandene Buchungen sichtbar.
- Neue Buchung möglich.
- Änderung möglich.
- Löschung möglich.
- Monats- und Raumwechsel möglich.
- Fehlender AD Kalender erzeugte keinen Fehler.
- Buchungen wurden dadurch nicht blockiert.

---

## E2 – Betrieb ohne AdPlaner

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** `adplaner` vorübergehend deaktiviert.

**Feststellungen:**
- Monatsansicht vollständig geladen.
- Räume und vorhandene Buchungen sichtbar.
- Neue Buchung möglich.
- Änderung möglich.
- Löschung möglich.
- Monats- und Raumwechsel möglich.
- Fehlender AdPlaner erzeugte keinen Fehler.
- Buchungen wurden dadurch nicht blockiert.

---

## E3 – Kalenderkontext / LocalBase nicht verfügbar

**Ergebnis:** ⏸️ Nicht geprüft

**Hintergrund:**
- Ein erster Versuch, `localbase` vollständig zu deaktivieren, führte beim Raumplaner zu HTTP 500.
- Anschließend wurde festgestellt, dass LocalBase möglicherweise als harte technische Abhängigkeit gedacht ist.
- Gleichzeitig sind an dieser Architektur bzw. den Abhängigkeiten noch Umstellungen vorgesehen.

**Bewertung:** Der erzeugte Zustand wird deshalb derzeit nicht als fachlich gültiger Abnahmetest gewertet. E3 bleibt bewusst **nicht geprüft** und soll nach Festlegung der Zielarchitektur neu definiert und wiederholt werden.

**Nicht als Abnahmefehler gewertet:** HTTP 500 beim künstlichen vollständigen Abschalten von LocalBase.

---

## E4 – Tastatur und Fokus

**Ergebnis:** ❌ Nicht erfolgreich

**Feststellung:**
- Das Buchungs-/Formular-Overlay lässt sich nicht mit `Esc` schließen.

**Hinweis:** Weitere Teilkriterien zur Tastaturbedienung wurden nicht vollständig einzeln dokumentiert und deshalb nicht pauschal negativ bewertet.

**Möglicher Ticket-Titel:** `Raumplaner: Formular-Overlay muss per Escape schließbar sein`

---

## E5 – Verständliche Fehlermeldungen

**Ergebnis:** ❌ Nicht erfolgreich

**Feststellung:**
- Kollisionsprüfung selbst funktioniert.
- Die dabei erzeugte Fehlermeldung befindet sich jedoch hinter dem geöffneten Formular-Overlay und ist für den Benutzer nicht wahrnehmbar.

**Hinweis:** Weitere Teilkriterien wie leerer Titel, fehlender Raum oder weitere ungültige Eingaben wurden nicht separat protokolliert und deshalb nicht zusätzlich bewertet.

**Möglicher Ticket-Titel:** `Raumplaner: Validierungsfehler im aktiven Formular sichtbar anzeigen`

---

## E6 – Datenminimierung

**Ergebnis:** ✅ Erfolgreich

**Prüfung:** Monats-API als Nicht-Admin-Testkonto `adc-demo-bl-now`.

**Übertragene Daten umfassen im Wesentlichen:**
- Raum-ID, Raumname, Beschreibung und Sortierung.
- Buchungs-ID und Raum-ID.
- Eigentümer-UID und Anzeigename.
- Zweck und Titel.
- Start- und Endzeit.
- `canManage`.
- Fähigkeit `canManageRooms`.

**Nicht festgestellt:**
- keine E-Mail-Adressen.
- keine Telefonnummern.
- keine Gruppenlisten.
- keine zusätzlichen Rolleninformationen.
- keine weitergehenden Profildaten.
- keine sachfremden personenbezogenen Zusatzinformationen.

**Bewertung:** Die Antwort enthält keine erkennbar unnötigen personenbezogenen Informationen für die getestete Funktion.

**Optimierungsmöglichkeit:** Es kann geprüft werden, ob `userUid` bei fremden Buchungen im Frontend tatsächlich benötigt wird, da `canManage` bereits serverseitig geliefert wird. Dies wurde nicht als Abnahmefehler bewertet.

---

# Zusammenfassung der nicht erfolgreichen Prüffälle

## 1. A7 – Scrolling / kleiner Viewport

**Problem:** Navigation und horizontale Scrollführung sind bei kleinem Viewport nicht ausreichend ergonomisch.

**Erforderlich:**
- sticky Monatsnavigation,
- kein zweiter Seiten-Scrollbar,
- horizontaler Matrix-Scrollbar am Viewport erreichbar.

---

## 2. B5 – Überschneidungen / Fehlermeldung

**Problem:** Serverseitige Kollisionsprüfung funktioniert, die Fehlermeldung liegt aber hinter dem Formular-Overlay.

**Erforderlich:** Validierungs- und Kollisionsmeldungen innerhalb bzw. oberhalb des aktiven Dialogs anzeigen.

---

## 3. B7 – Zeitgrenzen und Raster

**Problem:** Aktuelle harte Zeitgrenzen entsprechen nicht mehr dem fachlichen Soll.

**Erforderlich:**
- keine pauschale Grenze 06:00–21:00 Uhr,
- Zeitraster ggf. auf ca. 5 Minuten reduzieren,
- UI-Auswahl und Servervalidierung konsistent gestalten,
- Verhalten über Mitternacht fachlich festlegen.

---

## 4. E4 – Escape / Tastaturbedienung

**Problem:** Formular-Overlay lässt sich nicht per `Esc` schließen.

**Erforderlich:** Dialog muss per Escape geschlossen werden können; anschließend sollte der Fokus sinnvoll zum auslösenden Element zurückkehren.

---

## 5. E5 – Fehlermeldungen

**Problem:** Fehler werden teilweise technisch erzeugt, aber im aktiven Bedienkontext nicht sichtbar dargestellt.

**Erforderlich:** Fehlermeldungen müssen unmittelbar beim Formular sichtbar und verständlich sein.

---

# Nicht geprüfte Prüffälle

## A6 – Abweichende persönliche Zeitzone

Nicht geprüft, da kein entsprechendes Testkonto eingerichtet wurde und der Test im aktuellen Durchlauf geringe Priorität hatte.

## E3 – Kalenderkontext / LocalBase

Nicht geprüft, da die Zielarchitektur und die Rolle von LocalBase noch umgestellt werden. Der Test muss nach Abschluss dieser Umstellungen neu definiert werden.

---

# Weitere technische Beobachtung außerhalb der Abnahmewertung

Beim Wiederherstellen des Normalzustands wurden beim Ausführen von `occ` Meldungen ausgegeben, dass mehrere Demo-Seed-Commands einen nicht mehr vorhandenen LocalBase-Service referenzieren:

`OCA\LocalBase\Service\DemoAccountProvisioningService`

Betroffen waren die Seed-Demo-Commands von:
- AD Kalender,
- AdPlaner,
- AD Raumplaner,
- AD Urlaub.

Alle relevanten Apps ließen sich anschließend aktivieren und der Raumplaner funktionierte nach Reload wieder normal.

**Bewertung:** Separater technischer Befund, nicht einem der 31 Abnahmetests zugerechnet. Vermutlich Versions-/Umbauartefakt zwischen den Apps und LocalBase.

---

# Schlussentscheidung

**Gesamtstatus: Noch nicht vollständig abnahmefähig.**

Die geprüften Kernfunktionen des Raumplaners sind überwiegend stabil. Besonders positiv sind die serverseitig bestätigten Berechtigungsprüfungen für fremde Buchungen, die Besitzerermittlung aus der Sitzung, die Adminberechtigungen sowie der CSRF-Schutz für Buchungen und Raumverwaltung.

Vor einer vollständigen Abnahme sollten mindestens die fünf als nicht erfolgreich bewerteten Prüffälle korrigiert bzw. fachlich abschließend entschieden und erneut getestet werden. E3 sollte nach Abschluss der vorgesehenen Architekturänderungen neu spezifiziert und nachgetestet werden.
