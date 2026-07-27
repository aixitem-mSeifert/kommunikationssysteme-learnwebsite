TLS-Serverclient
Programmiergerüst
Ihre Aufgabe ist es einen einfachen Echoserver und dazu passenden Echoclient zu programmieren, die die Textnachrichten TLS-verschlüsselt überträgen.

Dafür erstellen Sie ein leeres (Maven-)Projekt und implementieren dort schnell einen simplen minimalen Echoserver und einen Echoclient.

kein Multiclient-Server nötig -> kein zusätzlicher Serverthread
kein Broadcast nötig -> kein zusätzlicher Clientthread
wenn der erste und einzige Client beendet ist, endet auch der Server
Clientseite:
Socket
while (Scanner -> DataOutputStream.writeUTF -> DataInputStream.readUTF)
Serverseite:
ServerSocket.accept
while (DataInputStream.readUTF -> UpperCase -> DataOutputStream.writeUTF)
Im Folgenden werden wir Server und Client an ein paar wenigen Stellen anpassen, so dass TLS benutzt wird.
Danach haben Sie einen Echoserver, der beliebig viele verschüsselte Nachrichten zurücksendet.
Wie das funktioniert wird im Folgenden beschrieben.

Machen Sie sich im Verlauf Ihrer Programmierung auch Gedanken dazu, wann Sie die Casts zu den SSL-Varianten benötigen.

Dokumentation zu den benötigten Klassen
Folgende Klassen helfen Ihnen bei der Erstellung einer SSL/TLS-Verbindung:

javax.net.ssl.SSLServerSocketFactory

javax.net.ssl.SSLServerSocket

javax.net.ssl.SSLSocketFactory

javax.net.ssl.SSLSocket

Die Properties (siehe nächster Absatz) müssen gesetzt werden bevor die Factories benutzt werden, weil die Properties von den Factories verwendet werden.
Zertifikate
Java verwendet zur Verwaltung und Interaktion mit Zertifikaten Key- und Truststores.
Diese haben wir im ersten Aufgabenteil erstellt und werden sie nun verwenden.
Wer Maven verwendet sollte diese unter src/main/resources/... ablegen.

Dokumentation zu den Keystoreparametern
Bekanntmachen der Java-Key-Stores

In der JVM müssen die Pfade zu den Keystores mit folgenden Properties angegeben werden:

javax.net.ssl.keyStore

javax.net.ssl.keyStorePassword

javax.net.ssl.trustStore

javax.net.ssl.trustStorePassword

Die Doku finden Sie unter Customizing the Default Keystores and Truststores, Store Types, and Store Passwords und How to Specify a java.lang.System Property

Wenn Sie als Value den Pfad zu einer Datei im Maven-Projekt angeben, starten Sie vom Projekt-Root aus gesehen (dort wo die pom.xml liegt).
Beispielpfad: src/main/resources/irgendein.jks