Grundfunktion
Wer mag, kann diese Seite runterprogrammieren (und braucht die nächste Seite dann nicht wirklich).
Wer es lieber etwas detaillierter mag, kann die nächste Seite zur Hilfe nehmen.
Wie nach der vorherigen Seite zu erwarten, beschäftigen Sie sich in dieser Übung sich mit der Kommunikation über eine Netzwerkverbindung. Zu entwickeln ist ein TCPIP-basierter Echoserver und der dazugehörige Echoclient. Der Client verschickt dabei Textnachrichten, die vom Server als Echo wieder an den gleichen Client zurückgesendet werden.

Funktionen des Clients
Folgende Funktionalität soll Schritt für Schritt im Client implementiert werden

Der Client soll es ermöglichen, mehrere Textnachrichten über eine Verbindung an den Server zu senden.
Die Antworten des Servers sollen auf der Konsole angezeigt werden.
Zum clientseitigen Beenden der Verbindung schickt der Client eine Exit-Nachricht (exit).
Daraufhin empfängt er eine Antwort endend auf exit und soll sich anschließend beenden (nicht vorher).
Grundfunktionen des Servers
Der Server soll alle per TCPIP empfangenen Nachrichten wieder zurücksenden, aber verändert z.B. mit einem Präfix wie echo .
Wenn der Server die Nachricht exit empfängt, soll er die entsprechende Antwort noch senden (z.B. echo exit) und die Verbindung zu dem Client danach schließen (der Server selbst soll nicht beendet werden).
Verwenden Sie DataInputStream und DataOutputStream mit den Methoden readUTF und writeUTF