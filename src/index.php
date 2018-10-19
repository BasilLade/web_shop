<?php
include_once('Autoloader.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>webshop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php
echo '&#9786<br>';

//$phone = EntityFactory::newTag('Handy');
//$tv = EntityFactory::newTag('TV');
//$android = EntityFactory::newTag('Android');

$button = new ButtonWidget('webshop');
$button->setLabel('hallo');
$button->addCssClass('test');
$button->setValue('');
echo $button;
$protaghandy = Database::instance()->loadList(DBSchema::SCHEMA, Tag::class, [
    Tag::NAME => [
        'Handy',
        'Android'
    ]
]);
$protagtv = Database::instance()->loadList(DBSchema::SCHEMA, Tag::class, [Tag::NAME => 'TV']);
//$product = EntityFactory::newProduct('Sony-Handy', $protaghandy, 'das ist ein Handy', 423.90);
//$updateproduct = EntityFactory::newProduct('Sony-Fernseh',$protagtv,'das ist ein Fernseh',773.00);

//$handy = Database::instance()->load(DBSchema::SCHEMA,Product::class, $product);
//$bild = EntityFactory::newPicture('assets/img/img.png',$handy);
//

$products = Database::instance()->loadList(DBSchema::SCHEMA, Product::class);
$tags = Database::instance()->loadList(DBSchema::SCHEMA, Tag::class);
$img = Database::instance()->loadList(DBSchema::SCHEMA, Picture::class);

$testupdates = Database::instance()->loadList(DBSchema::SCHEMA, Product::class, [Product::NAME => 'Sony Fernseher']);


echo '<table>';
foreach ($tags as $kategorie) {
    echo '<tr>';
    echo '<th>' . $kategorie->get(Tag::ID) . '</th>';
    echo '<td> ' . $kategorie->get(Tag::NAME) . '</td>';
    echo '</tr>';
}
echo '</table>';
foreach ($img as $value) {
//    echo '<img src="' . $value->get(Picture::PATH) . '">';
    $image = new ImageWidget($value->get(Picture::PATH));
    echo $image;
}

echo '<table>';
foreach ($products as $value) {
    echo '<tr>';
    echo '<th>' . $value->get(Product::ID) . '</th>';
    $bilder = $value->get(Picture::class);
    foreach ($bilder as $bild) {
//        echo '<td><img src="' . $bild->get(Picture::PATH) . '" width="30%;"</td>';
        $image = new ImageWidget($bild->get(Picture::PATH));
        $image->addCssClass('Sony');
        echo '<td>' . $image . '</td>';
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

$fernseherTag = Database::instance()->loadList(DBSchema::SCHEMA, Tag::class, [Tag::NAME => 'Android'])[0];

foreach ($testupdates as $fernseher) {
    $fernseher->connectTo($fernseherTag);
//   $fernseher->disconnectFrom($fernseherTag);
}
foreach ($testupdates as $testupdate) {
    $testupdate->set(Product::NAME, 'Sony Fernseher');
//    $testupdate->dump();
    Database::instance()->save(DBSchema::SCHEMA, $testupdate);
}
?>

</body>
</html>