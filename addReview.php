<?php
require "session.php";

$database = new Database();

if (isset($_POST["review"])) {
  $sql = "INSERT INTO `reviews`(`id_sender`, `id_recipient`, `review_text`) VALUES (:sender, :recipient, :review)";
  $param = array(
    'sender' => $_SESSION["id"],
    'recipient' => $_GET["id"],
    'review' => $_POST["review"]
  );

  $database->getInsert($sql, $param);

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
          <h2>Оставьте свой отзыв о задании</h2>
          <form action="" method="POST">
            <textarea name="review" placeholder="Ваш отзыв"></textarea>
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