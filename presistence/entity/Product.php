<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 16.10.18
 * Time: 14:37
 */

class Product extends Entity
{
    const NAME = 'name';
    const DESC = 'description';
    const PRICE = 'price';

    public function get($fieldName) {
        switch($fieldName) {
            case Order::class:
                $filter = [];
                $filter[Connector::LEFT] = $this->data[self::ID];
                $connectedEntities = Database::instance()->loadList(ConfigDB::SCHEMA,Connector::class,$filter);
                $result = [];
                foreach ($connectedEntities as $connection){
                    $result[] = Database::instance()->load(ConfigDB::SCHEMA,Order::class,$connection->get(Connector::RIGHT));
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

            case Picture::class:
                $filter = [];
                $filter[Picture::PRODUCT] = $this->data[self::ID];
                return Database::instance()->loadList(ConfigDB::SCHEMA, Picture::class, $filter);

            default:
                return parent::get($fieldName);
        }
    }

}