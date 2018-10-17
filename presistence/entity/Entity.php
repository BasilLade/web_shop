<?php

/**
 * Abstrakte Klasse für alle Datenbanktabellen. Implementiert EntityInt und
 * deren Funktionen (set, get, setData und getData)
 *
 * @author Jorge Windmeisser
 */
class Entity implements EntityInt
{
    /*
     * Diese Konstanten enthalten die Spaltennamen als Werte die es in allen
     * Tabellen gibt.
     */

    const ID = 'id';

    /*
     * Leeres Array <code>$data</code> durch protected geschützt, sodass nur 
     * hier und in Unterklassen dieser Klasse darauf zugegriffen werden kann.
     */

    protected $data = [];

    public function __construct()
    {

        /*
         * Hier wird die ID aus dem Klassennamen einem _ und einer UUID
         * zusammengesetzt.
         */
        $this->data[self::ID] = self::getClass() . '_' . self::getGUID();
    }

    /* 
     * Funktion um eine UUID zu erzeugen.
     */

    public
    function getClass()
    {
        return get_class($this);
    }

    public static function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {

            /*
             * Es wird ein Zufallswert erzeugt.
             */
            $randomValue = rand();

            /*
             * Erzeugt eine 13-stellige ID an die der <code>$randomValue</code>
             * vorne hinzugefügt wird.
             * Für more_entropy ist <code>true</code> gesetzt. Damit werden
             * zusätzlich 10 Zeichen an die ID angehängt.
             */
            $uniqueId = uniqid($randomValue, true);

            /*
             * alles in MD5 umwandeln
             */
            $md5Coding = md5($uniqueId);

            /*
             * alles in Grossbuchstaben umwandeln
             */
            $uuid = strtoupper($md5Coding);

            /*
             * gibt die UUID zurück
             */
            return $uuid;
        }
    }

    /**
     * Liefert die Namen der Felder die im Entity definiert sind.
     *
     * @return Array<string> Ein Array mit den Namen der Felder die in der
     * Entity definiert sind.
     */
    public
    static function getFields($className)
    {
        /*
         * anhand von <code>$this->className</code> die Klasse auswählen
         */
        $r = new ReflectionClass($className);

        /*
         * Alle Konstanten aus der gewünschten Klasse speichern
         */
        return $r->getConstants();
    }

    /**
     * @see EntityInt
     */
    public function set($fieldName, $fieldValue)
    {
        $this->data[$fieldName] = $fieldValue;
    }

    /**
     * @see EntityInt
     */
    public function get($fieldName)
    {
        return $this->data[$fieldName];
    }

    public function connectTo(Entity $value)
    {
        $checkexist = Database::instance()->loadList(ConfigDB::SCHEMA, Connector::class,
            [
                Connector::LEFT => $this->get(self::ID),
                Connector::RIGHT => $value->get(self::ID)
            ]);
        if (count($checkexist) === 0) {
            EntityFactory::newConnector($this, $value);
        }
    }    /**
     * @see EntityInt
     */
    public
    function setData(array $data)
    {
        $this->data = $data;
    }

    public function disconnectFrom(Entity $value)
    {
        $checkexist = Database::instance()->loadList(ConfigDB::SCHEMA, Connector::class,
            [
                Connector::LEFT => $this->get(self::ID),
                Connector::RIGHT => $value->get(self::ID)
            ]);
        if (count($checkexist) !== 0) {
            echo 'HERE';
            foreach ($checkexist as $connection)
            Database::instance()->delete(ConfigDB::SCHEMA, Connector::class, $connection->get(self::ID));
        }

    }    /**
     * @see EntityInt
     */
    public
    function getData()
    {
        return $this->data;
    }

    /**
     *
     * @return type
     */
    public
    function __toString(): string
    {
        return $this->data[Entity::ID] . '';
    }

    public function dump() {
        echo '<pre>';
        print_r($this->data);
        echo '</pre>';
    }

}
