<?php

$slides = [
    ['s01', 'Kommunikationssysteme 1: Einführung', 'Kommunikationssysteme_1_Einfu╠êhrung.txt'],
    ['s02', 'Kommunikationssysteme 2: Schichtenmodell', 'Kommunikationssysteme_2_Schichtenmodell.txt'],
    ['s03', 'Kommunikationssysteme 3: Sockets', 'Kommunikationssysteme_3_Sockets.txt'],
    ['s04', 'Kommunikationssysteme 4: Darstellung', 'Kommunikationssysteme_4_Darstellung.txt'],
    ['s05', 'Kommunikationssysteme 5: Einführung IP-Adressen', 'Kommunikationssysteme_5_Einfu╠êhrung_IP_Adressen.txt'],
    ['s06', 'Kommunikationssysteme 6: CIDR', 'Kommunikationssysteme_6_CIDR.txt'],
    ['s07', 'Kommunikationssysteme 7: NAT', 'Kommunikationssysteme_7_NAT.txt'],
    ['s08', 'Kommunikationssysteme 8: Routingprotokolle', 'Kommunikationssysteme_8_Routingprotokolle.txt'],
    ['s09', 'Kommunikationssysteme 9: ARP, ICMP und IP', 'Kommunikationssysteme_9_ARP_ICMP_IP.txt'],
    ['s10', 'Kommunikationssysteme 10: Send and Wait', 'Kommunikationssysteme_10_SendWait.txt'],
    ['s11', 'Kommunikationssysteme 11: Sliding Window', 'Kommunikationssysteme_11_SlidingWindow.txt'],
    ['s12', 'Kommunikationssysteme 12: TCP', 'Kommunikationssysteme_12_TCP.txt'],
    ['s13', 'Kommunikationssysteme 13: UDP', 'Kommunikationssysteme_13_UDP.txt'],
    ['s14', 'Kommunikationssysteme 14: DNS', 'Kommunikationssysteme_14_DNS.txt'],
    ['s15', 'Kommunikationssysteme 15: Anwendungsprotokolle', 'Kommunikationssysteme_15_Anwendungsprotokolle.txt'],
    ['s16', 'Kommunikationssysteme 16: Sicherungsschicht und Netztechnik', 'Kommunikationssysteme_16_Einfuehrung_Sicherungsschicht_Netztechnik.txt'],
    ['s17', 'Kommunikationssysteme 17: Kanalzuteilung', 'Kommunikationssysteme_17_Kanalzuteilung.txt'],
    ['s18', 'Kommunikationssysteme 18: Fehlerkorrektur', 'Kommunikationssysteme_18_Fehlerkorrektur.txt'],
    ['s19', 'Kommunikationssysteme 19: Bitübertragungsschicht', 'Kommunikationssysteme_19_Bitu╠êbertragungsschicht.txt'],
];

$sources = array_map(static fn (array $source): array => [
    'id' => $source[0],
    'type' => 'lecture',
    'filename' => 'vorlesungsfolien/' . $source[2],
    'title' => $source[1],
    'reliability' => 'Primäre Fachquelle',
    'coverageStatus' => 'eingearbeitet',
    'knownIssues' => str_contains($source[2], '╠') ? ['Dateiname enthält ein Unicode-Extraktionsartefakt.'] : [],
], $slides);

$sources[] = ['id' => 'e2015', 'type' => 'memory-exam', 'filename' => 'klausuren/2015-02 Rechnernetze Klausur Gedächtnisprotokoll.txt', 'title' => 'Klausur 2015 (Gedächtnisprotokoll)', 'reliability' => 'Nur Relevanz und Aufgabenstil', 'coverageStatus' => 'eingearbeitet', 'knownIssues' => ['Unvollständig; keine autorisierten Lösungen oder Punkte.']];
$sources[] = ['id' => 'e2016', 'type' => 'mock-exam', 'filename' => 'klausuren/2016 SoSe Rechnernetze Probeklausur.txt', 'title' => 'Probeklausur 2016', 'reliability' => 'Primäre Prüfungsformatquelle', 'coverageStatus' => 'eingearbeitet', 'knownIssues' => []];
$sources[] = ['id' => 'e2018', 'type' => 'memory-exam', 'filename' => 'klausuren/2018-07-20 Rechnernetze Gedächtnisprotokoll.txt', 'title' => 'Klausur 2018 (Gedächtnisprotokoll)', 'reliability' => 'Nur Relevanz und Aufgabenstil', 'coverageStatus' => 'eingearbeitet', 'knownIssues' => ['Keine autorisierten Lösungen oder Punkte; zusätzliche TLS-/Serialisierungsbegriffe.']];

$exerciseSources = [
    ['id' => 'u-bitfolgen', 'filename' => 'klausuren/uebungen/Bitfolgen.txt', 'title' => 'Übung: Bitfolgen und Leitungscodes'],
    ['id' => 'u-cidr', 'filename' => 'klausuren/uebungen/CIDR.txt', 'title' => 'Übung: CIDR und Subnetting'],
    ['id' => 'u-crc', 'filename' => 'klausuren/uebungen/CRC.txt', 'title' => 'Übung: CRC-Prüfsumme'],
    ['id' => 'u-osi', 'filename' => 'klausuren/uebungen/ISO_OSI-Schichtenmodell.txt', 'title' => 'Übung: ISO/OSI-Schichtenmodell'],
    ['id' => 'u-mtu', 'filename' => 'klausuren/uebungen/MTU.txt', 'title' => 'Übung: MTU und IP-Fragmentierung'],
    ['id' => 'u-mtu-programm', 'filename' => 'klausuren/uebungen/MTU (Programm).txt', 'title' => 'Übung: MTU-Fragmentierung programmieren'],
    ['id' => 'u-sliding-window', 'filename' => 'klausuren/uebungen/SlidingWindow.txt', 'title' => 'Übung: Sliding Window'],
    ['id' => 'u-selective-repeat', 'filename' => 'klausuren/uebungen/TCPKommunikation1-Selective Repeat.txt', 'title' => 'Übung: TCP Selective Repeat'],
    ['id' => 'u-go-back-n', 'filename' => 'klausuren/uebungen/TCPKommunikation2-Go-Back-N.txt', 'title' => 'Übung: TCP Go-Back-N'],
];

foreach ($exerciseSources as $source) {
    $sources[] = [
        'id' => $source['id'], 'type' => 'exercise', 'filename' => $source['filename'], 'title' => $source['title'],
        'reliability' => 'Bereitgestellte Übungsquelle', 'coverageStatus' => 'direkt angezeigt', 'knownIssues' => [],
    ];
}

foreach (['01_grungerüst.md', '02_inhaltfuellen.md', '03_glossar_und_training.md', '04_check.md'] as $index => $filename) {
    $sources[] = ['id' => 'p0' . ($index + 1), 'type' => 'requirement', 'filename' => 'propmts/' . $filename, 'title' => 'Anforderung ' . ($index + 1), 'reliability' => 'Verbindliche Projektanforderung', 'coverageStatus' => 'eingearbeitet', 'knownIssues' => []];
}

return $sources;