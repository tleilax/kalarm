<?php
require 'bootstrap.php';

$last_update = DB::get()->query("SELECT MAX(timestamp) FROM `weather_data`")->fetchColumn();
$totals      = DB::get()->query("SELECT COUNT(*) AS `total`, MIN(`timestamp`) AS `min`, MAX(`timestamp`) AS `max` FROM `weather_data`")->fetch(PDO::FETCH_ASSOC);

$from = new DateTime();
if (isset($_REQUEST['from']) && is_numeric($_REQUEST['from'])) {
    $from = DateTime::createFromformat('Ymd', $_REQUEST['from']);
}
$days = @$_REQUEST['days'] ?: 1;

if (isset($_REQUEST['yesterday']) || isset($_REQUEST['tomorrow'])) {
    $from->modify(isset($_REQUEST['yesterday']) ? 'yesterday' : 'tomorrow');

    $url = $_SERVER['PHP_SELF'] . '?from=' . $from->format('Ymd');
    if ($days > 1) {
        $url .= '&days=' . $days;
    }
    header('Location: ' . $url);
    die;
}

$min = clone $from;
$max = clone $min;
if ($days > 1) {
    $max->modify('+' . ($days - 1) . ' days 23:59:59');
}

$data = WeatherData::get($min, $max);

$query = "SELECT MAX(`precipitation`) FROM `weather_data` WHERE `timestamp` BETWEEN :min AND :max";
$statement = DB::get()->prepare($query);
$statement->bindValue(':min', $min->getTimestamp());
$statement->bindValue(':max', $max->getTimestamp());
$statement->execute();
$max_value = 5 * ceil($statement->fetchColumn() / 5);

require 'views/index.php';