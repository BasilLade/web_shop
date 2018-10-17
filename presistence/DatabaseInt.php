<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 16.10.18
 * Time: 15:51
 */

interface DatabaseInt
{

    /**
     * @param string $id
     * Anhand der ID wird ein Datensatz ausgelesen und in
     * ein Entity-Objekt gespeichert.
     */
    public function load(string $schema, string $dataType, string $id, array $filter = [], $json = null);


    /*
    * Funktion <code>loadList</code> wird gebraucht um die Waren auszulesen.
    *
    * @param $schema
    * @param $dataType
    * @param array $filter
    * @param bool $json
    * @return Eine Liste von Entity-Objekten in einem Array verpackt.
    */
    public function loadList($schema, $dataType, $filter = [], $json = false);

    /**
     * Funktion um Daten als Datensatz in die Datenbank zu speichern.
     *
     * @param $schema
     * @param $entity
     * @return bool
     */
    public function save($schema, $entity): ?Entity;

    /**
     *
     * Funktion um Datensätze als gelöscht zu markieren
     *
     * @param $schema
     * @param $dataType
     * @param $id
     * @return mixed
     */
    public function delete($schema, $dataType, $id);

    //public function beginTransaction();

    //public function commit();
    public function beginTransaction();

    public function commit();

}