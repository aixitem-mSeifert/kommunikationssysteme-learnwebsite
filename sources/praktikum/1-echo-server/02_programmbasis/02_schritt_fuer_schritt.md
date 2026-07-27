optional: Schritt für Schritt
Beginnen Sie erste Tests nach dem unten gegebenen Schema und fügen Ausgaben in den Programmcode hinzu, die den jeweiligen Status anzeigen (z.B: "Server wurde gestartet", "Server wartet auf Verbindungen", "Neuer Client verbunden" ...).
Ohne diese Ausgaben kann die Bearbeitung schwieriger sein, weil man nicht sieht an welcher Stelle der Server auf Eingabe oder Ähnliches wartet.

Hilfreich könnte es sein folgende autarke Szenarien nacheinander zu ermöglichen.

Starten Sie zuerst den Server. Versuchen Sie dann einen Client zu verbinden und eine Nachricht zu übermitteln

Starten Sie den Server, starten Sie den Client. Versuchen Sie mehr als eine Nachricht über die Netzwerkverbindung zu übermitteln
(Programm muss angepasst werden)

Starten Sie den Server und dann den Client. Schicken Sie abermals mehr als eine Nachricht an den Server und im Anschluss schicken Sie die Nachricht \exit. Diese sollte entsprechend den Vorgaben behandelt werden.
(Programm muss angepasst werden)