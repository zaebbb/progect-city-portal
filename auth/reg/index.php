<?php 
    include_once "./../../components/config.php";
    include_once "./../../components/functions.php";
    include_once "./../../components/header.php";

    $redirect_auth();

    $validate = $validate_register($_POST);
    if(isset($_SESSION['error']) && empty($_SESSION['error']) && $validate == true){
       header("Location: " . $get_url_page('auth/login'));
    }

    $session_data = $_SESSION['error'];
    $_SESSION['error'] = [];
?>

<section class="section__form">
    <h2 class="section__heading">Регистрация</h2>
    <form class="section__form--form" action method="POST">
        <input type="text" placeholder="Ваше ФИО" class="section__form--input input__name" name="input__name" required>
        <div class="section__form-error error__name"></div>
        <input type="text" placeholder="Введите логин" class="section__form--input input__login" name="input__login" required>
        <div class="section__form-error error__login"><?= !empty($session_data['unique']) ? $session_data['unique'] : ""  ?></div>
        <input type="email" placeholder="Ваша почта" class="section__form--input input__email" name="input__email" required>
        <div class="section__form-error error__email"></div>
        <input type="password" placeholder="Введите пароль" class="section__form--input input__pass" name="input__pass" required>
        <div class="section__form-error error__pass"></div>
        <input type="password" placeholder="Повторите пароль" class="section__form--input input__pass--check" name="input__pass--check" required>
        <div class="section__form-error error__pass--check"></div>
        <label for="checkbox" class="section__form--checkbox__label">
            <input type="checkbox" class="section__form--input input__checkbox" id="checkbox" name="checkbox" required>
            <span>Согласие на обработку персональных данных</span>
        </label>
        <div class="section__form-error error__checkbox"></div>
        <input type="submit" value="Зарегистрироваться" class="section__form--input input__btn" name="input__btn">
    </form>
</section>

<script>renameTitle("Регистрация");</script>

<?php 
    include_once "./../../components/footer.php"
?>