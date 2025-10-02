<?php
// Empfänger der E-Mail (deine E-Mail-Adresse)
$empfaenger = "paulauer00@gmail.com"; 

// Betreff der E-Mail
$betreff = "Neue Kontaktanfrage von AP Group Webseite";

// Überprüfe, ob das Formular abgesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Daten aus dem Formular holen
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $nachricht = trim($_POST["message"]);

    // Überprüfe die Daten
    if ( empty($name) OR empty($nachricht) OR !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        // Schicke einen Fehler, falls etwas fehlt
        http_response_code(400);
        echo "Bitte fülle alle Felder aus und versuche es erneut.";
        exit;
    }

    // E-Mail-Inhalt zusammenstellen
    $email_inhalt = "Name: $name\n";
    $email_inhalt .= "E-Mail: $email\n\n";
    $email_inhalt .= "Nachricht:\n$nachricht\n";

    // E-Mail-Header festlegen
    $email_header = "From: $name <$email>\r\n";

    // E-Mail senden
    if (mail($empfaenger, $betreff, $email_inhalt, $email_header)) {
        // Erfolgreich gesendet
        http_response_code(200);
        echo "Vielen Dank! Deine Nachricht wurde gesendet.";
    } else {
        // Fehler beim Senden
        http_response_code(500);
        echo "Oops! Etwas ist schief gelaufen. Bitte versuche es später erneut.";
    }

} else {
    // Falls das Skript direkt aufgerufen wird
    http_response_code(403);
    echo "Es gab ein Problem mit der Anfrage.";
}
?>