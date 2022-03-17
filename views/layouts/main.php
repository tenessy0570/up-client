<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Pop it MVC</title>
</head>

<body>
    <header>
        <nav>
            <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
            <?php
            if (!app()->auth::check()) : ?>
                <div>
                    <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                    <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
                </div>

            <?php
            else : ?>
                <div class="logout">
                    <span>Здравствуйте, <?= app()->auth::user()->first_name ?></span>
                    <a href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
                </div>
            <?php
            endif;
            ?>
        </nav>
    </header>
    <main>
        <?= $content ?? '' ?>
    </main>

</body>

</html>