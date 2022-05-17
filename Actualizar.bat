@echo off
chcp 65001
cls
Echo Batch de ejecución, no contiene codigo o conección con el sistema operativo.
Rem LLamada a codigo php, estructura de datos
set path=%cd%

CD %path%
php.exe rttp.php

pause