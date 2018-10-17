<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 16.10.18
 * Time: 14:37
 */

class Produkt extends Entity
{
    const NAME = 'name';
    const BEZ = 'beschreibung';
    const PREIS = 'preis';

    public function get($fieldName) {
        switch($fieldName) {
            case Bestellung::class:
                $filter = [];
                $filter[Connector::LEFT] = $this->data[self::ID];
                $connectedEntities = Database::instance()->loadList(ConfigDB::SCHEMA,Connector::class,$filter);
                $result = [];
                foreach ($connectedEntities as $connection){
                    $result[] = Database::instance()->load(ConfigDB::SCHEMA,Bestellung::class,$connection->get(Connector::RIGHT));
                }
                return $result;

            case Tag::class:
                $filter = [];
                $filter[Connector::LEFT] = $this->data[self::ID];
                $connectedEntities = Database::instance()->loadList(ConfigDB::SCHEMA, Connector::class, $filter);
                $result = [];
                foreach($connectedEntities as $connection) {
                    $result[] =  Database::instance()->load(ConfigDB::SCHEMA, Tag::class, $connection->get(Connector::RIGHT));
                }
                return $result;

            case BILD::class:
                $filter = [];
                $filter[Bild::PRODUKT] = $this->data[self::ID];
                return Database::instance()->loadList(ConfigDB::SCHEMA, Bild::class, $filter);

            default:
                return parent::get($fieldName);
        }
    }

}