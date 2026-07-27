XML-Echoserverclient
Im folgenden Praktikum werden Sie ein Echoserver-Gerüst so vervollständigen, dass die Kommunikation über XML erfolgt.
Benutzt wird dafür JAXB (Java Architecture for XML Binding)

Zentral für das Arbeiten mit JAXB sind die beiden Interfaces javax.xml.bind.Marshaller und javax.xml.bind.Unmarshaller.
Ein Beispiel soll Ihnen helfen sich in die grundlegenden Funktionen einzuarbeiten.

Arbeitsanweisungen
Sie erhalten ein Maven-Projekt als GitLab-Repo

Generieren Sie zuerst aus der Schema-Datei (.xsd) die Klassen für die zu serialisierenden Objekte. Die Klassen sollen im package de.fhac.kosy.xml.generated (im Ordner target) erzeugt werden.

Das jaxb2-maven-plugin zum Generieren der Klassen ist bereits in der pom.xml konfiguriert.
Ausführen lässt sich das Plugin dann mit:

mvn jaxb2:xjc
Siehe Maven & JAXB

Vervollständigen Sie die Klasse XMLSerialisation:
Schreiben Sie den Konstruktor, in dem Sie die wichtigsten Objekte für den Umgang mit JAXB erzeugen
Benutzen Sie den im Konstruktor erzeugten Marshaller/Unmarshaller zum Serialisieren der Objekte
Implementieren Sie nun die TODOs in Client und Server.