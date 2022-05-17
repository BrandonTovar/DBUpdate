<?php
$email = "bastovice@gmail.com";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail->CharSet = 'UTF-8';
	$mail->isSMTP();
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'cfdi@multielectrico.com';                     //SMTP username
    $mail->Password   = 'Admin2013';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('cfdi@multielectrico.com', 'Multielectrico');
    $mail->addAddress($email, 'Soporte');     //Add a recipient
    //$mail->addAttachment("C:/inetpub/wwwroot/FACT/Temp/" . $file, $file);    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Sin conexión con la base de datos.";
    $mail->Body    = '<html><head></head><body style="
    background: white;
    font-family: monospace;
">

    <h1>El archivo sql.php encargado de actualizar la base de datos esta presentando inconvenientes.</h1>

<p>1.- Verificar si el equipo tiene acceso a red.</p>
<p>2.- Verificar si en el host, mysql users, esta agregadada la ip del equipo</p>
    
</body></html>';
    $mail->AltBody = 'Sin conexión con la base de datos.';
    $mail->send();
    //echo 'Message has been sent';	
} 
catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>