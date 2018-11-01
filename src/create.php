<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Created by PhpStorm.
 * User: cwolf
 * Date: 30.10.18
 * Time: 11:38
 */
require_once("Autoloader.php");

if (isset($_POST["submit"])) {
    $errors = [];
    $toCheck = ["name", "description", "price"];
    foreach ($toCheck as $check) {
        if (empty($_POST[$check])) {
            $errors[] = $check . "is empty";
        }
    }
    $submitedTags = [];
    foreach ($_POST as $key => $value) {
        if (!strpos($key, "tag")) {
            $tags[] = $key;
        }
    }
    if (count($errors) === 0) {
        $tags = $protaghandy = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class, [
            Tag::NAME => $submitedTags]);
        $product = EntityFactory::newProduct($_POST["name"], $tags, $_POST["description"], (int)$_POST["price"]);
    } else {
        foreach ($errors as $error) {
            echo "<script>alert(" . $error . ");</script>";
        }
    }
    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
//    $date = date_create();
//    $timestamp = date_timestamp_get($date);
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["image"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $picture = EntityFactory::newPicture($target_file, $product);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
$tags = $protaghandy = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</head>
<body>
<header>
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">Logo goes here</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Produkt hinzufügen</a></li>
                <li><a href="create-tag.php">Tag hinzufügen</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <form class="col s12" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-name" name="name" type="text" class="validate">
                    <label for="product-name">Produkt Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-description" name="description" type="text" class="validate">
                    <label for="product-description">Produkt Beschreibung</label>
                </div>
            </div>
            <?php
            foreach ($tags as $tag) {
                ?>
                <p>
                    <label>
                        <input type="checkbox" name="tag-<?php echo $tag->get(Tag::NAME); ?>"/>
                        <span><?php echo $tag->get(Tag::NAME); ?></span>
                    </label>
                </p>
                <?php
            }
            ?>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-price" name="price" type="number" class="validate">
                    <label for="product-price">Produkt Preis</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-image" name="image" type="file" class="validate">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="submit" type="submit" name="submit" class="validate">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>