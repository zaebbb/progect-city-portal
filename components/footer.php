</main>

<footer class="section__footer">
    <ul class="section__footer--list">
    <?php if(empty($_SESSION['user']['id'])): ?>
        <li class="section__footer--item">
            <a href="<?=$get_url_page("auth/login")?>" class="section__footer--link">Авторизация</a>
        </li>
        <li class="section__footer--item">
            <a href="<?=$get_url_page("auth/reg")?>" class="section__footer--link">Регистрация</a>
        </li>
    <?php else: ?>
        
        <li class="section__footer--item">
            <a href="<?=$get_url_page("admin")?>" class="section__footer--link">Профиль</a>
        </li>
        <li class="section__footer--item">
            <a href="<?=$get_url_page("problems")?>" class="section__footer--link">Мои заявки</a>
        </li>
        <li class="section__footer--item">
            <a href="<?=$get_url_page("create")?>" class="section__footer--link">Создание заявки</a>
        </li>
        <li class="section__footer--item">
            <a href="<?=$get_url_page("components/exit.php")?>" class="section__footer--link">Выйти</a>
        </li>
    <?php endif; ?>
    </ul>
</footer>

</body>
</html>