<?php
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //do the logic part
    if (isset($_POST['schoolkey']) && isset($_POST['sessionID']) && isset($_POST['classID']) && isset($_POST['termID'])  && isset($_POST['studentID']) && isset($_POST['courseID'])) {

        //update
        if (isset($_POST['isUpdate'])) {
            $sql_check = mysqli_query($connect, "SELECT `id`, `school`, `session`, `term`, `course`, `student`, `cat`, `exam`, `date_created` FROM `student_marks` WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}'  AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}' AND id='{$_POST['id']}'") or die("Could't fetch data" . mysqli_error($connect));;

            if (mysqli_num_rows($sql_check) == 1) {
                $sql = mysqli_query($connect, "UPDATE `student_marks` SET `cat`='{$_POST['cat']}',`exam`='{$_POST['exam']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}' AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}' AND id='{$_POST['id']}'") or die("Could't update data" . mysqli_error($connect));
                if ($sql == 1) {
                    echo json_encode(array("status" => "success"));
                }
            }
        } else {
            //insert nursery data
            if(isset($_POST['nursery']) && isset($_POST['quotation'])){
                //add
                $sql_check = mysqli_query($connect, "SELECT `id`, `school`, `school_level`, `term`, `session`, `class`, `student`, `course`, `quotation`, `date_created` 
                FROM `nursery_marks` WHERE term='{$_POST['termID']}' AND class='{$_POST['classID']}' AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}'") or die("Could't fetch nursery data" . mysqli_error($connect));

                if (mysqli_num_rows($sql_check) > 0) {
                    $rows = mysqli_fetch_array($sql_check);
                    //update quotation
                    if (isset($_POST['quotation'])) {
                        $sql = mysqli_query($connect, "UPDATE `nursery_marks` SET `quotation`='{$_POST['quotation']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}' AND student='{$_POST['studentID']}'  AND course='{$_POST['courseID']}' AND id='{$rows['id']}'") or die("Could't update data" . mysqli_error($connect));
                        if ($sql == 1) {
                            echo json_encode(array("status" => "success"));
                        }
                    }

                } else {
                    $sql = mysqli_query($connect, "INSERT INTO `nursery_marks`(`id`, `school`, `school_level`, `term`, `session`, `class`, `student`, `course`, `quotation`, `date_created`)
                    VALUES (0,'{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['termID']}','{$_POST['sessionID']}','{$_POST['classID']}','{$_POST['studentID']}','{$_POST['courseID']}','{$_POST['quotation']}',NOW())") or die("Could't insert data" . mysqli_error($connect));
                    if ($sql) {
                        echo json_encode(array("status" => "success"));
						return;
                    } else {
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
            //it is primary
            else{
                //check
                $sql_check = mysqli_query($connect, "SELECT `id`, `school`, `session`, `term`, `course`, `student`, `cat`, `exam`, `date_created` FROM `student_marks` WHERE term='{$_POST['termID']}' AND class='{$_POST['classID']}' AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}'") or die("Could't fetch data" . mysqli_error($connect));

                if (mysqli_num_rows($sql_check) > 0) {
                    $rows = mysqli_fetch_array($sql_check);
                    //update CAT
                    if (isset($_POST['cat'])) {
                        $sql = mysqli_query($connect, "UPDATE `student_marks` SET `cat`='{$_POST['cat']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}' AND student='{$_POST['studentID']}'  AND course='{$_POST['courseID']}' AND id='{$rows['id']}'") or die("Could't update data" . mysqli_error($connect));
                        if ($sql == 1) {
                            echo json_encode(array("status" => "success"));
                        }
                    }else if (isset($_POST['exam'])) {
                        $sql = mysqli_query($connect, "UPDATE `student_marks` SET `exam`='{$_POST['exam']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}' AND student='{$_POST['studentID']}'  AND course='{$_POST['courseID']}' AND id='{$rows['id']}'") or die("Could't update data" . mysqli_error($connect));
                        if ($sql == 1) {
                            echo json_encode(array("status" => "success"));
                        }
                    }else if (isset($_POST['catb']) && isset($_POST['examb'])) {
                    $sql = mysqli_query($connect, "UPDATE `student_marks` SET `cat`='{$_POST['catb']}',`exam`='{$_POST['examb']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionID']}' AND term='{$_POST['termID']}' AND student='{$_POST['studentID']}'  AND course='{$_POST['courseID']}' AND id='{$rows['id']}'") or die("Could't update data" . mysqli_error($connect));
                        if ($sql == 1) {
                            echo json_encode(array("status" => "success"));
                        }
                    }

                } else {
                    $sql = mysqli_query($connect, "INSERT INTO `student_marks`(`id`, `school`, `session`,`class`, `term`, `course`, `student`, `cat`, `exam`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['sessionID']}','{$_POST['classID']}','{$_POST['termID']}','{$_POST['courseID']}','{$_POST['studentID']}','{$_POST['cat']}','{$_POST['exam']}',NOW())") or die("Could't insert data" . mysqli_error($connect));
                    if ($sql) {
                        echo json_encode(array("status" => "success"));
                    } else {
                        echo json_encode(array("status" => "notsaved"));
                    }
                }
            }
        }
    }
}

//retrive marks for admin
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all'])  && isset($_GET['sessionID'])  && isset($_GET['schoolkey'])){
    $sql = mysqli_query($connect, "SELECT COUNT(student_marks.`id`) record_number,student_marks.`id`, student_marks.`school`, `session`,student_marks.student, t.term, `course`, st.firstname,st.lastname, `cat`, `exam`, student_marks.`date_created` FROM `student_marks` LEFT JOIN students st ON st.id = student_marks.student LEFT JOIN terms t ON t.id = student_marks.term WHERE student_marks.school = '{$_GET['schoolkey']}' AND student_marks.session = '{$_GET['sessionID']}' and student_marks.student='{$_GET['studentID']}' GROUP BY student_marks.student,student_marks.session") or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 1){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}
//retrive marks for teacher
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['classID']) && isset($_GET['sessionID']) && isset($_GET['studentID'])  && isset($_GET['schoolkey'])){
    $sql = mysqli_query($connect, "SELECT COUNT(student_marks.`id`) record_number,student_marks.`id`, student_marks.`school`, `session`,student_marks.student, t.term, `course`, st.firstname,st.lastname, `cat`, `exam`, student_marks.`date_created` FROM `student_marks` LEFT JOIN students st ON st.id = student_marks.student LEFT JOIN terms t ON t.id = student_marks.term WHERE student_marks.school = '{$_GET['schoolkey']}' AND student_marks.session = '{$_GET['sessionID']}' and student_marks.student='{$_GET['studentID']}' GROUP BY student_marks.student,student_marks.session") or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 1){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}
?>
