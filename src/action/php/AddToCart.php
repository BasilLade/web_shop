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
        $preis = filter_input(INPUT_POST, 'preis', FILTER_SANITIZE_NUMBER_FLOAT);
       echo "Der Text ist: ".$text . ' ';
       echo "Der Preis ist: " . $preis;
    }

}
