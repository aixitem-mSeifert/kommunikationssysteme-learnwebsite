# CIDR-Berechnungen und Routing-Aufgaben

---

## Aufgabe 1

### Aufgabenstellung
Sie haben das Netz 143.215.16.0/21 (CIDR-Notation) zugewiesen bekommen und sollen das Netzwerk Ihres Unternehmens mit diesen IP-Adressen konfigurieren.
Dieses Netzwerk soll in 16 Subnetze unterteilt werden.
Jedes Subnetz soll die gleiche Anzahl an IP-Adressen zugeteilt bekommen.
Welche Subnetz-Maske (a.b.c.d) wählen Sie (mit Begründung)?
Geben Sie den daraus resultierenden Adressraum für das niedrigst- und höchstwertige Subnetz an. 

---

### Lösung

#### Subnetzmaske
Um 16 Subnetze zu adressieren benötigt man 4 Bit ($2^4 = 16$), der Netzwerkanteil eines Subnetzes muss daher 25 Bit ($21 + 4$) groß sein.
Deshalb ist folgende Subnetzmaske zu wählen:

| Binärdarstellung (Netz- und Host-Bits) | Dezimal |
| :--- | :--- |
| `11111111.11111111.11111111.10000000` | **255.255.255.128** |
| `25 Netz-Bits / 7 Host-Bits` | `/25` |

#### Kleinstes und Größtes Subnetz

| Subnetz | Zusätzliche Bits | Subnetz (CIDR) | Adressraum | Reservierte Adressen |
| :--- | :---: | :--- | :--- | :--- |
| **Kleinstes Subnetz**<br>*(Alle 4 zusätzlichen Netzwerkbits sind 0)* | `0000` | `143.215.16.0/25` | `143.215.16.0` – `143.215.16.127` | 0 und 127 sind reserviert |
| **Größtes Subnetz**<br>*(Alle 4 zusätzlichen Netzwerkbits sind 1)* | `1111` | `143.215.23.128/25` | `143.215.23.128` – `143.215.23.255` | 128 und 255 sind reserviert |

---

## Aufgabe 2

### Aufgabenstellung
Sie haben das Netz 135.206.208.0/20 (CIDR-Notation) zugewiesen bekommen und sollen das Netzwerk Ihres Unternehmens mit diesen IP-Adressen konfigurieren. Dieses Netzwerk soll in 8 Subnetze unterteilt werden. Jedes Subnetz soll die gleiche Anzahl an IP-Adressen zugeteilt bekommen.
Welche Subnetz-Maske (a.b.c.d) wählen Sie (mit Begründung)?
Geben Sie für eins dieser Subnetze den daraus resultierenden Adressraum an. 

---

### Lösung
Um 8 Subnetze zu adressieren benötigt man 3 Bit ($2^3 = 8$), der Netzwerkanteil eines Subnetzes muss daher 23 Bit ($20 + 3$) groß sein und folglich ist die Subnetzmaske **255.255.254.0** (`11111111.11111111.11111110.00000000`) zu wählen. 

Es genügt hier die Nennung von einem der folgenden 8 Adressräume:

| Subnetz | Subnetz (CIDR) | Adressraum | Reservierte Adressen |
| :--- | :--- | :--- | :--- |
| **Kleinstes Subnetz** *(alle 3 zusätzlichen Bits = 0)* | `135.206.208.0/23` | `135.206.208.0` – `135.206.209.255` | 208.0 und 209.255 sind reserviert |
| **Subnetz 2** | `135.206.210.0/23` | `135.206.210.0` – `135.206.211.255` | 210.0 und 211.255 sind reserviert |
| **Subnetz 3** | `135.206.212.0/23` | `135.206.212.0` – `135.206.213.255` | 212.0 und 213.255 sind reserviert |
| **Subnetz 4** | `135.206.214.0/23` | `135.206.214.0` – `135.206.215.255` | 214.0 und 215.255 sind reserviert |
| **Subnetz 5** | `135.206.216.0/23` | `135.206.216.0` – `135.206.217.255` | 216.0 und 217.255 sind reserviert |
| **Subnetz 6** | `135.206.218.0/23` | `135.206.218.0` – `135.206.219.255` | 218.0 und 219.255 sind reserviert |
| **Subnetz 7** | `135.206.220.0/23` | `135.206.220.0` – `135.206.221.255` | 220.0 und 221.255 sind reserviert |
| **Größtes Subnetz** *(alle 3 zusätzlichen Bits = 1)* | `135.206.222.0/23` | `135.206.222.0` – `135.206.223.255` | 222.0 und 223.255 sind reserviert |

---

## Aufgabe 3

### Aufgabenstellung
Sie sind Administrator des Netzwerkes 189.189.64.0/19.
Wie viele Hosts können Sie in dieses Netzwerk aufnehmen?
Welche Subnetzmaske (a.b.c.d) müssen Sie bei den Hosts konfigurieren?
Wie lautet die Broadcast-Adresse für dieses Netzwerk?
Sie sollen dieses Netz in 4 gleich große Subnetze aufteilen. Welche Netzwerkmaske stellen Sie dann an den Rechnern innerhalb dieser Subnetze ein?

---

### Lösung

| Frage | Berechnung | Lösung / Ergebnis |
| :--- | :--- | :--- |
| **Anzahl Hosts** | $32 - 19 = 13 	ext{ Bits}$ für Adressierung der Hosts.<br>Somit $2^{13} - 2 = 8192 - 2$ | **8190 Hosts** |
| **Subnetzmaske** | `11111111.11111111.11100000.00000000` | **255.255.224.0** |
| **Broadcast-Adresse** | Die ersten 19 Bit (Netzteil) sind unverändert, danach alle auf 1 gesetzt.<br>`10111101.10111101.01011111.11111111` | **189.189.95.255** |
| **Netzwerkmaske für 4 Subnetze** | Für vier Subnetze benötigt man 2 Bit (insgesamt also nun $19 + 2 = 21 	ext{ Bit}$ für den Netzwerkanteil) | **255.255.248.0** |

---

## Aufgabe 4

### Aufgabenstellung
Angenommen Ihr Rechner habe die IP-Adresse 149.201.206.54 und die Netzwerkmaske 255.255.192.0.
Ihr Rechner möchte an die folgenden Ziel-Adressen 149.201.198.112 und 149.201.76.43 ein IP-Paket versenden.
Befinden sich die Ziel-Adressen im selben IP-Subnetz wie die Ausgangsadresse? Woran erkennen Sie dies?

---

### Lösung

#### Standardlösung via AND-Verknüpfung

| Schritt | Adresse / Verknüpfung | Binärdarstellung | Ergebnis | Status |
| :--- | :--- | :--- | :--- | :---: |
| **Quell-IP & Maske** | `149.201.206.54 & 255.255.192.0` | `10010101.11001001.11001110.00110110`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.11000000.00000000`<br>= **149.201.192.0** | Ausgangsnetz |
| **1. Ziel-IP & Maske** | `149.201.198.112 & 255.255.192.0` | `10010101.11001001.11000110.01110000`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.11000000.00000000`<br>= **149.201.192.0** | Identisch ✅<br>*(selbes Subnetz)* |
| **2. Ziel-IP & Maske** | `149.201.76.43 & 255.255.192.0` | `10010101.11001001.01001100.00101011`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.01000000.00000000`<br>= **149.201.64.0** | Nicht identisch ❌<br>*(nicht selbes Subnetz)* |

#### Alternative Lösung (Effiziente Betrachtung des 3. Bytes)
Wir wollen wissen ob die IP-Adressen im Netzteil übereinstimmen. Dabei fällt auf, dass die ersten beiden Bytes bei allen drei Adressen identisch sind. Wir betrachten also nur das dritte Byte:
* Das dritte Byte der Subnetzmaske ist $192_{10} = 128_{10} + 64_{10} = 11000000_2$.
* In der Binärdarstellung sehen wir nun, dass nur die ersten beiden Bits des dritten Bytes relevant sind.

| IP-Adresse | 3. Byte (Dezimal) | 3. Byte (Binär) | Relevante Bits | Ergebnis |
| :--- | :---: | :--- | :---: | :---: |
| **Quell-IP** | `206` | `1100 1110` | **`11`** | Baseline |
| **1. Ziel-IP** | `198` | `1100 0110` | **`11`** | **Gleiches Netz** ✅ |
| **2. Ziel-IP** | `76` | `0100 1100` | **`01`** | **Anderes Netz** ❌ |

---

## Aufgabe 5

### Aufgabenstellung
Angenommen Ihr Rechner habe die IP-Adresse 149.201.1.54 und die Netzwerkmaske 255.255.192.0.
Ihr Rechner möchte an die folgenden Ziel-Adressen 149.201.198.112 und 149.201.76.43 ein IP-Paket versenden.
Befinden sich die Ziel-Adressen im selben IP-Subnetz wie die Ausgangsadresse? Woran erkennen Sie dies?

---

### Lösung

#### Standardlösung via AND-Verknüpfung

| Schritt | Adresse / Verknüpfung | Binärdarstellung | Ergebnis | Status |
| :--- | :--- | :--- | :--- | :---: |
| **Quell-IP & Maske** | `149.201.1.54 & 255.255.192.0` | `10010101.11001001.00000001.00110110`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.00000000.00000000`<br>= **149.201.0.0** | Ausgangsnetz |
| **1. Ziel-IP & Maske** | `149.201.198.112 & 255.255.192.0` | `10010101.11001001.11000110.01110000`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.11000000.00000000`<br>= **149.201.192.0** | Nicht identisch ❌<br>*(nicht selbes Subnetz)* |
| **2. Ziel-IP & Maske** | `149.201.76.43 & 255.255.192.0` | `10010101.11001001.01001100.00101011`<br>`11111111.11111111.11000000.00000000` | `10010101.11001001.01000000.00000000`<br>= **149.201.64.0** | Nicht identisch ❌<br>*(nicht selbes Subnetz)* |

#### Alternative Lösung (Effiziente Betrachtung des 3. Bytes)
Da die ersten beiden Bytes identisch sind, betrachten wir wieder nur die ersten zwei Bits des dritten Bytes:

| IP-Adresse | 3. Byte (Dezimal) | 3. Byte (Binär) | Relevante Bits | Ergebnis |
| :--- | :---: | :--- | :---: | :---: |
| **Quell-IP** | `1` | `0000 0001` | **`00`** | Baseline |
| **1. Ziel-IP** | `198` | `1100 0110` | **`11`** | **Anderes Netz** ❌ |
| **2. Ziel-IP** | `76` | `0100 1100` | **`01`** | **Anderes Netz** ❌ |

Beide Ziel-IPs liegen also nicht im gleichen Netz.

---

## Aufgabe 6

### Aufgabenstellung

#### Routingtabelle

| Ziel-IP-Adresse | Anschluss |
| :--- | :---: |
| `192.168.0.0/16` | 1 |
| `192.168.128.0/24` | 2 |
| `192.168.192.0/20` | 3 |
| `137.226.12.0/25` | 4 |
| `0.0.0.0/0` | 5 |

**Frage:** Auf welchen Anschluss wird ein Paket mit der Zieladresse **192.168.203.10** weitergeleitet?

---

### Lösung

#### Abgleich der Routingtabelle

| Ziel-IP-Adresse | Byte 1 | Byte 2 | Byte 3 | Byte 4 | Match? | Anschluss |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: |
| `192.168.0.0/16` | **1100 0000** | **1010 1000** | 0000 0000 | 0000 0000 | Passt ✅ | 1 |
| `192.168.128.0/24` | **1100 0000** | **1010 1000** | **10**00 0000 | 0000 0000 | Falsch ❌ | 2 |
| `192.168.192.0/20` | **1100 0000** | **1010 1000** | **1100** 0000 | 0000 0000 | Passt ✅ | 3 |
| `137.226.12.0/25` | — | — | — | — | Falsch ❌ | 4 |
| `0.0.0.0/0` | — | — | — | — | Default ✅ | 5 |
| **192.168.203.10** *(Ziel-IP)* | **1100 0000** | **1010 1000** | **1100** 1011 | 0000 1010 | **Gewählt: Anschluss 3** | **3 ✅** |

#### Erläuterung & Begründung
* Die Ziel-IP muss mit den relevanten Netz-Bits (entsprechend der CIDR-Präfixlänge) der Route übereinstimmen.
* **Erste Zeile (`192.168.0.0/16`):** Passt, da die ersten zwei Bytes (16 Bits) übereinstimmen.
* **Zweite Zeile (`192.168.128.0/24`):** Passt nicht, da sich das zweite Bit im dritten Byte unterscheidet (`10...` vs `11...`).
* **Dritte Zeile (`192.168.192.0/20`):** Passt, da die ersten vier Bits im dritten Byte (`1100`) exakt übereinstimmen.
* **Vierte Zeile:** Passt nicht.
* **Fünfte Zeile (`0.0.0.0/0`):** Default Route, passt immer.

**Ergebnis:** Von den drei passenden Routen (Anschluss 1, 3 und 5) wird nach der **Longest Prefix Match**-Regel die spezifischste Route gewählt (Anschluss 3 mit **/20**).
