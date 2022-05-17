<?php

ftp_upload:
//Subir archivos a un host via ftp
// establecer una conexión básica
$ftp_user_name = 'wcpp';
$ftp_user_pass = 'Admin2013.';
$ftp_server = 'files.000webhost.com';

$errno='';
$connect = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 
echo "\r\nConectado";
//Accediendo a el host con credenciales
$login = ftp_login($connect, $ftp_user_name, $ftp_user_pass);
ftp_pasv($connect, true);
if($login == false)
{
    die("But failed at login Attempted to connect to $connection for user $ftp_user_name....");
}
else{
    echo "\r\nAcceso autorizado\r\n";
}
//Subiendo un archivo local
if ($gestor = opendir("$local\\")) {
    while (false !== ($entrada = readdir($gestor))) {
        if ($entrada != "." && $entrada != "..") {
            $file= "$local\\".$entrada;
            $remote_file ="/public_html/FACT/$entrada";

            if (ftp_put($connect, $remote_file, $file, FTP_ASCII)) {
                chr(27);
                echo("\r");
                echo "se ha cargado $entrada con éxito";
            } else {
                echo "Hubo un problema durante la transferencia de $entrada";
            }
        }
    }
    closedir($gestor);
}

ftp_close($connect);
?>