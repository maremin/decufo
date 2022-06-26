<?php
require "session.php";

$database = new Database();

if (isset($_POST["comment"])) {
  $sql = "INSERT INTO `purpose_workers`(`id_worker`, `comment`, `id_task`) VALUES (:id_worker, :comment, :id_task)";
  $param = array(
    'id_worker' => $_SESSION["id"],
    'id_task' => $_GET["id"],
    'comment' => $_POST["comment"],
  );

  $task = $database->getInsert($sql, $param);

  $sqlAuthor = "SELECT `id_author` FROM `tasks` WHERE `id_task` = :id";
  $paramAuthor = array(
    "id" => $_GET["id"]
  );

  $author =  $database->selectFirstCell($sqlAuthor, $paramAuthor);

  addNotification($_SESSION["id"], $task, "Вы в листе ожидания заказчика");
  addNotification($author, $task, "Исполнитель откликнулся на ваше задание");

  header("location: http://localhost/tasks.php");
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
      <div class="comment">
        <div class="main-container">
          <h2>Напишите заказчику, что вы умеетее делать, чтобы он вас нанял.</h2>
          <form action="" method="POST">
            <textarea name="comment" placeholder="Ваш комментарий"></textarea>
            <button type="submit">Отправить</button>
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