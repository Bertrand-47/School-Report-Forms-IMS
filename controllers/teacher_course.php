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
            $sql = mysqli_query($connect, "DELETE from `teacher_courses` WHERE id = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve class by school_level and session

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all']) && isset($_GET['sessionid']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT teacher_courses.`id`, teacher_courses.`session`, 
        sl.level, courses.subjectname, courses.coursename, teacher_courses.`date_created`, teachers.name FROM `teacher_courses`
        LEFT JOIN courses ON courses.id= teacher_courses.course_id
        INNER JOIN teachers ON teachers.teacher_key= teacher_courses.teacher_key
        LEFT JOIN school_levels sl on sl.id=teacher_courses.school_level
        WHERE teacher_courses.school_level = '{$_GET['school_level']}' AND teacher_courses.session='{$_GET['sessionid']}' ORDER BY teacher_courses.date_created DESC")or die("Could't fetch data".mysqli_error($connect));
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
        $sql = mysqli_query($connect, "SELECT teacher_courses.`id`, teacher_courses.`session`, 
        sl.level, courses.subjectname, courses.coursename, teacher_courses.`date_created`, teachers.name FROM `teacher_courses`
        LEFT JOIN courses ON courses.id= teacher_courses.course_id
        INNER JOIN teachers ON teachers.teacher_key= teacher_courses.teacher_key
        LEFT JOIN school_levels sl on sl.id=teacher_courses.school_level
        WHERE teacher_courses.school_level = '{$_GET['school_level']}' AND teacher_courses.session='{$_GET['sessionid']}' AND teacher_courses.teacher_key='{$_GET['teacher_id']}'")or die("Could't fetch data".mysqli_error($connect));
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