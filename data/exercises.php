<?php

$sourceRef = static fn (string $sourceId, string $locator): array => [
    'sourceId' => $sourceId,
    'locatorType' => 'lecture',
    'locator' => $locator,
    'sourceStatus' => 'belegt',
];
$table = static fn (string $title, array $headers, array $rows): array => [
    'title' => $title,
    'headers' => $headers,
    'rows' => $rows,
];
$task = static fn (string $title, string $prompt, array $solution, ?array $exerciseTable = null): array => [
    'title' => $title,
    'prompt' => $prompt,
    'table' => $exerciseTable,
    'solution' => $solution,
];

return [
    [
        'id' => 'exercise-cidr',
        'title' => 'CIDR',
        'description' => 'Subnetze bilden, Adressbereiche bestimmen und CIDR-Präfixe sicher anwenden.',
        'topics' => ['CIDR', 'Subnetzmasken', 'Netz- und Broadcastadressen', 'Hostbereiche'],
        'tasks' => [
            $task('Vier gleich große Subnetze', 'Teile das Netz 192.168.40.0/24 in vier gleich große Subnetze. Ergänze die Tabelle. Trage die erste und letzte nutzbare Hostadresse ein; Netz- und Broadcastadresse sind keine Hosts.', [
                'steps' => ['Vier Subnetze benötigen 2 zusätzliche Präfixbits: /24 wird zu /26.', 'Ein /26-Netz enthält 64 Adressen, davon sind 62 als Hosts nutzbar.', 'Die Blockgröße im letzten Oktett beträgt 64.'],
                'table' => $table('Lösung: Subnetze', ['Subnetz', 'Präfix', 'Netzadresse', 'Erster Host', 'Letzter Host', 'Broadcast'], [
                    ['1', '/26', '192.168.40.0', '192.168.40.1', '192.168.40.62', '192.168.40.63'], ['2', '/26', '192.168.40.64', '192.168.40.65', '192.168.40.126', '192.168.40.127'], ['3', '/26', '192.168.40.128', '192.168.40.129', '192.168.40.190', '192.168.40.191'], ['4', '/26', '192.168.40.192', '192.168.40.193', '192.168.40.254', '192.168.40.255'],
                ]),
                'result' => 'Alle vier Subnetze sind gleich groß und decken den ursprünglichen Bereich vollständig ab.',
            ], $table('Subnetze zum Ausfüllen', ['Subnetz', 'Präfix', 'Netzadresse', 'Erster Host', 'Letzter Host', 'Broadcast'], [
                ['1', '', '', '', '', ''], ['2', '', '', '', '', ''], ['3', '', '', '', '', ''], ['4', '', '', '', '', ''],
            ])),
            $task('Netzbereich eines Präfixes', 'Analysiere 10.34.13.77/21. Bestimme Subnetzmaske, Netzadresse, Broadcastadresse, nutzbaren Hostbereich und die Anzahl nutzbarer Hosts.', [
                'steps' => ['Das Präfix /21 entspricht der Maske 255.255.248.0.', 'Im dritten Oktett ist die Blockgröße 256 - 248 = 8. Die 13 liegt im Block 8 bis 15.', 'Damit reicht das Netz von 10.34.8.0 bis 10.34.15.255.', 'Es bleiben 11 Hostbits: 2^11 - 2 = 2046 nutzbare Hosts.'],
                'table' => $table('Lösung: Netzbereich', ['Angabe', 'Wert'], [
                    ['Subnetzmaske', '255.255.248.0'], ['Netzadresse', '10.34.8.0'], ['Erster Host', '10.34.8.1'], ['Letzter Host', '10.34.15.254'], ['Broadcastadresse', '10.34.15.255'], ['Nutzbare Hosts', '2046'],
                ]),
            ], $table('Netzbereich zum Ausfüllen', ['Angabe', 'Wert'], [
                ['Subnetzmaske', ''], ['Netzadresse', ''], ['Erster Host', ''], ['Letzter Host', ''], ['Broadcastadresse', ''], ['Nutzbare Hosts', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s06', 'CIDR, Präfixe und Subnetzberechnung')],
    ],
    [
        'id' => 'exercise-mtu',
        'title' => 'MTU',
        'description' => 'IPv4-Fragmentierung mit Total Length, Fragment Offset und MF-Flag berechnen.',
        'topics' => ['MTU', 'IP-Fragmentierung', 'Fragment Offset', 'MF-Flag'],
        'tasks' => [
            $task('Fragmentierung auf einer Ethernet-Strecke', 'Ein IPv4-Datagramm enthält 3500 Byte Nutzdaten und einen 20 Byte großen Header. Die nächste Strecke hat eine MTU von 1500 Byte. Zerlege das Datagramm. Nutzdatenfragmente müssen, außer dem letzten, durch 8 teilbar sein.', [
                'steps' => ['Maximale Nutzdaten pro Fragment: floor((1500 - 20) / 8) * 8 = 1480 Byte.', 'Die Nutzdaten werden in 1480 + 1480 + 540 Byte geteilt.', 'Der Fragment Offset zählt in 8-Byte-Einheiten: 0, 1480/8 = 185 und 2960/8 = 370.', 'MF ist bei allen Fragmenten außer dem letzten 1.'],
                'table' => $table('Lösung: Fragmente', ['Fragment', 'Nutzdaten', 'Total Length', 'Offset (8 Byte)', 'MF'], [
                    ['1', '1480 Byte', '1500 Byte', '0', '1'], ['2', '1480 Byte', '1500 Byte', '185', '1'], ['3', '540 Byte', '560 Byte', '370', '0'],
                ]),
            ], $table('Fragmente zum Ausfüllen', ['Fragment', 'Nutzdaten', 'Total Length', 'Offset (8 Byte)', 'MF'], [
                ['1', '', '', '', ''], ['2', '', '', '', ''], ['3', '', '', '', ''],
            ])),
            $task('Zweite Fragmentierung', 'Ein bereits als IPv4-Datagramm vorliegendes Paket hat insgesamt 2600 Byte (davon 20 Byte Header). Es muss über eine Strecke mit MTU 1000 Byte übertragen werden. Berechne die neuen Fragmente.', [
                'steps' => ['Maximale Nutzdaten pro Fragment: floor((1000 - 20) / 8) * 8 = 976 Byte.', 'Die 2580 Byte Nutzdaten werden als 976 + 976 + 628 Byte übertragen.', 'Die Offsets sind 0, 976/8 = 122 und 1952/8 = 244.'],
                'table' => $table('Lösung: zweite Fragmentierung', ['Fragment', 'Nutzdaten', 'Total Length', 'Offset (8 Byte)', 'MF'], [
                    ['1', '976 Byte', '996 Byte', '0', '1'], ['2', '976 Byte', '996 Byte', '122', '1'], ['3', '628 Byte', '648 Byte', '244', '0'],
                ]),
            ], $table('Fragmente zum Ausfüllen', ['Fragment', 'Nutzdaten', 'Total Length', 'Offset (8 Byte)', 'MF'], [
                ['1', '', '', '', ''], ['2', '', '', '', ''], ['3', '', '', '', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s09', 'IPv4-Header, Fragmentierung und Fragment Offset')],
    ],
    [
        'id' => 'exercise-mtu-programm',
        'title' => 'MTU (Programm)',
        'description' => 'Eine Fragmentierungslogik als kleine, testbare Java-Komponente entwerfen.',
        'topics' => ['Java', 'Objektmodell', 'Fragmentierungslogik', 'JUnit'],
        'tasks' => [
            $task('Modell und Algorithmus', 'Entwirf die Klassen Packet und Route. Packet soll mindestens Nutzdatenlänge, Headerlänge, Identifikation, Offset und MF-Flag enthalten. Route.processPacket(packet) soll bei zu kleiner MTU Fragmente erzeugen. Notiere die drei wichtigsten Regeln für die Methode.', [
                'steps' => ['Die maximale Fragmentnutzlast ist floor((MTU - Headerlänge) / 8) * 8; ein MTU-Wert kleiner oder gleich der Headerlänge ist ungültig.', 'Jedes Fragment übernimmt die Identifikation des ursprünglichen Pakets. Der Offset wird in 8-Byte-Einheiten gespeichert.', 'MF ist 1, solange nach dem Fragment noch Nutzdaten folgen, und 0 beim letzten Fragment.', 'Die Methode sollte ein Paket ohne Fragmentierung als Einzelelement zurückgeben, wenn seine Gesamtlänge die MTU nicht überschreitet.'],
                'code' => "List<Packet> processPacket(Packet packet) {\n    int maxPayload = ((mtu - packet.headerLength) / 8) * 8;\n    if (maxPayload <= 0) throw new IllegalArgumentException();\n\n    List<Packet> fragments = new ArrayList<>();\n    int offsetBytes = 0;\n    while (offsetBytes < packet.payloadLength) {\n        int remaining = packet.payloadLength - offsetBytes;\n        int payload = Math.min(maxPayload, remaining);\n        boolean moreFragments = offsetBytes + payload < packet.payloadLength;\n        fragments.add(packet.fragment(payload, offsetBytes / 8, moreFragments));\n        offsetBytes += payload;\n    }\n    return fragments;\n}",
            ], $table('Testfälle zum Ausfüllen', ['Nutzdaten', 'Header', 'MTU', 'Anzahl Fragmente', 'Offsets', 'MF-Folge'], [
                ['3500 Byte', '20 Byte', '1500 Byte', '', '', ''], ['2580 Byte', '20 Byte', '1000 Byte', '', '', ''], ['800 Byte', '20 Byte', '1500 Byte', '', '', ''],
            ])),
            $task('JUnit-Testfälle', 'Formuliere für die drei Testfälle eine aussagekräftige Assertion-Tabelle. Prüfe mindestens Anzahl, Nutzdatenlängen, Offsets und MF-Flags.', [
                'table' => $table('Lösung: erwartete Tests', ['Nutzdaten', 'Header', 'MTU', 'Anzahl Fragmente', 'Offsets', 'MF-Folge'], [
                    ['3500 Byte', '20 Byte', '1500 Byte', '3', '[0, 185, 370]', '[1, 1, 0]'], ['2580 Byte', '20 Byte', '1000 Byte', '3', '[0, 122, 244]', '[1, 1, 0]'], ['800 Byte', '20 Byte', '1500 Byte', '1', '[0]', '[0]'],
                ]),
                'result' => 'Die Testfälle decken Fragmentierung, eine andere MTU und den unveränderten Einzelfall ab.',
            ], $table('Testfälle zum Ausfüllen', ['Nutzdaten', 'Header', 'MTU', 'Anzahl Fragmente', 'Offsets', 'MF-Folge'], [
                ['3500 Byte', '20 Byte', '1500 Byte', '', '', ''], ['2580 Byte', '20 Byte', '1000 Byte', '', '', ''], ['800 Byte', '20 Byte', '1500 Byte', '', '', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s09', 'IPv4-Fragmentierung und MTU')],
    ],
    [
        'id' => 'exercise-crc',
        'title' => 'CRC',
        'description' => 'Eine CRC-Prüfsumme per Modulo-2-Division nachvollziehbar berechnen und prüfen.',
        'topics' => ['CRC', 'Generatorpolynom', 'Modulo-2-Division', 'XOR'],
        'tasks' => [
            $task('CRC per XOR-Division', 'Gegeben sind Datenbits D = 1101011011 und Generator G = 10011. Hänge vier Nullbits an D an und führe die Modulo-2-Division aus. Trage die XOR-Schritte und den Rest in die Tabelle ein. Ein Bindestrich bedeutet, dass keine XOR-Operation beginnt.', [
                'steps' => ['Der Grad des Generators ist 4, daher werden vier Nullbits angehängt: 11010110110000.', 'Die XOR-Division liefert den Rest 1110.', 'Das übertragene Codewort ist Datenbits plus Rest: 11010110111110.', 'Zur Kontrolle ergibt die Division des Codeworts durch 10011 den Rest 0000.'],
                'table' => $table('Lösung: XOR-Schritte', ['Schritt', 'Aktueller 5-Bit-Block', 'XOR mit G', 'Arbeitsbits nach dem Schritt'], [
                    ['1', '11010', '10011', '01001110110000'], ['2', '10011', '10011', '00000010110000'], ['3', '10110', '10011', '00000000101000'], ['4', '10100', '10011', '00000000001110'],
                ]),
            ], $table('XOR-Division zum Ausfüllen', ['Schritt', 'Aktueller 5-Bit-Block', 'XOR mit G', 'Arbeitsbits nach dem Schritt'], [
                ['1', '', '10011', ''], ['2', '', '10011', ''], ['3', '', '10011', ''], ['4', '', '10011', ''],
            ])),
            $task('Fehlerprüfung', 'Prüfe das Codewort 11010110111110 erneut mit G = 10011. Entscheide außerdem, ob das empfangene Wort 11010110111111 als fehlerfrei gelten darf.', [
                'steps' => ['Das korrekt gebildete Codewort ergibt bei der Division den Rest 0000.', 'Beim veränderten Wort ist das letzte Bit umgekippt; die Division ergibt einen Rest ungleich 0000.', 'Ein Rest 0000 bedeutet daher: kein Fehler detektiert. Ein Rest ungleich 0000 bedeutet: Fehler detektiert.'],
                'result' => 'Das erste Wort besteht die CRC-Prüfung, das zweite wird als fehlerhaft erkannt.',
            ]),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s18', 'CRC, Generatorbits und Paritätsprüfung')],
    ],
    [
        'id' => 'exercise-selective-repeat',
        'title' => 'TCP Kommunikation 1 - Selective Repeat',
        'description' => 'Paket- und ACK-Verluste bei Selective Repeat in einem zeitlichen Ablauf verfolgen.',
        'topics' => ['Selective Repeat', 'Einzelbestätigungen', 'Pufferung', 'Timeout'],
        'tasks' => [
            $task('Paket 3 geht verloren', 'Der Sender überträgt die Pakete 1 bis 5. Paket 3 geht verloren; die Pakete 4 und 5 erreichen den Empfänger. Der Empfänger bestätigt jedes korrekt empfangene Paket einzeln und puffert Pakete außerhalb der aktuellen Lücke. Ergänze den Ablauf bis zur erfolgreichen Wiederübertragung von Paket 3.', [
                'steps' => ['Selective Repeat verwirft Paket 4 und 5 nicht, sondern puffert sie.', 'Nach dem Timeout wird nur Paket 3 erneut übertragen.', 'Sobald Paket 3 eintrifft, kann der Empfänger 3, 4 und 5 in Reihenfolge an die Anwendung weitergeben.'],
                'table' => $table('Lösung: Paketverlust', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                    ['1', 'DATA 1', 'nimmt Paket 1 an', 'ACK 1'], ['2', 'DATA 2', 'nimmt Paket 2 an', 'ACK 2'], ['3', 'DATA 3', 'Paket geht verloren', '-'], ['4', 'DATA 4', 'puffert Paket 4', 'ACK 4'], ['5', 'DATA 5', 'puffert Paket 5', 'ACK 5'], ['6', 'Timeout für 3; DATA 3 erneut', 'nimmt 3 an und liefert 3, 4, 5 aus', 'ACK 3'],
                ]),
            ], $table('Ablauf zum Ausfüllen', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                ['1', '', '', ''], ['2', '', '', ''], ['3', '', '', ''], ['4', '', '', ''], ['5', '', '', ''], ['6', '', '', ''],
            ])),
            $task('ACK 3 geht verloren', 'Der Sender überträgt die Pakete 1 bis 5. Alle Pakete kommen an, aber ACK 3 geht verloren. ACK 4 und ACK 5 erreichen den Sender. Muss Paket 3 erneut übertragen werden? Begründe und ergänze die Tabelle.', [
                'steps' => ['Bei Selective Repeat bestätigt ACK 4 den Empfang von Paket 4, nicht automatisch alle kleineren Pakete.', 'Der Sender hat aber ACK 1, ACK 2, ACK 4 und ACK 5 erhalten. Dadurch ist bekannt, dass auch Paket 3 angekommen ist; eine erneute Übertragung ist nicht nötig.', 'Der Empfänger liefert die Pakete in der Reihenfolge 1 bis 5 aus.'],
                'table' => $table('Lösung: ACK-Verlust', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                    ['1', 'DATA 1', 'nimmt 1 an', 'ACK 1'], ['2', 'DATA 2', 'nimmt 2 an', 'ACK 2'], ['3', 'DATA 3', 'nimmt 3 an', 'ACK 3 verloren'], ['4', 'DATA 4', 'nimmt 4 an', 'ACK 4'], ['5', 'DATA 5', 'nimmt 5 an', 'ACK 5'], ['6', 'erhält ACK 4 und ACK 5; kein Timeout für 3', 'hat 1 bis 5 vollständig', '-'],
                ]),
            ], $table('Ablauf zum Ausfüllen', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                ['1', '', '', ''], ['2', '', '', ''], ['3', '', '', ''], ['4', '', '', ''], ['5', '', '', ''], ['6', '', '', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s11', 'Sliding Window und Selective Repeat')],
    ],
    [
        'id' => 'exercise-go-back-n',
        'title' => 'TCP Kommunikation 2 - Go-Back-N',
        'description' => 'Kumulative ACKs und Rücksprung zur ersten fehlenden Sequenznummer nachvollziehen.',
        'topics' => ['Go-Back-N', 'Kumulative ACKs', 'Timeout', 'Wiederübertragung'],
        'tasks' => [
            $task('Paket 2 geht verloren', 'Der Sender überträgt die Pakete 1 bis 5. Paket 2 geht verloren. Bei Go-Back-N verwirft der Empfänger alle später eintreffenden Pakete und bestätigt kumulativ das letzte zusammenhängende Paket. Ergänze den Ablauf bis zum Ende der Wiederübertragung.', [
                'steps' => ['Nach Paket 1 sendet der Empfänger ACK 1.', 'Pakete 3 bis 5 werden wegen der Lücke verworfen; der Empfänger sendet wiederholt ACK 1.', 'Nach dem Timeout für Paket 2 überträgt der Sender ab Paket 2 alle noch offenen Pakete erneut: 2, 3, 4 und 5.'],
                'table' => $table('Lösung: Paketverlust', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                    ['1', 'DATA 1', 'nimmt 1 an', 'ACK 1'], ['2', 'DATA 2', 'Paket geht verloren', '-'], ['3', 'DATA 3', 'verwirft wegen Lücke', 'ACK 1 (doppelt)'], ['4', 'DATA 4', 'verwirft wegen Lücke', 'ACK 1 (doppelt)'], ['5', 'DATA 5', 'verwirft wegen Lücke', 'ACK 1 (doppelt)'], ['6', 'Timeout für 2; DATA 2, 3, 4, 5 erneut', 'nimmt 2, 3, 4, 5 in Reihenfolge an', 'ACK 2, ACK 3, ACK 4, ACK 5'],
                ]),
            ], $table('Ablauf zum Ausfüllen', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                ['1', '', '', ''], ['2', '', '', ''], ['3', '', '', ''], ['4', '', '', ''], ['5', '', '', ''], ['6', '', '', ''],
            ])),
            $task('ACK 2 geht verloren', 'Der Sender überträgt 1, 2 und 3. ACK 2 geht verloren, ACK 3 erreicht den Sender. Erkläre, warum Go-Back-N in diesem Fall keine Wiederübertragung von Paket 2 benötigt.', [
                'steps' => ['ACK 3 ist kumulativ und bestätigt den zusammenhängenden Empfang bis einschließlich Paket 3.', 'Damit ist Paket 2 indirekt bestätigt, obwohl ACK 2 selbst verloren ging.', 'Es kommt zu keinem Timeout und keiner Wiederübertragung.'],
                'table' => $table('Lösung: ACK-Verlust', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                    ['1', 'DATA 1', 'nimmt 1 an', 'ACK 1'], ['2', 'DATA 2', 'nimmt 2 an', 'ACK 2 verloren'], ['3', 'DATA 3', 'nimmt 3 an', 'ACK 3'], ['4', 'erhält ACK 3; bestätigt 1 bis 3', 'hat 1 bis 3 vollständig', '-'],
                ]),
            ], $table('Ablauf zum Ausfüllen', ['Ereignis', 'Sender', 'Empfänger', 'ACK'], [
                ['1', '', '', ''], ['2', '', '', ''], ['3', '', '', ''], ['4', '', '', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s11', 'Sliding Window, Go-Back-N und kumulative ACKs')],
    ],
    [
        'id' => 'exercise-bitfolgen',
        'title' => 'Bitfolgen',
        'description' => 'Bitfolgen lesen, Leitungscodes anwenden und Hamming-Distanzen bestimmen.',
        'topics' => ['Bitfolgen', 'Manchester-Code', 'NRZ', 'Hamming-Distanz'],
        'tasks' => [
            $task('Manchester-Code zeichnen', 'Verwende die Konvention 0 = Low-High und 1 = High-Low. Codiere die Bitfolge 10110010. Ergänze für jedes Bit die beiden Signalhälften.', [
                'steps' => ['Jedes Bit hat in der Mitte einen Pegelwechsel.', 'Für 1 wird High-Low, für 0 Low-High eingetragen.'],
                'table' => $table('Lösung: Manchester-Code', ['Position', 'Bit', '1. Hälfte', '2. Hälfte'], [
                    ['1', '1', 'High', 'Low'], ['2', '0', 'Low', 'High'], ['3', '1', 'High', 'Low'], ['4', '1', 'High', 'Low'], ['5', '0', 'Low', 'High'], ['6', '0', 'Low', 'High'], ['7', '1', 'High', 'Low'], ['8', '0', 'Low', 'High'],
                ]),
            ], $table('Manchester-Code zum Ausfüllen', ['Position', 'Bit', '1. Hälfte', '2. Hälfte'], [
                ['1', '1', '', ''], ['2', '0', '', ''], ['3', '1', '', ''], ['4', '1', '', ''], ['5', '0', '', ''], ['6', '0', '', ''], ['7', '1', '', ''], ['8', '0', '', ''],
            ])),
            $task('Hamming-Distanz', 'Vergleiche A = 10110110 und B = 10011100. Markiere in der Tabelle jede abweichende Stelle und bestimme die Hamming-Distanz.', [
                'steps' => ['Die Bitfolgen unterscheiden sich an den Positionen 3, 5 und 7.', 'Die Hamming-Distanz ist die Anzahl dieser Positionen: d(A,B) = 3.'],
                'table' => $table('Lösung: Bitvergleich', ['Position', 'A', 'B', 'Unterschied?'], [
                    ['1', '1', '1', 'nein'], ['2', '0', '0', 'nein'], ['3', '1', '0', 'ja'], ['4', '1', '1', 'nein'], ['5', '0', '1', 'ja'], ['6', '1', '1', 'nein'], ['7', '1', '0', 'ja'], ['8', '0', '0', 'nein'],
                ]),
                'result' => 'd(A,B) = 3.',
            ], $table('Bitvergleich zum Ausfüllen', ['Position', 'A', 'B', 'Unterschied?'], [
                ['1', '1', '1', ''], ['2', '0', '0', ''], ['3', '1', '0', ''], ['4', '1', '1', ''], ['5', '0', '1', ''], ['6', '1', '1', ''], ['7', '1', '0', ''], ['8', '0', '0', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s19', 'Leitungscodes und Bitübertragung')],
    ],
    [
        'id' => 'exercise-sliding-window',
        'title' => 'Sliding Window',
        'description' => 'Fenstergröße, Round-Trip-Time und maximal ausnutzbare Datenrate berechnen.',
        'topics' => ['Sliding Window', 'Bandwidth-Delay-Product', 'RTT', 'Fenstergröße'],
        'tasks' => [
            $task('Benötigte Fenstergröße', 'Eine Verbindung hat 10 Mbit/s und eine RTT von 80 ms. Wie viele 1000-Byte-Segmente müssen gleichzeitig unterwegs sein, damit die Leitung ausgelastet wird? Ergänze die Rechnungstabelle.', [
                'steps' => ['Bandwidth-Delay-Product = 10.000.000 Bit/s * 0,08 s = 800.000 Bit.', '800.000 Bit / 8 = 100.000 Byte.', 'Bei 1000 Byte pro Segment werden 100.000 / 1000 = 100 Segmente benötigt.'],
                'table' => $table('Lösung: Fenstergröße', ['Rechenschritt', 'Wert'], [
                    ['RTT in Sekunden', '0,08 s'], ['BDP', '800.000 Bit'], ['BDP in Byte', '100.000 Byte'], ['Segmentgröße', '1000 Byte'], ['Benötigte Segmente', '100'],
                ]),
            ], $table('Fenstergröße zum Ausfüllen', ['Rechenschritt', 'Wert'], [
                ['RTT in Sekunden', ''], ['BDP', ''], ['BDP in Byte', ''], ['Segmentgröße', '1000 Byte'], ['Benötigte Segmente', ''],
            ])),
            $task('Maximale Datenrate des Fensters', 'Ein Sender darf maximal 64 KiB unbestätigte Daten halten. Die RTT beträgt 50 ms. Berechne die theoretisch maximal erreichbare Datenrate ohne Windows-Scale-Option.', [
                'steps' => ['64 KiB = 64 * 1024 Byte = 65.536 Byte = 524.288 Bit.', 'Datenrate = Fenstergröße / RTT = 524.288 Bit / 0,05 s.', 'Das ergibt 10.485.760 Bit/s, also ungefähr 10,49 Mbit/s.'],
                'table' => $table('Lösung: Datenrate', ['Rechenschritt', 'Wert'], [
                    ['Fenstergröße', '65.536 Byte'], ['Fenstergröße in Bit', '524.288 Bit'], ['RTT', '0,05 s'], ['Maximale Rate', '10.485.760 Bit/s = 10,49 Mbit/s'],
                ]),
            ], $table('Datenrate zum Ausfüllen', ['Rechenschritt', 'Wert'], [
                ['Fenstergröße', null], ['Fenstergröße in Bit', ''], ['RTT', null], ['Maximale Rate', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s11', 'Sliding Window, RTT und Bandwidth-Delay-Product')],
    ],
    [
        'id' => 'exercise-osi',
        'title' => 'ISO/OSI-Schichtenmodell',
        'description' => 'Die sieben OSI-Schichten ordnen, Aufgaben zuweisen und das TCP/IP-Modell vergleichen.',
        'topics' => ['ISO/OSI-Modell', 'Schichtenfunktionen', 'TCP/IP-Referenzmodell', 'Kapselung'],
        'tasks' => [
            $task('Sieben Schichten ordnen', 'Trage die sieben ISO/OSI-Schichten in der Reihenfolge von oben (anwendungsnah) nach unten (physisch) ein. Verwende die deutschen Schichtnamen.', [
                'table' => $table('Lösung: OSI-Reihenfolge', ['Position', 'OSI-Schicht'], [
                    ['7', 'Anwendung'], ['6', 'Darstellung'], ['5', 'Sitzung'], ['4', 'Transport'], ['3', 'Vermittlung'], ['2', 'Sicherung'], ['1', 'Bitübertragung'],
                ]),
            ], $table('OSI-Reihenfolge zum Ausfüllen', ['Position', 'OSI-Schicht'], [
                ['7', ''], ['6', ''], ['5', ''], ['4', ''], ['3', ''], ['2', ''], ['1', ''],
            ])),
            $task('Funktionen und TCP/IP-Zuordnung', 'Ergänze pro OSI-Schicht eine typische Funktion und ordne sie anschließend dem vereinfachten TCP/IP-Referenzmodell zu. Eine OSI-Schicht darf dabei einer TCP/IP-Schicht zugeordnet werden, mehrere OSI-Schichten können gemeinsam abgebildet werden.', [
                'table' => $table('Lösung: Funktionen und Zuordnung', ['OSI-Schicht', 'Typische Funktion', 'TCP/IP-Schicht'], [
                    ['Anwendung', 'Dienste für Anwendungen', 'Anwendung'], ['Darstellung', 'Formatierung, Kodierung, Kompression', 'Anwendung'], ['Sitzung', 'Aufbau und Verwaltung von Sitzungen', 'Anwendung'], ['Transport', 'Ende-zu-Ende-Transport, Zuverlässigkeit', 'Transport'], ['Vermittlung', 'Routing und logische Adressen', 'Internet'], ['Sicherung', 'Rahmen, MAC und Fehlererkennung', 'Netzzugriff'], ['Bitübertragung', 'Bits als elektrische/optische/funkbasierte Signale', 'Netzzugriff'],
                ]),
                'result' => 'Das TCP/IP-Modell fasst die drei oberen OSI-Schichten typischerweise in der Anwendungsschicht und die unteren beiden in der Netzzugriffsschicht zusammen.',
            ], $table('Zuordnung zum Ausfüllen', ['OSI-Schicht', 'Typische Funktion', 'TCP/IP-Schicht'], [
                ['Anwendung', '', ''], ['Darstellung', '', ''], ['Sitzung', '', ''], ['Transport', '', ''], ['Vermittlung', '', ''], ['Sicherung', '', ''], ['Bitübertragung', '', ''],
            ])),
        ],
        'solutionStatus' => 'Musterlösungen bleiben eingeklappt und können pro Aufgabe aufgedeckt werden.',
        'sourceRefs' => [$sourceRef('s02', 'ISO/OSI-Schichten und TCP/IP-Referenzmodell')],
    ],
];