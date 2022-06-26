<?php
require "session.php";

$database = new Database();

$sqlRole = "SELECT * FROM `user_roles`";
$sqlCategory = "SELECT * FROM `categories`";

if (isset($_POST["e_mail"]) && isset($_POST["pwd"]) && isset($_POST["surname"]) && isset($_POST["name"]) && isset($_POST["last_name"]) && isset($_POST["birthday"]) && isset($_POST["phone"])) {
    $sql = "INSERT INTO `users`(`surname`, `user_name`, `last_name`, `birthday_date`, `phone`, `e_mail`, `site`, `pwd`, `id_user_role`, id_group) VALUES (:surname, :name, :last_name, :birthday, :phone, :e_mail, :site, :pwd, :role, :group)";

    $param = array(
        "role" => $_POST["role"],
        "surname" => $_POST["surname"],
        "name" => $_POST["name"],
        "last_name" => $_POST["last_name"],
        "birthday" => $_POST["birthday"],
        "phone" => $_POST["phone"],
        "e_mail" => $_POST["e_mail"],
        "site" => $_POST["site"],
        "pwd" => password_hash($_POST["pwd"], PASSWORD_DEFAULT),
        "group" => 2
    );

    $getId = $database->getInsert($sql, $param);

    $sqlAddCategory = "INSERT INTO `purpose_categories_users`(`id_category`, `id_user`) VALUES (:category, :user)";
    $paramAddCategory = array(
        "category" => $_POST["category"],
        "user" => $getId
    );

    $database->getInsert($sqlAddCategory, $paramAddCategory);

    header("location: http://localhost/login.php");
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/auth.css">
    <?php if ($_SESSION["theme"] == "dark") : ?>
        <link rel="stylesheet" href="/style/dark.css" />
    <?php endif; ?>
    <title>reg</title>
</head>

<body>
    <main>
        <div class="auth-container">
            <h2>Регистрация</h2>
            <form action="" method="post">
                <select name="role" id="" required>
                    <?php foreach ($database->selectAll($sqlRole) as $item) : ?>
                        <option value="<?= $item["id_user_role"] ?>"><?= $item["role_name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="surname" placeholder="Фамилия">
                <input type="text" name="name" placeholder="Имя">
                <input type="text" name="last_name" placeholder="Отчество">
                <input type="text" name="birthday" placeholder="Дата рождения">
                <input type="text" name="phone" placeholder="Телефон">
                <input type="text" name="site" placeholder="Ваш сайт">
                <select name="role" id="" required>
                    <?php foreach ($database->selectAll($sqlCategory) as $item) : ?>
                        <option value="<?= $item["id_category"] ?>"><?= $item["category_name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="e_mail" placeholder="Ваша электронная почта">
                <input type="password" name="pwd" placeholder="Пароль">
                <button>Зарегистрироваться</button>
            </form>
        </div>
    </main>
</body>

</html>