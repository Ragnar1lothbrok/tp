<?php
$fichier=__DIR__ . DIRECTORY_SEPARATOR . 'demo.csv';
$resource = fopen($fichier, 'r+');
$k =0;
while ($line = fgets($resource)){
    $k++;
    if ($k==1){
        fwrite($resource, 'salut les gens');
        break;
    }
}
fclose($resource);