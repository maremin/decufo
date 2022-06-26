<?php
require "session.php";

$database = new Database();

$sql = "SELECT * FROM `feedbacks` WHERE `feedback_type` = :type ORDER BY id_feedback desc";
$paramPhone = array(
    "type" => "phone"
);
$paramMail = array(
    "type" => "email"
);


?>
<?php if($_SESSION["rule"] > 99): ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/admin.css" />
    <?php if ($_SESSION["theme"] == "dark") : ?>
        <link rel="stylesheet" href="/style/dark.css" />
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="container">
            <a href="index.php"><img src="/img/logo.svg" alt="logo" /></a>
            <div class="user"><a href="sessionEnd.php"><img src="/img/lk.jpg" alt="personal cabinet" /></a></div>
        </div>
    </header>
    <main>
        <?php require("aside.php") ?>
        <section class="content">
            <div class="main-container">
                <a href="addCategory.php"><button>Добавить категорию</button></a>
                <div class="feedback">
                    <div class="phone">
                        <h2>Заказ звонков</h2>
                        <?php foreach ($database->selectAll($sql, $paramPhone) as $item) : ?>
                            <p><?= $item["info"] ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="e-mail">
                        <h2>Почты на рассылку</h2>
                        <?php foreach ($database->selectAll($sql, $paramMail) as $item) : ?>
                            <p><?= $item["info"] ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php require("footer.php") ?>
        </section>
    </main>
</body>

</html>
<?php else: ?>
<?php header("location: index.php"); ?>
<?php endif; ?>