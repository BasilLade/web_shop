<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('Autoloader.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>webshop</title>
    <link rel="stylesheet" href="assets/css/style.css">
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <script src="lib/js/jquery/jquery-3.3.1.min.js"></script>
    <script src="action/js/AddToCart.js"></script>
</head>
<body>
<?php
echo '&#9786<br>';

//$phone = EntityFactory::newTag('Handy');
//$tv = EntityFactory::newTag('TV');
//$android = EntityFactory::newTag('Android');
//$protaghandy = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class, [
//    Tag::NAME => [
//        'Handy',
//        'Android'
//    ]
//]);
//$protagtv = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class, [Tag::NAME => 'TV']);
//$product = EntityFactory::newProduct('Sony-Handy', $protaghandy, 'das ist ein Handy', 423.90);
//$updateproduct = EntityFactory::newProduct('Sony-Fernseh',$protagtv,'das ist ein Fernseh',773.00);
//
//$handy = Database::instance()->load(DBConfig::SCHEMA,Product::class, $product);
//$bild = EntityFactory::newPicture('assets/img/img.png',$handy);


$products = Database::instance()->loadList(DBConfig::SCHEMA, Product::class);
$tags = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class);
$img = Database::instance()->loadList(DBConfig::SCHEMA, Picture::class);

$testupdates = Database::instance()->loadList(DBConfig::SCHEMA, Product::class, [Product::NAME => 'Sony Fernseher']);


echo '<table>';
foreach ($tags as $kategorie) {
    echo '<tr>';
    echo '<th>' . $kategorie->get(Tag::ID) . '</th>';
    echo '<td> ' . $kategorie->get(Tag::NAME) . '</td>';
    echo '</tr>';
}
echo '</table>';
//foreach ($img as $value) {
////    echo '<img src="' . $value->get(Picture::PATH) . '">';
//    $image = new ImageWidget($value->get(Picture::PATH));
//    echo $image;
//}
echo '<table>';
foreach ($products as $value) {
    echo '<tr>';
    echo '<th class="id">' . $value->get(Product::ID) . '</th>';
    $bilder = $value->get(Picture::class);

    echo '<td>';
    foreach ($bilder as $bild) {
//        echo '<td><img src="' . $bild->get(Picture::PATH) . '" width="30%;"</td>';
        $image = new ImageWidget($bild->get(Picture::PATH));
        $image->addCssClass('Sony');
        echo $image;
    }
    echo '</td>';
    echo '<td> ' . $value->get(Product::NAME) . '</td>';
    echo '<td> ' . $value->get(Product::DESC) . '</td>';
    echo '<td class="preis"> ' . $value->get(Product::PRICE) . ' Fr.</td>';

    $cats = $value->get(Tag::class);
    echo '<td>';
    $tagfilter = null;
    foreach ($cats as $cat) {
        $tagfilter .= $cat->get(Tag::NAME) . ', ';
    }
    $tagfilter = substr($tagfilter,0,-2);
    echo $tagfilter;
    echo '</td>';

    echo '<td>';
//    $button = new ButtonWidget('webshop');
//    $button->setLabel($value->get(Product::NAME) . ' Hinzufügen');
//    $button->addCssClass('test');
//    $button->setValue($value->get(Product::ID));
//    $button->setActionName('addToCart');
//    echo $button;
    ?>
    <button type="button" onclick='addToCart("<?php echo $value->get(Product::ID) ?>")'><?= $value->get(Product::NAME) . ' Hinzufügen' ?></button>
    <?php
    echo '</tr>';
}
echo '</table>';

$fernseherTag = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class, [Tag::NAME => 'Android'])[0];

foreach ($testupdates as $fernseher) {
    $fernseher->connectTo($fernseherTag);
//   $fernseher->disconnectFrom($fernseherTag);
}
foreach ($testupdates as $testupdate) {
    $testupdate->set(Product::NAME, 'Sony Fernseher');
    Database::instance()->save(DBConfig::SCHEMA, $testupdate);
//    $pic = EntityFactory::newPicture('assets/img/img.png',$testupdate);
}
?>

</body>
</html>