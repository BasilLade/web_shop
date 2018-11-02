<?php
/**
 * @Author g.muheim
 * @Author r.frei
 * @Author c.wolf
 */
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
<?php
$tags = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class);
$products = Database::instance()->loadList(DBConfig::SCHEMA, Product::class);
$img = Database::instance()->loadList(DBConfig::SCHEMA, Picture::class);
?>
<header>
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">Logo goes here</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#">Home</a></li>
                <li><a href="create.php">Produkt hinzufügen</a></li>
                <li><a href="create-tag.php">Tag hinzufügen</a></li>
            </ul>
        </div>
        <div class="nav-content">
            <ul class="tabs" style="background-color: #ee6e73; color:#fff;">
                <li class="tab"><a href="#">alle</a></li>
                <?php
                foreach ($tags as $tag) {
                    echo '<li class="tab"><a href="#">' . $tag->get(TAG::NAME) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <?php
    echo '&#9786<br>';

    ?>
    <table>
        <thead>
        <tr class="caption-of-table">
            <th>ID</th>
            <th>Produkt Bild</th>
            <th>Produkt Name</th>
            <th>Produkt Beschreibung</th>
            <th>Produkt Preis</th>
            <th>Produkt Kategorien</th>
            <th>Produkt kaufen</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($products as $value) {
            $cats = $value->get(Tag::class);
            $tagfilter = null;
            foreach ($cats as $cat) {
                $tagfilter .= $cat->get(Tag::NAME) . ', ';
            }
            $tagclasses = str_replace(',', '', $tagfilter);
            echo '<tr class="' . $tagclasses . ' alle">';
            echo '<td>' . $value->get(Product::ID) . '</td>';

            echo '<td>';
            $bilder = $value->get(Picture::class);
            foreach ($bilder as $bild) {
                $image = new ImageWidget($bild->get(Picture::PATH));
                $image->addCssClass('ProductPic');
                echo $image;
            }
            echo '</td>';
            echo '<td> ' . $value->get(Product::NAME) . '</td>';
            echo '<td> ' . $value->get(Product::DESC) . '</td>';
            echo '<td class="preis"> ' . $value->get(Product::PRICE) . ' Fr.</td>';

            echo '<td>';
            $tagfilter = substr($tagfilter, 0, -2);
            echo $tagfilter;
            echo '</td>';
            echo '<td>';
            ?>
            <button type="button" class="waves-effect waves-light btn"
                    onclick="addToCart('<?php echo $value->get(Product::ID) ?>')"><?= $value->get(Product::NAME) . ' Hinzufügen' ?></button>
            <?php
            echo '</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>