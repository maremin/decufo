<?php
require "session.php";

$database = new Database();

if ($_GET["id"] != FALSE) {
  if (isset($_POST["team"])) {
    $sql = "SELECT * FROM `tasks`  join purpose_categories_tasks where purpose_categories_tasks.id_task = tasks.id_task and  `id_category` = :id and `team` = :team and `state` = :state";
    $param = array(
      "id" => $_GET["id"],
      "state" => "public",
      "team" => "yes"
    );
    // var_dump($database->selectAll($sql, $param));
    $category = $database->selectAll($sql, $param);
  }
  else {
    $sql = "SELECT * FROM `purpose_categories_tasks` join tasks where purpose_categories_tasks.id_task = tasks.id_task AND `id_category` = :id AND `state` = :state";
    $param = array(
      "id" => $_GET["id"],
      "state" => "public"
    );
    $category = $database->selectAll($sql, $param);
  }
} else {
  if (isset($_POST["team"])) {
    $sql = "SELECT * FROM `tasks` WHERE `team` = :team and `state` = :state order by id_task DESC";
    $param = array(
      "team" => "yes",
      "state" => "public"
    );
    $category = $database->selectAll($sql, $param);
    } else {
      $sql = 'SELECT * FROM tasks where `state` = :state order by id_task DESC';
      $param = array(
        "state" => "public"
      );
      $category = $database->selectAll($sql, $param);
    }
}
?>
<?php if ($_SESSION["rule"] > 10) : ?>

  <!DOCTYPE html>
  <html lang="ru">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tasks</title>
    <link rel="stylesheet" href="/style/style.css" />
    <link rel="stylesheet" href="/style/tasks.css" />
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
      <?php require('aside.php') ?>
      <section class="content">
        <nav>
          <div class="main-container">
            <h2>Задания</h2>
            <a href="users.php">
              <h2>Исполнители</h2>
            </a>
          </div>
        </nav>
        <div class="filters">
          <div class="main-container">
            <div class="team">
              <form action="" method="POST">
                <div class="team-content">
                  <input type="checkbox" name="team" id="team" />
                  <p>Команда</p>
                  <button type="submit">Применить</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="tasks">
          <?php foreach ($category as $item) : ?>
            <a href="task.php?id=<?= $item["id_task"] ?>">
              <div class="task">
                <div class="main-container">
                  <h2><?= $item["task_name"] ?></h2>
                  <p><?= $item["task_definition"] ?></p>
                  <div class="details">
                    <div class="cost">
                      <img src="/img/cost.svg" alt="cost" />
                      <p><?= $item["cost"] ?></p>
                    </div>
                    <div class="location">
                      <img src="/img/location.svg" alt="location" />
                      <p><?= $item["place"] ?></p>
                    </div>
                  </div>
                  <?php if ($_SESSION["user_role"] == 2) : ?>
                    <a href="addComment.php?id=<?= $item["id_task"] ?>"><button>Откликнуться</button></a>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
        <?php require('footer.php') ?>
      </section>
    </main>
    <script src="https://unpkg.com/imask"></script>
  </body>

  </html>
<?php else : ?>
  <?php header("location: login.php"); ?>
<?php endif; ?>