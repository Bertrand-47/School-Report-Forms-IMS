<?php
header('Content-Type: application/json');
$array = array();
//connect to DB
if (file_exists("../controllers/database/connection.php")) {
    require_once("../controllers/database/connection.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //do the logic part course
    if (isset($_POST['schoolkey']) && isset($_POST['session_id']) && isset($_POST['school_level']) && isset($_POST['coursename']) && isset($_POST['maxmark']) && isset($_POST['t_id'])) {
        //update course
        if (isset($_POST['update'])) {
            $sql = mysqli_query($connect, "UPDATE `test_period_courses` SET `courname`='{$_POST['coursename']}',`maxmark`='{$_POST['maxmark']}' WHERE id='{$_POST['id']}'");
            if ($sql){
                echo json_encode(array("status" => "success"));
            }
        }else if (isset($_POST['isdelete'])){
            $sql = mysqli_query($connect, "DELETE from `test_period_courses`  WHERE id='{$_POST['id']}'");
            if ($sql){
                echo json_encode(array("status" => "success"));
            }
        }
        else {
            //add new
            $sql = mysqli_query($connect, "INSERT INTO `test_period_courses`(`id`, `t_id`, `courname`, `maxmark`, `date_created`) VALUES (0,'{$_POST['t_id']}','{$_POST['coursename']}','{$_POST['maxmark']}',NOW())") or die("Could't fetch data".mysqli_error($connect));
            if ($sql) {
                echo json_encode(array("status" => "success"));
            }
        }
    }
    //end courses
    //do the logic part marks
    if (isset($_POST['schoolkey']) && isset($_POST['session_id']) && isset($_POST['school_level']) && isset($_POST['student']) && isset($_POST['mark']) && isset($_POST['course_mark']) && isset($_POST['t_id'])) {
        //update mark
        if (isset($_POST['update_mark'])) {
            $sql = mysqli_query($connect, "UPDATE `test_period_marks` SET `marks`='{$_POST['mark']}' WHERE id='{$_POST['id']}'");
            if ($sql){
                echo json_encode(array("status" => "success"));
            }
        }else if (isset($_POST['isdelete_mark'])){
            $sql = mysqli_query($connect, "DELETE from `test_period_marks`  WHERE id='{$_POST['id']}'");
            if ($sql){
                echo json_encode(array("status" => "success"));
            }
        }
        else {
            //add new
            $sql = mysqli_query($connect, "INSERT INTO `test_period_marks`(`id`, `t_id`, `student`, `course`, `marks`, `date_created`) VALUES (0,'{$_POST['t_id']}','{$_POST['student']}','{$_POST['course_mark']}','{$_POST['mark']}',NOW())") or die("Could't fetch data".mysqli_error($connect));
            if ($sql) {
                echo json_encode(array("status" => "success"));
            }
        }
    }
}

//course
else if (isset($_GET['t_id'])){
    $sql = mysqli_query($connect, "SELECT `id`, `t_id`, `courname`, `maxmark`, `date_created` FROM `test_period_courses` WHERE t_id='{$_GET['t_id']}'")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}
else if (isset($_GET['id'])){
    $sql = mysqli_query($connect, "SELECT `id`, `t_id`, `courname`, `maxmark`, `date_created` FROM `test_period_courses` WHERE id='{$_GET['id']}'")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//marks
else if (isset($_GET['t_id_mark'])){
    $sql = mysqli_query($connect, "SELECT test_period_marks.`id`, s.firstname, s.lastname, tc.courname, tc.maxmark, `marks`, test_period_marks.`date_created` FROM `test_period_marks` LEFT JOIN students s ON s.id = test_period_marks.student LEFT JOIN test_period_courses tc ON tc.id = test_period_marks.course  WHERE test_period_marks.t_id='{$_GET['t_id_mark']}' ORDER BY s.firstname, s.lastname")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}
else if (isset($_GET['id_mark'])){
    $sql = mysqli_query($connect, "SELECT `id`, `t_id`, `courname`, `maxmark`, `date_created` FROM `test_period_courses` WHERE id='{$_GET['id']}'")or die("Could't fetch data".mysqli_error($connect));
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
