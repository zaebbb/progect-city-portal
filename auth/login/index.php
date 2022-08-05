<?php 
    include_once "./../../components/config.php";
    include_once "./../../components/functions.php";
    include_once "./../../components/header.php";

    $redirect_auth();

    $validate = $validate_authorize($_POST);

    if(isset($_SESSION['error']) && empty($_SESSION['error']) && $validate == true){
        header("Location: " . $get_url_page('auth/login'));
     }
 
     $session_data = $_SESSION['error'];
     $_SESSION['error'] = [];
?>
<h2 class="section__heading">Авторизация</h2>
<form class="section__form--form" action method="POST">
        <div class="section__form-error error__email"><?=!empty($session_data['login']) ? $session_data['login'] : ""?></div>
        <input type="text" placeholder="Введите логин" class="section__form--input input__login" name="input__login" required>
        <input type="password" placeholder="Введите пароль" class="section__form--input input__pass" name="input__pass" required>
        <div class="section__form-error error__pass"></div>
        <input type="submit" value="Авторизоваться" class="section__form--input input__btn" name="input__btn">
    </form>
</section>

<script>renameTitle("Авторизация");</script>

<?php 
    include_once "./../../components/footer.php"
?>