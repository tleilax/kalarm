<?php
    ini_set('date.timezone', 'Europe/Berlin');

    function to_float($string) {
        return str_replace(',', '.', $string) + 0.0;
    }

    set_exception_handler(function ($e) {
        header('Content-Type: text/plain');
        printf('Exception #%u: %s in %s on line %u', $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    });

    $db = new PDO('sqlite:' . __DIR__ . '/kalarm.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
