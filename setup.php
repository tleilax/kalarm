<?php
    require 'bootstrap.php';

    DB::get()->exec("CREATE TABLE IF NOT EXISTS `weather_data` (
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
