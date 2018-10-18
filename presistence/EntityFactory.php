<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 17.10.18
 * Time: 10:08
 */

class EntityFactory
{
    public static function newProduct(string $name, array $tags, string $description, float $price): ?Product
    {
        Database::instance()->beginTransaction();
        $produkt = new Product();
        $produkt->set(Product::NAME, $name);
        $produkt->set(Product::DESC, $description);
        $produkt->set(Product::PRICE, $price);
        $entity = Database::instance()->save(ConfigDB::SCHEMA, $produkt);


            foreach ($tags as $tag) {
                self::newConnector($produkt, $tag);
            }


        if (Database::instance()->commit()) {
            return $entity;
        }
        return null;
    }

    public static function newConnector(string $left, string $right): ?Connector
    {
        $connector = new Connector();
        $connector->set(Connector::LEFT, $left);
        $connector->set(Connector::RIGHT, $right);
        return Database::instance()->save(ConfigDB::SCHEMA, $connector);
    }

    public static function newTag($name): ?Tag
    {
        $tag = new Tag();
        $tag->set(Tag::NAME, $name);
        return Database::instance()->save(ConfigDB::SCHEMA, $tag);
    }

    public static function newPicture(string $path, Product $product): ?Picture
    {
        $bild = new Picture();
        $bild->set(Picture::PATH, $path);
        $bild->set(Picture::PRODUCT, $product->get(Product::ID));
        return Database::instance()->save(ConfigDB::SCHEMA, $bild);
    }

    public static function newCustomer(string $firstname, string $surname, string $email, int $age): ?Customer
    {
        $kunde = new Customer();
        $kunde->set(Customer::FIRSTNAME, $firstname);
        $kunde->set(Customer::NAME, $surname);
        $kunde->set(Customer::EMAIL, $email);
        $kunde->set(Customer::AGE, $age);
        return Database::instance()->save(ConfigDB::SCHEMA, $kunde);

    }

    public static function newOrder(string $date, Customer $customer, array $products): ?Order
    {
        Database::instance()->beginTransaction();
        $bes = new Order();
        $bes->set(Order::DATE, $date);
        $bes->set(Order::CUSTOMER, $customer->get(Customer::ID));
        $entity = Database::instance()->save(ConfigDB::SCHEMA, $bes);

        foreach ($products as $product) {
            self::newConnector($bes, $product);

        }
        if (Database::instance()->commit()) {
            return $entity;
        }
        return null;
    }
}