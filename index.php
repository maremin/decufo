<?php
require "session.php";

$database = new Database();

$sql = "SELECT id_category, count(*) as topcount from purpose_categories_tasks group by id_category order by topcount DESC limit 3";
$count = $database->selectFirstColumn($sql);

$sql = "SELECT * from categories join imgs where categories.id_img = imgs.id_img and id_category = :id";
$param1 = array(
  "id" => $count[0]
);
$param2 = array(
  "id" => $count[1]
);
$param3 = array(
  "id" => $count[2]
);
// var_dump($count[0]);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Index</title>
  <link rel="stylesheet" href="style/style.css" />
  <link rel="stylesheet" href="style/main.css" />
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
    <?php include("aside.php") ?>
    <section class="content">
      <div class="jumbotron">
        <img src="/img/logoWhite.svg" alt="logoWhite" />
        <h1>Найди своего</h1>
        <div class="choices">
          <h1>Заказчика</h1>
          <h1>Исполнителя</h1>
        </div>
      </div>
      <div class="statistics">
        <div class="main-container">
          <h2>К нам приходят новые специалисты</h2>
          <div class="columns">
            <div class="column">
              <img src="/img/column2018.svg" alt="column2018" />
              <div class="column-text">
                <p>2018</p>
                <p>20 000 человек</p>
              </div>
            </div>
            <div class="column">
              <img src="/img/column2019.svg" alt="column2019" />
              <div class="column-text">
                <p>2019</p>
                <p>30 000 человек</p>
              </div>
            </div>
            <div class="column">
              <img src="/img/column2020.svg" alt="column2020" />
              <div class="column-text">
                <p>2020</p>
                <p>40 000 человек</p>
              </div>
            </div>
            <div class="column">
              <img src="/img/column2021.svg" alt="column2021" />
              <div class="column-text">
                <p>2021</p>
                <p>50 000 человек</p>
              </div>
            </div>
            <div class="column">
              <img src="/img/column2022.svg" alt="column2022" />
              <div class="column-text">
                <p>2022</p>
                <p>90 000 человек</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="popular">
        <div class="main-container">
          <h2>Популярные категории</h2>
          <div class="cards">
            <?php foreach ($database->selectAll($sql, $param1) as $item) : ?>
              <div class="card">
                <img src="data:image/jpg;base64,<?= base64_encode($item['img']) ?>" alt="">
                <p><?= $item["category_name"] ?></p>
              </div>
            <?php endforeach; ?>
            <?php foreach ($database->selectAll($sql, $param2) as $item) : ?>
              <div class="card">
                <img src="data:image/jpg;base64,<?= base64_encode($item['img']) ?>" alt="">
                <p><?= $item["category_name"] ?></p>
              </div>
            <?php endforeach; ?>
            <?php foreach ($database->selectAll($sql, $param3) as $item) : ?>
              <div class="card">
                <img src="data:image/jpg;base64,<?= base64_encode($item['img']) ?>" alt="">
                <p><?= $item["category_name"] ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="cta">
        <h2>Войти, чтобы</h2>
        <div class="buttons">
          <h2><a href="<?php echo (checkReg()) ?>">Подобрать задание</h2></a>
          <h2><a href="<?php echo (checkReg()) ?>">Добавить задание</h2></a>
        </div>
      </div>
      <?php include("footer.php") ?>
    </section>
  </main>
</body>

</html>