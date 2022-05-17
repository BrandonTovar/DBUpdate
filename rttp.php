<?php
msg("Realizando comprobación de archivos.");
    check:
$dir = "\\\\192.100.10.20\pdf\EMPRESA1\FACT";
$file_n = __DIR__."/file_n.txt";

//Obtener rutas.

if  (file_exists(__DIR__."/path's.txt"))
{
    $file_paths = file(__DIR__."/path's.txt");
    $dir = trim($file_paths[1]);
    $local= trim($file_paths[3]);
}
else
{  
    include ('selectFolder.php');
    $local = substr(exec("destino.bat"), 3);
    unlink(__DIR__."/destino.bat");
    $fp = fopen(__DIR__."/path's.txt", "w");
    fwrite($fp,"//Ruta de origen\r\n".$dir."\r\n//Ruta de destino\r\n".$local);
    fclose($fp);
}

$nm = count(scandir($dir));

//Comprobar valores.
if  (file_exists($file_n) && $nm == trim(file($file_n)[0]))
{
    msg("Todo en orden.");
    sleep(3);   
    goto check;    
}
else
{
    $fp = fopen("file_n.txt","w");fwrite($fp, $nm);fclose($fp);
    msg("Actualizando archivos");
    exec("robocopy /s /Z /R:3 /W:5 /NJH /NJS /NFL /NDL $dir $local /MAXAGE:".DATE("Y")."1201");
        sql:
    //Actualiar los datos en la base de datos.
    include 'sql.php';
    sleep(3);
    goto check;  
}
goto check;
function msg($msg){
    $strl = strlen($msg);
    chr(27);echo "\r$msg";
    for ($i = $strl; $i < 70;$i++){
        echo " ";
    }
    echo "\r";
    
}

?>