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
    $toCheck = ["name"];
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
        $tag = EntityFactory::newTag($_POST["name"]);
        $success = '<div><p><font color="green">Tag wurde Hinzugefügt!</font></p>';
    } else {
        foreach ($errors as $error) {
            echo "<script>alert(" . $error . ");</script>";
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
                <li><a href="create.php">Produkt hinzufügen</a></li>
                <li><a href="#">Tag hinzufügen</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <form class="col s12" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="input-field col s12">
                    <input id="tag-name" name="name" type="text" class="validate" autofocus>
                    <label for="tag-name">Tag Name</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <?php
                    if(isset($success)) echo $success; ?>
                    <input id="submit" type="submit" name="submit" class="validate">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>