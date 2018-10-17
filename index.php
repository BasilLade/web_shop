<?php
include_once('Autoloader.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>webshop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

//$prod::newTag('Handy');
//
//
//$protag = Database::instance()->loadList(ConfigDB::SCHEMA,Tag::class,['name' => 'Handy']);
//$produkt = EntityFactory::newProdukt('Sony-Handy',$protag,'das ist ein Handy',423);
//
//$fernseh = Database::instance()->load(ConfigDB::SCHEMA,Produkt::class, $produkt);
//$bild = EntityFactory::newBild('img/img.png',$fernseh);


$producte = Database::instance()->loadList(ConfigDB::SCHEMA, Produkt::class);
$tags = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class);
$img = Database::instance()->loadList(ConfigDB::SCHEMA, Bild::class);

$testupdates = Database::instance()->loadList(ConfigDB::SCHEMA,Produkt::class,[Produkt::NAME => 'Sony Fernseher']);


echo '<table>';
foreach ($tags as $kategorie) {
    echo '<tr>';
    echo '<th>' . $kategorie->get(Tag::ID) . '</th>';
    echo '<td> ' . $kategorie->get(Tag::NAME) . '</td>';
    echo '</tr>';
}
echo '</table>';
foreach ($img as $value) {
    echo '<img src="' . $value->get(Bild::PATH) . '">';
}

echo '<table>';
foreach ($producte as $value) {
    echo '<tr>';
    echo '<th>' . $value->get(Produkt::ID) . '</th>';
    $bilder = $value->get(BILD::class);
    foreach ($bilder as $bild) {
        echo '<td><img src="' . $bild->get(Bild::PATH) . '" width="30%;"</td>';
    }
    echo '<td> ' . $value->get(Produkt::NAME) . '</td>';
    echo '<td> ' . $value->get(Produkt::BEZ) . '</td>';
    echo '<td> ' . $value->get(Produkt::PREIS) . ' Fr.</td>';
    $cats = $value->get(Tag::class);
    foreach ($cats as $cat){
        echo '<td> ' . $cat->get(Tag::NAME) . ' </td>';
    }
    echo '</tr>';
}
echo '</table>';

$fernseherTag = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class, [Tag::NAME => 'Fernseh'])[0];

foreach($testupdates as $fernseher) {
    $fernseher->connectTo($fernseherTag);
//   $fernseher->disconnectFrom($fernseherTag);
}
foreach ($testupdates as $testupdate){
    $testupdate->set(Produkt::NAME,'Sony Fernseher');
    $testupdate->dump();
    Database::instance()->save(ConfigDB::SCHEMA,$testupdate);
}
?>

</body>
</html>