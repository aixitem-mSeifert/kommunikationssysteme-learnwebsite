# Praktikum: Asynchroner Server in Java (nio)

Die bisherigen Aufgaben haben sich mit synchroner Kommunikation beschäftigt. In diesem Praktikum geht es erstmals um **asynchrone Kommunikation**. Ziel ist es, einen **asynchronen Multi-Client-Echo-Server** zu entwickeln, der mehrere Clients gleichzeitig bedienen kann – ganz ohne blockierende Aufrufe.

Dafür werden Klassen aus dem Package `java.nio` (NIO steht für *non-blocking IO*) verwendet.

---

## Übersicht der verwendeten Klassen und Methoden

| Klasse / Interface | Zweck & Beschreibung | Wichtige Methoden / Aufrufe |
| :--- | :--- | :--- |
| **`AsynchronousServerSocketChannel`** | Server-Komponente zum Entgegennehmen von Client-Verbindungen (pendant zu `ServerSocket`). | `open()`, `bind()`, `accept()` |
| **`CompletionHandler<V, A>`** | Callback-Interface zur Verarbeitung asynchroner I/O-Ereignisse. | `completed()`, `failed()` |
| **`AsynchronousSocketChannel`** | Repräsentiert die aktive zweiseitige Kommunikationsverbindung zu einem Client. | `read()`, `write()` |
| **`ByteBuffer`** | Puffer-Speicher zum Lesen und Schreiben von Datenströmen im NIO-Framework. | `allocate()`, `array()`, `wrap()` |
| **`AsynchronousChannelGroup`** | Optionales Thread-Management zur Sauberen Ressourcensteuerung des Servers. | `withThreadPool()`, `awaitTermination()` |

---

## Ablauf und Implementierungsschritte

### 1. `java.nio.channels.AsynchronousServerSocketChannel`

Serverseitig wird der Ablauf wie folgt skizziert:

1. **Serverobjekt erzeugen:**  
   Aus der statischen Methode `AsynchronousServerSocketChannel.open()` erhält man ein Serverobjekt (ähnlich zu `ServerSocket` bei synchroner Programmierung).
2. **Adresse binden:**  
   Im nächsten Schritt bindet man dieses Serverobjekt an eine `InetSocketAddress`, wie z. B.:
   ```java
   new InetSocketAddress("localhost", 4711)
   ```
3. **Asynchrone Sockets öffnen:**  
   Im letzten Schritt öffnen wir asynchrone Sockets, indem wir die (nicht-blockierende) Methode `accept` aufrufen. Hier kann sich dann der erste Client verbinden.

#### Parameter der `accept`-Methode:
* **1. Parameter (`Attachment`):** Wird hier nicht benötigt und daher auf `null` gesetzt.
* **2. Parameter (`Handler`):** Eine Klasse, die das Interface `CompletionHandler` implementiert. Hier bietet es sich an, eine anonyme Klasse zu implementieren:
  ```java
  new CompletionHandler<AsynchronousSocketChannel, Object>()
  ```

---

### 2. `java.nio.channels.CompletionHandler`

In diesem Interface sind zwei Methoden definiert, die implementiert werden müssen: `completed` und `failed`.

| Methode | Beschreibung & Vorgehen |
| :--- | :--- |
| **`failed(Throwable exc, Object attachment)`** | Kann zunächst nebensächlich behandelt werden: Ausgabe einer Fehlermeldung inklusive Grund und anschließendes Beenden des Programms. |
| **`completed(AsynchronousSocketChannel result, Object attachment)`** | Hier wird erneut die `accept`-Methode aufgerufen (mit `this` als zweitem Parameter). Dadurch wird aus einem Single-Client-Server ein **Multi-Client-Server**. |

> **Hinweis zum Multi-Client-Verhalten:**  
> Durch den erneuten Aufruf von `accept` (nicht-blockierend) mit dem aktuellen (`this`) `CompletionHandler` wird sichergestellt, dass die nächste Verbindung angenommen werden kann. In dieser wird dann wiederum `accept` für die übernächste Verbindung aufgerufen usf.

---

### 3. `java.nio.channels.AsynchronousSocketChannel` & `java.nio.ByteBuffer`

Den `AsynchronousSocketChannel` (erster Parameter der `completed`-Methode) übergeben wir der Übersichtlichkeit halber einer neuen, eigenen Methode `handle`.

* Dieser Parameter repräsentiert das aktuelle Kommunikationsobjekt zwischen dem Server und einem Client (ähnlich zu `Socket` bei synchroner Programmierung).

#### Ablauf in der `handle`-Methode:

1. **Endlosschleife:**  
   Lassen Sie eine Endlosschleife laufen, um beliebig lange mit dem einen Client kommunizieren zu können.
2. **Buffer anlegen:**  
   In der Schleife wird ein `ByteBuffer` mit `allocate` angelegt (Größe: `1024` Bytes).
3. **Asynchrones Lesen:**  
   Aus dem übergebenen `AsynchronousSocketChannel` wird mit `read` asynchron in den Buffer gelesen. Die Rückgabe ist ein `Future` und beinhaltet die Anzahl der gelesenen Bytes.
4. **Ergebnis abholen:**  
   Diese Antwort wird blockierend mit `.get()` geholt.
5. **Daten verarbeiten & ausgeben:**  
   Die eingelesenen Bytes werden als String ausgegeben:
   ```java
   new String(readBuffer.array(), 0, bytesRead)
   ```
6. **Antwort senden:**  
   Ein veränderter String (z. B. `toUpperCase()`) wird als Antwort zurückgeschickt. Um aus einem String wieder einen `ByteBuffer` zu erzeugen, eignet sich:
   ```java
   ByteBuffer.wrap(in.toUpperCase().getBytes())
   ```
   Diese Antwort wird anschließend mit `write` (aus der Instanz des übergebenen `AsynchronousSocketChannel`) zurückgesendet.

---

## Server am Leben halten

Damit der Server nicht direkt terminiert, muss der Main-Thread offen gehalten werden.

### Variante A: Einfache Endlosschleifen / Thread-Blocking
Für das Minimal-Programm genügen Varianten, die den Main-Thread endlos ausführen (bis z. B. `Strg+C` gedrückt wird):

```java
while (true)
    ;
```
*oder:*
```java
Thread.currentThread().join();
```

---

### Variante B: `AsynchronousChannelGroup` (Erweitertes Thread-Management)
Alternativ ist es möglich, eine `AsynchronousChannelGroup` anzulegen:

```java
// Hier werden Threads nach Bedarf für den ThreadPool erzeugt 
// (alternativ: feste Client-Anzahl mit Executors.newFixedThreadPool(4) definieren)
AsynchronousChannelGroup group = AsynchronousChannelGroup.withThreadPool(Executors.newCachedThreadPool());

// Group muss beim Öffnen mit übergeben werden
AsynchronousServerSocketChannel server = AsynchronousServerSocketChannel.open(group);

// bind und accept
// ...

// Auf Beendigung des Main-Threads wird "quasi" endlos gewartet. 
// Ein group.shutdown() oder group.shutdownNow() zur Programmlaufzeit 
// führt zu einem sauberen Ende des Main-Threads.
group.awaitTermination(Long.MAX_VALUE, TimeUnit.SECONDS);
```
