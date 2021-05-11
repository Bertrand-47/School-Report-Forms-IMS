<?php
  header('Content-Type: application/json');
  $array = array();
  //connect to DB
  if (file_exists("../controllers/database/connection.php")) {
      require_once("../controllers/database/connection.php");
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' 
  && isset($_POST['sessionID'])
  && isset($_POST['termID'])
  && isset($_POST['schoolkey'])
  && isset($_POST['school_level'])
  && isset($_POST['studentID'])
  && isset($_POST['classID'])){
    $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id`, `coursename`, `maxcat`, `maxexam`, IFNULL(sm.cat, '') as cat, IFNULL(sm.exam, '') as exam FROM `courses` LEFT JOIN student_marks sm ON sm.course = courses.id and sm.student= '{$_POST['studentID']}'
    WHERE sm.session = '{$_POST['sessionID']}'
    AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}'
    UNION ALL SELECT courses.`id`, `coursename`, `maxcat`, `maxexam`, '','' FROM `courses` WHERE courses.session = '{$_POST['sessionID']}' and courses.id NOT IN (SELECT courses.`id` FROM `courses` LEFT JOIN student_marks sm
    ON sm.course = courses.id and sm.student= '{$_POST['studentID']}' WHERE courses.session = '{$_POST['sessionID']}' AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}')") or die("Error, fetch data".mysqli_error($connect));

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
