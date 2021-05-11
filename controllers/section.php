<?php
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['classname']) && isset($_POST['section']) && isset($_POST['teacher']) && isset($_POST['schoolkey'])){
            //update
            if ($_POST['isUpdate']){
                $sql = mysqli_query($connect, "UPDATE `sections` SET school = '{$_POST['schoolkey']}',`class`='{$_POST['classname']}',`section`='{$_POST['section']}',`teacher`='{$_POST['teacher']}' WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }
            else{
                $sql_check = mysqli_query($connect, "SELECT `id`,school, `class`, `section`, `teacher`, `date_created` FROM `sections` WHERE class='{$_POST['classname']}' AND section='{$_POST['section']}' AND teacher='{$_POST['teacher']}' AND school = '{$_POST['schoolkey']}'");
                if (mysqli_num_rows($sql_check) > 0){
                    echo json_encode(array("status" => "exist"));
                }else{
                    //add
                    $sql = mysqli_query($connect, "INSERT INTO `sections`(`id`, school, `class`, `section`, `teacher`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['classname']}','{$_POST['section']}','{$_POST['teacher']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                    if($sql){
                        echo json_encode(array("status" => "success"));
                    }else{
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
        }else if ($_POST['isDelete']){
            $sql = mysqli_query($connect, "DELETE from `sections` WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}'")or die("Could't delete users".mysqli_error($connect));
            if ($sql == 1){
                echo json_encode(array("status" => "success"));
            }
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['r_t']  && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT DISTINCT sections.`id`,sections.school, cl.classname,cl.numbericname, `section`, t.name, sections.`date_created` FROM `sections` LEFT JOIN classes cl ON cl.id = sections.class LEFT JOIN teachers t ON t.id = sections.teacher WHERE sections.school = '{$_GET['schoolkey']}' ORDER BY sections.date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            $array = array();
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['classID']  && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT DISTINCT sections.`id`,sections.school, cl.id, cl.classname,cl.numbericname, `section`, t.name, sections.`date_created` FROM `sections` LEFT JOIN classes cl ON cl.id = sections.class LEFT JOIN teachers t ON t.id = sections.teacher WHERE sections.school = '{$_GET['schoolkey']}' AND cl.`id`='{$_GET['classID']}' ORDER BY sections.date_created desc")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            $array = array();
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['id'] && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT DISTINCT sections.`id`, sections.school,cl.id AS classID,cl.classname, cl.numbericname, `section`,  t.name, sections.`date_created` FROM `sections` LEFT JOIN classes cl ON cl.id=sections.class LEFT JOIN teachers  t ON t.id = sections.teacher WHERE sections.id = '{$_GET['id']}' AND sections.school = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) == 1){
            $array = array();
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }
    }

    //know more this lines from here
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['r_s'] && $_GET['schoolkey']){
        $sql = mysqli_query($connect, "SELECT DISTINCT sections.`id`,sections.school, cl.classname,cl.numbericname, `section`, t.name, sections.`date_created` FROM `sections` LEFT JOIN classes cl ON cl.id = sections.class LEFT JOIN teachers t ON t.id = sections.teacher WHERE sections.id = 2 AND school = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            $array = array();
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }
    }
?>