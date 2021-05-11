<?php

    //header
    header('Content-Type: application/json');
    $array = array();

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `teacher_classes` WHERE id = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve class by school_level and session

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sessionid']) && isset($_GET['school_level'])  && isset($_GET['all'])){
        $sql = mysqli_query($connect, "SELECT teacher_classes.`id`, teachers.name, sl.level, classes.numbericname, classes.section, teacher_classes.`session`, teacher_classes.`school_level`, teacher_classes.`date_created` FROM `teacher_classes`
        LEFT JOIN classes ON classes.id= classID
        LEFT JOIN teachers ON teachers.id= teacher_classes.teacher_key
        LEFT JOIN school_levels sl on sl.id=classes.classname
        WHERE teacher_classes.school_level = '{$_GET['school_level']}' AND teacher_classes.session='{$_GET['sessionid']}' ORDER BY teacher_classes.date_created DESC")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve class by school and session and teacher
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['teacher_id']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT teacher_classes.`id`, teachers.name, sl.level, classes.numbericname, classes.section, teacher_classes.`session`, teacher_classes.`school_level`, teacher_classes.`date_created` FROM `teacher_classes`
        LEFT JOIN classes ON classes.id= classID
        LEFT JOIN teachers ON teachers.id= teacher_classes.teacher_key
        LEFT JOIN school_levels sl on sl.id=classes.classname
        WHERE teacher_classes.school_level = '{$_GET['school_level']}' AND teacher_classes.session='{$_GET['sessionid']}' AND teachers.id='{$_GET['teacher_id']}'")or die("Could't fetch data".mysqli_error($connect));
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