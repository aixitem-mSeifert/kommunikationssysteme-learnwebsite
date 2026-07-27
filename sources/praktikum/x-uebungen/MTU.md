# IP-Fragmentierung (MTU)

## Aufgabe 1

Sie wollen von Ihrem Rechner A aus ein Datenpaket der Länge **5251 Byte** (Nutzdaten ohne IP-Header) via IP an den Rechner B senden.
Die Rechner A und B sind über den Router R verbunden. 

Für die Strecke von Ihrem Rechner A zum Router R gelte **MTU=1700**, für die Strecke vom Router R zum Rechner B gelte **MTU=1100**:

`A <--- (MTU=1700) ---> R <--- (MTU=1100) ---> B`

Erstellen Sie Tabellen zu der Fragmentierung mit den Headern: ID, MF, Total Length, Offset.

### Lösung zu Aufgabe 1

**Wichtige Regeln:**
* **ID** darf nicht variieren. Fest, aber beliebig.
* **MF (More Fragments)** ist immer 1, solange ein Nachfolgepaket kommt.
* Pakete werden im Router **nicht** neu gepackt. Wird also ein zu großes Paket an den Router gesendet, wird das Paket explizit weiter geteilt (fragmentiert).
* Die Nutzdaten (Payload) müssen restlos durch **8** teilbar sein.
* In der **Total Length** muss der IP-Header von 20 Byte mit berücksichtigt werden.

#### Strecke A ↔ R (MTU=1700)

| ID | MF | Total Length | Offset |
|:---|:---|:---|:---|
| 1 | 1 | 1680 + 20 = 1700 | 0 |
| 1 | 1 | 1680 + 20 = 1700 | 1680 / 8 = 210 |
| 1 | 1 | 1680 + 20 = 1700 | 3360 / 8 = 420 |
| 1 | 0 | 211 + 20 = 231 | 5040 / 8 = 630 |

#### Strecke R ↔ B (MTU=1100)

| ID | MF | Total Length | Offset |
|:---|:---|:---|:---|
| 1 | 1 | 1080 + 20 = 1100 | 0 |
| 1 | 1 | 600 + 20 = 620 | 1080 / 8 = 135 |
| 1 | 1 | 1080 + 20 = 1100 | 1680 / 8 = 210 |
| 1 | 1 | 600 + 20 = 620 | 2760 / 8 = 345 |
| 1 | 1 | 1080 + 20 = 1100 | 3360 / 8 = 420 |
| 1 | 1 | 600 + 20 = 620 | 4440 / 8 = 555 |
| 1 | 0 | 211 + 20 = 231 | 5040 / 8 = 630 |

---

## Aufgabe 2

Rechner A sei über einen Router R mit Rechner B verbunden.
Für die Strecke von A zu R gelte **MTU=1600**, für die Strecke von R zu B sei die **MTU=1000**:

`A <--- (MTU=1600) ---> R <--- (MTU=1000) ---> B`

Es soll ein IP-Paket mit einer **Gesamtlänge von 3000 Byte** von A zu B übertragen werden.
Erstellen Sie Tabellen zu der Fragmentierung mit den Headern: ID, MF, Total Length, Offset.

### Lösung zu Aufgabe 2

**Wichtige Regeln:**
* **ID** darf nicht variieren. Fest, aber beliebig.
* **MF (More Fragments)** ist immer 1, solange ein Nachfolgepaket kommt.
* Das IP-Paket hat eine Gesamtlänge von 3000 Byte, also **2980 Byte Nutzdaten + 20 Byte IP-Header**.
* Pakete werden im Router **nicht** neu gepackt. Wird also ein zu großes Paket an den Router gesendet, wird das Paket explizit weiter geteilt.
* Die Nutzdaten müssen restlos durch **8** teilbar sein. Man sieht dies in dieser Aufgabe daran, dass das erste Fragment gesamt nur 1596 Byte statt 1600 Byte groß ist (1576 ist durch 8 teilbar, 1580 nicht).
* In der **Total Length** muss der IP-Header von 20 Byte mit berücksichtigt werden.

#### Strecke A ↔ R (MTU=1600)

| ID | MF | Total Length | Offset |
|:---|:---|:---|:---|
| 1 | 1 | 1576 + 20 = 1596 | 0 |
| 1 | 0 | 1404 + 20 = 1424 | 1576 / 8 = 197 |

#### Strecke R ↔ B (MTU=1000)

| ID | MF | Total Length | Offset |
|:---|:---|:---|:---|
| 1 | 1 | 976 + 20 = 996 | 0 |
| 1 | 1 | 600 + 20 = 620 | 976 / 8 = 122 |
| 1 | 1 | 976 + 20 = 996 | 1576 / 8 = 197 |
| 1 | 0 | 428 + 20 = 448 | 2552 / 8 = 319 |
