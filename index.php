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

//$phone = EntityFactory::newTag('Handy');
//$tv = EntityFactory::newTag('TV');
//$android = EntityFactory::newTag('Android');


$protaghandy = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class, [
    Tag::NAME => [
        'Handy',
        'Android'
    ]
]);

$protagtv = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class, [Tag::NAME => 'TV']);
//$product = EntityFactory::newProduct('Sony-Handy', $protaghandy, 'das ist ein Handy', 423.90);
//$updateproduct = EntityFactory::newProduct('Sony-Fernseh',$protagtv,'das ist ein Fernseh',773.00);

//$handy = Database::instance()->load(ConfigDB::SCHEMA,Product::class, $product);
//$bild = EntityFactory::newPicture('img/img.png',$handy);
//

$products = Database::instance()->loadList(ConfigDB::SCHEMA, Product::class);
$tags = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class);
$img = Database::instance()->loadList(ConfigDB::SCHEMA, Picture::class);

$testupdates = Database::instance()->loadList(ConfigDB::SCHEMA, Product::class, [Product::NAME => 'Sony Fernseher']);


echo '<table>';
foreach ($tags as $kategorie) {
    echo '<tr>';
    echo '<th>' . $kategorie->get(Tag::ID) . '</th>';
    echo '<td> ' . $kategorie->get(Tag::NAME) . '</td>';
    echo '</tr>';
}
echo '</table>';
foreach ($img as $value) {
    echo '<img src="' . $value->get(Picture::PATH) . '">';
}

echo '<table>';
foreach ($products as $value) {
    echo '<tr>';
    echo '<th>' . $value->get(Product::ID) . '</th>';
    $bilder = $value->get(Picture::class);
    foreach ($bilder as $bild) {
        echo '<td><img src="' . $bild->get(Picture::PATH) . '" width="30%;"</td>';
    }
    echo '<td> ' . $value->get(Product::NAME) . '</td>';
    echo '<td> ' . $value->get(Product::DESC) . '</td>';
    echo '<td> ' . $value->get(Product::PRICE) . ' Fr.</td>';
    $cats = $value->get(Tag::class);
    foreach ($cats as $cat) {
        echo '<td> ' . $cat->get(Tag::NAME) . ' </td>';
    }
    echo '</tr>';
}
echo '</table>';

$fernseherTag = Database::instance()->loadList(ConfigDB::SCHEMA, Tag::class, [Tag::NAME => 'Android'])[0];

foreach ($testupdates as $fernseher) {
    $fernseher->connectTo($fernseherTag);
//   $fernseher->disconnectFrom($fernseherTag);
}
foreach ($testupdates as $testupdate) {
    $testupdate->set(Product::NAME, 'Sony Fernseher');
//    $testupdate->dump();
    Database::instance()->save(ConfigDB::SCHEMA, $testupdate);
}
?>

</body>
</html>