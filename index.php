<?php
require 'bootstrap.php';

header('Content-Type: text/plain');

$last = $db->query("SELECT * FROM `weather_data` ORDER BY `timestamp` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo 'Last update: ' . date('d.m.Y H:i:s', $last['timestamp']) . PHP_EOL;
echo 'Currently raining: ' . ($last['raining'] ? 'Yes' : 'No') . PHP_EOL;
var_dump($last);

echo '--' . PHP_EOL;
echo $db->query("SELECT COUNT(*) FROM `weather_data`")->fetchColumn() . ' entries in db' . PHP_EOL;
