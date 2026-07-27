# Ein einfacher Echoserver

Zum Einstieg schauen wir uns einen simplen Echoserver mit dazu passendem Client an.

So oder so ähnlich werden Sie das vielleicht schon in der Vorlesung gesehen haben. Eventuell mit anderen Streams (es gibt viele Möglichkeiten).  
**Verwenden Sie im Praktikum die hier gezeigten Streams.**

---

## Quellcode

### `Server.java`
```java
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;

public class Server {
    public static void main(String[] args) throws IOException {
        ServerSocket serverSocket = new ServerSocket(1234);
        Socket socket = serverSocket.accept(); // blocking

        DataInputStream input = new DataInputStream(socket.getInputStream());
        DataOutputStream output = new DataOutputStream(socket.getOutputStream());
        String in = input.readUTF(); // blocking

        output.writeUTF("echo: " + in);
    }
}
```

### `Client.java`
```java
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.Socket;

public class Client {
    public static void main(String[] args) throws IOException {
        Socket socket = new Socket("localhost", 1234);
        DataOutputStream output = new DataOutputStream(socket.getOutputStream());
        DataInputStream input = new DataInputStream(socket.getInputStream());

        output.writeUTF("Hallo Welt");
        String in = input.readUTF(); // blocking

        System.out.println(in);
    }
}
```

---

## Ablauf & Interaktion zwischen Server und Client

| Schritt | Server-Aktion | Client-Aktion | Erläuterung / Wechselwirkung |
| :---: | :--- | :--- | :--- |
| **1** | `ServerSocket` wird erstellt und `accept()` wird aufgerufen (blockiert). | — | Der Server startet und wartet auf eingehende Verbindungsanfragen. |
| **2** | `accept()` wird auf der Serverseite ausgelöst und gibt ein `Socket` zurück. | `Socket` wird erstellt (`new Socket("localhost", 1234)`). | Das Erstellen des Sockets auf Clientseite stellt die Verbindung zum Server her und hebt die Blockierung von `accept()` auf. |
| **3** | Streams werden angelegt; Server wartet an der blockierenden Methode `readUTF()`. | Streams werden angelegt. | Beide Seiten bereiten die I/O-Streams vor. Der Server wartet auf Eintreffen von Daten. |
| **4** | Server empfängt die Daten über `readUTF()` (Blockierung aufgehoben). | Client sendet Nachricht mit `writeUTF("Hallo Welt")`. | Der Aufruf von `writeUTF` beim Client löst das wartende `readUTF` beim Server aus. |
| **5** | Server verarbeitet die Nachricht (`"echo: " + in`). | Client wartet an der Methode `readUTF()` auf Antwort. | Auf Clientseite wartet `readUTF` auf die Rückmeldung vom Server. |
| **6** | Server sendet die Antwort mit `writeUTF("echo: " + in)`. | Client empfängt die Echo-Antwort via `readUTF()` und gibt sie aus (`System.out.println`). | Die Echo-Antwort vom Server löst das `readUTF` beim Client aus. |

---

## Detaillierte Schritt-für-Schritt-Erklärung

1. Wir starten mit dem Server. Es wird ein `ServerSocket` erstellt und darauf die Methode `accept` aufgerufen. Diese blockiert.
2. Die blockierende Methode `accept` auf der Serverseite wird auf Clientseite ausgelöst durch das Erstellen des passenden `Socket`.
3. Beide Seiten legen geeignete Streams an und die Serverseite wartet jetzt an der blockierenden Methode `readUTF`.
4. Das wartende `readUTF` auf Serverseite wird vom passenden `writeUTF` auf Clientseite ausgelöst.
5. Auf Clientseite wartet `readUTF` auf die passende Antwort vom Server.
6. Die Echo-Antwort vom Server mit `writeUTF` löst das `readUTF` beim Client aus.

> **Wichtiger Hinweis:**  
> **Sowohl zum Bearbeiten dieser Aufgabe als auch für die Klausur ist es relevant diesen Code zu verstehen!**
