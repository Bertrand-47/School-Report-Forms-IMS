<?php

    //header
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();

    // function updateTeacherClass($connect, $teacherID, $classID){
    //     $sql = mysqli_query($connect, "UPDATE `classes` SET `teacher`='$teacherID' WHERE id='{$classID}");
    //     if($sql){
    //         return json_encode(array("status" => "teacher class added success"));
    //     }else{
    //         return json_encode(array("status" => "notsaved"));
    //     }
    // }

    //receive the requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['names']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['permission'])){

            //update
            if (isset($_POST['isUpdate'])){
                if ($_POST['password'] !== ''){
                    $password = md5($_POST['password']);

                    $sql = mysqli_query($connect, "UPDATE `accounts` SET `names`='{$_POST['names']}',`email`='{$_POST['email']}',`permission`='{$_POST['permission']}',accounts.school='{$_POST['schoolkey']}', password='$password', default_password= 1, school_level ='{$_POST['school_level']}' WHERE id = '{$_POST['id']}' AND accounts.school = '{$_POST['schoolkey']}'")or die("Could't update data".mysqli_error($connect));
                    if ($sql == 1){
						update_teacher($connect, $_POST['permission'], $_POST['schoolkey'],$_POST['school_level'], $_POST['teacher_email'], $_POST['email'], $_POST['names'], $_POST['sessionid']);
                        echo json_encode(array("status" => "success"));
                    }
                }
                //update without password
                else{
                    $sql = mysqli_query($connect, "UPDATE `accounts` SET `names`='{$_POST['names']}',`email`='{$_POST['email']}',`permission`='{$_POST['permission']}',accounts.school='{$_POST['schoolkey']}', school_level ='{$_POST['school_level']}'	WHERE id = '{$_POST['id']}'")or die("Could't update data".mysqli_error($connect));
                    if ($sql == 1){
						update_teacher($connect, $_POST['permission'], $_POST['schoolkey'],$_POST['school_level'], $_POST['teacher_email'], $_POST['email'], $_POST['names'], $_POST['sessionid']);
                        echo json_encode(array("status" => "success"));
                    }
                }
            }

            //add new
            else{
                //add
                $sql_check = mysqli_query($connect, "SELECT `id`, `names`, `email`, `password`, default_password, `permission`, school, school_level, `date_created` FROM `accounts` WHERE email ='{$_POST['email']}'");
                if (mysqli_num_rows($sql_check) > 0){
                    echo json_encode(array("status" => "exist"));
                }else{
                    $pass = md5($_POST['password']);
                    $sql = mysqli_query($connect, "INSERT INTO `accounts`(`id`, `names`, `email`, `password`, default_password, `permission`, school, school_level, `date_created`) 
                    VALUES (0,'{$_POST['names']}','{$_POST['email']}','$pass',0,'{$_POST['permission']}','{$_POST['schoolkey']}','{$_POST['school_level']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                    if($sql){
                        if($_POST['permission'] == 'Teacher'){
                            //add to teacher's table
                            //get random key to just diffentiate some teacher's data
                            $num = mt_rand(100000,999999);
                            // $sql_t = mysqli_query($connect, "INSERT INTO `teachers`(`id`,teacher_key, `school`, `school_level`, `session`, 
                            // `name`, `contact`, `email`, `date_created`) 
                            // VALUES (0,'$num','{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['sessionid']}','{$_POST['names']}','','{$_POST['email']}',NOW())") or die("Could't insert 1 teacher" . mysqli_error($connect));

                            save_teacher($connect, $_POST['permission'], $_POST['schoolkey'],$_POST['school_level'], $_POST['email'], $_POST['names'], $_POST['sessionid']);
                        
                        }
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
        }

        //delete
        else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `accounts` WHERE id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve all
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['r_t']  && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT accounts.`id`, `names`, `email`, `password`,default_password, `permission`,sc.schoolname,sl.id AS school_level_id,sl.level,accounts.`date_created` FROM `accounts` LEFT JOIN schools sc ON accounts.school = sc.id LEFT JOIN school_levels sl ON sl.id = accounts.school_level WHERE accounts.school = '{$_GET['schoolkey']}' AND accounts.school_level='{$_GET['school_level']}' ORDER BY accounts.date_created DESC")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

//    for teachers
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['teacher']  && $_GET['user_key']  && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT accounts.`id`, `names`, `email`, `password`,default_password, `permission`,sc.schoolname,sl.id AS school_level_id,sl.level, accounts.`date_created` FROM `accounts` LEFT JOIN schools sc ON accounts.school = sc.id LEFT JOIN school_levels sl ON sl.id = accounts.school_level WHERE accounts.school = '{$_GET['schoolkey']}' AND accounts.id='{$_GET['user_key']}' ORDER BY accounts.date_created DESC")or die("Could't fetch data".mysqli_error($connect));
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
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id']){
        $sql = mysqli_query($connect, "SELECT accounts.`id`, `names`, `email`, `password`,default_password, `permission`, sc.schoolname,sl.id AS school_level_id,sl.level, accounts.`date_created` FROM `accounts` LEFT JOIN schools sc ON accounts.school = sc.id LEFT JOIN school_levels sl ON sl.id = accounts.school_level WHERE accounts.id = '{$_GET['id']}' AND accounts.school = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
	
	function save_teacher($connect, $permission, $schoolkey, $school_level, $email, $names, $sessionid){
		$sql = mysqli_query("SELECT `id`, `teacher_key`, `school`, `school_level`, `session`, `name`, `contact`, `email`, `date_created` FROM `teachers` 
		WHERE school_level='$school_level' AND session='$sessionid' AND email='$email'");
		if(mysqli_num_rows($sql) == 0){
			if($permission == 'Teacher'){
				//add to teacher's table
				//get random key to just diffentiate some teacher's data
				$num = mt_rand(100000,999999);
				$sql_t = mysqli_query($connect, "INSERT INTO `teachers`(`id`,teacher_key, `school`, `school_level`, `session`, `name`, `contact`, `email`, `date_created`) 
				VALUES (0,'$num','$schoolkey','$school_level','$sessionid','$names','','$email',NOW())") or die("Could't insert 1 teacher" . mysqli_error($connect));
			}
		}
    }
    function update_teacher($connect, $permission, $schoolkey, $school_level, $teacher_email, $email, $names, $sessionid){
        $sql = mysqli_query($connect,"UPDATE `teachers` SET `name`='$names',`email`='$email' WHERE school_level='$school_level' AND session='$sessionid' AND email='$teacher_email'");
	}
?>