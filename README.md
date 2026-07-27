# Kommunikationssysteme lernen

Eine PHP-Lernwebsite zur Vorbereitung auf die Prüfung im Modul
„Kommunikationssysteme“. Die Inhalte werden direkt aus den PHP-Dateien im
Verzeichnis `data/` geladen. Es wird keine Datenbank benötigt.

## Voraussetzungen

- PHP 8.1 oder neuer
- Ein aktueller Webbrowser

Unter Windows kann PHP beispielsweise über [XAMPP](https://www.apachefriends.org/de/index.html) installiert werden.

## Projekt starten

1. PowerShell im Projektverzeichnis öffnen.
2. Den eingebauten PHP-Webserver starten:

   ```powershell
   & 'C:\xampp\php\php.exe' -S 127.0.0.1:8080 -t .
   ```

   Falls PHP über den PATH erreichbar ist, genügt:

   ```powershell
   php -S 127.0.0.1:8080 -t .
   ```

3. Im Browser [http://127.0.0.1:8080](http://127.0.0.1:8080) öffnen.

Wenn Port `8080` bereits verwendet wird, kann ein anderer Port genutzt werden,
zum Beispiel:

```powershell
& 'C:\xampp\php\php.exe' -S 127.0.0.1:8081 -t .
```

Danach ist die Website unter [http://127.0.0.1:8081](http://127.0.0.1:8081) erreichbar.

Zum Beenden des Webservers im laufenden PowerShell-Fenster `Ctrl+C` drücken.

## Daten prüfen

Die Datenprüfung stellt sicher, dass IDs, Quellenreferenzen, Lerninhalte,
Quizfragen, Lernkarten, Übungen und Klausurpunkte konsistent sind. Sie wird aus dem
Projektverzeichnis heraus gestartet:

```powershell
& 'C:\xampp\php\php.exe' .\scripts\validate-data.php
```

Bei einer erreichbaren PHP-Installation funktioniert auch:

```powershell
php .\scripts\validate-data.php
```

Bei Erfolg wird `Datenprüfung erfolgreich` ausgegeben.