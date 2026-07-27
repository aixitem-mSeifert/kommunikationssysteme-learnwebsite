# MTU (Programm) - Aufgabenstellung

Einen Lösungsvorschlag findet man unter [https://git.fh-aachen.de/kommunikationssysteme/mtu](https://git.fh-aachen.de/kommunikationssysteme/mtu). Mögliche Fehler bitte weiterleiten.

---

## 1. Übersicht & Zielsetzung

Schreiben Sie ein Programm, das eine **MTU-Fragmentierung** simuliert. Es empfiehlt sich, **Maven** zu benutzen (z. B. für die JUnit-Dependency).

Dazu erstellen Sie die folgenden drei Klassen:

| Klasse | Beschreibung / Aufgabe |
| :--- | :--- |
| `Packet` | Repräsentiert ein IP-Paket mit ID, More-Fragments-Flag (MF), Payload und Offset. |
| `Route` | Enthält die Logik zur Fragmentierung von Paketen basierend auf der MTU. |
| `Simulation` | Stellt die Hauptklasse dar, in der Routen definiert, Startpakete übergeben und Ergebnisse ausgegeben werden. |

---

## 2. Klassenspezifikationen

### 2.1 Klasse `Packet`

Bei dieser Klasse bietet es sich an, eine **Record-Klasse** (`record`) zu verwenden.

#### Attribute

| Attribut | Typ | Beschreibung |
| :--- | :--- | :--- |
| `ID` | `String` | Eindeutige Kennung des Pakets |
| `mf` | `boolean` | More Fragments Flag (gibt an, ob weitere Fragmente folgen) |
| `payload` | `int` | Nutzlast des Pakets in Bytes |
| `offset` | `int` | Offset der Nutzlast in Bytes |

#### Methoden

| Methode | Rückgabetyp | Beschreibung |
| :--- | :--- | :--- |
| `toString()` | `String` | Formatierte Zeichenkettendarstellung des Pakets |

---

### 2.2 Klasse `Route`

Diese Klasse implementiert die eigentliche Fragmentierungslogik.

#### Attribute

| Attribut | Modifizierer / Typ | Beschreibung |
| :--- | :--- | :--- |
| `MTU` | `private final int` | Maximum Transmission Unit der Route |
| `maxSize` | `private final int` | Maximal mögliche Payload-Größe als Vielfaches von 8 (kann identisch sein mit der MTU abzüglich Header) |

#### Methoden

| Methode | Rückgabetyp | Beschreibung |
| :--- | :--- | :--- |
| `Route(int mtu)` | Konstruktor | Initialisiert die Route mit der gegebenen MTU und berechnet `maxSize` |
| `toString()` | `String` | Formatierte Ausgabe der Routeninformationen |
| `processPacket(Packet packet)` | `List<Packet>` | Erhält ein Eingangspaket und gibt 1 bis $n$ Ausgangspakete in einer Liste zurück |

> **Hinweis zur Logik:** Die Methode `processPacket` erhält ein Eingangspaket und zerlegt es entsprechend der MTU/`maxSize`. Dementsprechend wird hier die eigentliche Logik der Fragmentierung implementiert.

---

### 2.3 Klasse `Simulation`

Hier werden die Route(n) definiert, mit einem Startpaket befüllt und die Ergebnisse auf der Konsole ausgegeben.

#### Beispielhafter Quellcode in `Simulation`:

```java
Route route1 = new Route(1700);
Route route2 = new Route(1100);
System.out.println(route1);
System.out.println(route2);
System.out.println();

String ID = "x";

Packet packet1 = new Packet(ID, false, 5251, 0);

// Komplettes unzerlegtes Startpaket rein, Teilpakete raus (theoretisch auch identisch)
List<Packet> packets = route1.processPacket(packet1);
packets.forEach(System.out::println);
System.out.println();

List<Packet> packets2 = new ArrayList<>();
// Alle bisherigen Teilpakete von der ersten Route werden jetzt in die zweite Route gesteckt
for (Packet packet : packets) {
    packets2.addAll(route2.processPacket(packet));
}
packets2.forEach(System.out::println);
```

#### Dazugehöriger Konsolen-Output:

```text
Route [MTU=1700, maxSize=1680]
Route [MTU=1100, maxSize=1080]

Packet{ID='x' MF=1, Total Length=1680+20=1700, offset=   0/8=  0}
Packet{ID='x' MF=1, Total Length=1680+20=1700, offset=1680/8=210}
Packet{ID='x' MF=1, Total Length=1680+20=1700, offset=3360/8=420}
Packet{ID='x' MF=0, Total Length= 211+20= 231, offset=5040/8=630}

Packet{ID='x' MF=1, Total Length=1080+20=1100, offset=   0/8=  0}
Packet{ID='x' MF=1, Total Length= 600+20= 620, offset=1080/8=135}
Packet{ID='x' MF=1, Total Length=1080+20=1100, offset=1680/8=210}
Packet{ID='x' MF=1, Total Length= 600+20= 620, offset=2760/8=345}
Packet{ID='x' MF=1, Total Length=1080+20=1100, offset=3360/8=420}
Packet{ID='x' MF=1, Total Length= 600+20= 620, offset=4440/8=555}
Packet{ID='x' MF=0, Total Length= 211+20= 231, offset=5040/8=630}
```

---

## 3. Unit Testing mit JUnit

Bauen Sie JUnit-Tests ein. Erstellen Sie dazu eine Testklasse `RouteTest` unter `src/test/java`.

### 3.1 Maven-Dependency (`pom.xml`)

Dafür kann man folgende Maven-Dependency verwenden:

```xml
<dependency>
    <groupId>junit</groupId>
    <artifactId>junit</artifactId>
    <version>4.13.2</version>
    <scope>test</scope>
</dependency>
```

### 3.2 Testfall `testProcessPackage()`

Folgenden Testfall kann man verwenden, gerne auch weitere anlegen:

```java
@Test
public void testProcessPackage() {
    List<Packet> packets = new Route(2000).processPacket(new Packet("x", false, 4200, 0));
    assertEquals(3, packets.size());
    assertEquals("x", packets.get(0).ID());
    assertTrue(packets.get(0).mf());
    assertEquals(1976, packets.get(0).payload());
    assertEquals(0, packets.get(0).offset());
    assertEquals("x", packets.get(1).ID());
    assertTrue(packets.get(1).mf());
    assertEquals(1976, packets.get(1).payload());
    assertEquals(1976, packets.get(1).offset());
    assertEquals("x", packets.get(2).ID());
    assertFalse(packets.get(2).mf());
    assertEquals(248, packets.get(2).payload());
    assertEquals(3952, packets.get(2).offset());
}
```

### 3.3 Erwartete Werte im Testfall

| Fragment Index | ID | MF Flag (`mf`) | Payload (Bytes) | Offset (Bytes) |
| :---: | :---: | :---: | :---: | :---: |
| `0` | `"x"` | `true` | `1976` | `0` |
| `1` | `"x"` | `true` | `1976` | `1976` |
| `2` | `"x"` | `false` | `248` | `3952` |