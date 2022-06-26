<?php
require "session.php";

$database = new Database();

$sql = "SELECT * FROM `tasks` join users WHERE tasks.id_author = users.id_user and `id_task` = :id";
$param = array(
    "id" => $_GET["id"]
);

$sqlWorker = "SELECT * FROM `tasks` join users WHERE tasks.id_worker = users.id_user and `id_task` = :id";
$paramWorker = array(
    "id" => $_GET["id"]
);


$sqlAnswer = "SELECT * FROM `purpose_workers` join users WHERE purpose_workers.id_worker = users.id_user and `id_task` =  :id";
$paramAnswer = array(
    "id" => $_GET["id"]
);

$sqlGetId = "SELECT id_author FROM `tasks` WHERE `id_task` = :id";
$paramGetId = array(
    "id" => $_GET["id"]
);

$getId = $database->selectFirstCell($sqlGetId, $paramGetId);

$sqlImg = 'SELECT * FROM users join imgs WHERE  users.id_img = imgs.id_img and id_user = :id';
$paramImg = array(
    'id' => $getId
);
// var_dump($database->selectAll($sql, $param));
?>
<?php if ($_SESSION["rule"] > 10) : ?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Task</title>
        <link rel="stylesheet" href="style/style.css" />
        <link rel="stylesheet" href="style/tasks.css" />
        <link rel="stylesheet" href="/style/users.css" />
        <link rel="stylesheet" href="style/task.css" />
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
                <div class="task">
                    <?php foreach ($database->selectAll($sql, $param) as $item) : ?>
                        <div class="task-container">
                            <div class="main-container">
                                <h2><?= $item["task_name"] ?></h2>
                                <p><?= $item["task_definition"] ?></p>
                                <div class="details">
                                    <ul>
                                        <li><?= $item["time_start_finish"] ?></li>
                                        <li><?= $item["place"] ?></li>
                                        <li><?= $item["cost"] ?></li>
                                    </ul>
                                </div>
                                <div class="info">
                                    <a href="lk.php?id=<?= $item["id_user"] ?>">
                                        <div class="user">
                                            <?php foreach ($database->selectAll($sqlImg, $paramImg) as $itemImg) : ?>
                                                <img src="data:image/jpg;base64,<?= base64_encode($itemImg['img']) ?>" alt="lk" />
                                            <?php endforeach; ?>
                                            <p><?= $item["surname"] ?></p>
                                            <p><?= $item["user_name"] ?></p>
                                            <p><?= $item["last_name"] ?></p>
                                        </div>
                                    </a>
                                    <p><?= $item["date_public_task"] ?></p>
                                </div>
                                <?php if ($_SESSION["user_role"] == 2 and $item["state"] == "public") : ?>
                                    <a href="addComment.php?id=<?= $item["id_task"] ?>"><button>Откликнуться</button></a>
                                <?php endif; ?>
                                <?php if ($_SESSION["id"] == $item["id_worker"] and $item["state"] == "finished") : ?>
                                    <a href="addReview.php?id=<?= $item["id_author"] ?>"><button>Оставить отзыв</button></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($item["id_author"] == $_SESSION["id"]) : ?>
                            <div class="answers">
                                <div class="main-container">
                                    <?php if ($item["state"] == "finished") : ?>
                                        <a href="addReview.php?id=<?= $item["id_worker"] ?>"><button>Оставить отзыв</button></a>
                                    <?php else : ?>
                                        <?php if ($item["state"] == "private") : ?>
                                            <h2>Ваш исполнитель</h2>
                                            <?php foreach ($database->selectAll($sqlWorker, $paramWorker) as $item) : ?>
                                                <div class="card-container">
                                                    <div class="data">
                                                        <p><?= $item["surname"] ?></p>
                                                        <p><?= $item["user_name"] ?></p>
                                                        <p><?= $item["last_name"] ?></p>
                                                    </div>
                                                    <div class="info">
                                                        <div class="details">
                                                            <p>Отзывов:</p>
                                                            <p><?= countReview($item["id_worker"]) ?></p>
                                                        </div>
                                                        <div class="details">
                                                            <p>Заданий:</p>
                                                            <p><?= countTasks($item["id_worker"]) ?></p>
                                                        </div>
                                                        <div class="details">
                                                            <p>Категории:</p>
                                                            <p>Красота</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="lk.php?id=<?= $item["id_worker"] ?>"><button>Подробнее</button></a>
                                                <a href="endTask.php?id=<?= $item["id_task"] ?>"><button>Завершить задание</button></a>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <h2>Откликнувшиеся</h2>
                                            <div class="card">
                                                <?php foreach ($database->selectAll($sqlAnswer, $paramAnswer) as $item) : ?>
                                                    <div class="card-container">
                                                        <div class="data">
                                                            <p><?= $item["user_name"] ?></p>
                                                            <p><?= $item["comment"] ?></p>
                                                        </div>
                                                        <div class="info">
                                                            <div class="details">
                                                                <p>Отзывов:</p>
                                                                <p><?= countReview($item["id_worker"]) ?></p>
                                                            </div>
                                                            <div class="details">
                                                                <p>Заданий:</p>
                                                                <p><?= countTasks($item["id_worker"]) ?></p>
                                                            </div>
                                                            <div class="details">
                                                                <p>Категории:</p>
                                                                <p>Красота</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="addWorker.php?id=<?= $item["id_worker"] ?>"><button>Нанять</button></a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php include("footer.php") ?>
            </section>
        </main>
    </body>

    </html>
<?php else : ?>
    <?php header("location: login.php"); ?>
<?php endif; ?>