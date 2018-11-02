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
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    if (isset($_POST['tag'])) {
        $submitedTags = $_POST['tag'];
    } else {
        $submitedTags = null;
    }

//    if (empty($name)|| $price == '') {
//        echo 'nicht richtig ausgefüllt';
//    } else {

    $errors = [];
//        $toCheck = ["name", "description", "price"];
    $toCheck = ["Produkt Name" => $name, "Produkt Preis" => $price, "Tag" => $submitedTags];
    foreach ($toCheck as $key => $check) {
        if (empty($check)) {
            $errors[] = $key . " is empty! ";
        }
    }

    if (count($errors) === 0) {
        $tags = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class, [
            Tag::NAME => $submitedTags]);
        $product = EntityFactory::newProduct($_POST["name"], $tags, $_POST["description"], (float)$_POST["price"]);
    } else {
        foreach ($errors as $error) {
            echo "<script>alert(" . $error . ");</script>";
            echo $error;
        }
    }
    /**
     * IMPORTANT TO CHANGE PERMISSIONS
     * sudo chown www-data:ww-data /var/www/html/web_shop/src/assets/img
     * sudo chmod 755 /var/www/html/web_shop/src/assets/img
     */
    $allImg = count($_FILES['image']['name']);
    for ($i = 0; $i < $allImg; $i++) {
        if (is_uploaded_file($_FILES['image']['tmp_name'][$i])) {
            $tmpFilePath = $_FILES['image']['tmp_name'][$i];
            $target_dir = "assets/img/";
            $target_file = $target_dir . basename($_FILES["image"]["name"][$i]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
//        $date = date_create();
//        $timestamp = date_timestamp_get($date);
            $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
// Check if file already exists
            if (file_exists($target_file)) {
                $picture = EntityFactory::newPicture($target_file, $product);
                $uploadOk = 0;

            }
// Check file size
            if ($_FILES["image"]["size"][$i] > 2000000) {
                echo "Sorry, your file is too large.";
                print_r($_FILES['image']['size']);
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
                echo "Sorry, your file was not uploaded. Either it already exists or somthing went wrong.";
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($tmpFilePath, $target_file)) {
                    $picture = EntityFactory::newPicture($target_file, $product);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }

}
$tags = Database::instance()->loadList(DBConfig::SCHEMA, Tag::class);
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
                    <input id="product-name" name="name" type="text" class="validate"
                           value="<?php if (isset($name)) echo $name; ?>" autofocus>
                    <label for="product-name">Produkt Name *</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-description" name="description" type="text" class="validate"
                           value="<?php if (isset($description)) echo $description; ?>">
                    <label for=" product-description">Produkt Beschreibung</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <label>Tags *</label>
                </div>
            </div>
            <?php
            foreach ($tags as $tag) {
                ?>
                <p>
                    <label>
                        <input type="checkbox" name="tag[]"
                               value="<?php echo $tag->get(Tag::NAME) ?>"
                            <?php
                            if (isset($submitedTags)) {
                                foreach ($submitedTags as $value) {
                                    if ($value == $tag->get(Tag::NAME)) {
                                        echo 'checked';
                                    }
                                }
                            }
                            ?>
                        />
                        <span><?php echo $tag->get(Tag::NAME); ?></span>
                    </label>
                </p>
                <?php
            }
            ?>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-price" name="price" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.05"
                           class="validate" value="<?php if (isset($price)) echo $price; ?>">
                    <label for=" product-price">Produkt Preis *</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="product-image" name="image[]" type="file" class="validate" multiple="multiple">
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