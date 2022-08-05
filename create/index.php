<?php 
    include_once "./../components/config.php";
    include_once "./../components/functions.php";
    include_once "./../components/header.php";

    $redirect_unauth();

    $all_categories = $get_categories();

    $validate = $validate_problem($_POST);

    $data_session = $_SESSION['error'];

    if(isset($_FILES['input__file']) && !empty($_FILES["input__file"]) && $validate == true){
        if(
            !strpos($_FILES['input__file']["name"], ".png") &&
            !strpos($_FILES['input__file']["name"], ".jpg") &&
            !strpos($_FILES['input__file']["name"], ".jpeg") &&
            !strpos($_FILES['input__file']["name"], ".bmp")
        ){
            $_SESSION['error']['type_file'] = "Файл не является изображением";
            $validate = false;
        }
        if($_FILES['input__file']["size"] > 10 * 1024 * 1024){
            $_SESSION['error']['size'] = "Загружаемый файл должен быть не более 10 МБ";
            $validate = false;
            header("Location: " . $get_url_page("create"));
        }

        if($validate == true){
            $filename = $generate_filename();
            $title = $_POST['input__name'];
            $description = $_POST['input__textarea'];
            $user_id = $_POST['input__userid'];
            $category = $_POST['input__category'];

            copy($_FILES['input__file']["tmp_name"], $_SERVER['DOCUMENT_ROOT']. "/images/active/" . $filename);

            $query_db("INSERT INTO `problems` (`title`,`description`,`photo_problem`,`user_id`,`category`) VALUES ('$title','$description','$filename','$user_id','$category');");

            header("Location: " . $get_url_page("create"));
        }
    }

    $data_session = $_SESSION['error'];
    $_SESSION['error'] = [];
?>

<section class="section__form">
    <h2 class="section__heading">Создать заявку</h2>
    <form class="section__form--form" action method="POST" ENCTYPE="multipart/form-data">
        <input type="hidden" value="<?=$_SESSION["user"]["id"]?>" name="input__userid">

        <input type="text" placeholder="Название проблемы" class="section__form--input input__name" name="input__name" required>
        <div class="section__form-error error__name"></div>

        <textarea required name="input__textarea" class="section__form--input input__trextarea" placeholder="Описание проблемы"></textarea>

        <select type="email" placeholder="Ваша почта" class="section__form--input input__select" name="input__category" required>
            <option selected disabled>Категория:</option>
            <?php foreach($all_categories as $category): ?>
                <option value="<?=$category[1]?>"><?=$category[1]?></option>
            <?php endforeach; ?>
        </select>

        <input type="file" class="section__form--input input__pass" name="input__file" required>
        <div class="section__form-error error__pass"><?=!empty($data_session['type_file']) ? $data_session['type_file'] : "" ?></div>
        <div class="section__form-error error__pass"><?=!empty($data_session['size']) ? $data_session['size'] : "" ?></div>

        <input type="submit" value="Создать" class="section__form--input input__btn" name="input__btn">
    </form>
</section>

<script>renameTitle("Создать заявку");</script>

<?php 
    include_once "./../components/footer.php"
?>