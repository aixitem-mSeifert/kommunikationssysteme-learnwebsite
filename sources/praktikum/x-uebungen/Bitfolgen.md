# Bitfolgen

## 1. Aufgabe
Stellen Sie die Bitfolge **0 1 1 0 0 1 1 0 0 0 1** im Manchester-Code (nach IEEE 802.3) dar.

### Lösung
*Hinweis: Nach IEEE 802.3 entspricht '0' einem Übergang von High nach Low (High→Low) und '1' einem Übergang von Low nach High (Low→High).*

| Bit | 0 | 1 | 1 | 0 | 0 | 1 | 1 | 0 | 0 | 0 | 1 |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Signalverlauf (IEEE 802.3)** | High $\rightarrow$ Low | Low $\rightarrow$ High | Low $\rightarrow$ High | High $\rightarrow$ Low | High $\rightarrow$ Low | Low $\rightarrow$ High | Low $\rightarrow$ High | High $\rightarrow$ Low | High $\rightarrow$ Low | High $\rightarrow$ Low | Low $\rightarrow$ High |
| **1. Hälfte der Bit-Zeit** | High | Low | Low | High | High | Low | Low | High | High | High | Low |
| **2. Hälfte der Bit-Zeit** | Low | High | High | Low | Low | High | High | Low | Low | Low | High |

---

## 2. Aufgabe
Welche Bitfolge dekodiert der Empfänger bei Benutzung des Manchester-Codes (nach IEEE)?

### Lösung

| Signalverlauf | High $\rightarrow$ Low | Low $\rightarrow$ High | Low $\rightarrow$ High | High $\rightarrow$ Low | Low $\rightarrow$ High | High $\rightarrow$ Low | High $\rightarrow$ Low | High $\rightarrow$ Low | Low $\rightarrow$ High | Low $\rightarrow$ High | High $\rightarrow$ Low |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Dekodierte Bitfolge** | **1** | **0** | **0** | **1** | **0** | **1** | **1** | **1** | **0** | **0** | **1** |

---

## 3. Aufgabe
Wie groß ist die Hamming-Distanz der beiden Bitfolgen **10101110** und **10110100**?

### Lösung
$$\begin{array}{rccccccccl}
& 1 & 0 & 1 & 0 & 1 & 1 & 1 & 0 & \\
\text{XOR} & 1 & 0 & 1 & 1 & 0 & 1 & 0 & 0 & \\
\hline
= & 0 & 0 & 0 & \mathbf{1} & \mathbf{1} & 0 & \mathbf{1} & 0 & \rightarrow \text{3 Einsen}
\end{array}$$

$\rightarrow$ **Hamming-Distanz ist 3**

---

## 4. Aufgabe
Stellen Sie die Bitfolge **0 0 1 1 1 0 1 0 0 0 1 0** im differentiellen NRZ-Code dar.

### Lösung
*Als Startsignalpegel wurde hier High gewählt, wenn man Low wählt, dann ist das dargestellte Signal dementsprechend gespiegelt.*

#### Differentieller NRZ-Code (Startpegel = High)
*(Hinweis: Bei '0' bleibt der Pegel gleich, bei '1' wechselt der Pegel)*

| Bit-Zeit | 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12 |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Bitwert** | - | 0 | 0 | 1 | 1 | 1 | 0 | 1 | 0 | 0 | 0 | 1 | 0 |
| **Pegel** | **High** | High | High | Low | High | Low | Low | High | High | High | High | Low | Low |

#### Differentieller NRZ-Code (Startpegel = Low)

| Bit-Zeit | 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12 |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Bitwert** | - | 0 | 0 | 1 | 1 | 1 | 0 | 1 | 0 | 0 | 0 | 1 | 0 |
| **Pegel** | **Low** | Low | Low | High | Low | High | High | Low | Low | Low | Low | High | High |

---

Stellen Sie die gleiche Bitfolge im NRZ-Code dar.

### Lösung

#### NRZ-Code (direkt)
*(Hinweis: High für Bit '1', Low für Bit '0')*

| Bit-Zeit | 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12 |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Bitwert** | - | 0 | 0 | 1 | 1 | 1 | 0 | 1 | 0 | 0 | 0 | 1 | 0 |
| **Pegel** | **Low** | Low | Low | High | High | High | Low | High | Low | Low | Low | High | Low |