<?php

$date = new DateTime();
echo "Formatted date: " . $date->format('d/m/Y') . PHP_EOL;

$date->modify('+1 month');
echo "Modified date (+1 month): " . $date->format('d/m/Y') . PHP_EOL;

$d1 = new DateTime('2014-01-01');
$d2 = new DateTime('2019-04-01');

$diff = $d1->diff($d2);
echo "Il y a {$diff->y} années, {$diff->m} mois et {$diff->d} jours de différence." . PHP_EOL;


$interval = new DateInterval('P1M1DT1M'); 
$startDate = new DateTime('2019-01-01');
$startDate->add($interval);

echo "Date after interval addition: " . $startDate->format('Y-m-d H:i:s') . PHP_EOL;