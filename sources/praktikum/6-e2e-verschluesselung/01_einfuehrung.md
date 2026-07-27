# Einführung: Transportverschlüsselung vs. Ende-zu-Ende-Verschlüsselung

Wir haben bereits in einer vorangegangenen Aufgabe [Transportverschlüsselung](#) eingesetzt. Das bedeutet, dass die Verbindung zwischen Server und Client auf dem Kommunikationsweg zwischen den beiden verschlüsselt war, aber beide Seiten wieder den Klartext lesen konnten.

In dem Szenario war dies auch unabdingbar, da unser Kommunikationspartner eben der Server war und dieser logischerweise den Nachrichteninhalt lesen können muss. Wir wollten direkt etwas vom Server (in dem Fall ein einfaches Echo-Reply). Es gibt aber auch den Fall, dass wir vom Server nur indirekt etwas wollen, nämlich Infrastruktur, und der eigentliche Kommunikationspartner ist ein anderer Client. Bisher wurde das nur angedeutet durch Broadcasts, die andere Clients mitbekommen.

---

## Gegenüberstellung von Anwendungsfällen

| Szenario / Dienst | Ziel der Kommunikation | Server-Rolle | Verschlüsselungsart |
| :--- | :--- | :--- | :--- |
| **Amazon** | Bestellung / Webdienst nutzen | Direkter Kommunikationspartner (muss Daten im Klartext verarbeiten) | Transportverschlüsselung |
| **Messaging Services** | Kommunikation zwischen Clients | Reine Infrastruktur (Nachrichtenübermittlung ohne Mitlesen) | Ende-zu-Ende-Verschlüsselung (E2E) |

---

## Problem bei reiner Transportverschlüsselung für Messagedienste

Wenn nur Transportverschlüsselung genutzt wird:
1. **Client 1** sendet die Nachricht transportverschlüsselt an den Messaging-Server.
2. Der **Server** entschlüsselt die Nachricht und kann den Inhalt im Klartext einsehen.
3. Der **Server** baut eine neue Transportverschlüsselung auf und leitet die Nachricht an **Client 2** weiter.

Bei Messaging-Diensten ist es jedoch explizit gewollt, dass der Server **nicht** mehr in die Kommunikation reinschauen kann.

---

## Ende-zu-Ende-Verschlüsselung (E2E)

Dies kann man verhindern, indem man [Ende-zu-Ende (E2E)](#) verschlüsselt, also hier von Client 1 zu Client 2 permanent nur verschlüsselt sieht und nur an den Clientendpunkten Klartext lesen kann.

### Übersicht bekannter Messaging-Dienste

| Dienst | Standardmäßige E2E-Verschlüsselung | Anmerkung |
| :--- | :--- | :--- |
| **Signal** | Ja | Standardmäßig aktiv |
| **WhatsApp** | Ja | Standardmäßig aktiv |
| **Telegram** | Nein | Nur bei expliziter Anforderung („Geheimer Chat“) |

> **Wichtiger Hinweis:**  
> Eine E2E-Verschlüsselung ist etwas anderes als eine E2E-Verbindung, und eine E2E-Verschlüsselung benötigt auch keine E2E-Verbindung!

---

## Schema: End-to-End Encryption

```
[Lynna (Sender)] --------(Verschlüsselt)--------> [Server] --------(Verschlüsselt)--------> [Lindsey (Receiver)]
   (Message)                                      (Message)                                    (Message)
```

*Quelle der Abbildung: awesoft.net (E2E-Verschlüsselung)*
