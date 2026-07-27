# Broadcast

## Klassendiagramm Overview

### Package `de.fhac.kosy.server`

#### Klasse `Server` «Singleton»
* **Attribute:**
  * `-port: int`
  * `-running: boolean`
  * `-connections: Collection<Connection>`
  * `-serverSocket: ServerSocket`
  * `-instance: Server`

* **Methoden:**
  * `-Server()`
  * `+getInstance(): Server`
  * `+broadcast(message: String): void`
  * `+removeConnection(connectionId: T): void`
  * `+main(args: String[]): void`

#### Klasse `Connection` «Thread»
* **Attribute:**
  * `-clientSocket: Socket`
  * `-running: boolean`

* **Methoden:**
  * `+Connection(client: Socket)`
  * `+sendToClient(message: String)`
  * `+waitForMessage(): String`
  * `+terminate(): void`
  * `+run(): void`

---

### Package `de.fhac.kosy.client`

#### Klasse `Client`
* **Attribute:**
  * `-socket: Socket`
  * `-running: boolean`
  * `-receiver: Receiver`

* **Methoden:**
  * `+Client(socket: Socket)`
  * `+sendToServer(message: String)`
  * `+stop(): void`
  * `+isRunning(): boolean`
  * `+promptForNewMessage(): String`
  * `+main(args: String[]): void`
  * `-startReceiver(): void`

#### Klasse `Receiver` «Thread»
* **Attribute:**
  * `-socket: Socket`
  * `-client: Client`

* **Methoden:**
  * `+Receiver(socket: Socket, client: Client)`
  * `+processReceivedMessage(message: String): void`
  * `+waitForNewMessage(): String`
  * `+run(): void`

---

## Übersicht der Klassen und Methoden

| Package | Klasse | Stereotyp / Vererbung | Attribute | Methoden / Aufgaben |
| :--- | :--- | :--- | :--- | :--- |
| `de.fhac.kosy.server` | **Server** | `«Singleton»` | `- port: int`<br>`- running: boolean`<br>`- connections: Collection<Connection>`<br>`- serverSocket: ServerSocket`<br>`- instance: Server` | `- Server()`<br>`+ getInstance(): Server`<br>`+ broadcast(message: String): void`<br>`+ removeConnection(connectionId: T): void`<br>`+ main(args: String[]): void` |
| `de.fhac.kosy.server` | **Connection** | `«Thread»` (extends `Thread`) | `- clientSocket: Socket`<br>`- running: boolean` | `+ Connection(client: Socket)`<br>`+ sendToClient(message: String)`<br>`+ waitForMessage(): String`<br>`+ terminate(): void`<br>`+ run(): void` |
| `de.fhac.kosy.client` | **Client** | – | `- socket: Socket`<br>`- running: boolean`<br>`- receiver: Receiver` | `+ Client(socket: Socket)`<br>`+ sendToServer(message: String)`<br>`+ stop(): void`<br>`+ isRunning(): boolean`<br>`+ promptForNewMessage(): String`<br>`+ main(args: String[]): void`<br>`- startReceiver(): void` |
| `de.fhac.kosy.client` | **Receiver** | `«Thread»` (extends `Thread`) | `- socket: Socket`<br>`- client: Client` | `+ Receiver(socket: Socket, client: Client)`<br>`+ processReceivedMessage(message: String): void`<br>`+ waitForNewMessage(): String`<br>`+ run(): void` |

---

## Beschreibung

`Receiver extends Thread` :  
Klasse, in der alle Antworten vom Server verarbeitet (in den meisten Fällen ausgegeben) werden (Lesen aus Streams).

* Empfangen der Servernachrichten
* Auswerten von Kommandos
* Ausgeben von Nachrichten

Der Server soll ebenfalls Broadcast-Nachrichten unterstützen. Dazu wird jede eingehende Nachricht darauf überprüft, ob der String `roadc` am Anfang der Nachricht steht. Falls ja, soll der Server diesen String aus der Nachricht löschen, und die Restnachricht (also den eigentlichen Nachrichtentext) an alle verbundenen Clients schicken.

Starten Sie den Server und mindestens zwei Clients. Testen Sie die Nachrichtenübermittlung von einem Client an alle anderen Clients.

Testen Sie ob auch die nicht aktiv sendenden Clients die Nachricht sofort erhalten ohne selber vorher eine Nachricht zu verschicken. Wenn die anderen Clients erst eine Nachricht schreiben müssen liegt das daran, dass Sie den Empfang der Nachrichten nicht in einem eigenen Thread (`Receiver`) gestartet haben. (Siehe Multi-Client)
