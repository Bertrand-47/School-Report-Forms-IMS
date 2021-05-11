<?php

    header('Content-Type: application/json');
    $array = array();

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    //check the requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['schoolname'])){
            //update
            if ($_POST['isUpdate']){
                $sql = mysqli_query($connect, "UPDATE `schools` SET `schoolname`='{$_POST['schoolname']}',`schoollogo`='{$_POST['schoollogo']}' WHERE id = '{$_POST['id']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }

            //insert new
            else{
                //check
                $check = mysqli_query($connect, "SELECT `id`, `schoolname`, `schoollogo`, `date_created` FROM `schools` WHERE id = '{$_POST['schoolkey']}'");
                if (mysqli_num_rows($check) > 0){
                    echo json_encode(array("status" => "exist"));
                }else{
                    //add
                    $sql = mysqli_query($connect, "INSERT INTO `schools`(`id`, `schoolname`,`schoollogo`, `date_created`) VALUES (0,'{'{$_POST['schoolname']}','{$_POST['schoollogo']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                    if($sql){
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
        }

        //delete
        else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `schools` WHERE school_key = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve all schools
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all'])){
        $sql = mysqli_query($connect, "SELECT `id`, `schoolname`, `schoollogo`, `date_created` FROM `schools` ORDER BY date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }


    //retrive by id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])  && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT `id`, `schoolname`, `schoollogo`, `date_created` FROM `schools` WHERE id = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve by id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT `id`, `schoolname`, `schoollogo`, `date_created` FROM `schools` WHERE id = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve school levels
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT `id`, `level` FROM `school_levels` WHERE id='{$_GET['school_level']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve school levels
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all_levels'])){
        $sql = mysqli_query($connect, "SELECT `id`, `level` FROM `school_levels`")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
?>