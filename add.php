<?php
require "session.php";

//объявление экземпляра класса
$database = new Database();

//запрос для вывода в выпадающий список категорий
$sqlCategory = "SELECT * FROM `categories`";

// проверка на заполнение полей ввода, запрос на добавление задания и параметры к нему
if (isset($_POST["name"]) && isset($_POST["definition"]) && isset($_POST["cost"]) && isset($_POST["place"]) && isset($_POST["time_start"])) {
  $sqlTask = "INSERT INTO `tasks`(`task_name`, `task_definition`, `cost`, `place`, `time_start_finish`, `id_author`) VALUES (:name, :definition, :cost, :place, :time_start, :id_user)";

  $paramTask = array(
    "name" => $_POST["name"],
    "definition" => $_POST["definition"],
    "cost" => $_POST["cost"],
    "place" => $_POST["place"],
    "time_start" => $_POST["time_start"],
    "id_user" => $_SESSION["id"]
  );

  $getId = $database->getInsert($sqlTask, $paramTask);

  // запрос на добавление категории в таблицу назначения категорий заданий и параметры к нему(два добавления) 

  $sqlAddCategory = "INSERT INTO `purpose_categories_tasks`(`id_category`, `id_task`) VALUES (:category, :task)";
  $paramAddCategory = array(
    "category" => $_POST["category"],
    "task" => $getId
  );
  $paramAddCategoryAnother = array(
    "category" => $_POST["category_another"],
    "task" => $getId
  );

  $database->getInsert($sqlAddCategory, $paramAddCategory);
  $database->getInsert($sqlAddCategory, $paramAddCategoryAnother);

  // уведомление для заказчика и переадресовка

  addNotification($_SESSION["id"], $getId, "Вы опубликовали задание");
  header("location: http://localhost/");
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
  <!-- проверка на темную тему  -->
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
          <h2>Найдите своего исполнителя, создав задание</h2>
          <form action="" method="POST">
            <div class="inputs">
              <input type="text" name="name" placeholder="Ваше задание" required />
              <input type="text" name="definition" placeholder="Описание поподробнее" required />
              <input type="text" name="cost" placeholder="Установите цену" required />
              <input type="text" name="place" placeholder="Город, в котором будет задание" required />
              <input type="text" name="time_start" placeholder="Примерные сроки" required />
              <select name="category" id="" required>
                <!-- вывод категорий в выпадающем списке -->
                <?php foreach ($database->selectAll($sqlCategory) as $item) : ?>
                  <option value="<?= $item["id_category"] ?>"><?= $item["category_name"] ?>*</option>
                <?php endforeach; ?>
              </select>
              <select name="category_another" id="">
                <?php foreach ($database->selectAll($sqlCategory) as $item) : ?>
                  <option value="<?= $item["id_category"] ?>"><?= $item["category_name"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit">Добавить задание</button>
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