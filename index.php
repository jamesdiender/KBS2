<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Windesheim brochure aanvragen</title>
</head>

<body>
    <div>
        <img src="logoWindesheim.gif" alt="Logo Windesheim" id="logoWindesheim" width=>
        <h1>Vraag een opleidingsflyer aan</h1>
        <p>Vraag hieronder een opleidingsflyer aan. Je krijgt de downloadable pdf binnen enkele minuten in je mailbox (kan ook in je reclame/spamfolder belanden).
            Ben je jonger dan 16 jaar? Vraag dan eerst toestemming aan een van je ouders of verzorgers om je persoonlijke gegevens hier achter te laten.
        </p>
    </div>

    <form method="post">
        <div class="formDiv">
            <h2>Vul je persoonlijke gegevens in</h2>
            <div class="formRow">
                <label for="formVoornaam">Voornaam</label>
                <input type="text" required name="formVoornaam" id="formVoornaam" class="formInput">
            </div>
            <div class="formRow">
                <label for="formTussenvoegsel">Tussenvoegsel</label>
                <input type="text" name="formTussenvoegsel" id="formTussenvoegsel" class="formInput">
            </div>
            <div class="formRow">
                <label for="formAchternaam">Achternaam</label>
                <input type="text" required name="formAchternaam" id="formAchternaam" class="formInput">
            </div>
            <div class="formRow">
                <label for="formEmail">Emailadres</label>
                <input type="text" required name="formEmail" id="formEmail" class="formInput">
            </div>
        </div>

        <div class="formDiv">
            <h2>Vooropleiding</h2>
            <div class="formRow">
                <label for="formVooropleiding">Opleiding</label>
                <select name="formVooropleiding" id="formVooropleiding" class="formSelect">
                    <option>HAVO</option>
                    <option>VWO</option>
                    <option>MBO</option>
                    <option>Overig</option>
                </select>
            </div>
            <div class="formRow">
                <label for="formAfstudeerjaar">Afstudeerjaar</label>
                <select name="formAfstudeerjaar" id="formAfstudeerjaar" class="formSelect">
                    <option>2018</option>
                    <option>2019</option>
                    <option>2020</option>
                    <option>2021</option>
                    <option>Opleiding afgerond</option>
                </select>
            </div>

        </div>

        <div class="formDiv">
            <h2>Kies de gewenste opleidingen</h2>
            <div class="formRow">
                <select name="formOpleiding">
                    <option value="Bouwkunde">Bouwkunde</option>
                    <option value="HBO-ICT">HBO-ICT</option>
                    <option value="Civiele Techniek">Civiele Techniek</option>
                </select>
            </div>

            </div>
        </div>

        <div>
            <button name="formSubmit" id="formSubmit">Verzenden</button>
        </div>
    </form>
</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if (isset($_POST['formSubmit'])) {
    $voornaam = $_POST['formVoornaam'];

    $tussenvoegsel = "";
    if (isset($_POST['formTussenvoegsel'])) {
        $tussenvoegsel = $_POST['formTussenvoegsel'];
    }

    $achternaam = $_POST["formAchternaam"];
    $email = $_POST["formEmail"];
    $vooropleiding = $_POST['formVooropleiding'];
    $afstudeerjaar = $_POST['formAfstudeerjaar'];
    $opleiding = $_POST['formOpleiding'];

    $url_bk = "http://mailings02.cordeo.net/re?l=D0Iysxw8dI9vr2lsrI1";
    $url_cv = "http://mailings02.cordeo.net/re?l=D0Iysxw8dI9vr2lsrI2";
    $url_ict = "http://mailings02.cordeo.net/re?l=D0Iysxw8dI9vr2lsrI3";

    $opleidingen = array();
    $opleidingen['Bouwkunde'] = $url_bk;
    $opleidingen['HBO-ICT'] = $url_ict;
    $opleidingen['Civiele Techniek'] = $url_cv;

    $messageGroet = "Beste " . $voornaam . $tussenvoegsel . $achternaam . "<br><br>";
    $messageTekst = "Leuk dat je geïnteresseerd bent in een opleiding bij Windesheim! We hebben je flyer(s) voor je klaargezet.<br><br>";
    $messageOpleiding = "<a href='$opleidingen[$opleiding]'> Opleidingsflyer $opleiding";
    $message = $messageGroet . $messageTekst . $messageOpleiding;
    //echo $message;

    require 'assets/vendor/autoload.php';

    $mail = new PHPMailer(true);                                // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPDebug = 3;                                   // Enable verbose debug output
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host = '192.168.1.5';                              // Specify main and backup SMTP servers
        $mail->SMTPAuth = false;                                // Enable SMTP authentication
        //$mail->Username = '';                                 // SMTP username
        //$mail->Password = '';                                 // SMTP password
        $mail->SMTPSecure = 'TLS';                              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                       // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@windesheim.nl', '$vnaam');
        $mail->addAddress($email);                              // Add a recipient

        //Content
        $mail->isHTML(true);                                    // Set email format to HTML
        $mail->Subject = "Uw Windesheim opleidingsflyer!";
        $mail->Body = $message;
        $mail->AltBody = '';

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }


}
print("<br><br>Server: " .  gethostname());
?>
