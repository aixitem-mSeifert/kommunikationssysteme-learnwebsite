<?php

$exerciseRef = static fn (string $sourceId): array => ['sourceId' => $sourceId, 'locatorType' => 'exercise', 'locator' => 'gesamte Übungsdatei', 'sourceStatus' => 'belegt'];
$table = static fn (string $title, array $headers, array $rows, ?string $note = null): array => ['title' => $title, 'headers' => $headers, 'rows' => $rows, 'note' => $note];

return [
    [
        'id' => 'exercise-bitfolgen', 'title' => 'Bitfolgen und Leitungscodes', 'filename' => 'klausuren/uebungen/Bitfolgen.txt',
        'description' => 'Manchester-Code, differentieller NRZ-Code, NRZ-Code und Hamming-Distanz.',
        'topics' => ['Manchester-Code', 'Differentieller NRZ-Code', 'NRZ-Code', 'Hamming-Distanz'],
        'tasks' => ['Manchester-Code darstellen', 'Manchester-Code dekodieren', 'Hamming-Distanz berechnen', 'Eine Bitfolge in differentieller NRZ- und NRZ-Codierung darstellen'],
        'solutionStatus' => 'Lösungsabschnitte sind in der Originaldatei enthalten; einzelne Darstellungen bleiben als Arbeitsauftrag offen.',
        'tables' => [],
        'sourceRefs' => [$exerciseRef('u-bitfolgen')],
    ],
    [
        'id' => 'exercise-cidr', 'title' => 'CIDR und Subnetting', 'filename' => 'klausuren/uebungen/CIDR.txt',
        'description' => 'Subnetzaufteilung, Adressräume, Hostzahlen, Netzwerkadressen und Routing mit Longest Prefix Match.',
        'topics' => ['CIDR', 'Subnetzmasken', 'Host- und Broadcastadressen', 'Netzzugehörigkeit', 'Routing'],
        'tasks' => ['143.215.16.0/21 in 16 Subnetze teilen', '135.206.208.0/20 in 8 Subnetze teilen', '189.189.64.0/19 analysieren und in 4 Subnetze teilen', 'Zieladressen mit einer Netzwerkmaske vergleichen', 'Eine Routingentscheidung für 192.168.203.10 treffen'],
        'solutionStatus' => 'Ausführliche Lösungswege mit Binärdarstellungen und Zwischenergebnissen.',
        'tables' => [
            $table('Routingtabelle', ['Ziel-IP-Adresse', 'Anschluss'], [
                ['192.168.0.0/16', '1'], ['192.168.128.0/24', '2'], ['192.168.192.0/20', '3'], ['137.226.12.0/25', '4'], ['0.0.0.0/0', '5'],
            ]),
            $table('Bewertung für Ziel 192.168.203.10', ['Ziel-IP-Adresse', 'Passend?', 'Anschluss'], [
                ['192.168.0.0/16', 'Ja', '1'], ['192.168.128.0/24', 'Nein', '2'], ['192.168.192.0/20', 'Ja', '3'], ['137.226.12.0/25', 'Nein', '4'], ['0.0.0.0/0', 'Ja', '5'],
            ], 'Von den passenden Routen gewinnt der längste Präfix: Anschluss 3.'),
        ],
        'sourceRefs' => [$exerciseRef('u-cidr')],
    ],
    [
        'id' => 'exercise-crc', 'title' => 'CRC-Prüfsumme', 'filename' => 'klausuren/uebungen/CRC.txt',
        'description' => 'Modulo-2-Division zur Berechnung einer CRC-Prüfsumme mit einem Generatorpolynom.',
        'topics' => ['CRC', 'Generatorpolynom', 'Modulo-2-Arithmetik'],
        'tasks' => ['CRC-Prüfsumme für die Bitfolge 100100011101 berechnen', 'Übertragene Nachricht bestimmen'],
        'solutionStatus' => 'Der Lösungsweg ist als tabellarische XOR-Division in der Originaldatei enthalten.',
        'tables' => [],
        'sourceRefs' => [$exerciseRef('u-crc')],
    ],
    [
        'id' => 'exercise-osi', 'title' => 'ISO/OSI-Schichtenmodell', 'filename' => 'klausuren/uebungen/ISO_OSI-Schichtenmodell.txt',
        'description' => 'Schichten des ISO/OSI-Modells sortieren und den TCP/IP-Referenzmodellen zuordnen.',
        'topics' => ['ISO/OSI-Modell', 'TCP/IP-Referenzmodell', 'Schichtenfunktionen'],
        'tasks' => ['Die sieben OSI-Schichten in die richtige Reihenfolge bringen', 'OSI-Schichten den TCP/IP-Schichten zuordnen'],
        'solutionStatus' => 'Die Aufgaben enthalten Lösungseinstiege, die Zuordnung bleibt als Übung bearbeitbar.',
        'tables' => [
            $table('OSI-Schichten in Reihenfolge', ['Position', 'OSI-Schicht'], [
                ['7', 'Anwendung'], ['6', 'Darstellung'], ['5', 'Sitzung (Kommunikation)'], ['4', 'Transport'], ['3', 'Vermittlung'], ['2', 'Sicherung'], ['1', 'Bitübertragung'],
            ]),
            $table('Zuordnung zum TCP/IP-Referenzmodell', ['TCP/IP-Schicht', 'Zugeordnete OSI-Schicht(en)'], [
                ['Anwendung', 'Anwendung, Darstellung, Sitzung (Kommunikation)'], ['Transport', 'Transport'], ['Internet', 'Vermittlung'], ['Netzzugriff', 'Sicherung, Bitübertragung'],
            ]),
        ],
        'sourceRefs' => [$exerciseRef('u-osi')],
    ],
    [
        'id' => 'exercise-mtu', 'title' => 'MTU und IP-Fragmentierung', 'filename' => 'klausuren/uebungen/MTU.txt',
        'description' => 'Fragmentierung über zwei Routerstrecken mit unterschiedlichen MTUs und 8-Byte-Offsets.',
        'topics' => ['MTU', 'IP-Fragmentierung', 'MF-Flag', 'Total Length', 'Fragment Offset'],
        'tasks' => ['5251 Byte Nutzdaten über MTU 1700 und 1100 fragmentieren', '3000 Byte Gesamtlänge über MTU 1600 und 1000 fragmentieren'],
        'solutionStatus' => 'Vollständige Fragmenttabellen mit ID, MF, Total Length und Offset.',
        'tables' => [
            $table('A nach R: MTU 1700', ['ID', 'MF', 'Total Length', 'Offset'], [
                ['1', '1', '1680 + 20 = 1700', '0'], ['1', '1', '1680 + 20 = 1700', '1680 / 8 = 210'], ['1', '1', '1680 + 20 = 1700', '3360 / 8 = 420'], ['1', '0', '211 + 20 = 231', '5040 / 8 = 630'],
            ]),
            $table('R nach B: MTU 1100', ['ID', 'MF', 'Total Length', 'Offset'], [
                ['1', '1', '1080 + 20 = 1100', '0'], ['1', '1', '600 + 20 = 620', '1080 / 8 = 135'], ['1', '1', '1080 + 20 = 1100', '1680 / 8 = 210'], ['1', '1', '600 + 20 = 620', '2760 / 8 = 345'], ['1', '1', '1080 + 20 = 1100', '3360 / 8 = 420'], ['1', '1', '600 + 20 = 620', '4440 / 8 = 555'], ['1', '0', '211 + 20 = 231', '5040 / 8 = 630'],
            ]),
            $table('A nach R: MTU 1600', ['ID', 'MF', 'Total Length', 'Offset'], [
                ['1', '1', '1576 + 20 = 1596', '0'], ['1', '0', '1404 + 20 = 1424', '1576 / 8 = 197'],
            ]),
            $table('R nach B: MTU 1000', ['ID', 'MF', 'Total Length', 'Offset'], [
                ['1', '1', '976 + 20 = 996', '0'], ['1', '1', '600 + 20 = 620', '976 / 8 = 122'], ['1', '1', '976 + 20 = 996', '1576 / 8 = 197'], ['1', '0', '428 + 20 = 448', '2552 / 8 = 319'],
            ]),
        ],
        'sourceRefs' => [$exerciseRef('u-mtu')],
    ],
    [
        'id' => 'exercise-mtu-programm', 'title' => 'MTU-Fragmentierung programmieren', 'filename' => 'klausuren/uebungen/MTU (Programm).txt',
        'description' => 'Java-Aufgabe zur Simulation von IP-Fragmentierung mit Packet, Route und Simulation sowie JUnit-Tests.',
        'topics' => ['Java', 'Maven', 'JUnit', 'Fragmentierungslogik', 'Objektmodell'],
        'tasks' => ['Packet, Route und Simulation implementieren', 'Route.processPacket für Fragmentierung entwickeln', 'RouteTest mit dem vorgegebenen Testfall anlegen'],
        'solutionStatus' => 'Aufgabenbeschreibung mit externem Lösungsvorschlag und einem vollständigen JUnit-Beispieltest.',
        'tables' => [],
        'sourceRefs' => [$exerciseRef('u-mtu-programm')],
    ],
    [
        'id' => 'exercise-sliding-window', 'title' => 'Sliding Window und Bandwidth-Delay-Product', 'filename' => 'klausuren/uebungen/SlidingWindow.txt',
        'description' => 'Fenstergröße, Round-Trip-Time, erreichbare Datenrate und Windows Scale Option.',
        'topics' => ['Sliding Window', 'Bandwidth-Delay-Product', 'RTT', 'Windows Scale Option'],
        'tasks' => ['Fenstergröße für 24 Mbit/s zwischen Erde und Mond berechnen', 'Maximale Datenrate für ein 64-KiB-Fenster bis zum Mars berechnen'],
        'solutionStatus' => 'Ausführliche Lösungswege mit Einheitenumrechnung.',
        'tables' => [],
        'sourceRefs' => [$exerciseRef('u-sliding-window')],
    ],
    [
        'id' => 'exercise-selective-repeat', 'title' => 'TCP-Kommunikation: Selective Repeat', 'filename' => 'klausuren/uebungen/TCPKommunikation1-Selective Repeat.txt',
        'description' => 'Zeitliche Abläufe bei Paketverlust und verloren gegangener Quittung unter Selective Repeat.',
        'topics' => ['Selective Repeat', 'Timeout', 'ACK', 'Wiederübertragung', 'Timing'],
        'tasks' => ['Paket 3 geht verloren', 'Die Quittung für Paket 3 geht verloren'],
        'solutionStatus' => 'Arbeitsblätter und ausgefüllte Lösungstabellen für beide Szenarien.',
        'tables' => [
            $table('Paket 3 geht verloren', ['Sender Paket#', 'Kommentar', 'Empfänger Paket#'], [
                ['1', '', ''], ['2', '', '1'], ['3', 'Paketverlust', '2'], ['4', '', '-'], ['5', '', '4'], ['6', 'ACK2', '5'], ['7', 'ACK3', '6'], ['8', 'fehlendes ACK4', '7'], ['9', 'fehlendes ACK4, Timeout #3', '8'], ['3', 'Wiederübertragung', '9'], ['4', '', '3'], ['5', '', '-'], ['6', '', '-'], ['7', '', '-'], ['8', 'ACK10 (kumulativ)', '-'], ['10', '', ''],
            ]),
            $table('Quittung für Paket 3 geht verloren', ['Sender Paket#', 'Kommentar', 'Empfänger Paket#'], [
                ['1', '', ''], ['2', '', '1'], ['3', '', '2'], ['4', '', '3'], ['5', '', '4'], ['6', 'ACK2', '5'], ['7', 'ACK3', '6'], ['8', 'ACK4 verloren', '7'], ['9', 'ACK5; Timer für #3 beenden', '8'], ['10', 'ACK6', '9'],
            ]),
        ],
        'sourceRefs' => [$exerciseRef('u-selective-repeat')],
    ],
    [
        'id' => 'exercise-go-back-n', 'title' => 'TCP-Kommunikation: Go-Back-N', 'filename' => 'klausuren/uebungen/TCPKommunikation2-Go-Back-N.txt',
        'description' => 'Kumulative Bestätigungen und Rücksprung bei Paket- oder ACK-Verlust im Go-Back-N-Verfahren.',
        'topics' => ['Go-Back-N', 'Kumulative ACKs', 'Sliding Window', 'Timeout', 'Paketverlust'],
        'tasks' => ['Paket 2 geht beim ersten Mal verloren', 'Die Quittung für Paket 2 geht verloren'],
        'solutionStatus' => 'Arbeitsblätter und ausgefüllte Lösungstabellen für beide Szenarien.',
        'tables' => [
            $table('Paket 2 geht verloren', ['Sender Paket#', 'Kommentar', 'Empfänger Paket#'], [
                ['1', '', ''], ['2', 'Paket 2 verloren; keine weiteren ACKs', '1'], ['3', '', '-'], ['4', '', '-'], ['5', 'ACK2', '-'], ['6', 'fehlendes ACK3', '-'], ['7', 'fehlendes ACK3, Timeout #2', '-'], ['2', 'Wiederübertragung', '-'], ['3', '', '2'], ['4', '', '3'], ['5', '', '4'], ['6', 'ACK3', '5'], ['7', 'ACK4', '6'], ['8', 'ACK5', '7'], ['9', 'ACK6', '8'], ['10', 'ACK7', '9'],
            ]),
            $table('Quittung für Paket 2 geht verloren', ['Sender Paket#', 'Kommentar', 'Empfänger Paket#'], [
                ['1', '', ''], ['2', '', '1'], ['3', '', '2'], ['4', '', '3'], ['5', 'ACK2', '4'], ['6', 'ACK3 verloren', '5'], ['7', 'ACK4; Timer für #2 beenden', '6'], ['8', 'ACK5', '7'], ['9', 'ACK6', '8'], ['10', 'ACK7', '9'],
            ]),
        ],
        'sourceRefs' => [$exerciseRef('u-go-back-n')],
    ],
];