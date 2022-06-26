<?php
require "session.php";

$database = new Database();

$sql = "SELECT * FROM `purpose_categories_tasks` join tasks where purpose_categories_tasks.id_task = tasks.id_task AND `id_category` = :id";
$param = array(
  "id" => $_GET["id"]
);
$cost = 0;
foreach ($database->selectAll($sql, $param) as $item) {
  $cost = $cost + $item["cost"];
};
?>
<?php if($_SESSION["rule"] > 10): ?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Report</title>
  <link rel="stylesheet" href="style/style.css" />
  <link rel="stylesheet" href="style/report.css" />
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
      <div class="info">
        <div class="main-container">
          <h2>Финансовый отчет по категории</h2>
          <section>
            <p>Общая сумма по данной категории</p>
            <p><?php echo $cost ?></p>
          </section>
          <section>
            <p>Количество заданий по этой категории</p>
            <p><?php echo $database->countRow($sql, $param) ?></p>
          </section>
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