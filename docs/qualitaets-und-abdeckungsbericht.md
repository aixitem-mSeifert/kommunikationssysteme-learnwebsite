# Qualitäts- und Abdeckungsbericht

Stand: 22.07.2026

## Themenstruktur

Die Website ordnet die 19 Vorlesungsextrakte und drei Prüfungsquellen acht Lernbereichen zu:

1. Grundlagen und Architekturen
2. Verteilte Anwendungen und Datendarstellung
3. IP-Adressierung, Vermittlung und Routing
4. Zuverlässiger Transport und TCP
5. UDP, Multimedia und Anwendungsprotokolle
6. Sicherungsschicht, LAN und Ethernet
7. Fehlererkennung und Fehlerkorrektur
8. Bitübertragung und drahtlose Netze

Jeder Inhaltsblock nennt Quellenstatus und Fundstelle. `belegt` erlaubt reguläre Aussagen; `mehrdeutig`, `historisch/vereinfacht`, `unklar` und `Gedächtnisprotokoll` erzeugen einen sichtbaren Hinweis. Gedächtnisprotokolle steuern nur Relevanz und Aufgabenstil bei.

## Abdeckungsmatrix

Abkürzungen: `G` = Glossar, `K` = Lernkarte, `Q` = Quizfrage, `E` = Klausuraufgabe. 54 Begriffskarten werden aus dem Glossar erzeugt; zwölf zusätzliche Karten üben Abläufe, Vergleiche und Rechenschemata. Jede Karte besitzt eigene Quellenangaben.

| Quelldatei | Erkannte Themen | Lernbereich / Lernseite | Methodenbeschreibung | G | K | Q | E | Erkennbare Lücken |
|---|---|---|---|---|---|---|---|---|
| `Kommunikationssysteme_1_Einfu╠êhrung.txt` | Rollenmodelle, Kommunikationsarten, Netzklassen, Topologien, Graphmetriken | 1 / `grundlagen-und-schichten` | Vergleiche der Rollen und Kommunikationsarten; Metriken mit Bedeutung | Broadcast, Forward-/Reverse-Proxy | ja | q01, q04, q41 | 2016 A1; 2015/2018 Block 1 | Keine fachliche Lücke; Dateiname mit Unicode-Artefakt |
| `Kommunikationssysteme_2_Schichtenmodell.txt` | Protokoll, Dienst, Schnittstelle, Modularisierung, OSI, TCP/IP, Kapselung | 1 / `grundlagen-und-schichten` | Kapselung und vollständige Schichtfunktionen | Protokoll, Dienst, PDU | ja | q02, q03, q42 | 2016 A1; 2015/2018 Block 1 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_3_Sockets.txt` | Ports, Socket/ServerSocket, TCP-Client/Server, Blockierung, Threads | 2 / `sockets-und-datenformate` | Voraussetzungen, Server-/Client-Schritte, Ergebnis und Thread-Begründung | Socket, ServerSocket | ja | q06, q10, q43 | 2018 Block 3 nur thematisch angrenzend | Kein Programmieren verlangt; Code bleibt Ablaufquelle |
| `Kommunikationssysteme_4_Darstellung.txt` | Endianness, Marshalling, ASN.1/BER, Serialisierung, XML/XSD, JSON | 2 / `sockets-und-datenformate` | Marshalling-, Serialisierungs- und XSD-Abläufe; Formatvergleich | Marshalling, ASN.1, XML, XSD | ja | q07–q09, q44 | 2018 Block 3 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_5_Einfu╠êhrung_IP_Adressen.txt` | Internet/AS, IPv4, Klassen, privat/Loopback, Subnetting | 3 / `adressierung-und-routing` | Netz-, Broadcast-, Hostbereich- und Eigenes-Subnetz-Bestimmung | MTU thematisch später; IPv4-Begriffe im Lerntext | indirekt | q11, q46 | 2016 A2; 2015/2018 Block 2 | Private Bereichsnotation zu Folie 7 mehrdeutig; Dateiname beschädigt |
| `Kommunikationssysteme_6_CIDR.txt` | CIDR, LPM, Default-/Hostroute, Delegation, Aggregation | 3 / `adressierung-und-routing` | LPM und Aggregation mit Voraussetzungen, Ausnahmen und Ergebnis | CIDR, LPM, Routenaggregation | ja | q12, q45 | 2016 A2; 2015/2018 Block 2 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_7_NAT.txt` | NAT/NAPT, Tabellen, Traversal, vier NAT-Typen | 3 / `adressierung-und-routing` | Ausgehende und eingehende Tabellenübersetzung; Typen und Folgen | NAT, NAPT | ja | über Bereichsquiz; Anwendung im Lerntext | thematisch in IP-Blöcken | Private Bereichsnotation zu Folie 5 mehrdeutig |
| `Kommunikationssysteme_8_Routingprotokolle.txt` | Control/Data Plane, Intra-/Inter-AS, Link State, Dijkstra, Distance Vector, RIP/OSPF/IS-IS/BGP | 3 / `adressierung-und-routing` | Dijkstra und Distance Vector mit Eingaben, Schritten, Ergebnis und Abgrenzung | Dijkstra, Distance Vector | ja | Routing-/LPM-Transfer im Bereich | 2015/2018 Block 2 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_9_ARP_ICMP_IP.txt` | ARP/RARP/DHCP, IPv4-Header, Fragmentierung, ICMP, IPv6 | 3 / `adressierung-und-routing` | ARP-Ablauf, DHCP-Zweck, vollständige Fragmentierung | ARP-Schicht, MTU, IPv6 | ja | q13–q15 | 2016 A2; 2015/2018 Block 2 | ICMP-Typnummern beschädigt; IPv6/ICMP historisch oder vereinfacht |
| `Kommunikationssysteme_10_SendWait.txt` | Zuverlässigkeit, Stop-and-Wait, Verlustfälle, Sequenznummern, Auslastung, Pipelining | 4 / `zuverlaessigkeit-und-tcp` | Datenverlust, ACK-Verlust, Duplikat und Nutzungsgrad schrittweise | RTT als verwandter Begriff | indirekt | q16, q47 | 2015 Block 3 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_11_SlidingWindow.txt` | Fenster, BDP, GBN, SR, Selective Reject, ACK-Arten | 4 / `zuverlaessigkeit-und-tcp` | Verfahren, Pufferung, Timeout und ACK-Verhalten abgegrenzt | Sliding Window, Go-Back-N, Selective Repeat, RTT | ja | q17, q18 | 2016 A3; 2015/2018 Block 3/4 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_12_TCP.txt` | Receiver/Congestion Window, RTT/Timeout, Stauphasen, Handshakes, Header, Optionen | 4 / `zuverlaessigkeit-und-tcp` | Fluss-/Staukontrolle, RTT-Nachführung, Auf-/Abbau | Congestion Window, Fast Retransmit, Window Scale | ja | q19, q20, q48 | 2016 A3; 2015 Block 3 | Window-Scale-Maximalformel durch Extraktion beschädigt |
| `Kommunikationssysteme_13_UDP.txt` | UDP, Checksumme, Digitalisierung, Bitrate, Streaming, Medienprotokolle | 5 / `udp-dns-und-anwendungsprotokolle` | Medienpipeline, Bitratenrechnung und Playback-Puffer | UDP, Playback-Puffer | ja | q21, q49 | thematische Transferübungen | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_14_DNS.txt` | Namensraum, FQDN, Domäne/Zone, Delegation, Records, Auflösung, Caching, Angriffe | 5 / `udp-dns-und-anwendungsprotokolle` | iterative/rekursive Auflösung mit Rollen und Ergebnis | DNS, DNS-Zone, Resource Record | ja | q22 | thematische Transferübungen | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_15_Anwendungsprotokolle.txt` | HTTP-Ausschnitt, TLS, FTP, E-Mail, SSH, SNMP | 5 / `udp-dns-und-anwendungsprotokolle` | belegter HTTP-Abruf, klassischer TLS-Ablauf, FTP-Modi, Mailrollen, Port-Forwarding | HTTP, TLS, Keystore/Truststore, MIME, MIB | ja | q23–q25, q50 | 2018 Block 3 | HTTP vor Folie 475 fehlt; TLS/SSH historisch; Keystore/Truststore nicht ausreichend erklärt |
| `Kommunikationssysteme_16_Einfuehrung_Sicherungsschicht_Netztechnik.txt` | Linkdienste, Topologien, Komponenten, Switch-Learning, Medien | 6 / `lan-und-ethernet` | Switch-Learning, unbekanntes Ziel und Broadcast schrittweise | Bridge | ja | q26, q51 | 2018 Block 5 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_17_Kanalzuteilung.txt` | TDMA/FDMA/ALOHA, CSMA/CD, BEB, Ethernet, Fast/Gigabit, Token Ring | 6 / `lan-und-ethernet` | CSMA/CD/BEB, Rahmenfelder, Mindestlänge, Token-Ablauf | CSMA/CD, Ethernet-Mindestlänge, BEB, Token Ring | ja | q27–q30, q52 | 2016 A5; 2015/2018 Block 5 | 60/64-Byte-Konflikt mit 2015; beschädigter FCS-/ACK-Satz ausgeschlossen |
| `Kommunikationssysteme_18_Fehlerkorrektur.txt` | Hamming, Parität, FEC/ARQ, CRC, FCS | 7 / `hamming-und-crc` | CRC einschließlich schriftlicher XOR-Division; Hamming-Regeln | Hamming-Abstand, CRC, FEC | ja | q31–q35, q53, q54 | 2016 A5; 2015/2018 Block 5 | Keine erkennbare quellengetragene Lücke |
| `Kommunikationssysteme_19_Bitu╠êbertragungsschicht.txt` | Leitungscodes, Blockcodes, Baud/Bit, Modulation, Shannon, WLAN/CSMA/CA | 8 / `leitungscodes-modulation-wlan` | Zeichenregeln, Blockcodierung, Modulationsvergleich, CSMA/CA-Sequenz | Baud, QPSK, Manchester, CSMA/CA, Hidden Station | ja | q36–q40, q55, q56 | 2016 A4/A5; 2015/2018 Block 4/5 | Allgemeine Baud-/Bitratenformel beschädigt; Dateiname mit Unicode-Artefakt |
| `2015-02 Rechnernetze Klausur Gedächtnisprotokoll.txt` | Fünf Blöcke: Modelle, IP, Fenster, Codes, Ethernet/WLAN/Parität | alle relevanten Bereiche; eigenes 2015-Themenset | foliengestützte Methoden in den jeweiligen Lernseiten | keine allein daraus abgeleitete Definition | Quellenlückenkarten nur transparent | Relevanz, keine autoritative Fachfrage | fünf unbewertete Blöcke | Keine autorisierten Punkte, Zeit oder Lösungen; 60-Byte-Angabe widerspricht stärkeren Quellen |
| `2016 SoSe Rechnernetze Probeklausur.txt` | Offizielle fünf Aufgabenblöcke | Bereiche 1, 3, 4, 6–8; vollständige Simulation | konkrete Rechnungen, Zeichnungen und Fehlerabläufe | Chordaler Ring als Lücke | Lückenkarte | q05, q45, q46, q48, q52 | 120 min, 85 Punkte, Gewichtung 20/20/15/18/12 | Chordaler Ring wird gefragt, aber in den Folien nicht erklärt |
| `2018-07-20 Rechnernetze Gedächtnisprotokoll.txt` | Schichten, CIDR/IP, TLS/Serialisierung, GBN, Bridge/Ethernet/CRC | alle relevanten Bereiche; eigenes 2018-Themenset | foliengestützte Methoden in den jeweiligen Lernseiten | Keystore/Truststore als Lücke | Lückenkarte | q25 und thematisch verwandte Fragen | fünf unbewertete Blöcke | Keine autorisierten Punkte, Zeit oder Lösungen; Keystore/Truststore unzureichend belegt |

## Prüfungsrelevante Methoden

- Subnetz, Broadcast und Hostbereich aus Präfix und Adresse bestimmen
- Longest Prefix Match und CIDR-Routenaggregation
- Dijkstra, Distance Vector und NAT-/NAPT-Tabellenübersetzung
- ARP sowie ein- und mehrstufige IP-Fragmentierung
- Stop-and-Wait-Verlustfälle, Go-Back-N und Selective Repeat
- Fensterdurchsatz, Bandwidth-Delay-Produkt und TCP-Staukontrolle
- DNS-Auflösung und klassischer TLS-Ablauf gemäß Unterlagen
- Switch-Learning, CSMA/CD, Binary Exponential Backoff und Ethernet-Mindestlänge
- Hamming-Regeln und schriftliche CRC-Division
- Leitungscodes zeichnen, Modulationen vergleichen und CSMA/CA verfolgen

## Bekannte offene Quellenlücken

- Definition und Vorteile eines chordalen Rings
- HTTP-Grundlagen vor der extrahierten Folie 475
- konkrete Keystore-/Truststore-Inhalte und Codefragen
- beschädigte Window-Scale-Maximalrechnung
- beschädigte allgemeine Baud-/Bitratenformel
- unsichere ICMP-Typnummern
- Widerspruch 60/64 Byte bei der Ethernet-Mindestlänge
- beschädigter FCS-/ACK-Satz
- autorisierte Lösungen, Punkte und Zeiten der Gedächtnisprotokolle 2015/2018

Diese Punkte erscheinen auf den betroffenen Lern- oder Trainingsseiten sichtbar als `unklar`, `mehrdeutig`, `historisch/vereinfacht` oder `Gedächtnisprotokoll`. Sie wurden nicht mit externem Wissen geschlossen.

## Ausgeführte Prüfungen

- rekursiver PHP-Syntaxcheck mit `C:\xampp\php\php.exe -l`
- JavaScript-Syntaxcheck mit `node --check`
- `php scripts/validate-data.php` für IDs, Relationen, Quellenstatus, Quellenabdeckung, mindestens zwei Anwendungsfragen und eine Methodenlernkarte je Bereich, Frageantworten, Klausurpunkte, Originalgewichtung 2016 und unbewertete Gedächtnisprotokolle
- HTTP-Smoke-Test aller Einstiegseiten, Lernbereiche und Themen
- interner Link-Crawl und kontrollierter 404-Test
- Suche nach Grundgerüst-Platzhaltern
- Editor-Diagnostik
- statische Prüfung der mobilen CSS-Breakpoints, Fokusdarstellung, Labels, Skip-Link, dynamischen Datenmengen und Lösungssperre vor Klausurabgabe

Im Projekt ist kein Browser-Automatisierungswerkzeug installiert. Eine abschließende Sichtprüfung in echten mobilen und Desktop-Viewports sowie die Kontrolle der Browser-Konsole bleiben daher manuell durchzuführen.