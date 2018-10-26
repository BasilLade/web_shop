<?php

/**
 * Klasse für die Datenbankverbindung und Datenbankabfragen. Enthält alle Daten
 * die zur Verbindung gebraucht werden (Driver, Host, Schema, User und Passwort)
 * In der Funktion<code>connect()</code> werden diese an ein PDO-Objekt übergeben.
 * Das PDO-Objekt kümmert sich um die Verbindung zur Datenbank.
 *
 * @author Jorge Windmeisser
 */
class MySQLDatabase extends DBConfig implements DatabaseInt
{


    protected static $db = null;
    protected $transaction = false;
    protected $connection = null;

    public function beginTransaction()
    {
        $this->transaction = true;
        return $this->connection->beginTransaction();
    }

    /*
     * <code>$connection</code> auf NULL gesetzt, weil am Anfang 
     * keine Verbindung zur Datenbank besteht
     */

    public function commit()
    {
        $this->transaction = false;
        return $this->connection->commit();
    }

    public function load(string $schema, string $dataType, string $id, array $filter = [], $json = null)
    {

        $filterSql = $this->buildFilter($filter);
        if (count($filter) === 0) {
            $filterSql .= ' id=\'' . $id . '\'';
        } else {
            $filterSql .= ' AND id=\'' . $id . '\'';
        }

        /*
         * Funktion <code>connect</code> aufrufen um eine Verbindung zur
         * Datenbank herzustellen.
         */
        $this->connect($schema);

        /*
         * Datenbank-Abfrage ausführen
         */
        try {
            /*
             * Die Datenbank-Abfrage zusammensetzen.
             */
            $sql = 'SELECT * FROM ' . strtolower($dataType) . ' WHERE ' . $filterSql;
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            /*
             * Resultat der Datenbank-Abfrage zwischenspeichern
             */
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return null;
            }

            if (self::JSON === $json) {
                $entity = json_encode($result);
            } else {
                /*
                 * Neues Objekt vom Typ <code>$dataType</code>, dieser entspricht
                 * einem Tabellennamen.
                 */
                $entity = new $dataType();

                /*
                 * Die Daten aus der Abfrage werden in das Objekt gesetzt.
                 */
                $entity->setData($result);
            }
            /*
             * gibt das Objekt zurück
             */
            return $entity;
        } catch (Exception $e) {
            echo $e;
            exit();
        }
        return null;
    }

    /**
     *
     * @param $schema
     * @param $dataType
     * @param array $filter
     * @param bool $json
     * @return Eine Liste von Entity-Objekten in einem Array verpackt.
     */
    public function loadList($schema, $dataType, $filter = [], $json = false)
    {

        $filterSql = $this->buildFilter($filter);

        /*
         * alles in Kleinbuchstaben umwandeln
         */
        $class = strtolower($dataType);

        /*
         * Funktion <code>connect</code> aufrufen um eine Verbindung zur
         * Datenbank herzustellen
         */
        $this->connect($schema);

        $sql = 'select * from ' . $class . ' ' . $filterSql;

        /*
         * Datenbank-Abfrage zusammensetzen mit Klassennamen und
         * dem Tag- und Gelöschtfilter.
         */
        $statement = $this->connection->prepare($sql);

        /*
         * Datenbank-Abfrage ausführen
         */
        $statement->execute();

        /*
         * Resultat der Datenbank-Abfrage zwischenspeichern
         */
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $returnVal = [];

        /*
         * Die Zeilen auslesen
         */
        foreach ($result as $data) {

            $entity = null;

            if (self::JSON === $json) {
                $entity = json_encode($data);
            } else {
                /*
                 * Neues Objekt wird instanziert anhand des Namens der im Parameter
                 * gesetzt wurde.
                 */
                $entity = new $dataType();

                /*
                 * Mit Objekt <code>$entity</code> Aufruf der Funktion
                 * <code>setData</code> (die von "Entity" vererbt wurde)
                 */
                $entity->setData($data);
            }

            $returnVal[] = $entity;
        }
        /*
         *  Speicherplatz wieder freigeben.
         */
        $result = null;
        if (self::JSON === $json) {
            return json_encode($returnVal);
        } else {
            return $returnVal;
        }
    }

    /*
     * Funktion <code>loadList</code> wird gebraucht um die Waren auszulesen.
     */

    /**
     * @param $schema
     * @param $entity
     * @return bool
     * @throws Exception
     */
    public function save($schema, $entity): ?Entity
    {

        $class = $entity->getClass();
        $id = $entity->__toString();
        $insert = false;
        $loadedEntity = $this->load($schema, $class, $id);

        if ($loadedEntity === null) {
            $insert = true;
        }

        if ($insert === true) {


            /*
             * Holt die Daten aus dem Entity-Objekt und speichert sie in
             * <code>$data</code>
             */
            $data = $entity->getData();

            /*
             * SQL-Statement wird zusammengesetzt.
             */

            /*
             * <code>get_class</code> holt den Tabellennamen.
             */
            $sql = "INSERT INTO " . strtolower(get_class($entity));
            $sqlColumn = " (";
            $sqlValues = " (";
            $values = [];
            foreach ($data as $fieldName => $fieldValue) {

                /*
                 * Hier werden die Spaltennamen durch Komma
                 * getrennt aneinandergehängt.
                 */
                $sqlColumn .= $fieldName . ", ";

                /*
                 * setzt die nötigen Zeichen und Komma ein
                 */
                $sqlValues .= "?, ";

                /*
                 * Hier werden die Werte der Zellen gespeichert.
                 */
                $values[] = $fieldValue;
            }

            /*
             * Hier werden mit <code>substr</code> das letzte Komma und Leerzeichen
             * weggelassen.
             */
            $sqlColumn = substr($sqlColumn, 0, -2);
            $sqlValues = substr($sqlValues, 0, -2);

            /*
             * Hier wird das Statement vervollständigt.
             */
            $sql .= $sqlColumn . ") values " . $sqlValues . ")";
        } else {

            $values = [];

            /*
             * Holt die Daten aus dem Entity-Objekt und speichert sie in
             * <code>$data</code>
             */
            $data = $entity->getData();

            /*
             * SQL-Statement wird zusammengesetzt.
             */

            /*
             * <code>get_class</code> holt den Tabellennamen.
             */
            $sql = 'UPDATE ' . strtolower(get_class($entity)) . ' SET ';
            $sqlSet = '';

            foreach ($data as $fieldName => $fieldValue) {
                $sqlSet .= $fieldName . "=?, ";
                /*
                 * Hier werden die Werte der Zellen gespeichert.
                 */
                $values[] = $fieldValue;
            }
            $sqlSet = substr($sqlSet, 0, -2);
            $sql .= $sqlSet . ' WHERE ' . Entity::ID . ' =?';

            $values[] = $entity->get(Entity::ID);
        }
        try {

            /*
             * mit Datenbank verbinden und Statement ausführen
             */
            $this->connect($schema);
            $statement = $this->connection->prepare($sql);
            $statement->execute($values);
        } catch (Exception $e) {
            echo $e;
            return null;
        }

        return $entity;
    }

    public function delete($schema, $dataType, $id)
    {
        /*
         * Das SQL-Statement wird zusammengesetzt.
         */

        $sql = 'DELETE FROM ' . strtolower($dataType) . ' WHERE ' . Entity::ID . '=?';
        try {
            /*
             * mit Datenbank verbinden und Statement ausführen
             */
            $this->connect($schema);
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id]);
        } catch (Exception $e) {
            echo $e;
        }
    }

    protected function buildFilter(array $filter = [])
    {
        $filterSql = '';
        /*
         * Wenn <code>$filter</code> nicht null ist, dann Datenbank-Abfrage mit
         * dem gewünschten Kategorienfilter machen.
         */
        if (count($filter) > 0) {
            $filterSql = ' WHERE ';
            foreach ($filter as $key => $f) {
                if (is_array($f)) {
                    foreach ($f as $f2) {
                        $filterSql .= $key;
                        $filterSql .= '=';
                        $filterSql .= '\'' . $f2 . '\' OR ';
                    }
                } else {
                    $filterSql .= $key;
                    $filterSql .= '=';
                    $filterSql .= '\'' . $f . '\' AND ';
                }
            }
        }

        $filterSql = substr($filterSql, 0, -4);


        return $filterSql;
    }

    /*
     * Funktion um Datensätze als gelöscht zu markieren
     */

    /**
     * Funktion um eine Datenbank-Verbindung aufzubauen
     */
    protected function connect(string $schema)
    {

        /*
         * Das passiert nur wenn es noch keine Verbindung gibt, sonst könnte es
         * sein, dass zu viele Verbindungen eröffnet werden.
         */
        if ($this->connection === NULL) {
            try {

                /*
                 * Hier werden die Verbindungs-Daten die in den Konstanten
                 * gespeichert sind an das neue PDO-Objekt übergeben.
                 * Das PDO Objekt kümmert sich dann um die Verbindung zur Datenbank.
                 */
                $this->connection = new PDO(self::DRIVER . ":host=" . self::HOST . ";dbname=" . $schema, self::USER, self::PASSWORD);

                /*
                 * Die Fehlerbehandlung des PDO-Objekts wird so gesetzt damit
                 * beijedem Fehler eine Ausnahme geworfen wird, damit können
                 * wir diese Fehler abfangen.
                 */
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                exit();
            }
        }
    }

    public function rollback()
    {
        $this->transaction = false;
        return $this->connection->rollback();
    }

}
