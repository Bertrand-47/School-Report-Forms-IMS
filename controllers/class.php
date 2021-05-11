<?php

    //header
    header('Content-Type: application/json');
    $array = array();

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    function save_teacher($connect, $teacher, $class, $session, $school_level){
        $sql_chk = mysqli_query($connect, "SELECT `teacher_key` FROM `teacher_classes` WHERE teacher_key='$teacher' AND classID='$class' AND session='$session' AND school_level='$school_level'") or die("Could't fetch teacher classes".mysqli_error($connect));
        if(!mysqli_num_rows($sql_chk)){
            $sql_i=mysqli_query($connect, "INSERT INTO `teacher_classes`(`id`, `teacher_key`, `classID`, `session`, `school_level`, `date_created`) 
            VALUES (0,'$teacher','$class', $session, $school_level,NOW())");
        }
    }

    //receive the requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['school_level']) && isset($_POST['numbericnumber']) && isset($_POST['section']) && isset($_POST['sessionid'])){
            //update
            if (isset($_POST['isUpdate'])){
                $sql = mysqli_query($connect, "UPDATE `classes` SET `school` ='{$_POST['schoolkey']}',`classname`='{$_POST['school_level']}',`numbericname`='{$_POST['numbericnumber']}', section ='{$_POST['section']}' WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}' AND classes.session = '{$_POST['sessionid']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    if(isset($_POST['teacher'])){
                        save_teacher($connect, $_POST['teacher'], $_POST['id'], $_POST['sessionid'], $_POST['school_level']);
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "success"));
                    }
                }
            }

            //add new class
            else{
                //add
                $sql = mysqli_query($connect, "INSERT INTO `classes`(`id`, classes.school, classes.session, `classname`, `numbericname`, section,
                    `date_created`) VALUES (0,'{$_POST['schoolkey']}', '{$_POST['sessionid']}', '{$_POST['school_level']}',
                    '{$_POST['numbericnumber']}',
                    '{$_POST['section']}', NOW())") or die("Could't insert data".mysqli_error($connect));
                if($sql){
                    $last_id = mysqli_insert_id($connect);
                    if(isset($_POST['teacher'])){
                        save_teacher($connect, $_POST['teacher'], $last_id, $_POST['sessionid'], $_POST['school_level']);
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "success"));
                    }
                }else{
                    echo json_encode(array("status" => "notsaved"));
                }
            }
        }

        //delete
        else if (isset($_POST['isDelete'])){
            $sql_delete_t = mysqli_query($connect, "DELETE FROM `teacher_classes` WHERE classID='{$_POST['id']}'");
            $sql_delete_student = mysqli_query($connect, "DELETE FROM `students` WHERE classname='{$_POST['id']}'");
            $sql_delete_student_comment = mysqli_query($connect, "DELETE FROM `student_comments` WHERE class='{$_POST['id']}'");
            $sql_delete_student_marks_p = mysqli_query($connect, "DELETE FROM `student_marks` WHERE class='{$_POST['id']}'");
            $sql_delete_student_marks_n = mysqli_query($connect, "DELETE FROM `nursery_marks` WHERE class='{$_POST['id']}'");
            $sql_delete_student_position = mysqli_query($connect, "DELETE FROM `student_positions` WHERE class='{$_POST['id']}'");
            $sql_delete_student_remar = mysqli_query($connect, "DELETE FROM `student_remarques` WHERE class='{$_POST['id']}'");
            $sql = mysqli_query($connect, "DELETE from `classes` WHERE id = '{$_POST['id']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve class by school and session

    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sessionid']) && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school,classes.session, sl.level, `numbericname`, section, classes.`date_created` FROM `classes`
        LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.school = '{$_GET['schoolkey']}' AND classes.session = '{$_GET['sessionid']}' AND classes.classname = '{$_GET['school_level']}' GROUP BY classes.id ORDER BY classname,numbericname,section, date_created desc ")or die("Could't fetch data".mysqli_error($connect));
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
        $sql = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section,classes.`date_created` FROM `classes` 
        LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.`session` = '{$_GET['sessionid']}' AND classes.classname = '{$_GET['school_level']}' GROUP BY classes.id ORDER BY classname,numbericname,section, date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //get class by class id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])  && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT classes.`id`,classes.school, classes.session,`numbericname`, section,sl.id as school_level_id,sl.level, classes.`date_created` FROM `classes` 
        LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.id = '{$_GET['id']}' AND classes.classname='{$_GET['school_level']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
    //retrieve class by class,school level
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['classID']) && isset($_GET['schoolkey']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section,classes.`date_created` FROM `classes` 
        LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.school = '{$_GET['schoolkey']}' AND classes.`id` = '{$_GET['classID']}' AND classes.classname='{$_GET['school_level']}' GROUP BY classes.id")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }
    //retrieve class by school level
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['schoolkey']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section,classes.`date_created` FROM `classes` 
        LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.school = '{$_GET['schoolkey']}' AND classes.classname='{$_GET['school_level']}' GROUP BY classes.id")or die("Could't fetch data".mysqli_error($connect));
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