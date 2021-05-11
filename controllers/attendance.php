<?php
header('Content-Type: application/json');

//connect to DB
if(file_exists("../controllers/database/connection.php")){
    require_once("../controllers/database/connection.php");
}

$array = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //do the logic part
    if(isset($_POST['schoolkey']) && isset($_POST['user_id']) && isset($_POST['classID'])){
        //update
        if ($_POST['isUpdate']){
            $sql_check = mysqli_query($connect,"SELECT id from attendance WHERE id='{$_POST['id']}'") or die("Could't fetch data".mysqli_error($connect));
            if (mysqli_num_rows($sql_check) == 1){

                if ($_POST['status'] !== ''){
                    $sql = mysqli_query($connect, "UPDATE `attendance` SET `school`='{$_POST['schoolkey']}',`session_id`='{$_POST['session_id']}',`user_id`='{$_POST['user_id']}',`class`='{$_POST['classID']}',`date`='{$_POST['date']}',`status`='{$_POST['status']}' WHERE attendance.id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'")or die("Could't update data".mysqli_error($connect));
                    if ($sql){
                        echo json_encode(array("status" => "success"));
                    }
                }else{
                    echo json_encode(array("status" => "empty_status"));
                }
            }
            return;
        }
        else{
            //check
            $sql_check = mysqli_query($connect,"SELECT id from attendance WHERE school='{$_POST['schoolkey']}' AND date='{$_POST['date']}' AND date='{$_POST['user_id']}' AND class='{$_POST['classID']}'");
            if (mysqli_num_rows($sql_check) == 0){
                //add
                $sql = mysqli_query($connect, "INSERT INTO `attendance`(`id`, `school`, `session_id`, `user_id`, `class`, `date`, `status`, `type`,`date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['session_id']}','{$_POST['user_id']}','{$_POST['classID']}','{$_POST['date']}','{$_POST['status']}','{$_POST['type']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                if($sql){
                    echo json_encode(array("status" => "success"));
                }else{
                    echo json_encode(array("status" => "exist"));
                }
            }
            return;
        }
    }else if ($_POST['isDelete']){
        $sql = mysqli_query($connect, "DELETE from `attendance` WHERE id = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
        if ($sql == 1){
            echo json_encode(array("status" => "success"));
        }
    }
}

//get teacher attendance
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['teacher'] && $_GET['all'] && $_GET['date'] && $_GET['attendancetype'] && $_GET['schoolkey']){
    $sql = mysqli_query($connect, "SELECT DISTINCT attendance.`id`, attendance.`school`, `session_id`, t.name, c.classname,c.numbericname,c.section, `date`, `status`, attendance.`date_created` FROM `attendance` left JOIN teachers t ON t.id = user_id LEFT JOIN schools s ON s.school_key = attendance.school LEFT JOIN sessions sess ON sess.id = attendance.session_id LEFT JOIN classes c ON c.id = attendance.class WHERE type='{$_GET['attendancetype']}' AND attendance.school='{$_GET['schoolkey']}' AND attendance.date='{$_GET['date']}' ORDER BY date DESC")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['teacher'] && $_GET['classID'] && $_GET['date'] && $_GET['attendancetype'] && $_GET['schoolkey']){
    $sql = mysqli_query($connect, "SELECT DISTINCT attendance.`id`, attendance.`school`, `session_id`, t.name, c.classname,c.numbericname,c.section, `date`, `status`, attendance.`date_created` FROM `attendance` left JOIN teachers t ON t.id = user_id LEFT JOIN schools s ON s.school_key = attendance.school LEFT JOIN sessions sess ON sess.id = attendance.session_id LEFT JOIN classes c ON c.id = attendance.class WHERE type='{$_GET['attendancetype']}' AND attendance.school='{$_GET['schoolkey']}' AND attendance.date='{$_GET['date']}' AND attendance.class='{$_GET['classID']}' ORDER BY date DESC")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//get student attendance
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['student'] && $_GET['all'] && $_GET['date'] && $_GET['attendancetype'] && $_GET['schoolkey']){
    $sql = mysqli_query($connect, "SELECT DISTINCT attendance.`id`, attendance.`school`, `session_id`,  t.firstname,t.lastname, c.classname,c.numbericname,c.section, `date`, `status`, attendance.`date_created` FROM `attendance` left JOIN students t ON t.id = user_id LEFT JOIN schools s ON s.school_key = attendance.school LEFT JOIN sessions sess ON sess.id = attendance.session_id LEFT JOIN classes c ON c.id = attendance.class WHERE type='{$_GET['attendancetype']}' AND attendance.school='{$_GET['schoolkey']}' AND attendance.date='{$_GET['date']}' ORDER BY date DESC")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['student'] && $_GET['classID'] && $_GET['date'] && $_GET['attendancetype'] && $_GET['schoolkey']){
    $sql = mysqli_query($connect, "SELECT DISTINCT attendance.`id`, attendance.`school`, `session_id`,  t.firstname,t.lastname, c.classname,c.numbericname,c.section, `date`, `status`, attendance.`date_created` FROM `attendance` left JOIN students t ON t.id = user_id LEFT JOIN schools s ON s.school_key = attendance.school LEFT JOIN sessions sess ON sess.id = attendance.session_id LEFT JOIN classes c ON c.id = attendance.class WHERE type='{$_GET['attendancetype']}' AND attendance.school='{$_GET['schoolkey']}' AND attendance.date='{$_GET['date']}' AND attendance.class='{$_GET['classID']}' ORDER BY date DESC")or die("Could't fetch data".mysqli_error($connect));
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