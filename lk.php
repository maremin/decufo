<?php
require "session.php";

$database = new Database();


if ($_GET["id"] != false) {
  $id = $_GET['id'];
} else {
  $id = $_SESSION['id'];
  // var_dump($_SESSION['id']);
}

$sql = 'SELECT * FROM users join imgs WHERE  users.id_img = imgs.id_img and id_user = :id';
$param = array(
  'id' => $id
);

// var_dump($database->selectAll($sql, $param));

$sqlFeedback = 'SELECT * FROM reviews join users  WHERE  reviews.id_sender = users.id_user and id_recipient = :id';

$sqlHistory = "SELECT * FROM `tasks` WHERE `id_author` = :id or `id_worker` = :id order by `state` DESC";

$sqlNotifications = "SELECT * FROM `notifications` where `id_user` = :id ORDER BY notification_date DESC";

$sqlCertificate = "SELECT * FROM `certificates` join imgs WHERE certificates.id_img = imgs.id_img and id_user = :id";

if (isset($_POST["upload"])) {
  $img_type = substr($_FILES['img']['type'], 0, 5);
  $size = 2 * 1024 * 1024;
  if (!empty($_FILES['img']['tmp_name']) and $img_type == 'image' and $_FILES['img']['type'] == "image/jpeg") {
    $img = file_get_contents($_FILES['img']['tmp_name']);
    $name = randomString();

    $sqlImg = "INSERT INTO `imgs`(`img_name`, `img`) VALUES (:name, :img)";
    $paramImg = array(
      "name" => $name,
      "img" => $img
    );

    $getId = $database->getInsert($sqlImg, $paramImg);

    $sqlAddCertificate = "INSERT INTO `certificates`(`id_img`, `id_user`) VALUES (:img, :id)";
    $paramAddCertificate = array(
      "id" => $id,
      "img" => $getId
    );

    $database->getInsert($sqlAddCertificate, $paramAddCertificate);
  } else {
    echo "<p>Загрузите фотографию формата jpg</p>";
  }
}
// var_dump($_SESSION["user_role"]);
?>
<?php if($_SESSION["rule"] > 10): ?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LK</title>
  <link rel="stylesheet" href="/style/style.css" />
  <link rel="stylesheet" href="/style/tasks.css" />
  <link rel="stylesheet" href="/style/lk.css" />
  <link rel="stylesheet" href="/style/addCategory.css" />
  <?php if ($_SESSION["theme"] == "dark") : ?>
    <link rel="stylesheet" href="/style/dark.css" />
  <?php endif; ?>
</head>

<body>
  <header>
    <div class="container">
      <a href="index.php"><img src="/img/logo.svg" alt="logo" /></a>
      <?php if ($_GET["id"] != false) : ?>
        <div class="user"><a href="lk.php"><img src="/img/lk.jpg" alt="personal cabinet" /></a></div>
      <?php else : ?>
        <a href="change.php"><button>Переключить тему</button></a>
        <div class="user"><a href="sessionEnd.php"><img src="/img/lk.jpg" alt="personal cabinet" /></a></div>
      <?php endif; ?>
    </div>
  </header>
  <main>
    <?php include("aside.php") ?>
    <section class="content">
      <div class="main-container">
        <div class="information-container">
          <div class="information">
            <?php foreach ($database->selectAll($sql, $param) as $item) : ?>
              <div class="profile">
                <a href="updateImg.php?id=<?php echo $id ?>"><img src="data:image/jpg;base64,<?= base64_encode($item['img']) ?>" alt="lk" /></a>
                <p><?= $item["surname"] ?></p>
                <p><?= $item["user_name"] ?></p>
                <p><?= $item["last_name"] ?></p>
              </div>
              <div class="contacts">
                <p><?= $item["phone"] ?></p>
                <p><?= $item["site"] ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <!-- добавить проверку на пользователя страницы -->
          <?php if ($_SESSION['user_role'] == 1 and $_SESSION["id"] == $id) : ?>
            <a href="add.php"><button>Добавить задание</button></a>
          <?php endif; ?>
        </div>
      </div>
      <div class="menu">
        <div class="main-container">
          <ul>
            <li><button id="feedbacks">
                <h2>Отзывы</h2>
              </button></li>
            <li><button id="history">
                <h2>История заданий</h2>
              </button></li>
            <li><button id="certificate">
                <h2>Сертификаты</h2>
              </button></li>
            <li><button id="notifications">
                <h2>Уведомления</h2>
              </button></li>
          </ul>
        </div>
      </div>
      <div class="feedbacks">
        <div class="main-container">
          <?php foreach ($database->selectAll($sqlFeedback, $param) as $item) : ?>
            <div class="feedback">
              <div class="user">
                <img src="/img/lk.svg" alt="lk" />
                <p><?= $item["surname"] ?></p>
                <p><?= $item["user_name"] ?></p>
                <p><?= $item["last_name"] ?></p>
              </div>
              <p>
                <?= $item["review_text"] ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="history">
        <?php foreach ($database->selectAll($sqlHistory, $param) as $item) : ?>
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
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="certificate">
        <?php if ($_SESSION["user_role"] == 1) : ?>
          <div class="main-container">
            <div class="main-container">
              <p>У заказчиков нет сертификатов</p>
            </div>
          </div>
          <?php else : ?>`
          <div class="add">
            <div class="main-container">
              <?php if ($_GET["id"] == false) : ?>
                <h2>Добавить сертификат</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                  <input type="file" name="img" placeholder="Картинка для для категории"><input type="submit" value="Загрузить" name="upload">
                </form>
              <?php endif; ?>
              <div class="certificates">
                <?php foreach ($database->selectAll($sqlCertificate, $param) as $item) : ?>
                  <div class="card">
                    <img src="data:image/jpg;base64,<?= base64_encode($item['img']) ?>" alt="">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="notifications">
        <?php if ($_GET["id"] == false) : ?>
          <div class="main-container">
            <?php foreach ($database->selectAll($sqlNotifications, $param) as $item) : ?>
              <div class="note">
                <p><?= $item["notification_type"] ?></p>
                <a href="task.php?id=<?= $item["id_task"] ?>"><button>Посмотреть задание</button></a>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p>Вы не можете смотреть чужие уведомления</p>
          <?php endif; ?>
          </div>
      </div>
      <?php include("footer.php") ?>
    </section>
  </main>
  <script src="/style/script.js"></script>
</body>

</html>
<?php else: ?>
<?php header("location: login.php"); ?>
<?php endif; ?>