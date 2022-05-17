<?php

$nUser=shell_exec("echo %USERNAME%");
$nUser=trim($nUser);

$fp=fopen("C:\Users\Public\admin.bat", "w");

fwrite($fp, '@echo off
echo Ejecutando como administrador
setlocal enabledelayedexpansion
set SEPARATOR=/
set filecontent=
for /f "delims=" %%a in (C:\Users\Public\user.txt) do (
  set currentline=%%a
  set filecontent=!filecontent!!currentline!

)
setx NmbrP %filecontent%



cd /d "%~dp0" && ( if exist "%temp%\getadmin.vbs" del "%temp%\getadmin.vbs" ) && fsutil dirty query %systemdrive% 1>nul 2>nul || (  cmd /u /c echo Set UAC = CreateObject^("Shell.Application"^) : UAC.ShellExecute "cmd.exe", "/k cd ""%~dp0"" && ""%~dpnx0""", "", "runas", 1 >> "%temp%\getadmin.vbs" && "%temp%\getadmin.vbs" 1>nul 2>nul && exit /B )
cls
echo ejecutandose para %NmbrP%
cd C:\Users\%NmbrP%\Desktop\php\
php.exe puertas.php
exit
');
fclose($fp);

$nUser=shell_exec("echo %USERNAME%");
$nUser=trim($nUser);
$fp=fopen("C:/Users/$nUser/Desktop/php/ejecutar.vbs", "w");

fwrite($fp, 'Set WshShell = WScript.CreateObject("WScript.Shell")
Dim sInput
sInput = InputBox("Ingresa el nombre de usuario: ")
WshShell.run "runas /user:"+sInput+" ""cmd /k cd C:\Users\"+sInput+"\Desktop && copy C:\Users\Public\admin.bat C:\Users\"+sInput+"\Desktop\admin.bat && admin.bat && exit"""
WScript.Sleep 500 
WshShell.SendKeys "Admin2013.{ENTER}"

');
fclose($fp);


system("C:/Users/$nUser/Desktop/php/ejecutar.vbs");
sleep(1);
unlink("C:/Users/$nUser/Desktop/php/ejecutar.vbs");
system("exit");
?>


