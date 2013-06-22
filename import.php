<?php
    require 'bootstrap.php';
$i = $_REQUEST['i'];
$rows = array_filter(array_map('trim', file('http://www.uni-oldenburg.de/dezernat4/wetter/ausgabe.php?datei=Wetter' . $i . '.txt')));
header('content-type: text/plain');

$statement = $db->prepare("REPLACE INTO `weather_data` (`timestamp`, `temperature`, `temperature_felt`, `wind_direction`, `wind_speed`, `humidity`, `precipitation`, `raining`, `luminous_intensity`, `radiation`, `air_pressure`) VALUES (:timestamp, :temperature, :temperature_felt, :wind_direction, :wind_speed, :humidity, :precipitation, :raining, :luminous_intensity, :radiation, :air_pressure)");

echo 'Importing ' . count($rows) . ' rows...';
flush();ob_flush();
foreach ($rows as $row) {
    $cols = explode("\t", $row);

    $statement->bindValue(':timestamp', strtotime($cols[0] . ' ' . $cols[1]));
    $statement->bindValue(':temperature', to_float($cols[3]));
    $statement->bindValue(':temperature_felt', to_float($cols[4]));
    $statement->bindValue(':wind_direction', to_float($cols[7]));
    $statement->bindValue(':wind_speed', to_float($cols[2]));
    $statement->bindValue(':humidity', to_float($cols[6]));
    $statement->bindValue(':precipitation', to_float($cols[9]));
    $statement->bindValue(':raining', 0);
    $statement->bindValue(':luminous_intensity', to_float($cols[5]));
    $statement->bindValue(':radiation', to_float($cols[8]));
    $statement->bindValue(':air_pressure', to_float($cols[10]));
    $statement->execute();
}
echo ' done!';
