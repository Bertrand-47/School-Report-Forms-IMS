<?php
header('Content-Type: application/json');
$array = array();
//connect to DB
if (file_exists("../controllers/database/connection.php")) {
    require_once("../controllers/database/connection.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //do the logic part
    if (isset($_POST['schoolkey']) && isset($_POST['sessionid']) && isset($_POST['classID']) && isset($_POST['termID'])  && isset($_POST['studentID']) && isset($_POST['courseID'])) {

        //update
        if (isset($_POST['isUpdate'])) {
            $sql_check = mysqli_query($connect, "SELECT `id`, `school`, `session`, `term`, `course`, `student`, `cat`, `exam`, `date_created` FROM `student_marks` WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionid']}' AND term='{$_POST['termID']}'  AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}' AND id='{$_POST['id']}'") or die("Could't fetch data" . mysqli_error($connect));;

            if (mysqli_num_rows($sql_check) == 1) {
                $sql = mysqli_query($connect, "UPDATE `student_marks` SET `cat`='{$_POST['cat']}',`exam`='{$_POST['exam']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionid']}' AND term='{$_POST['termID']}' AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}' AND id='{$_POST['id']}'") or die("Could't update data" . mysqli_error($connect));
                if ($sql == 1) {
                    echo json_encode(array("status" => "success"));
                }
            }
        } else {
            //add
            $sql_check = mysqli_query($connect, "SELECT `id`, `school`, `session`, `term`, `course`, `student`, `cat`, `exam`, `date_created` FROM `student_marks` WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionid']}' AND term='{$_POST['termID']}'  AND course='{$_POST['courseID']}' AND student='{$_POST['studentID']}'") or die("Could't fetch data" . mysqli_error($connect));;

            if (mysqli_num_rows($sql_check) == 1) {
                $rows = mysqli_fetch_array($sql_check);
                //update
                $sql = mysqli_query($connect, "UPDATE `student_marks` SET `cat`='{$_POST['cat']}',`exam`='{$_POST['exam']}', class='{$_POST['classID']}' WHERE school='{$_POST['schoolkey']}' AND session='{$_POST['sessionid']}' AND term='{$_POST['termID']}' AND student='{$_POST['studentID']}'  AND course='{$_POST['courseID']}' AND id='{$rows['id']}'") or die("Could't update data" . mysqli_error($connect));
                if ($sql == 1) {
                    echo json_encode(array("status" => "success"));
                }
            } else {
                $sql = mysqli_query($connect, "INSERT INTO `student_marks`(`id`, `school`, `session`,`class`, `term`, `course`, `student`, `cat`, `exam`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['sessionid']}','{$_POST['classID']}','{$_POST['termID']}','{$_POST['courseID']}','{$_POST['studentID']}','{$_POST['cat']}','{$_POST['exam']}',NOW())") or die("Could't insert data" . mysqli_error($connect));
                if ($sql) {
                    echo json_encode(array("status" => "success"));
                } else {
                    echo json_encode(array("status" => "notsaved"));
                }
            }
        }
    }
    //add comment to student
    if(isset($_POST['comment']) && isset($_POST['studentID'])){
      //check if student exist
      $sql_e = mysqli_query($connect, "SELECT `id`, `student`, `session`, `class`, `term`, `comment`, `date_created`
      FROM `student_comments` WHERE student='{$_POST['studentID']}' AND class='{$_POST['classID']}' and session='{$_POST['sessionID']}' and term='{$_POST['termID']}'");
      if(mysqli_num_rows() > 1){
          // update
          $sql_u = mysqli_query($connect, "UPDATE `student_comments` SET `comment`='{$_POST['comment']}}' WHERE student='{$_POST['studentID']}' AND class='{$_POST['classID']}' and session='{$_POST['sessionID']}' and term='{$_POST['termID']}'");
          if ($sql_u) {
            echo json_encode(array("status" => "success"));
          }
      }else{
          $sql = mysqli_query($connect, "INSERT INTO `student_comments`(`id`, `student`, `session`, `class`, `term`, `comment`, `date_created`)
          VALUES (0,'{$_POST['studentID']}','{$_POST['sessionID']}','{$_POST['classID']}','{$_POST['termID']}','{$_POST['comment']}',NOW())");
          if($sql){
              echo json_encode(array("status" => "success"));
          }
      }
    }

    //add remarques to student
    if(isset($_POST['remarques']) && isset($_POST['studentID'])){
      //check if student exist
      $sql_e = mysqli_query($connect, "SELECT `id`, `student`, `session`, `class`, `term`, `remarques`, `date_created`
      FROM `student_remarques` WHERE student='{$_POST['studentID']}' AND class='{$_POST['classID']}' and session='{$_POST['sessionID']}' and term='{$_POST['termID']}'");
      if(mysqli_num_rows() > 1){
          // update
          $sql_u = mysqli_query($connect, "UPDATE `student_remarques` SET `remarques`='{$_POST['remarques']}}' WHERE student='{$_POST['studentID']}' AND class='{$_POST['classID']}' and session='{$_POST['sessionID']}' and term='{$_POST['termID']}'");
          if ($sql_u) {
            echo json_encode(array("status" => "success"));
          }
      }else{
          $sql = mysqli_query($connect, "INSERT INTO `student_remarques`(`id`, `student`, `session`, `class`, `term`, `remarques`, `date_created`)
          VALUES (0,'{$_POST['studentID']}','{$_POST['sessionID']}','{$_POST['classID']}','{$_POST['termID']}','{$_POST['remarques']}',NOW())");
          if($sql){
              echo json_encode(array("status" => "success"));
          }
      }
    }
}

//get all marks
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['all'])  && isset($_GET['sessionID'])  && isset($_GET['schoolkey'])){
	$sql = mysqli_query($connect, "SELECT COUNT(student_marks.`id`) record_number,student_marks.`id`, student_marks.`school`, `session`,student_marks.student, t.term, `course`, st.firstname,st.lastname, `cat`, `exam`, student_marks.`date_created` FROM `student_marks` LEFT JOIN students st ON st.id = student_marks.student LEFT JOIN terms t ON t.id = student_marks.term WHERE student_marks.school = '{$_GET['schoolkey']}' AND student_marks.session = '{$_GET['sessionID']}' and student_marks.student='{$_GET['studentID']}' GROUP BY student_marks.student,student_marks.session") or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) == 1){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//get student marks for single student
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['classID']) && isset($_GET['sessionID']) && isset($_GET['studentID'])  && isset($_GET['schoolkey'])){
    $sql = mysqli_query($connect, "SELECT COUNT(student_marks.`id`) record_number,student_marks.`id`, student_marks.`school`, `session`,student_marks.student, t.term, `course`, st.firstname,st.lastname, `cat`, `exam`, student_marks.`date_created` FROM `student_marks` LEFT JOIN students st ON st.id = student_marks.student LEFT JOIN terms t ON t.id = student_marks.term WHERE student_marks.school = '{$_GET['schoolkey']}' AND student_marks.session = '{$_GET['sessionID']}' and student_marks.student='{$_GET['studentID']}' GROUP BY student_marks.student,student_marks.session") or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) == 1){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//retrieve multiple student
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['classID']) &&  isset($_GET['termID']) && isset($_GET['isMultipleStudent']) && isset($_GET['school_level'])){
    //get school level 
    $sql_level = mysqli_query($connect, "SELECT `id`, `level` FROM `school_levels` WHERE id = '{$_GET['school_level']}'");
    if(mysqli_num_rows($sql_level) > 0){
        $rows = mysqli_fetch_array($sql_level);
        if($rows['level'] == 'Primary'){
            $sql = mysqli_query($connect, "SELECT student_marks.`id`, student_marks.`school`, student_marks.`session`,student_marks.student, t.term, `course`, st.id AS student_id, st.firstname,st.lastname, `cat`, `exam`, student_marks.`date_created`,
              (SUM(`cat`) + SUM(`exam`)) AS tatalCatExam,SUM(c.maxcat) + SUM(c.maxexam) AS totalMax,
              ((SUM(`cat`) + SUM(`exam`)) / (SUM(c.maxcat) + SUM(c.maxexam)) * 100)AS percentage FROM `student_marks`
              LEFT JOIN students st ON st.id = student_marks.student
              LEFT JOIN terms t ON t.id = student_marks.term
              LEFT JOIN student_positions sp ON sp.student_id=student_marks.student
              LEFT JOIN courses as c ON student_marks.course = c.id
              WHERE student_marks.term='{$_GET['termID']}' and student_marks.class='{$_GET['classID']}' and student_marks.session='{$_GET['sessionID']}' AND st.id IS NOT NULL
              GROUP BY student_marks.student, student_marks.term ORDER BY percentage DESC") or die("Could't fetch data".mysqli_error($connect));

            if (mysqli_num_rows($sql) > 0){
                while ($rows = mysqli_fetch_array($sql)){
                    $array[] = $rows;
                }
                echo json_encode($array);
            }else{
                echo json_encode($array);
            }
        }else{
            $sql = mysqli_query($connect, "SELECT nursery_marks.`id`, nursery_marks.`school`, nursery_marks.`session`,nursery_marks.student, t.term, `course`, st.id AS student_id, st.firstname,st.lastname, `quotation`, nursery_marks.`date_created` FROM `nursery_marks` LEFT JOIN students st ON st.id = nursery_marks.student LEFT JOIN terms t ON t.id = nursery_marks.term WHERE nursery_marks.class='{$_GET['classID']}' and nursery_marks.session='{$_GET['sessionID']}' GROUP BY nursery_marks.student") or die("Could't fetch data".mysqli_error($connect));

            if (mysqli_num_rows($sql) > 0){
                while ($rows = mysqli_fetch_array($sql)){
                    $array[] = $rows;
                }
                echo json_encode($array);
            }else{
                echo json_encode($array);
            }
        }
    }
}

//retrieve add position to student
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['classID']) && isset($_GET['studentID']) && isset($_GET['isNeedRanking']) && isset($_GET['termID']) && isset($_GET['sessionID'])){
    $sql = mysqli_query($connect, "SELECT student_marks.`id`, student_marks.class, student_marks.`school`, student_marks.`session`,student_marks.student, t.id as term_id, t.term, `course`, st.id AS student_id, st.firstname,st.lastname, c.maxcat, c.maxexam, `cat`, `exam`, student_marks.`date_created`,
        (cat + exam) AS tatalCatExam, (c.maxcat + c.maxexam) AS totalMax,
        ((`cat` + `exam`) / (c.maxcat + c.maxexam) * 100)AS percentage FROM `student_marks`
        LEFT JOIN students st ON st.id = student_marks.student
        LEFT JOIN terms t ON t.id = student_marks.term
        LEFT JOIN student_positions sp ON sp.student_id=student_marks.student
        LEFT JOIN courses as c ON student_marks.course = c.id
        WHERE student_marks.class='{$_GET['classID']}' and student_marks.session='{$_GET['sessionID']}' AND st.id IS NOT NULL AND st.id='{$_GET['studentID']}'
        GROUP BY student_marks.student, student_marks.term ORDER BY percentage DESC") or die("Could't fetch data".mysqli_error($connect));

    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){

            //check if is exist on position table
            $sql_pos = mysqli_query($connect, "SELECT `id`, `school_level`, `student_id`, `session_id`, `term_id`, `percentage` FROM `student_positions` 
            WHERE student_id='{$rows['student']}' AND term_id='{$rows['term_id']}' AND session_id='{$_GET['sessionID']}'") or die("Could't fetch data".mysqli_error($connect));
            if (mysqli_num_rows($sql_pos) == 1 ) {

                //update
                $sql_update = mysqli_query($connect, "UPDATE `student_positions` SET `percentage`='{$rows['percentage']}', term_id='{$rows['term_id']}' WHERE student_id='{$rows['student']}' AND class='{$rows['class']}' AND term_id='{$rows['term_id']}' ")or die("Could't update data".mysqli_error($connect));;
                if ($sql_update) {
                    echo json_encode(array("status" => "success"));
                }
            }
            //create new
            else {
                $sql_new = mysqli_query($connect, "INSERT INTO `student_positions`(`id`,school_level, `student_id`, `session_id`, `term_id`, `class`, `percentage`) VALUES (0,'{$_GET['school_level']}','{$rows['student']}','{$_GET['sessionID']}','{$rows['term_id']}','{$rows['class']}','{$rows['percentage']}')") or die("Could't add data".mysqli_error($connect));
                if ($sql_new) {
                    echo json_encode(array("status" => "success"));
                }
            }
        }
    }
}
?>
