<?php

    //header
    header('Content-Type: application/json');
    $array = array();

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    //receive the requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) || isset($_POST['subjectname'])){

            //update
            if (isset($_POST['isUpdate'])){
                $sql = mysqli_query($connect, "UPDATE `subjects` SET `school`='{$_POST['schoolkey']}',`school_level`= '{$_POST['school_level']}', `subjectname`='{$_POST['subjectname']}' WHERE id = '{$_POST['id']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }

            //add new
            else{
                //add
                $sql = mysqli_query($connect, "INSERT INTO `subjects`(`id`, school, session, `school_level`, `subjectname`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['sessionid']}','{$_POST['school_level']}','{$_POST['subjectname']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                if($sql){
                    echo json_encode(array("status" => "success"));
                }else{
                    echo json_encode(array("status" => "notsaved"));
                }
            }
        }else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `subjects` WHERE id = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve all subjects

    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all']) && isset($_GET['sessionid']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT subjects.`id`,s.schoolname, sl.level, `subjectname`, subjects.`date_created` FROM `subjects` LEFT JOIN schools s on s.id = subjects.school LEFT JOIN school_levels sl on sl.id = subjects.school_level WHERE subjects.school = '{$_GET['schoolkey']}' AND session='{$_GET['sessionid']}' ORDER BY date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve by school level

    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['school_level']) && isset($_GET['sessionid']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT subjects.`id`,s.schoolname, sl.level, `subjectname`, subjects.`date_created` FROM `subjects` LEFT JOIN schools s on s.id = subjects.school LEFT JOIN school_levels sl on sl.id = subjects.school_level WHERE subjects.school = '{$_GET['schoolkey']}' AND session='{$_GET['sessionid']}' AND sl.id ='{$_GET['school_level']}' ORDER BY date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve by id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT subjects.`id`,s.schoolname, sl.id as school_level_id, sl.level, `subjectname`, subjects.`date_created` FROM `subjects` LEFT JOIN schools s on s.id = subjects.school LEFT JOIN school_levels sl on sl.id = subjects.school_level WHERE subjects.school = '{$_GET['schoolkey']}' AND subjects.id = '{$_GET['id']}'") or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
?>