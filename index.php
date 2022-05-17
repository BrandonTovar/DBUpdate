<?php
#Codigo de generacion, archivo de configuracion.

function guardar(){
$user = "Brandon";
$pass = "@Admin2013.-/.*";
$ruta = "C:\\xampp\\Actualizar\\FACT\\";
$host = "192.100.10.20";
$send = "0";
$day = date("d");
$month = date("Y");

$pass_split = str_split($pass);
$user_split = str_split($user);
$ruta_split = str_split($ruta);
$host_split = str_split($host);
$send_split = str_split($send);
$day_split = str_split($day);
$month_split = str_split($month);

$passC = count($pass_split);
$userC = count($user_split);
$rutaC = count($ruta_split);
$hostC = count($host_split);
$sendC = count($send_split);
$dayC = count($day_split);
$monthC = count($month_split);


$max = max($passC , $userC , $rutaC , $hostC , $sendC , $dayC , $monthC);
global $cadena;
$cadena = $passC."»".$userC."»".$rutaC."»".$hostC."»".$sendC."»".$dayC."»".$monthC."»";


for($i=0;$i < $max;$i++){
if($passC > $i){$cadena = $cadena . $pass_split[$i];}
if($userC > $i){$cadena = $cadena . $user_split[$i];}
if($rutaC > $i){$cadena = $cadena . $ruta_split[$i];}
if($hostC > $i){$cadena = $cadena . $host_split[$i];}
if($sendC > $i){$cadena = $cadena . $send_split[$i];}
if($dayC > $i){$cadena = $cadena . $day_split[$i];}
if($monthC > $i){$cadena = $cadena . $month_split[$i];}
}
$fp = fopen("config.ini","w");
fwrite($fp,$cadena);
fclose($fp);
}
guardar();
exit;
#Codigo de extraccion, tomar datos de configuracion.
function getConfig($cadena){


$cadena = explode("»",$cadena);
$cadena_c = str_split($cadena[7]);
global $user,$pass ,$ruta ,$host ,$send ,$day ,$month;
$user = "";$pass = "";$ruta = "";$host = "";$send = "";$day = "";$month = "";

for($i=0;$i < count($cadena_c);){
if(strlen($pass) < $cadena[0]){$pass = $pass . $cadena_c[$i];$i++;}
if(strlen($user) < $cadena[1]){$user = $user . $cadena_c[$i];$i++;}
if(strlen($ruta) < $cadena[2]){$ruta = $ruta . $cadena_c[$i];$i++;}
if(strlen($host) < $cadena[3]){$host = $host . $cadena_c[$i];$i++;}
if(strlen($send) < $cadena[4]){$send = $send . $cadena_c[$i];$i++;}
if(strlen($day) < $cadena[5]){$day = $day . $cadena_c[$i];$i++;}
if(strlen($month) < $cadena[6]){$month = $month . $cadena_c[$i];$i++;}
}

echo $user . "\n",$pass . "\n",$ruta . "\n",$host . "\n",$send . "\n",$day . "\n",$month . "\n";


}




getConfig(file(__DIR__."/config.ini")[0]);



?>