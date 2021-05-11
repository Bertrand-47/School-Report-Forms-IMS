<?php

    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['schoolname'])  && isset($_POST['email']) && isset($_POST['password'])){

        //connect to DB
        if(file_exists("../controllers/database/connection.php")){
            require_once("../controllers/database/connection.php");
        }

        //do the logic part
        if(isset($_POST['email']) && isset($_POST['password'])){
            //logic
            $pass = md5($_POST['password']);
            $sql = mysqli_query($connect, "SELECT accounts.`id`, `names`, accounts.`email`, `password`,default_password, `permission`,accounts.school_level, s.id AS school_key, s.schoolname, accounts.`date_created`, accounts.`school`, t.teacher_key, t.id as teacher_id FROM accounts INNER JOIN schools s on s.id = accounts.school AND s.schoolname='{$_POST['schoolname']}' LEFT JOIN school_levels sl ON sl.id = accounts.school_level LEFT JOIN teachers t on t.email = '{$_POST['email']}' where accounts.email = '{$_POST['email']}' AND  password = '$pass'") or die("Could't fetch users".mysqli_error($connect));
            if(mysqli_num_rows($sql) == 1){

                $data = mysqli_fetch_array($sql);

                session_start();
                $_SESSION["fullname"] = $data["names"];
                $_SESSION["user_key"] = $data["id"];
                $_SESSION["email"] = $data["email"];
                $_SESSION["permission"] = $data["permission"];
                $_SESSION["school"] = $data["school_key"];
                $_SESSION["schoolname"] = $data["schoolname"];
                if($data["teacher_key"] !== "" && $data["teacher_id"] !== ""){
                    $_SESSION["teacher_key"] = $data['teacher_key'];
                    $_SESSION["teacher_id"] = $data['teacher_id'];
                }
                $_SESSION["school_level"] = $data['school_level'];
                $_SESSION["isLogin"] = true;

                echo json_encode(array(
                    "status" => "success", 
                    "data" => $data));
            }else{
                echo json_encode(array(
                    "status" => "notfound"));
            }
        }
    }
?>