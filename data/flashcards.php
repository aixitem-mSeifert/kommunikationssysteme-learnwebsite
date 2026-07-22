<?php

$cards = [];
foreach (require __DIR__ . '/glossary.php' as $item) {
    $cards[] = [
        'id' => 'f-' . $item['id'], 'areaId' => $item['areaIds'][0], 'topicId' => $item['topicIds'][0],
        'category' => in_array($item['sourceStatus'], ['unklar', 'mehrdeutig', 'historisch/vereinfacht'], true) ? 'exam-trap' : 'definition',
        'front' => $item['term'], 'back' => $item['details'], 'sourceStatus' => $item['sourceStatus'], 'sourceRefs' => $item['sourceRefs'],
    ];
}

$methodCard = static fn (string $id, string $areaId, string $topicId, string $category, string $front, string $back, string $sourceId, string $locator): array => [
    'id' => $id,
    'areaId' => $areaId,
    'topicId' => $topicId,
    'category' => $category,
    'front' => $front,
    'back' => $back,
    'sourceStatus' => 'belegt',
    'sourceRefs' => [['sourceId' => $sourceId, 'locatorType' => 'document', 'locator' => $locator, 'sourceStatus' => 'belegt']],
];

$cards = array_merge($cards, [
    $methodCard('f-method-service', 'a1', 't1', 'Vergleich', 'Dienst, Schnittstelle, Protokoll: Wie werden sie getrennt?', 'Der Dienst beschreibt das Angebot einer Schicht. Die Schnittstelle legt dessen Nutzung durch die höhere Schicht fest. Das Protokoll regelt die Kommunikation gleichrangiger Instanzen.', 's02', 'Dienst, Schnittstelle und Protokoll'),
    $methodCard('f-method-socket', 'a2', 't2', 'Ablauf', 'In welcher Reihenfolge arbeitet ein verbindungsorientierter TCP-Server?', 'ServerSocket an Port binden, auf Verbindung warten, Verbindungssocket annehmen, Daten lesen und schreiben, Verbindung schließen; parallele Clients gegebenenfalls getrennt bearbeiten.', 's03', 'TCP-Server-Ablauf'),
    $methodCard('f-method-subnet', 'a3', 't3', 'Rechenschema', 'Wie bestimmst du Netzadresse, Broadcast und Hostbereich eines IPv4-Subnetzes?', 'Präfix in Maske umsetzen; Adresse mit Maske verknüpfen; Hostbits für Broadcast auf 1 setzen; nach Aufgabenregel Netz- und Broadcastadresse vom Hostbereich ausschließen.', 's05', 'Subnetting-Verfahren'),
    $methodCard('f-method-dijkstra', 'a3', 't3', 'Ablauf', 'Wie läuft das Dijkstra-Verfahren in den Folien ab?', 'Startdistanz 0, übrige Distanzen unendlich; günstigsten unbesuchten Knoten fest wählen; Nachbardistanzen über ihn aktualisieren; wiederholen, bis alle Ziele feststehen.', 's08', 'Link State und Dijkstra'),
    $methodCard('f-method-lost-ack', 'a4', 't4', 'Fehlerfall', 'Was geschieht bei einem verlorenen Stop-and-Wait-ACK?', 'Der Sender läuft in den Timeout und sendet erneut. Der Empfänger erkennt das Duplikat an der Sequenznummer, liefert es nicht erneut aus und bestätigt nochmals.', 's10', 'Verlorenes ACK und Duplikaterkennung'),
    $methodCard('f-method-window-compare', 'a4', 't4', 'Vergleich', 'Go-Back-N und Selective Repeat: Was wird nach Verlust erneut gesendet?', 'Go-Back-N wiederholt ab der fehlenden Sequenz alle noch unbestätigten Rahmen. Selective Repeat puffert passende Folgerahmen und wiederholt gezielt den fehlenden Rahmen.', 's11', 'Go-Back-N und Selective Repeat'),
    $methodCard('f-method-window-rate', 'a4', 't4', 'Rechenschema', 'Wie schätzt du die durch ein Fenster begrenzte Datenrate?', 'Fenstergröße in Byte mit 8 multiplizieren und durch die RTT in Sekunden teilen. Das Ergebnis ist die näherungsweise Bitrate in bit/s.', 's11', 'Fenster, RTT und Durchsatz'),
    $methodCard('f-method-dns', 'a5', 't5', 'Ablauf', 'Welche Stationen durchläuft eine DNS-Auflösung ohne passenden Cacheeintrag?', 'Der Resolver fragt den lokalen DNS-Server. Dieser folgt je nach Verfahren Verweisen von Root über TLD zur autoritativen Zone, liefert den Resource Record zurück und kann ihn gemäß TTL cachen.', 's14', 'DNS-Auflösung'),
    $methodCard('f-method-switch', 'a6', 't6', 'Ablauf', 'Wie lernt und vermittelt ein Switch einen Ethernet-Rahmen?', 'Er lernt die Quell-MAC am Eingangsport. Ein bekanntes Ziel leitet er gezielt weiter; ein unbekanntes Ziel oder Broadcast verteilt er an die übrigen geeigneten Ports.', 's16', 'Switch-Learning und unbekannte Ziele'),
    $methodCard('f-method-beb', 'a6', 't6', 'Ablauf', 'Was folgt bei CSMA/CD auf eine erkannte Kollision?', 'Übertragung abbrechen, Jam-Signal senden, eine zufällige Wartezahl aus dem mit Wiederholungen wachsenden Backoff-Bereich wählen und danach erneut auf ein freies Medium warten.', 's17', 'CSMA/CD und Binary Exponential Backoff'),
    $methodCard('f-method-crc', 'a7', 't7', 'Rechenschema', 'Wie wird der CRC-Rest schriftlich bestimmt?', 'Generatorgrad r bestimmen, r Nullen anhängen, die erweiterte Bitfolge modulo 2 durch das Generatorwort teilen und den r Bit langen Rest an die Nutzdaten anhängen.', 's18', 'CRC-Verfahren'),
    $methodCard('f-method-csma-ca', 'a8', 't8', 'Ablauf', 'Wie lautet der normale CSMA/CA-Kernablauf?', 'Medium prüfen, IFS abwarten, zufälligen Backoff nur bei freiem Medium herunterzählen, senden und ACK erwarten; ohne ACK folgt ein neuer Versuch mit angepasstem Backoff.', 's19', 'CSMA/CA-Ablauf'),
]);

return $cards;