<?php
    require 'bootstrap.php';

    // http://www.uni-oldenburg.de/wetter/
    // http://www.uni-oldenburg.de/dezernat4/wetter/ausgabe.php?datei=wetter1306.txt

    $html = file_get_contents('http://www.uni-oldenburg.de/wetter/');
    $relevant = substr($html, $tmp = strpos($html, '<!-- #BeginEditable "Textkoerper" -->'), strpos($html, ' <!-- #EndEditable -->') - $tmp);
    $cleaned  = array_values(array_filter(array_map('trim', explode("\n", html_entity_decode(strip_tags($relevant), ENT_COMPAT, 'UTF-8')))));

    $data = array(
        'timestamp'          => DateTime::createFromFormat('dmYHis', preg_replace('/\D/', '', $cleaned[1]))->getTimestamp(),
        'temperature'        => to_float($cleaned[3]),
        'temperature_felt'   => to_float($cleaned[5]),
        'wind_direction'     => $cleaned[7],
        'wind_speed'         => to_float($cleaned[9]),
        'humidity'           => to_float($cleaned[11]) / 100,
        'precipitation'      => to_float($cleaned[13]),
        'raining'            => $cleaned[15] === 'Ja',
        'luminous_intensity' => to_float($cleaned[17]),
        'radiation'          => to_float($cleaned[19]),
        'air_pressure'       => to_float($cleaned[21]),
    );

    $statement = $db->prepare("REPLACE INTO `weather_data` (`timestamp`, `temperature`, `temperature_felt`, `wind_direction`, `wind_speed`, `humidity`, `precipitation`, `raining`, `luminous_intensity`, `radiation`, `air_pressure`) VALUES (:timestamp, :temperature, :temperature_felt, :wind_direction, :wind_speed, :humidity, :precipitation, :raining, :luminous_intensity, :radiation, :air_pressure)");
    $statement->bindValue(':timestamp', $data['timestamp']);
    $statement->bindValue(':temperature', $data['temperature']);
    $statement->bindValue(':temperature_felt', $data['temperature_felt']);
    $statement->bindValue(':wind_direction', $data['wind_direction']);
    $statement->bindValue(':wind_speed', $data['wind_speed']);
    $statement->bindValue(':humidity', $data['humidity']);
    $statement->bindValue(':precipitation', $data['precipitation']);
    $statement->bindValue(':raining', (int)$data['raining']);
    $statement->bindValue(':luminous_intensity', $data['luminous_intensity']);
    $statement->bindValue(':radiation', $data['radiation']);
    $statement->bindValue(':air_pressure', $data['air_pressure']);
    $statement->execute();
