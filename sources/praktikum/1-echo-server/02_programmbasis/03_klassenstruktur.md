# Klassenstruktur

## Diagramm

Das im UML-Diagramm dargestellte Klassendesign ist **nur ein Vorschlag** und ist UML-typisch nicht in allen Methoden und Attributen vollständig. Es steht Ihnen also frei bei Bedarf die Klassen zu erweitern oder eigene Lösungen zu erstellen.

### Package: `de.fhac.kosy.server`

#### Klasse: `Server` «Singleton»

| Sichtbarkeit | Typ | Name / Signatur | Beschreibung |
| :--- | :--- | :--- | :--- |
| **Attribute** | | | |
| `-` | `int` | `port` | Server-Port |
| `-` | `boolean` | `running` | Status des Servers |
| `-` | `ServerSocket` | `serverSocket` | Socket für eingehende Verbindungen |
| `-` | `Server` | `instance` | Singleton-Instanz |
| **Methoden** | | | |
| `-` | `void` | `Server()` | Privater Konstruktor |
| `+` | `Server` | `getInstance()` | Liefert die Singleton-Instanz zurück |
| `+` | `void` | `main(args: String[])` | Hauptmethode / Startpunkt |

---

### Package: `de.fhac.kosy.client`

#### Klasse: `Client`

| Sichtbarkeit | Typ | Name / Signatur | Beschreibung |
| :--- | :--- | :--- | :--- |
| **Attribute** | | | |
| `-` | `Socket` | `socket` | Socket für die Verbindung zum Server |
| `-` | `boolean` | `running` | Status des Clients |
| **Methoden** | | | |
| `+` | `void` | `Client(socket: Socket)` | Konstruktor |
| `+` | `String` | `sendToServer(message: String)` | Sendet eine Nachricht an den Server |
| `+` | `String` | `waitForNewMessage()` | Wartet auf eine neue Nachricht |
| `+` | `void` | `stop()` | Stoppt den Client |
| `+` | `boolean` | `isRunning()` | Gibt den Running-Status zurück |
| `+` | `String` | `prompForNewMessage()` | Fragt die Benutzereingabe ab |
| `+` | `void` | `processReceivedMessage(message: String)` | Verarbeitet empfangene Nachrichten |
| `+` | `void` | `main(args: String[])` | Hauptmethode / Startpunkt |

---

## Beschreibung

* **`Server`** (Main-Klasse im Serverprojekt):
  * Warten auf eingehende Verbindung
  * Verwalten der aktiven Verbindung
  * Singleton

* **`Client`** (Main-Klasse im Clientprojekt):
  * Verbindungsaufbau zum Server
  * Nutzereingaben
  * Senden der Nachrichten an den Server
