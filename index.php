<?php
require 'bootstrap.php';

$last_update = $db->query("SELECT MAX(timestamp) FROM `weather_data`")->fetchColumn();
$totals      = $db->query("SELECT COUNT(*) AS `total`, MIN(`timestamp`) AS `min`, MAX(`timestamp`) AS `max`
                           FROM `weather_data`")->fetch(PDO::FETCH_ASSOC);

$now  = @$_REQUEST['now'] ?: time();
$days = @$_REQUEST['days'] ?: 1;
$min = strtotime('today 0:00:00', $now);
$max = $days > 1
     ? strtotime('+' . ($days - 1) . ' days 23:59:59', $now)
     : strtotime('today 23:59:59', $now);

$query = "SELECT `timestamp`, `precipitation` FROM `weather_data` WHERE `timestamp` BETWEEN :min AND :max ORDER BY `timestamp` ASC";
$statement = $db->prepare($query);
$statement->bindValue(':min', $min);
$statement->bindValue(':max', $max);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT MAX(`precipitation`) FROM `weather_data` WHERE `timestamp` BETWEEN :min AND :max";
$statement = $db->prepare($query);
$statement->bindValue(':min', $min);
$statement->bindValue(':max', $max);
$statement->execute();
$max_value = 5 * ceil($statement->fetchColumn() / 5);

require 'views/index.php';