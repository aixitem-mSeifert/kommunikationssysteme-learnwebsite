# Sliding Window – Aufgaben und Lösungen

## 1. Aufgabe: 4K-Streaming auf dem Mond

### Aufgabenstellung
Die Astronautinnen auf einer Mondstation möchten gerne einen Streamingdienst in 4K nutzen. Die dazu benötigte Bandbreite sei $24\text{ Mbit/s}$. Die Lichtlaufzeit von der Erde zum Mond (eine Richtung) betrage $1{,}5\text{ Sekunden}$.

Zur Kommunikation wird ein Sliding-Window-Protokoll verwendet.
1. Wie groß muss die Window-Größe (in MB) mindestens sein, damit die Astronautinnen entspannt Filme schauen können?
2. Ist die errechnete Fenstergröße möglich?

---

### Lösung

#### Gegebene Parameter

| Parameter | Wert | Beschreibung |
| :--- | :--- | :--- |
| **Erwünschte Datenrate ($R$)** | $24\text{ Mbit/s} = 24 \cdot 10^6\text{ Bit/s}$ | Benötigte Bandbreite für 4K-Stream |
| **Lichtlaufzeit (Einfach)** | $1{,}5\text{ s}$ | Laufzeit Erde $\rightarrow$ Mond |
| **Round Trip Time ($	ext{RTT}$)** | $2 \cdot 1{,}5\text{ s} = 3\text{ s}$ | Hin- und Rücklaufzeit |

#### Berechnung (Bandwidth-Delay Product)

$$\text{Übertragungsfenster} = R \cdot \text{RTT}$$

| Schritt | Formel / Rechnung | Ergebnis |
| :--- | :--- | :--- |
| **Bit** | $24 \cdot 10^6\text{ Bit/s} \cdot 3\text{ s}$ | $72 \cdot 10^6\text{ Bit}$ |
| **Byte** | $\frac{72}{8} \cdot 10^6\text{ Byte}$ | $9 \cdot 10^6\text{ Byte}$ |
| **Megabyte (MB)** | $9 \cdot 10^6\text{ Byte}$ | **$9\text{ MB}$** |

#### Antworten auf die Fragen

* **Mindestgröße des Windows:** Das Übertragungsfenster muss mindestens **$9\text{ MB}$** groß sein.
* **Möglichkeit der Fenstergröße:** Diese Fenstergröße ist nur mit der **TCP Window Scale Option** (RFC 1323/7323) möglich, da das Standard-TCP-Fenster auf $64\text{ KiB}$ ($65.536\text{ Byte}$) beschränkt ist.

---

## 2. Aufgabe: Maximale Datenrate zum Mars

### Aufgabenstellung
Die Default-Maximalgröße eines Übertragungsfensters ist $65.536\text{ Byte}$ ($64\text{ KiB}$). Die Lichtlaufzeit bis zum Mars beträgt im besten Fall $3\text{ Minuten}$ (eine Richtung).

Welche Datenrate ließe sich unter diesen Voraussetzungen maximal erzielen?  
*Geben Sie das Ergebnis in $\text{kbit/s}$ auf zwei Nachkommastellen gerundet an.*

---

### Lösung

#### Gegebene Parameter

| Parameter | Wert | Beschreibung |
| :--- | :--- | :--- |
| **Fenstergröße ($W$)** | $65.536\text{ Byte} = 65.536 \cdot 8\text{ Bit} = 524.288\text{ Bit}$ | Max. Standard-TCP-Fenstergröße |
| **Lichtlaufzeit (Einfach)** | $3\text{ Minuten}$ | Laufzeit Erde $\rightarrow$ Mars |
| **Round Trip Time ($	ext{RTT}$)** | $2 \cdot 3\text{ Min} = 6\text{ Min} = 360\text{ s}$ | Hin- und Rücklaufzeit |

#### Berechnung

$$\text{Datenrate} = \frac{\text{Fenstergröße}}{\text{RTT}}$$

| Schritt | Rechnung | Ergebnis |
| :--- | :--- | :--- |
| **Bit pro Sekunde** | $\frac{524.288\text{ Bit}}{360\text{ s}}$ | $\approx 1.456{,}36\text{ Bit/s}$ |
| **KBit pro Sekunde** | $\frac{1.456{,}36\text{ Bit/s}}{1.000}$ | **$1{,}46\text{ kbit/s}$** |

#### Antwort

Unter den gegebenen Voraussetzungen lässt sich maximal eine Datenrate von **$1{,}46\text{ kbit/s}$** erzielen.
