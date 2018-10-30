<?php
/**
 * Created by PhpStorm.
 * User: gmuheim
 * Date: 26.10.18
 * Time: 15:13
 */

new AddToCart();

class AddToCart{

    public function __construct()
    {
        $text = filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

        $preis = Database::instance()->load(DBConfig::SCHEMA,Product::class,$id);
        $preis = $preis->get(Product::PRICE);
       echo "Der Text ist: ".$text . ' ';
       echo "Der Preis ist: " . $preis;
    }

}
