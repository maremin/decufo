<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/style/style.css">
  <link rel="stylesheet" href="/style/auth.css">
  <?php if ($_SESSION["theme"] == "dark") : ?>
    <link rel="stylesheet" href="/style/dark.css" />
  <?php endif; ?>
  <title>Auth</title>
</head>

<body>
  <main>
    <div class="auth-container">
      <h2>Аутентификация</h2>
      <form action="" method="POST">
        <input name="name" placeholder="E-mail*" type="text" require />
        <input name="pwd" placeholder="Пароль" type="password" />
        <p><a href="reg.php">Регистрация</a></p>
        <button type="submit">Войти</button>
      </form>
    </div>
  </main>
</body>

</html>