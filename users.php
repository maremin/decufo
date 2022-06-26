<?php
require "session.php";

$database = new Database();

$sqlAside = 'SELECT * from categories';

if ($_GET["id"] != FALSE) {
  $sql = "SELECT * FROM `purpose_categories_users` join users where purpose_categories_users.id_user = users.id_user AND `id_category` = :id AND `id_user_role` = :role";
  $param = array(
    "id" => $_GET["id"],
    "role" => 2
  );
} else {
  $sql = 'SELECT * FROM users where `id_user_role` = :role';
  $param = array(
    "role" => 2
  );   
}


$database->selectAll($sql, $param);
// var_dump($_SESSION["rule"]);
?>
<?php if($_SESSION["rule"] > 10): ?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Users</title>
  <link rel="stylesheet" href="/style/style.css" />
  <link rel="stylesheet" href="/style/tasks.css" />
  <link rel="stylesheet" href="/style/task.css" />
  <link rel="stylesheet" href="/style/users.css" />
  <?php if ($_SESSION["theme"] == "dark") : ?>
    <link rel="stylesheet" href="/style/dark.css" />
  <?php endif; ?>
</head>

<body>
  <header>
    <div class="container">
      <a href="index.html"><img src="/img/logo.svg" alt="logo" /></a>
      <div class="user"><a href="<?php echo (checkUser()); ?>"><img src="img/lk.jpg" alt="lk" /></a></div>
    </div>
  </header>
  <main>
    <aside>
      <ul>
        <?php foreach ($database->selectAll($sqlAside) as $item) : ?>
          <li><a href="users.php?id=<?= $item["id_category"] ?>"><?= $item["category_name"] ?></a></li>
        <?php endforeach; ?>
      </ul>
    </aside>
    <section class="content">
      <nav>
        <div class="main-container">
          <a href="tasks.php">
            <h2>Задания</h2>
          </a>
          <h2>Исполнители</h2>
        </div>
      </nav>
      <div class="cards">
        <?php foreach ($database->selectAll($sql, $param) as $item) : ?>
          <div class="card">
            <div class="main-container">
              <div class="card-container">
                <div class="data">
                  <p><?= $item["surname"] ?></p>
                  <p><?= $item["user_name"] ?></p>
                </div>
                <div class="info">
                  <div class="details">
                    <p>Отзывов:</p>
                    <p><?= countReview($item["id_user"]) ?></p>
                  </div>
                  <div class="details">
                    <p>Заданий:</p>
                    <p><?= countTasks($item["id_user"]) ?></p>
                  </div>
                  <div class="details">
                    <p>Категории:</p>
                    <p>Красота</p>
                  </div>
                </div>
              </div>
              <a href="lk.php?id=<?= $item["id_user"] ?>"><button>Подробнее</button></a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php include("footer.php") ?>
    </section>
  </main>
</body>

</html>
<?php else: ?>
<?php header("location: login.php"); ?>
<?php endif; ?>