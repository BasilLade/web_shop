<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 16.10.18
 * Time: 15:29
 */

abstract class Database
{
    private static $connection = null;

    public static function instance() :DatabaseInt {
        if(self::$connection === null) {
            self::$connection = new MySQLDatabase();
        }

        return self::$connection;
    }


}