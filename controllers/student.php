<?php

    //header
    header('Content-Type: application/json');

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();

    //requested
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['schoolkey']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['classname']) && isset($_POST['school_level'])  && isset($_POST['gender'])){

            //update
            if (isset($_POST['isUpdate'])){
                $sql = mysqli_query($connect, "UPDATE `students` SET `school`='{$_POST['schoolkey']}',`school_level`='{$_POST['school_level']}',`session`='{$_POST['sessionid']}',`classname`='{$_POST['classname']}',`firstname`='{$_POST['firstname']}',`lastname`='{$_POST['lastname']}',`classname`='{$_POST['classname']}',`date_birth`='{$_POST['datebth']}',`gender`='{$_POST['gender']}', `fathername`='{$_POST['fathername']}', `mothername`='{$_POST['mothername']}', `phonenumber`='{$_POST['phonenumber']}', `address`='{$_POST['address']}' WHERE id = '{$_POST['id']}'")or die("Could't fetch data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }

            //create new student
            else{
                //add
                $sql = mysqli_query($connect, "INSERT INTO `students`(`id`, school,school_level,`session`,`firstname`, `lastname`, `classname`, `date_birth`,gender, `fathername`, `mothername`, `phonenumber`, `address`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['sessionid']}','{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['classname']}','{$_POST['datebth']}','{$_POST['gender']}','{$_POST['fathername']}','{$_POST['mothername']}','{$_POST['phonenumber']}','{$_POST['address']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                if($sql){
                    echo json_encode(array("status" => "success"));
                }else{
                    echo json_encode(array("status" => "notsaved"));
                }
            }
        }

        //delete
        else if (isset($_POST['isDelete'])){
            $sql = mysqli_query($connect, "DELETE from `students` WHERE id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
            if ($sql == 1){
				$sql = mysqli_query($connect, "DELETE from `student_positions` WHERE student_id = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
				$sql_p_markers = mysqli_query($connect, "DELETE from `student_marks` WHERE student = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
				$sql_n_markers = mysqli_query($connect, "DELETE from `nursery_marks` WHERE student = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
				$sql_student_comments = mysqli_query($connect, "DELETE from `student_comments` WHERE student = '{$_POST['id']}'")or die("Could't delete data".mysqli_error($connect));
                echo json_encode(array("status" => "success"));
            }
        }

        if (isset($_POST['upload_file'])) {

            $path = "./database/uploads/"; //set your folder path
            $appr = $_SERVER["HTTP_HOST"];
            //set the valid file extensions
            $valid_formats = array("xls", "csv", "xlsx"); //add the formats you want to upload

            $name = $_FILES['file']['name']; //get the name of the file

            $size = $_FILES['file']['size']; //get the size of the file

            if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
                list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
                if (in_array($ext, $valid_formats)) { //if the file is valid go on.
                    if ($size < 2098888) { // check if the file size is more than 2 mb
                        $tmp = $_FILES['file']['tmp_name'];
                        if (move_uploaded_file($tmp, $path . $name)) { //check if it the file move successfully.
                             if ($ext == 'csv') {
                               if (file_exists($path.$name)) {
                                if (($handle = fopen($path.$name, "r")) !== FALSE) {
                                  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                      $fname = $data[1];
                                      $lname = $data[2];
                                      $class = $data[3];
                                      $db = $data[4];
                                      $gender = $data[5];
                                      $father = $data[6];
                                      $mother = $data[7];
                                      $pn = $data[8];
                                      $address = $data[9];
                                      $message = [];

                                      //search a class
                                      $sql_c = mysqli_query($connect, "SELECT classes.id, IF(sl.level='Primary', CONCAT('P', '', numbericname,section), CONCAT('N', '', numbericname,section)) as class , sl.level, `classname`, `numbericname`, `section` FROM `classes`
                                      LEFT JOIN school_levels sl ON sl.id = classes.school AND classes.session ='{$_POST['sessionid']}'
                                      HAVING class = '$class'");
                                      if (mysqli_num_rows($sql_c) > 0) {
                                        $row = mysqli_fetch_array($sql_c);
                                        //add
                                        $sql = mysqli_query($connect, "INSERT INTO `students`(`id`, school,school_level,`session`,`firstname`, `lastname`, `classname`, `date_birth`,gender, `fathername`, `mothername`, `phonenumber`, `address`, `date_created`)
                                        VALUES (0,'{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['sessionid']}','$fname','$lname','{$row['id']}','$db','$gender','$father','$mother','$pn','$address',NOW())") or die("Could't insert data".mysqli_error($connect));
                                        if($sql){
                                          $message[] = array("status" => "success");
                                        }else{
                                          $message[] = array("status" => "notsaved");
                                        }
                                      }
                                  }
                                  echo json_encode($message);
                                  fclose($handle);
                                }else {
                                  echo "false";
                                }
                               }
                             }
                        } else {
                            echo "failed";
                        }
                    } else {
                        echo "File size max 2 MB";
                    }
                } else {
                    echo "Invalid file format..";
                }
            } else {
                echo "Please select a file..!";
            }
            exit;
        }
    }

    //retrieve all student
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['r_t']) && isset($_GET['schoolkey']) && isset($_GET['school_level']) && isset($_GET['sessionid'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT students.`id`,
            students.school,students.school, `firstname`, `lastname`, c.id AS classID, sl.level,sl.id AS school_level_id,section, c.numbericname, `date_birth`,gender, `fathername`, `mothername`, `phonenumber`, `address`, students.`date_created` FROM `students`
            LEFT JOIN classes c ON c.id = students.classname
            LEFT JOIN school_levels sl ON sl.id = students.school_level
            WHERE students.school = '{$_GET['schoolkey']}'
            AND students.school_level='{$_GET['school_level']}'
            AND students.session='{$_GET['sessionid']}'
            ORDER BY students.`date_created` DESC")
        or die("Could't fetch data".mysqli_error($connect));
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
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])  && isset($_GET['schoolkey'])){
        $sql = mysqli_query($connect, "SELECT DISTINCT students.`id`,
            students.school,students.school, `firstname`, `lastname`, c.id AS classID, sl.level,sl.id AS school_level_id, sl.id AS school_level_id,section, c.numbericname, `date_birth`,gender, `fathername`, `mothername`, `phonenumber`, `address`, students.`date_created` FROM `students`
            LEFT JOIN classes c ON c.id = students.classname
            LEFT JOIN school_levels sl ON sl.id = students.school_level WHERE students.id = '{$_GET['id']}'  AND students.school = '{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0){
            while ($rows = mysqli_fetch_array($sql)){
                $array[] = $rows;
            }
            echo json_encode($array);
        }else{
            echo json_encode($array);
        }
    }

    //by teacher id
    else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['teacher_id'])  && isset($_GET['schoolkey']) && isset($_GET['school_level'])){
        $sql = mysqli_query($connect, "SELECT students.`id`, teacher_classes.`session`, 
        sl.level, students.firstname, students.lastname, cl.numbericname, cl.section, students.date_birth, students.gender, students.fathername, students.mothername, students.phonenumber, students.address FROM `teacher_classes`
        LEFT JOIN students ON students.classname= teacher_classes.classID
        LEFT JOIN school_levels sl on sl.id=students.school_level
        LEFT JOIN classes cl on cl.id=students.classname
        WHERE students.school_level = '{$_GET['school_level']}' AND students.session='{$_GET['sessionid']}' AND teacher_classes.teacher_key='{$_GET['teacher_id']}' ORDER BY students.date_created DESC") or die("Could't fetch users" . mysqli_error($connect));
        if (mysqli_num_rows($sql) > 0) {
            while ($rows = mysqli_fetch_array($sql)) {
                $array[] = $rows;
            }
            echo json_encode($array);
        } else {
            echo json_encode($array);
        }
    }
?>
