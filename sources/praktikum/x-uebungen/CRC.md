# CRC-Berechnung (Cyclic Redundancy Check)

## Aufgabenstellung

Wir üben im Folgenden das CRC-Verfahren. Als Grundlage wird das Generatorpolynom $x^5 + x^2 + x^1$ herangezogen.

1. Berechnen Sie nun die CRC-Prüfsumme zur Bitfolge `100100011101`.
2. Welche Nachricht wird übertragen?

---

## Lösung

### 1. Vorbereitung und Grundlagen

Um die Lösung bestimmen zu können, muss die Bitfolge um $\text{grad}(\text{Generatorpolynom}) = n$ Nullen ergänzt werden.

| Parameter | Wert / Darstellung | Erläuterung |
| :--- | :--- | :--- |
| **Generatorpolynom $G(x)$** | $x^5 + x^2 + x^1$ | Coeffs: $1\cdot x^5 + 0\cdot x^4 + 0\cdot x^3 + 1\cdot x^2 + 1\cdot x^1 + 0\cdot x^0$ |
| **Divisor (Bitfolge)** | `100110` | Länge = 6 Bits |
| **Grad $n$ des Polynoms** | `5` | Höchste Potenz $x^5$ |
| **Originale Bitfolge** | `100100011101` | Datenbits (12 Bits) |
| **Anzuhängende Nullen** | `00000` | $n = 5$ Nullen |
| **Erweiterte Bitfolge** | `10010001110100000` | Zu dividierender Wert (17 Bits) |

---

### 2. Schritt-für-Schritt Modulo-2-Division (XOR)

Die Division erfolgt durch stufenweise Modulo-2-Subtraktion (XOR-Verknüpfung):

| Schritt | Aktueller Dividend | XOR mit | Ergebnis | Nächstes Bit | Neuer Dividend |
| :---: | :---: | :---: | :---: | :---: | :---: |
| **1** | `100100` | `100110` | `000010` | `0` | `000100` |
| **2** | `000100` | `000000` | `000100` | `0` | `001001` |
| **3** | `001001` | `000000` | `001001` | `1` | `010011` |
| **4** | `010011` | `000000` | `010011` | `1` | `100111` |
| **5** | `100111` | `100110` | `000001` | `0` | `000010` |
| **6** | `000010` | `000000` | `000010` | `1` | `000101` |
| **7** | `000101` | `000000` | `000101` | `0` | `001010` |
| **8** | `001010` | `000000` | `001010` | `0` | `010100` |
| **9** | `010100` | `000000` | `010100` | `0` | `101000` |
| **10** | `101000` | `100110` | `001110` | `0` | `011100` |
| **11** | `011100` | `000000` | `011100` | `0` | `111000` |
| **12** | `111000` | `100110` | `011110` | - | **`11110` (Rest)** |

---

### 3. Schriftlicher Divisionsverlauf

```text
  10010001110100000 : 100110
  100110
  ------
  0000100
     000000
     ------
     0001001
        000000
        ------
        0010011
           000000
           ------
           0100111
              100110
              ------
              0000010
                 000000
                 ------
                 0000101
                    000000
                    ------
                    0001010
                       000000
                       ------
                       0010100
                          000000
                          ------
                          0101000
                             100110
                             ------
                             0011100
                                000000
                                ------
                                0111000
                                   100110
                                   ------
                                    11110  <-- CRC-Prüfsumme (Rest)
```

---

### 4. Ergebnisse

* **CRC-Prüfsumme**: `11110`
* **Übertragene Nachricht**: `10010001110111110` (Originale Bitfolge + CRC-Prüfsumme)
