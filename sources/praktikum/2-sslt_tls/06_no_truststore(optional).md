No Truststore! (optional)
Am schönsten wäre es natürlich, wenn wir keinen Truststore benötigen würden, sondern sich das Zertifikat in einer Zertifikatskette befinden würde.

Dafür reicht es aber nicht auf localhost zu hosten, dafür bekommt man nämlich keine gültigen Zertifikate ausgestellt. Man braucht also einen gültigen DNS-Eintrag auf den man ein Zertifikat austellen kann.

Dafür bietet sich Let's Encrypt an. Einen sinnvollen DNS-Eintrag bekommt man bei DynDNS-Anbietern wie zB Duck DNS. Dort könnte man zB seine Router-IP zu Hause hinterlegen und dort ein Port Forwarding 443 auf einen lokalen Rechner machen.
Hierbei sollte man durchaus wissen was man tut und auf Sicherheitsaspekte achten!

Hier die Studi-Kommentare um aus einem Zertifikat von Lets Encrypt einen Import für einen JKS zu erzeugen:

// Via Let'sEncrypt I got 'fullchain.pem' (my certificate concatenated with intermediate in chain (Let'sEncrypt's certificate)) and the corresponding private 'key.pem'
// Then I converted those to a PKCS12 file:
//     openssl pkcs12 -export -in fullchain.pem -inkey key.pem -out keystore.p12
// Then I converted that file to a JKS:
//     keytool -importkeystore -srckeystore keystore.p12 -destkeystore keystore.jks