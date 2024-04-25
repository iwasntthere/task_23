<?php
    session_start();
    $user_id = $_SESSION["user_id"] ?? false;
    if ($user_id) {
        require "vendor/autoload.php";
        $db = new \Photos\DB();
        $data = $db->get_user_photos($user_id);
    }
    if (isset($_GET["error"])) {
        $error = "Неверный логин или пароль";
    }
    if (isset($_GET["sign_error"])) {
        $sign_error = "Такой логин занят";
    }
    if (isset($_GET["sign_success"])) {
        $sign_success = "Регистрация успешна";
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task 21</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include "header.php" ?>

    <?php if ($user_id): ?>
        <h1>Галерея пользователя</h1>
        <div id="grid">
            <?php foreach ($data as $photo): ?>
                <?= (new Photos\Photo($photo["id"], $photo["image"], $photo["text"]))->get_html() ?>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <div class="form">
            <form action="login.php" method="post">
                <h1>Авторизация</h1>
                <input type="text" placeholder="Логин" name="login">
                <input type="text" placeholder="Пароль" name="password">
                <button>Вход</button>
                <?php if (isset($_GET["error"])): ?>
                    <p class="error"><?= $error?></p>
                <?php endif ?>
            </form>
            <form action="signup.php" method="post">
                <h1>Регистрация</h1>
                <input type="text" placeholder="Логин" name="login">
                <input type="text" placeholder="Пароль" name="password">
                <button>Зарегистрироваться</button>
                <?php if (isset($_GET["sign_error"])): ?>
                    <p class="error"><?= $sign_error?></p>
                <?php endif ?>
                <?php if (isset($_GET["sign_success"])): ?>
                    <p class="success"><?= $sign_success?></p>
                <?php endif ?>
            </form>
        </div>
    <?php endif; ?>

    <?php include "add_form.php"; ?>

    <div id="popup_photo">
        <img src="" alt="">
    </div>

    <script src="script.js"></script>
</body>
</html>
