<?php 
    include_once "./../components/config.php";
    include_once "./../components/functions.php";
    include_once "./../components/header.php";

    $redirect_unauth();
?>
     <h2 class="section__heading title__profile">Добро пожаловать, <?=$_SESSION['user']['username']?></h2>
<?php 
    if($_SESSION['user']['role'] == "admin"): 
        $all_categories = $get_categories();
        $create_category = $validate_categories($_POST);

        if(isset($_SESSION['error']) && empty($_SESSION['error']) && $create_category == true){
            header("Location: " . $get_url_page("admin"));
        }

        $del_cat = $delete_category($_POST);

        if($del_cat == true){
            header("Location: " . $get_url_page("admin"));
        }

        $session_data = $_SESSION['error'];
        $_SESSION['error'] = []
?>
    <form class="section__form--form" action method="POST">
        <input type="text" placeholder="Введите категорию" class="section__form--input input__login" name="input__category" required>
        <div class="section__form-error error__category"><?=!empty($session_data['category']) ? $session_data['category'] : ""?></div>
        <input type="submit" value="Создать" class="section__form--input input__btn" name="input__btn__create">
    </form>
    <div class="section__cards--content">
        <h3 class="section__cards--title">Все категории</h3>
        <?php foreach($all_categories as $category): ?>
        <form class="section__form--form admin__form" action method="POST">
            <input type="hidden" value="<?=$category[1]?>" class="section__form--input input__login" name="category_name" required>
            <p class="section__cards--description text__admin"><?=$category[1]?></p>
            <input type="submit" value="&times;" class="section__form--input input__delete--btn" name="input__btn__delete">
        </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>renameTitle("Профиль");</script>

<?php 
    include_once "./../components/footer.php"
?>