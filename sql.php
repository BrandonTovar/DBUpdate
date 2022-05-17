<?php
$pass = "*_N(U_QkW~G7vC3E";
$user = "id17975098_root";
$db_host="145.14.144.145";
$db="";

mysqli_report(MYSQLI_REPORT_STRICT);

if  (file_exists(__DIR__."/config.txt"))
{
    $sl = 0;
    coneccion_0:
    $sl++;
    if($sl >=10){goto end_error;}

    //Comprobar si existe conexion con la base de datos.

    try
    {
        $conection = new mysqli("$db_host","$user","$pass");
    }
    catch(Exception $e)
    {
        msg("error, imposible conectar con la base de datos.");sleep(15); goto coneccion_0;
    }

    //Guardar el dia y el valor para correo en un archivo.
    $fp = fopen(__DIR__."/date.txt", "w");
    fwrite($fp,date("d")."\r\n1");
    fclose($fp);
    //Obtener el nombre completo de la tabla article.
    $sql =  mysqli_query($conection,"SELECT table_schema AS nombre FROM information_schema.tables WHERE table_schema LIKE '%article%';");
    $dbs = mysqli_fetch_all($sql);

    //Obtener los datos de el archivo de configuracion.

    $config = file(__DIR__."/config.txt");
    $db =$dbs[0][0];
    
    //Comprobando los valores del archivo config y si es necesario corregirlos.

    if (trim($config[2]) <> $db and $db <> "")
    {
        unlink(__DIR__."/config.txt");
        $fp = fopen(__DIR__."/config.txt","w");
        fwrite($fp,"0 \r\n".Date("Y")."\r\n"."$db");
        fclose($fp);
    }
    else if ($db == "")
    {
        //Si el valor de $db es nulo, se vuelve a comprobar.
        goto coneccion_0;
    }
    
}
else
{
    //Creación del documento config en caso de que no exista.
    $sl = 0;
    coneccion_1:
    $sl++;
    if($sl >=10){goto end_error;}

    try
    {
        $conection = new mysqli("$db_host","$user","$pass");
    }

    catch(Exception $e)
    {
        msg("error, imposible conectar con la base de datos."); sleep(15); goto coneccion_1;
    }


    $fp = fopen(__DIR__."/date.txt", "w");fwrite($fp,date("d")."\r\n1");fclose($fp);
    $sql =  mysqli_query($conection,"SELECT table_schema AS nombre FROM information_schema.tables WHERE table_schema LIKE '%article%';");
    $dbs = mysqli_fetch_all($sql);
    $db =$dbs[0][0];
    $fp = fopen(__DIR__."/config.txt","w");
    fwrite($fp,"0 \r\n".Date("Y")."\r\n"."$db");
    fclose($fp);
}
$sl = 0;
coneccion:
$sl++;
if($sl >=10){goto end_error;}
try
{
    $conection = new mysqli("$db_host","$user","$pass","$db");
}
catch(Exception $e)
{
    msg("error, imposible conectar con la base de datos."); sleep(15); goto coneccion;
}
$fp = fopen(__DIR__."/date.txt", "w");fwrite($fp,date("d")."\r\n1");fclose($fp);
$sql = mysqli_query($conection, "SELECT Rfc, Folio FROM usuarios");
$list = mysqli_fetch_all($sql);
$file_paths = file(__DIR__."/path's.txt");
$dir= trim($file_paths[3]);

$files = glob($dir.'/*.{xml}', GLOB_BRACE);$total = count($files);
$porcentaje = $total * 0.01;

$xml = simplexml_load_file($files[0]);
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
$sl = 0;
for($i=0;$i < $total;$i++){
    coneccion_2:
    
    //Verificacion en caso de fallo en conexion.

    if($sl >=10){goto end_error;}

    try{
        
        $cont = (($i+1)*100)/$total;
        msg("Actualizando: ".intval($cont)."%");
        $xml = simplexml_load_file($files[$i]);
        $Comprobante = $xml->xpath('//cfdi:Comprobante')[0]['Folio'];
        $Receptor = $xml->xpath('//cfdi:Comprobante//cfdi:Receptor')[0]['Rfc'];
        if  ($conection->connect_errno)
        {
            msg("error, imposible conectar con la base de datos."); 
            sleep(15);  
            $conection = new mysqli("$db_host","$user","$pass","$db");
            $sl++;
            goto coneccion_2;
        }
        $fp = fopen(__DIR__."/date.txt", "w");fwrite($fp,date("d")."\r\n1");fclose($fp);
        $result = $conection->query("SELECT Rfc,Folio  FROM usuarios WHERE Rfc = '$Receptor' AND Folio = '$Comprobante'");
        if  ($result <> null)
        {
            $num = mysqli_num_rows($result);
        }
        else
        {
            msg("error, imposible conectar con la base de datos.");
            sleep(15);  
            $conection = new mysqli("$db_host","$user","$pass","$db");
            $sl++;
            goto coneccion_2;
        }
        if  ($num == 0)
        {
            $sql = "INSERT INTO usuarios(Rfc, Folio) VALUES ('$Receptor', '$Comprobante');";
            if  (mysqli_query($conection, $sql)) 
            {} 
            else 
            {}
        }
        else
        {}
        
    }
    catch(Exception $e)
    {
        msg("error, imposible conectar con la base de datos."); 
        sleep(15);
        $sl++;
        goto coneccion_2;
    }

    //Guardar el dia y el valor para correo en un archivo.

    $fp = fopen(__DIR__."/date.txt", "w");
    fwrite($fp,date("d")."\r\n1");
    fclose($fp);
    
}

//Guardar los valores en el archivo config.txt

$fp = fopen(__DIR__."/config.txt","w");
fwrite($fp,"$total \r\n".Date("Y")."\r\n"."$db");
fclose($fp);
mysqli_close($conection);

goto end;

//En caso de un error, se enviara un correo a la cuenta de sistemas.

end_error:

if  (file_exists(__DIR__."/date.txt"))
{
    $day = file(__DIR__."/date.txt");
    $check = trim($day[1]);
    $day = trim($day[0]);
}
else
{  
    $fp = fopen(__DIR__."/date.txt", "w");
    fwrite($fp,date("d")."\r\n1");
    fclose($fp);
    goto end_error;
}

if  ($day == date("d") and $check == 0)
{}
else
{
    $fp = fopen(__DIR__."/date.txt", "w");
    fwrite($fp,"".date("d")."\r\n0");
    fclose($fp);
    exec("C:\\xampp\php\php.exe C:\\xampp\htdocs\sendMail.php");
}

end:



?>