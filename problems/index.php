<?php 
    include_once "./../components/config.php";
    include_once "./../components/functions.php";
    include_once "./../components/header.php";

    $redirect_unauth();

    $problems_user = $get_problems($_SESSION['user']);

    // delete
    $status_del = $delete_problem($_POST);
    if($status_del !== false){
        header("Location: " . $get_url_page("problems"));
    }

    // update 
    if($_SESSION['user']['role'] == "admin"){
        $status = $edit_status($_POST);


        if(!empty($_FILES['input__file']) || $status !== false){

            if(!empty($_FILES['input__file'])){
                // validate file
                if(
                    !strpos($_FILES['input__file']["name"], ".png") &&
                    !strpos($_FILES['input__file']["name"], ".jpg") &&
                    !strpos($_FILES['input__file']["name"], ".jpeg") &&
                    !strpos($_FILES['input__file']["name"], ".bmp")
                ){
                    $_SESSION['error']['type_file'] = "Файл не является изображением";
                    header("Location: " . $get_url_page("problems"));
                    die;
                }
                if($_FILES['input__file']["size"] > 10 * 1024 * 1024){
                    $_SESSION['error']['size'] = "Загружаемый файл должен быть не более 10 МБ";
                    header("Location: " . $get_url_page("problems"));
                    die;
                }

                // generate info
                $problem_id = $_POST['input__probmlem__id'];
                $filename = $generate_filename();

                $search_problem = $query_db("SELECT * FROM `problems` WHERE `id` = '$problem_id'")->fetch_assoc();
                $old_filename = $search_problem["photo_problem"];

                // create file
                $dirname = $_SERVER["DOCUMENT_ROOT"] . "/images/completes/";
                
                copy($_FILES["input__file"]["tmp_name"], $dirname . $filename);

                $query_db("UPDATE `problems` SET `status` = 'complete', `photo_complete` = '$filename' WHERE `id` = '$problem_id'");
            }

            header("Location: " . $get_url_page("problems"));
        }
    }
?>
    
<section class="section__problems">

    <?php 
    if(empty($problems_user) == true): ?><h2 class="section__heading">Похоже вы не создали еще ни одной заявки!</h2><?php
    else: ?>
        <h2 class="section__heading">Ваши заявки</h2>
        <ul class="section__cards--list">
    <?php
        foreach($problems_user as $problem): 
            $status = "<font color='blue'>Новая</font>";
            if($problem[5] == "complete") $status = "<font color='green'>Решена</font>";
            if($problem[5] == "reject") $status = "<font color='red'>Отклонена</font>";
    ?>
        <li class="section__cards--item">
            <div class="section__cards--content">
                <h3 class="section__cards--title"><?=$problem[1]?></h3>
                <p class="section__cards--description"><?=$problem[2]?></p>
                <p class="section__cards--description"><strong>Категория:</strong> <?=$problem[4]?></p>
                <p class="section__cards--description"><strong>Статус:</strong> <?=$status?></p>
                <p class="section__cards--description"><strong>Дата:</strong> <?=$problem[7]?></p>
                <?=
                    $problem[5] == "reject" ? "<p class='section__cards--description'><strong>Причина отказа:</strong> $problem[8]</p>" : ""
                ?>
            </div>
            <?php
                if($problem[5] == "new"){
                if($_SESSION['user']['role'] == "admin"){
                ?>
                <form class="section__form--form edit__problem" action method="POST" ENCTYPE="multipart/form-data">
                    <input type="hidden" value="<?=$problem[0]?>" name="input__probmlem__id">

                    <textarea name="input__textarea" class="section__form--input input__trextarea" placeholder="Описание отказа решения проблемы"></textarea>

                    <input type="file" class="section__form--input input__pass" name="input__file">
                    <div class="section__form-error error__pass"><?=!empty($data_session['type_file']) ? $data_session['type_file'] : "" ?></div>
                    <div class="section__form-error error__pass"><?=!empty($data_session['size']) ? $data_session['size'] : "" ?></div>

                    <input type="submit" value="Изменить статус" class="section__form--input input__btn" name="input__btn">
                </form>
                <?php
                }
                    ?>
                <form class="section__form--form edit__problem" action method="POST">
                    <input type="hidden" value="<?=$problem[0]?>" name="input__probmlem__id">
                    <input type="submit" value="Удалить" class="section__form--input input__btn" name="input__btn_del">
                </form>
                    <?php
                }
            ?>
        </li>
    <?php 
        endforeach;
    endif;
    ?>
    </ul>
</section>

<script>renameTitle("Заявки");</script>
        

<?php 
    include_once "./../components/footer.php"
?>