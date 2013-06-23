<?php
class DB
{
    protected static $instance = null;
    
    public static function get()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new PDO(DSN);
            $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $instance;
    }
}