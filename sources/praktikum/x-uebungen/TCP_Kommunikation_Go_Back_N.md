# TCP Kommunikation 2 – Go-Back-N

## Aufgabenstellung

Angenommen zwei Kommunikationspartner haben sich zur Fehlerkontrolle auf das Verfahren **Go-Back-N** verständigt und das Sliding Window habe die Größe 7. Vereinfachend gehen wir von folgenden Annahmen aus:

* Alle Datenpakete haben dieselbe Länge und benötigen dieselbe Übertragungszeit
* Wenn der Sender Paket $n$ sendet, kommt gleichzeitig Paket $n-1$ beim Empfänger an
* Die Quittung für Paket $n$ trifft gleichzeitig mit dem Senden von Paket $n+4$ ein
* Der Timer zum Warten auf die Quittung für Paket $n$ läuft nach dem Senden von Paket $n+5$ ab

**Hinweise:**
* Der Empfänger puffert nur das als nächstes erwartete Segment; nicht erwartete Segmente werden verworfen
* In dem gefragten Szenario werden kumulative Bestätigungen verwendet
* Delayed Acknowledgments werden nicht verwendet

Skizzieren Sie den Ablauf der Kommunikation für die folgenden Fälle:

1. Paket 2 kommt beim ersten Mal nicht an
2. Die Quittung für Paket 2 geht verloren

> **Hinweis:** In die mittlere Spalte können Sie Kommentare eintragen (z.B. ACK3, timout #x); Sie können aber auch einfach, wie in den Vorlesungsunterlagen, Pfeile zur Verdeutlichung des Ablaufes in die Tabellen einzeichnen. Achten Sie in jedem Fall darauf, dass ein korrektes Timing erkennbar bleibt!

---

## Lösung

### Paket 2 geht verloren

| Sender Paket# | Kommentar | Empfänger Paket# |
| :---: | :--- | :---: |
| 1 | | |
| 2 | packet 2 lost $ightarrow$<br>no more ACKs... | 1 |
| 3 | | - |
| 4 | | - |
| 5 | $\leftarrow$ ACK2 | - |
| 6 | missing ACK3 | - |
| 7 | missing ACK3, **timeout #2** | - |
| 2 | resend | - |
| 3 | | 2 |
| 4 | | 3 |
| 5 | | 4 |
| 6 | $\leftarrow$ ACK3 | 5 |
| 7 | $\leftarrow$ ACK4 | 6 |
| 8 | $\leftarrow$ ACK5 | 7 |
| 9 | $\leftarrow$ ACK6 | 8 |
| 10 | $\leftarrow$ ACK7 | 9 |

---

### Quittung für Paket 2 geht verloren

| Sender Paket# | Kommentar | Empfänger Paket# |
| :---: | :--- | :---: |
| 1 | | |
| 2 | | 1 |
| 3 | | 2 |
| 4 | | 3 |
| 5 | $\leftarrow$ ACK2 | 4 |
| 6 | **(ACK3 lost)** | 5 |
| 7 | $\leftarrow$ **ACK4; kill Timer for #2** | 6 |
| 8 | $\leftarrow$ ACK5 | 7 |
| 9 | $\leftarrow$ ACK6 | 8 |
| 10 | $\leftarrow$ ACK7 | 9 |
