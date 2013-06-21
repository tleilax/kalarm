<?php
    ini_set('date.timezone', 'Europe/Berlin');

    function to_float($string) {
        return str_replace(',', '.', $string) + 0.0;
    }

    set_exception_handler(function ($e) {
        header('Content-Type: text/plain');
        printf('Exception #%u: %s in %s on line %u', $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    });

    $db = new PDO('sqlite:kalarm.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $res = $db->exec("CREATE TABLE IF NOT EXISTS `weather_data` (
        `timestamp` INTEGER PRIMARY KEY,
        `temperature` DECIMAL,
        `temperature_felt` DECIMAL,
        `wind_direction` CHAR(3),
        `wind_speed` DECIMAL,
        `humidity` DECIMAL,
        `precipitation` DECIMAL,
        `raining` INTEGER,
        `luminous_intensity` DECIMAL,
        `radiation` DECIMAL,
        `air_pressure` DECIMAL
    )");
