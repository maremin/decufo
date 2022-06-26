<?php
require "session.php";

$database = new Database();

// $sqlCategory = "SELECT * FROM `categories`";

// $sql = "SELECT * FROM tasks ORDER BY id_task DESC";

if (isset($_POST["upload"])) {
    $img_type = substr($_FILES['img']['type'], 0, 5);
    $size = 2 * 1024 * 1024;
    var_dump($_FILES['img']['type']);
    if (!empty($_FILES['img']['tmp_name']) and $img_type == 'image' and $_FILES['img']['type'] == "image/jpeg") {
        $img = file_get_contents($_FILES['img']['tmp_name']);
        $name = randomString();

        $sql = "INSERT INTO `imgs`(`img_name`, `img`) VALUES (:name, :img)";
        $param = array(
            "name" => $name,
            "img" => $img
        );

        $getId = $database->getInsert($sql, $param);

        $sqlAddCategory = "UPDATE `users` SET `id_img`= :img WHERE `id_user` = :id";
        $paramAddCategory = array(
            "img" => $getId,
            "id" => $_GET["id"]
        );

        $database->getInsert($sqlAddCategory, $paramAddCategory);

        header("location: http://localhost/lk.php");
    } else {
        echo "<p>Загрузите фотографию формата jpg</p>";
    }
}
?>
<?php if($_SESSION["rule"] > 10): ?>

<!DOCTYPE html>  
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Task</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="/style/add.css">
    <link rel="stylesheet" href="/style/addCategory.css">
    <?php if ($_SESSION["theme"] == "dark") : ?>
        <link rel="stylesheet" href="/style/dark.css" />
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="container">
            <a href="index.php"><img src="/img/logo.svg" alt="logo" /></a>
            <div class="user"><a href="<?php echo (checkUser()); ?>"><img src="img/lk.jpg" alt="lk" /></a></div>
        </div>
    </header>
    <main>
        <?php require("aside.php") ?>
        <section class="content">
            <div class="add">
                <div class="main-container">
                    <h2>Изменить картинку профиля</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="file" name="img" placeholder="Картинка для для категории"><input type="submit" value="Загрузить" name="upload">
                    </form>
                </div>
            </div>
            <?php require("footer.php") ?>
        </section>
    </main>
</body>

</html>
<?php else: ?>
<?php header("location: login.php"); ?>
<?php endif; ?>