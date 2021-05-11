<?php
header('Content-Type: application/json');

//connect to DB
if (file_exists("../controllers/database/connection.php")) {
    require_once("../controllers/database/connection.php");
}

$array = array();

//save teacher in account to let him/ her sign in in the system
function saveAccount($connect,$schoolID, $names,$email,$permission,$school_level, $status, $id,$password){

    $pass = md5($password);

    if ($status === 'isUpdate') {
        # update
        $sqlupdate = mysqli_query($connect, "UPDATE `accounts` SET `names`='$names',`email`='$email',`permission`='$permission',accounts.school='$schoolID', password='$pass', default_password= 1, school_level ='$school_level' WHERE id = '$id' AND accounts.school = '$schoolID'")or die("Could't update data".mysqli_error($connect));
        if ($sqlupdate == 1){
            return json_encode(array("status" => "account updated success"));
        }
    }else{
        //add
        $sql_check = mysqli_query($connect, "SELECT `email`, `password`, school, school_level FROM `accounts` WHERE email ='$email' AND school='$schoolID'");
        if (mysqli_num_rows($sql_check) > 0){
            return json_encode(array("status" => "exist"));
        }else{
            $sql = mysqli_query($connect, "INSERT INTO `accounts`(`id`, `names`, `email`, `password`, default_password, `permission`, school, school_level, `date_created`) VALUES (0,'$names','$email','$pass',0,'$permission','$schoolID','$school_level',NOW())") or die("Could't insert data".mysqli_error($connect));
            if($sql){
                return json_encode(array("status" => "account added success"));
            }else{
                return json_encode(array("status" => "notsaved"));
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //do the logic part
    if (isset($_POST['schoolkey']) && isset($_POST['school_level']) && isset($_POST['sessionid']) && isset($_POST['names']) && isset($_POST['email']) && isset($_POST['phone'])) {

        //update
        if (isset($_POST['isUpdate'])) {
            $sql = mysqli_query($connect, "UPDATE `teachers` SET `school`='{$_POST['schoolkey']}',`name`='{$_POST['names']}',`contact`='{$_POST['phone']}',`email`='{$_POST['email']}' WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'") or die("Could't fetch users" . mysqli_error($connect));
            if ($sql == 1) {

                //update also the account
                saveAccount($connect,$_POST['schoolkey'], $_POST['names'], $_POST['email'], 'Teacher', $_POST['school_level'], 'isUpdate',$_POST['id'], $_POST['passwordteacher']);

                echo json_encode(array("status" => "success"));
            }
        }

        //create new teacher
        else {
            //check if exist
            $isExist = mysqli_query($connect, "SELECT `id`, school, `name`, `contact`, `email`, `date_created` FROM `teachers` WHERE email = '{$_POST['email']}' AND school = '{$_POST['schoolkey']}' AND school_level = '{$_POST['school_level']}'") or die("Could't fetch users" . mysqli_error($connect));
            if (mysqli_num_rows($isExist) > 0) {
                echo json_encode(array(
                    "status" => "exist"));
            }
            //then add new
            else {

                //get random key to just diffentiate some teacher's data
                $num = mt_rand(100000,999999);

                $sql = mysqli_query($connect, "INSERT INTO `teachers`(`id`,teacher_key, `school`, `school_level`, `session`, `name`, `contact`, `email`, `date_created`) VALUES (0,'$num','{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['sessionid']}','{$_POST['names']}','{$_POST['phone']}','{$_POST['email']}',NOW())") or die("Could't insert 1 users" . mysqli_error($connect));
                if($sql){
                    //give a teacher an access to system
                    saveAccount($connect,$_POST['schoolkey'], $_POST['names'], $_POST['email'], 'Teacher', $_POST['school_level'], '', '', $_POST['passwordteacher']);
                    echo json_encode(array("status" => "success"));
                }
            }
        }
    }

    //delete teacher data here am following the teacher's key
    else if (isset($_POST['isDelete'])) {
        $sql = mysqli_query($connect, "DELETE from `teachers` WHERE teacher_key = '{$_POST['id']}'") or die("Could't delete users" . mysqli_error($connect));
        if ($sql) {
            //delete account too
            $sql_acc = mysqli_query($connect, "DELETE from `accounts` WHERE email = '{$_POST['email']}'")or die("Could't delete data".mysqli_error($connect));
            
            echo json_encode(array("status" => "success"));
        }
    }
}

//GET request for admin
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all']) && isset($_GET['schoolkey']) && isset($_GET['sessionid'])) {

    //retrieve teacher for admin
    $sql = mysqli_query($connect, "SELECT `id`, `teacher_key`, `school`, `school_level`, `session`,  `name`, `contact`, `email`, `date_created` FROM `teachers` WHERE session ='{$_GET['sessionid']}'") or die("Could't fetch users" . mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0) {
        while ($rows = mysqli_fetch_array($sql)) {
            $array[] = $rows;
        }
        echo json_encode($array);
    } else {
        echo json_encode($array);
    }
}

//retrieve teacher by email
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email']) && isset($_GET['schoolkey'])) {

    //retieve teacher by email
    $sql = mysqli_query($connect, "SELECT `id`, `teacher_key`, `school`, `school_level`, `session`,  `name`, `contact`, `email`, `date_created` FROM `teachers` WHERE email ='{$_GET['email']}'") or die("Could't fetch users" . mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0) {
        while ($rows = mysqli_fetch_array($sql)) {
            $array[] = $rows;
        }
        echo json_encode($array);
    } else {
        echo json_encode($array);
    }
}

//retrieve by id
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['teacher_key_course'])) {
    $sql = mysqli_query($connect, "SELECT `id`, `school`, `school_level`, `session`, `subjectname`, `coursename`, `teacher`, `assistant`, `maxcat`, `maxexam`, `date_created` FROM `courses` WHERE teacher='{$_GET['teacher_key_course']}'") or die("Could't fetch users" . mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0) {
        while ($rows = mysqli_fetch_array($sql)) {
            $array[] = $rows;
        }
        echo json_encode($array);
    } else {
        echo json_encode($array);
    }
}

//retrieve by teacher classes
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['teacher_key_class'])) {
    $sql = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section,t.name, classes.`date_created` FROM `classes` LEFT JOIN teachers t ON t.id = classes.teacher LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.teacher = '{$_GET['teacher_key_class']}' AND classes.session='{$_GET['sessionid']}'") or die("Could't fetch users" . mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0) {
        while ($rows = mysqli_fetch_array($sql)) {
            $array[] = $rows;
        }
        echo json_encode($array);
    } else {
        echo json_encode($array);
    }
}

//remove class on teacher
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['remove_class'])) {
    $sql = mysqli_query($connect, "UPDATE `class` SET `teacher`=0 WHERE id={$_GET['remove_id']}") or die("Could't fetch users" . mysqli_error($connect));
    if ($sql > 0) {
        echo json_encode(array("status" => "success"));
    } 
}
//remove course on teacher
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['remove_course'])) {
    $sql = mysqli_query($connect, "UPDATE `courses` SET `teacher`=0, `assistant`= 0 WHERE id={$_GET['remove_id']}") or die("Could't fetch users" . mysqli_error($connect));
    if ($sql > 0) {
        echo json_encode(array("status" => "success"));
    }
}
?>