<?php
$cAdmin = get_current_user();
$p1=readline("Ingresa la primera puerta de enlace: ");
$p2=readline("Ingresa la segunda puerta de enlace: ");

$user = fopen("C:\Users\Public\user.txt", "r");
$user=fgets($user);
$user=trim($user);

$nPE1=substr($p1, -3);
$nPE2=substr($p2, -3);
?>