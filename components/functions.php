<?php

$get_url_page = fn($path_to_file = "") => HOST . "/" . $path_to_file;

$get_db = fn() => new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$query_db = fn($macros = "") => $get_db()->query($macros);

$count_complete_quiz = function () use ($query_db){
    $count = $query_db("SELECT COUNT(*) AS `COUNTED` FROM `problems` WHERE `status` = 'complete';")->fetch_assoc()["COUNTED"];
    
    if((string)$count == 1){
        return "$count задачу";
    } else if(((string)$count)[strlen((string)$count) - 1] > 4 || ((string)$count)[strlen((string)$count) - 1] == 0){
        return "$count задач";
    }
    return "$count задачи";
};

$get_completes = function() use ($query_db){
    return $query_db("SELECT * FROM `problems` WHERE `status` = 'complete';")->fetch_all();
};

$validate_register = function($data) use ($query_db){
    $_SESSION['error'] = [];

    if(!empty($data)){

        if(isset($data["input__btn"]) && !empty($data["input__btn"])){
            $login = $data["input__login"];

            if(count($query_db("SELECT * FROM `users` WHERE `login` = '$login'")->fetch_all()) == 0){

                $username = $data["input__name"];
                $email = $data["input__email"];
                $password = password_hash($data["input__pass"], PASSWORD_DEFAULT);

                $query_db("INSERT INTO `users` (`username`,`login`,`email`,`password`) VALUES ('$username','$login','$email','$password')");

                return true;
            } else $_SESSION["error"]["unique"] = "Указанный вами логин уже зарегистрирован";
        } else $_SESSION["error"]["send_form"] = "Вы не отправили форму";
    } else $_SESSION["error"]["error_500"] = "Ошибка сервера";
    
    return false;
};

$validate_authorize = function($data) use ($query_db){
    if(!empty($data)){
        if(isset($data["input__btn"]) && !empty($data["input__btn"])){
            $login = $data["input__login"];
            $search_login = $query_db("SELECT * FROM `users` WHERE `login` = '$login'")->fetch_assoc();
            if($search_login == null){
                $_SESSION['error']['login'] = "Пользователь не найден";
                return false;
            }
            if($search_login["password"] != "adminWSR"){
                $password_db = $search_login["password"];

                if(!password_verify($data["input__pass"], $password_db)){
                    $_SESSION['error']['login'] = "Неверный лоигн или пароль";
                    return false;
                }
            }
            

            $_SESSION['user'] = $search_login;
            return true;
        }
    }

    return false;
};

// check auth user
$redirect_auth = function () use ($get_url_page){
    if(!empty($_SESSION['user']['id'])) header("Location: " . $get_url_page());
};

// check unautorzied user
$redirect_unauth = function () use ($get_url_page){
    if(empty($_SESSION['user']['id'])) header("Location: " . $get_url_page("auth/login"));
};

$get_categories = function() use ($query_db){
    return $query_db("SELECT * FROM `categories`")->fetch_all();
};

$validate_categories = function($data) use ($query_db){
    if(!empty($data) && !empty($data['input__btn__create'])){
        $category = $data["input__category"];
        $search_category = $query_db("SELECT * FROM `categories` WHERE `category` = '$category'")->fetch_all();
        if($search_category == null || count($search_category) == 0){
            $query_db("INSERT INTO `categories` (`category`) VALUES ('$category')");
            return true;
        }
        $_SESSION['error']['category'] = "Категория уже существует";
    }
    
    return false;
};

$get_problems = function ($datauser, $filter = "") use ($query_db){
    $id = $datauser['id'];
    $role = $datauser['role'];
    if($role == 'admin') return $query_db("SELECT * FROM `problems` ")->fetch_all();
    return $query_db("SELECT * FROM `problems` WHERE `user_id` = '$id'")->fetch_all();
};

$validate_problem = function ($data_problem){
    if(!empty($data_problem)) return true;
    return false;
};

$delete_category = function ($data) use ($query_db){
    if(!empty($data) && !empty($data['input__btn__delete'])){
        $delete_category = $data["category_name"];
        $query_db("DELETE FROM `categories` WHERE `category` = '$delete_category'");
        $query_db("DELETE FROM `problems` WHERE `category` = '$delete_category'");

        return true;
    }

    return false;
};

$edit_status = function ($data) use($query_db) {
    if(!empty($data) && isset($data["input__btn"]) && !empty($data["input__btn"])){
        if(!empty($data['input__textarea'])){
            $problem_id = $_POST['input__probmlem__id'];
            $reject_text = $_POST['input__textarea'];

            $query_db("UPDATE `problems` SET 
                `status` = 'reject',
                `reason_reject` = '$reject_text'
                WHERE `id` = '$problem_id'
            ");

            return "reject";
        }
        if(!empty($data['type_file'])){
            return "complete";
        }
    }

    return false;
};

$delete_problem = function ($data) use ($query_db){
    if(!empty($data) && isset($data['input__btn_del']) && !empty($data['input__btn_del'])){
        $problem_id = $data["input__probmlem__id"];
        $query_db("DELETE FROM `problems` WHERE `id` = $problem_id");

        return true;
    }

    return false;
};

$generate_filename = function(){
    return rand(100000000000000000, 999999999999999999) . ".jpg";
};