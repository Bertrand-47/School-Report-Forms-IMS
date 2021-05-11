<?php
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['names']) && isset($_POST['email']) && isset($_POST['changepassword']) && isset($_POST['permission']) && isset($_POST['id'])){
            //update
            if ($_POST['isUpdate']){
                $chk_sql = mysqli_query($connect, "SELECT `id`, `names`, `email`, `password`, `permission`, `class`, `school`, `default_password`, `date_created` FROM `accounts` WHERE id='{$_POST['id']}' AND school='{$_POST['schoolkey']}'");
                if (mysqli_num_rows($chk_sql) == 1){
                    $pass= md5($_POST['changepassword']);
                    $sql = mysqli_query($connect, "UPDATE `accounts` SET `names`='{$_POST['names']}',`email`='{$_POST['email']}',`permission`='{$_POST['permission']}',`class`='{$_POST['classname']}',school='{$_POST['schoolkey']}', password= '$pass', default_password = 1 WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'")or die("Could't update data".mysqli_error($connect));
                    if ($sql == 1){
                        echo json_encode(array("status" => "success"));
                    }
                }else{
                    echo json_encode(array("status" => "notexist"));
                }
            }
        }else if ($_POST['isDelete']){
            $sql = mysqli_query($connect, "DELETE from `accounts` WHERE id = '{$_POST['id']}'  AND school = '{$_POST['schoolkey']}'")or die("Could't delete data".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }else if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['isMyAccount'] && isset($_GET['id']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT `id`, `names`, `email`, `password`, `permission`, `class`, `school`, `default_password`, `date_created` FROM `accounts` WHERE id='{$_GET['id']}' AND school='{$_GET['schoolkey']}'");
        if (mysqli_num_rows($sql) == 1){
            $array = array();
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
?>