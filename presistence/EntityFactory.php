<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 17.10.18
 * Time: 10:08
 */

class EntityFactory
{
    public static function newConnector(string $left, string $right) : ?Connector {
        $connector = new Connector();
        $connector->set(Connector::LEFT, $left);
        $connector->set(Connector::RIGHT, $right);
        return Database::instance()->save(ConfigDB::SCHEMA, $connector);
    }


    public static function newProdukt(string $name,array $tags,string $bezeichnung, float $price) : ?Produkt {
        Database::instance()->beginTransaction();
        $produkt = new Produkt();
        $produkt->set(Produkt::NAME, $name);
        $produkt->set(Produkt::BEZ,$bezeichnung);
        $produkt->set(Produkt::PREIS,$price);
        $entity = Database::instance()->save(ConfigDB::SCHEMA,$produkt);

        foreach($tags as $tag) {
            self::newConnector($produkt,$tag);
        }

        if(Database::instance()->commit()) {
            return $entity;
        }
        return null;
    }

    public static function newTag($name) : ?Tag {
        $tag = new Tag();
        $tag->set(Tag::NAME, $name);
        return Database::instance()->save(ConfigDB::SCHEMA,$tag);
    }

    public static function newBild(string $path,Produkt $product) : ?Bild {
        $bild = new Bild();
        $bild->set(Bild::PATH, $path);
        $bild->set(Bild::PRODUKT, $product->get(Produkt::ID));
        return Database::instance()->save(ConfigDB::SCHEMA,$bild);
    }

    public static function newKunde(string $vorname,string $nachname,string $email,int $alter) : ?Kunde {
        $kunde = new Kunde();
        $kunde->set(Kunde::VORNAME,$vorname);
        $kunde->set(Kunde::NAME,$nachname);
        $kunde->set(Kunde::EMAIL,$email);
        $kunde->set(Kunde::ALTER,$alter);
        return Database::instance()->save(ConfigDB::SCHEMA,$kunde);

    }

    public static function newBestellung(string $datum, Kunde $kunde,array $products) : ?Bestellung {
        Database::instance()->beginTransaction();
        $bes = new Bestellung();
        $bes->set(Bestellung::DATUM, $datum);
        $bes->set(Bestellung::KUNDE, $kunde->get(Kunde::ID));
        $entity = Database::instance()->save(ConfigDB::SCHEMA,$bes);

        foreach ($products as $product){
            self::newConnector($bes,$product);

        }
        if(Database::instance()->commit()) {
            return $entity;
        }
        return null;
    }
}