<?php
require 'bootstrap.php';

header('Content-Type: text/plain');
echo $db->query("SELECT COUNT(*) FROM `weather_data`")->fetchColumn() . ' entries in db';
