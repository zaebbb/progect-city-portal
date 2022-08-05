<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?=$get_url_page("images/logo.png")?>"/>
    <title>Главная страница</title>
    <link rel="stylesheet" href="<?=$get_url_page("styles/style.css")?>">

    <script src="<?=$get_url_page("js/index.js")?>"></script>
</head>
<body>

<header class="section__header">
    <a href="<?=$get_url_page()?>" class="section__header--logo">
        <img class="section__header--logo__image" src="<?=$get_url_page("images/logo.png")?>">
    </a>
    <nav class="section__header--nav">
        <ul class="section__header--list">
        <?php if(empty($_SESSION['user']['id'])): ?>
            <li class="section__header--item">
                <a href="<?=$get_url_page("auth/login")?>" class="section__header--link">Авторизация</a>
            </li>
            <li class="section__header--item">
                <a href="<?=$get_url_page("auth/reg")?>" class="section__header--link">Регистрация</a>
            </li>
            <?php else: ?>
            <li class="section__header--item">
                <a href="<?=$get_url_page("admin")?>" class="section__header--link">Профиль</a>
            </li>
            <li class="section__header--item">
                <a href="<?=$get_url_page("problems")?>" class="section__header--link"><?=$_SESSION['user']['role'] == "admin" ? "Заявки" : "Мои заявки"?></a>
            </li>
            <li class="section__header--item">
                <a href="<?=$get_url_page("create")?>" class="section__header--link">Создание заявки</a>
            </li>
            <li class="section__header--item">
                <a href="<?=$get_url_page("components/exit.php")?>" class="section__header--link">Выйти</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="main">