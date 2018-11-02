<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 17.10.18
 * Time: 10:24
 */

class DBConfig extends Database
{
    const SCHEMA = 'webshop';

    const JSON = 'JSON';

    /*
     *  Treiber für den Datenbank-Hersteller festlegen. Kann auch oracle,
     *  postgre-SQL, mariaDB, etc... sein.
     */
    const DRIVER = 'mysql';

    /*
     * Host
     */
    const HOST = 'localhost';

    /*
     * Benutzername der Datenbank
     */
    const USER = 'root';

    /*
     * Passwort für die Datenbank
     */
    const PASSWORD = '123';
}