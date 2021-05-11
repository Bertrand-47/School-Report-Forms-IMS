<?php

    //header and variables
    header('Content-Type: application/json');
    $array = array();

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    //receive the requests

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['academic_year']) && isset($_POST['startdate'])  && 
            isset($_POST['enddate']) && isset($_POST['school_level'])){

            //update
            if (isset($_POST['isUpdate'])){
                $sql = mysqli_query($connect, "UPDATE `sessions` SET `academic_year`='{$_POST['academic_year']}', 
                    `school_level`='{$_POST['school_level']}', `startdate`='{$_POST['startdate']}' ,`enddate`='{$_POST['enddate']}', `status`='{$_POST['status']}'  WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }

            //add new session
            else{

                //check if session is ended
                $startdate = new DateTime($_POST['startdate']);
                $enddate = new DateTime($_POST['enddate']);
                $now = new DateTime();

                //check the date entered
                if($enddate < $now) {
                    echo json_encode(array("status" => "date_ended"));
                }else if ($enddate < $startdate){
                    echo json_encode(array("status" => "date_ended_less_startdate"));
                }

                //continue to add new

                else{
                    //add
                    $sql = mysqli_query($connect, "INSERT INTO `sessions`(`id`, school, school_level, academic_year, `startdate`,`enddate`, `status`, `date_created`) VALUES (0,'{$_POST['schoolkey']}' , '{$_POST['school_level']}','{$_POST['academic_year']}','{$_POST['startdate']}','{$_POST['enddate']}','{$_POST['status']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                    if($sql){
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "notsaved"));
                    }
                }

            }
        }

        //delete a session

        else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `sessions` WHERE id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['r_t']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT sessions.`id`, school,sl.id AS school_level_id,sl.level,academic_year, `startdate`,`enddate`, status, `date_created` FROM `sessions` LEFT JOIN school_levels sl ON sl.id = school_level WHERE sessions.school = '{$_GET['schoolkey']}' ORDER BY date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['school_level']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT sessions.`id`, school,sl.id AS school_level_id,sl.level,academic_year, `startdate`,`enddate`, status,`date_created` FROM `sessions` LEFT JOIN school_levels sl ON sl.id = school_level WHERE sessions.school = '{$_GET['schoolkey']}' AND sessions.school_level = '{$_GET['school_level']}' ORDER BY date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
        $sql = mysqli_query($connect, "SELECT sessions.`id`, school,sl.id AS school_level_id,sl.level,academic_year, `startdate`,`enddate`, status, `date_created` FROM `sessions` LEFT JOIN school_levels sl ON sl.id = school_level WHERE sessions.id = '{$_GET['id']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['selected_id'])){
        $sql = mysqli_query($connect, "SELECT sessions.`id`, school,sl.id AS school_level_id,sl.level,academic_year, `startdate`,`enddate`, status, `date_created` FROM `sessions` LEFT JOIN school_levels sl ON sl.id = school_level WHERE sessions.id = '{$_GET['selected_id']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;

                //set session 
                session_start();
                $_SESSION["sessionid"] = $rows["id"];
                $_SESSION["school_level"] = $rows["school_level_id"];
                $_SESSION["level"] = $rows["level"];
                $_SESSION["academic_year"] = $rows["academic_year"];
                $_SESSION["status"] = $rows["status"];
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
?>