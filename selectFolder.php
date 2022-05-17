<?php 
$fp = fopen(__DIR__."/destino.bat", "w");
fwrite($fp, '

@echo off 
setlocal
set "psCommand="(new-object -COM \'Shell.Application\')^
.BrowseForFolder(0,\'Selecciona la ruta destino.\',0,0).self.path""
for /f "usebackq delims=" %%I in (`powershell %psCommand%`) do set "folder=%%I"
setlocal enabledelayedexpansion
echo !folder!
endlocal

	');
fclose($fp);



?>