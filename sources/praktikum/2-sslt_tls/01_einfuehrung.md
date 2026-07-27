# Einführung

TLS (Transport Layer Security) ist ein kryptografisches Protokoll, das sichere Kommunikation über ein Netzwerk ermöglicht. Es kommt z. B. bei HTTPS, E-Mails oder VPNs zum Einsatz.

Um bei vernetzten Programm-Systemen Datenschutz gewährleisten zu können, ist es notwendig, die Kommunikation zu verschlüsseln. SSL/TLS ist dabei zur Best-Practice geworden. Die Verschlüsselungsalgorithmen sind, genau wie die Schlüssellänge, anpassbar.

---

## Ziele von TLS

| Ziel | Beschreibung |
| :--- | :--- |
| **Vertraulichkeit** | Daten werden verschlüsselt übertragen. |
| **Integrität** | Es wird sichergestellt, dass die Daten auf dem Weg nicht verändert wurden. |
| **Authentizität** | Der Kommunikationspartner (z. B. der Server) kann verifiziert werden. |

---

## SSL/TLS-Handshake

Beim TLS-Handshake handeln Client und Server aus, wie sie kommunizieren:

| Schritt | Name | Beschreibung |
| :---: | :--- | :--- |
| **1** | **Client Hello** | Der Client sendet dem Server unterstützte TLS-Versionen, Cipher Suites, Zufallszahlen. |
| **2** | **Server Hello** | Der Server wählt eine Cipher Suite, sendet sein Zertifikat (inkl. öffentlichem Schlüssel). |
| **3** | **Zertifikatsprüfung** | Der Client prüft, ob das Serverzertifikat gültig ist (z. B. durch eine CA signiert). |
| **4** | **Schlüsselaustausch** | Es wird ein symmetrischer Sitzungsschlüssel abgeleitet (schneller und effizienter). |
| **5** | **Fertig** | Beide Seiten senden eine "Finished"-Nachricht – ab jetzt ist die Verbindung (symmetrisch) verschlüsselt. |

---

## Wichtige Begriffe

In der nun folgenden Aufgabe wollen wir ein eigenes Zertifikat und Schlüsselpaar erzeugen und verwalten. Diese werden in sogenannten Keystores gespeichert.

| Begriff | Erklärung |
| :--- | :--- |
| **Keystore** | Container für Schlüsselpaare (also inkl. private Schlüssel) und Zertifikate (z. B. `keystore.jks`). |
| **Truststore** | Container für vertrauenswürdige Zertifikate, z. B. CA-Zertifikate oder eigene Zertifikate (ohne private Schlüssel!). **Technisch** ebenfalls ein Keystore, aber nicht inhaltlich. |
| **Schlüsselpaar** | Privater + öffentlicher Schlüssel. |
| **Zertifikat** | Öffentlicher Schlüssel + Identitätsinformationen, oft durch CA signiert. |
