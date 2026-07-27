# Asynchroner Client

Analog zur Serverseite skizzieren wir hier die Klassen und den Ablauf auf der Clientseite.

| Klasse | Beschreibung / Ablauf |
| :--- | :--- |
| `java.nio.channels.AsynchronousSocketChannel` | Analog zur Serverseite erhalten wir hier eine Client-Instanz durch Aufruf der statischen Methode `open`. (Man beachte das fehlende "Server" im Typnamen.)<br><br>Mit `connect` verbinden wir uns hier zur Serverseite mit einer `InetSocketAddress`. Das zurückgegebene `Future` liest man auch hier wieder blockierend mit `get` aus, um sicherzustellen dass die Verbindung hergestellt wurde. |
| `java.nio.ByteBuffer` | Solange der Benutzer Eingaben über die Konsole tätigt (z. B. über `Scanner.nextLine()`), schicken wir auch hier einen String per `ByteBuffer` zum Server mit `write` und lesen die Antwort mit `read` aus.<br><br>Das Handling der Buffer funktioniert analog zur Serverseite. |

### Aufgabenstellung
Testen Sie nun Ihre Client-Server-Kommunikation, auch mit mehreren Clients gleichzeitig.
