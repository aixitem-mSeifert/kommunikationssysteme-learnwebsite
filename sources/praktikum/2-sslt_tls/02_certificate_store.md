Certificate Store
Schlüsselpaar erzeugen
Um unsere Java-TCP-Sockets mit TLS auszustatten müssen wir Keystores erstellen.

Dazu benutzen wir keytool, welches bei JDK mitgeliefert wird (im bin-Verzeichnis).

Zum Erzeugen eines private/public-Keypaars verwenden wir den Befehl keytool -genkeypair mit mehreren Parametern.
Eine Liste von möglichen Optionen/Parametern erhalten Sie mit keytool -genkeypair --help.

Der zu erzeugende Keystore soll folgende Eigenschaften haben, die zum Teil direkt über Parameter oder per Eingabe auf der Kommandozeile erfolgen:

Wählen Sie ein Keystore-Passwort (Wird als Passwort abgefragt) Wichtig: Prinzipiell sollten Passwörter zufällig generiert werden, z.B. per Passwortgenerator pwgen
Der Servername soll tlsechoserver.kosy.fhac.de sein (Wird als Vor- und Nachname abgefragt)
Als Verschlüsselungsalgorithmus soll RSA verwendet werden
Die Keylänge soll 4096 Bit betragen
Der Dateiname des Keystores soll server-keystore.jks sein
Der Schlüsselname (Alias) für den erzeugten Schlüssel soll tlsechoserver sein
Optional: Abhängig von Ihrer Java-Version verwenden die Keystores möglicherweise noch ein proprietäres Format. Wenn vorgeschlagen, migrieren Sie auf PKCS12.

Im weiteren Verlauf werden weitere relevante Infos, die nicht per Parameter eingegeben wurden, abgefragt.

Keys anzeigen
Nach Erzeugung kann man sich den Storeinhalt wie folgt anzeigen lassen. Wenn die Schlüsselerzeugung funktioniert hat, sollte das Ergebnis in etwa so aussehen:

----------------------------------------------------
keytool -list -keystore server-keystore.jks
----------------------------------------------------
Keystore-Kennwort eingeben:  
Keystore-Typ: PKCS12
Keystore-Provider: SUN
 
Keystore enthält 1 Eintrag
 
tlsechoserver, 07.05.2019, PrivateKeyEntry, 
Zertifikat-Fingerprint (SHA-256): F7:07:C3:D1:9E:31:49:10:8F:65:F6:A1:08:C7:42:F1:69:1C:5D:2D:04:9D:22:91:28:42:70:BF:DB:FF:88:69
Hier erkennt man am Eintrag PrivateKeyEntry, dass sich auch der private Schlüssel im Zertifkat verbirgt. Mit keytool gibt es auch keine Möglichkeit diesen zu exportieren.
Diese Designentscheidung verringert das Risiko versehentlich den privaten Schlüssel weiterzugeben.

Keys exportieren
Auf Clientseite darf dieser private Schlüssel des Servers natürlich nicht landen!
Damit ein Client dem Serverzertifikat vertraut, muss es entweder von einer offiziellen CA signiert werden oder dem öffentlichen Schlüssel explizit vertraut werden.
Um den öffentlichen Schlüssel zu extrahieren benutzen sie den Befehl keytool -export. Weitere Optionen erhalten Sie mit keytool -export --help.

Es gibt andere Tools, die aus Keystoredateien private keys extrahieren können (ksExportKey, CERTivity, Portecle, KeyStore Explorer, ...)!

Vertrauenswürdige Schlüssel importieren
Dieses exportierte Zertifikat (ohne den privaten Schlüssel) muss nun einem besonderem Keystore, dem Truststore, hinzugefügt werden, in dem die vertrauenswürdigen öffentlichen Schlüssel hinterlegt sind.
Dazu stellt keytool den Parameter -import zur Verfügung. Wie zuvor können Sie auch hier die Optionen mit keytool -import --help einsehen. Der erzeugte Keystore soll truststore.jks heißen.

Hat alles funktioniert, können wir wieder in den Truststore schauen und sehen bei aufmerksamer Betrachtung trustedCertEntry hinter unserem Aliasnamen. Dort sehen wir also die Bestätigung, dass der private Schlüssel nicht mehr enthalten ist.

--------------------------------------------------
keytool -list -keystore truststore.jks 
--------------------------------------------------
Keystore-Kennwort eingeben:  
Keystore-Typ: PKCS12
Keystore-Provider: SUN
 
Keystore enthält 1 Eintrag
 
tlsechoserver-pub, 07.05.2019, trustedCertEntry, 
Zertifikat-Fingerprint (SHA-256): F7:07:C3:D1:9E:31:49:10:8F:65:F6:A1:08:C7:42:F1:69:1C:5D:2D:04:9D:22:91:28:42:70:BF:DB:FF:88:69
