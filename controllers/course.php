<?php

    //header
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();

    
    function save_teacher($connect, $teacher, $course, $session, $school_level){
        $sql_chk = mysqli_query($connect, "SELECT `teacher_key` FROM `teacher_courses` WHERE teacher_key='$teacher' AND course_id='$course' AND session='$session' AND school_level='$school_level'") or die("Could't fetch teacher classes".mysqli_error($connect));
        if(mysqli_num_rows($sql_chk)){
            $sql = mysqli_query($connect,"UPDATE `teacher_courses` SET `teacher_key`='$teacher' WHERE teacher_key='$teacher' AND course_id='$course' AND session='$session' AND school_level='$school_level'");
        }else if($teacher != null){
            $sql_i=mysqli_query($connect, "INSERT INTO `teacher_courses`(`id`, `teacher_key`, `course_id`, `session`, `school_level`, `date_created`) 
            VALUES (0,'$teacher','$course', $session, $school_level,NOW())");
        }
    }

    //receive requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['sessionid']) &&  isset($_POST['subjectname']) && isset($_POST['coursename']) && isset($_POST['cat']) && isset($_POST['exam']) && isset($_POST['teacher'])){

            //update
            if (isset($_POST['isUpdate'])){
                $sql = mysqli_query($connect, "UPDATE `courses` SET school = '{$_POST['schoolkey']}' ,school_level= '{$_POST['school_level']}' ,`subjectname`='{$_POST['subjectname']}',`coursename`='{$_POST['coursename']}',`maxcat`='{$_POST['cat']}',`maxexam`='{$_POST['cat']}' WHERE id = '{$_POST['id']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    if(isset($_POST['teacher'])){
                        save_teacher($connect, $_POST['teacher'],$_POST['id'], $_POST['sessionid'], $_POST['school_level']);
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "success"));
                    }
                }
            }

            //add new course
            else{
                //check first to see is not exist
                $sql_chec = mysqli_query($connect, "SELECT `id`,school, session, `subjectname`, `coursename`, `maxcat`, `maxexam`, `date_created` FROM `courses` WHERE school ='{$_POST['schoolkey']}' AND courses.coursename ='{$_POST['coursename']}'");
                if (mysqli_num_rows($sql_chec) > 0){
                    echo json_encode(array("status" => "exist"));
                }

                //add new if not exist
                else{
                    $sql = mysqli_query($connect, "INSERT INTO `courses`(`id`,school, school_level, session, `subjectname`,`coursename`, `maxcat`, `maxexam`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['sessionid']}', '{$_POST['subjectname']}','{$_POST['coursename']}','{$_POST['cat']}','{$_POST['exam']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                    if($sql){
                        $latest_id =  mysqli_insert_id($connect);
                        //update teacher courses
                        if(isset($_POST['teacher'])){
                            
                            save_teacher($connect, $_POST['teacher'],$latest_id, $_POST['sessionid'], $_POST['school_level']);
                            echo json_encode(array("status" => "success"));
                        }else{
                            echo json_encode(array("status" => "success"));
                        }
                        
                    }else{
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
        }

        //delete course
        else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `courses` WHERE id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
            $sql_c_t = mysqli_query($connect, "DELETE from `teacher_courses` WHERE course_id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
            
            if ($sql == 1){
                //delete student marks [primary]
                $sql = mysqli_query($connect, "DELETE from `student_marks` WHERE course = '{$_POST['id']}'")or die("Could't primary marks for this course".mysqli_error($connect));
                //delete student marks [nursery]
                $sql = mysqli_query($connect, "DELETE from `nursery_marks` WHERE course = '{$_POST['id']}'")or die("Could't course marks nursery".mysqli_error($connect));
            
                echo json_encode(array("status" => "success"));
            }
        }
    }

    //retrieve by session id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all']) && isset($_GET['sessionid']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT courses.`id`, sl.level, courses.`session`, sb.subjectname, sb.id as sub_id, `coursename`, `maxcat`, `maxexam`, courses.`date_created` FROM `courses` 
        LEFT JOIN school_levels sl ON sl.id=courses.school_level 
        LEFT JOIN subjects sb on sb.id= courses.subjectname WHERE courses.school_level='{$_GET['school_level']}' AND courses.session='{$_GET['sessionid']}' ORDER BY courses.date_created DESC")or die("Could't fetch course data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //retrieve courses by teacher id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['teacher_key']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT courses.`id`, teacher_courses.`session`, 
        sl.level, subjects.subjectname, subjects.id as sub_id, courses.coursename, courses.maxcat, courses.maxexam, teacher_courses.`date_created` FROM `teacher_courses`
        LEFT JOIN courses ON courses.id= teacher_courses.course_id
        LEFT JOIN subjects ON subjects.id= courses.subjectname
        LEFT JOIN teachers ON teachers.teacher_key= teacher_courses.teacher_key
        LEFT JOIN school_levels sl on sl.id=teacher_courses.school_level
        WHERE teacher_courses.school_level = '{$_GET['school_level']}' AND teacher_courses.session='{$_GET['sessionid']}' AND teacher_courses.teacher_key='{$_GET['teacher_key']}' ORDER BY teacher_courses.date_created DESC")or die("Could't fetch data".mysqli_error($connect));
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
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id']  && $_GET['school_level']){
        $sql = mysqli_query($connect, "SELECT courses.`id`, sl.level, courses.`session`, sb.subjectname, sb.id as sub_id, `coursename`, `maxcat`, `maxexam`, courses.`date_created` FROM `courses` 
        LEFT JOIN school_levels sl ON sl.id=courses.school_level 
        LEFT JOIN subjects sb on sb.id= courses.subjectname WHERE courses.id='{$_GET['id']}'")or die("Could't fetch data by id".mysqli_error($connect));
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
