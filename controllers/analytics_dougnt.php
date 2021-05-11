<?php
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("./database/connection.php")){
        require_once("./database/connection.php");
    }

    $label = array();
    $p = array();
    $label_gender = array();
    $p_gender = array();

    //student marks by courses statistics
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if (isset($_POST['gender']) && isset($_POST['term']) && isset($_POST['course']) && isset($_POST['classe'])) {
        if ($_POST['gender'] && $_POST['term'] == 'all_terms' && $_POST['course'] == 'all_courses' && $_POST['classe'] == 'all_classes') {
          $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id` AS courseid, t.term AS term1,
            s.gender, SUM(courses.maxcat) AS maxcat, SUM(courses.maxexam) AS maxexam, SUM(sm.`cat`) as cat, SUM(sm.`exam`) as exam FROM `courses`
            LEFT JOIN student_marks sm ON sm.course = courses.id
            LEFT JOIN students s ON s.id = sm.student
            LEFT JOIN terms t ON sm.term = t.id
            WHERE sm.session='{$_POST['session']}' AND sm.school='{$_POST['school_level']}' GROUP BY s.gender");

            if (mysqli_num_rows($sql) > 0){
                while ($rows = mysqli_fetch_array($sql)){

                  $total_max = $rows['maxexam'] + $rows['maxexam'];

                   $percentage =(($rows['cat'] + $rows['exam']) / $total_max * 100);

                   $p_gender[] = round($percentage);
                   $label_gender[] = $rows['gender'];

                }
                echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
            }else{
              echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
            }
        }
      }
      if ($_POST['gender'] && $_POST['term'] == 'all_terms' && $_POST['course'] == 'all_courses' && $_POST['classe'] !== 'all_classes') {
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id` AS courseid, t.term AS term1,
          s.gender, SUM(courses.maxcat) AS maxcat, SUM(courses.maxexam) AS maxexam, SUM(sm.`cat`) as cat, SUM(sm.`exam`) as exam FROM `courses`
          LEFT JOIN student_marks sm ON sm.course = courses.id
          LEFT JOIN students s ON s.id = sm.student
          LEFT JOIN terms t ON sm.term = t.id
          WHERE sm.session='{$_POST['session']}' AND sm.school='{$_POST['school_level']}'  AND sm.class='{$_POST['classe']}' GROUP BY s.gender");

          if (mysqli_num_rows($sql) > 0){
              while ($rows = mysqli_fetch_array($sql)){

                $total_max = $rows['maxexam'] + $rows['maxexam'];

                 $percentage =(($rows['cat'] + $rows['exam']) / $total_max * 100);

                 $p_gender[] = round($percentage);
                 $label_gender[] = $rows['gender'];

              }
              echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }else{
            echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }
      }
      if ($_POST['gender'] && $_POST['term'] !== 'all_terms'  && $_POST['course'] == 'all_courses' && $_POST['classe'] !== 'all_classes') {
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id` AS courseid, t.term AS term1,
          s.gender, SUM(courses.maxcat) AS maxcat, SUM(courses.maxexam) AS maxexam, SUM(sm.`cat`) as cat, SUM(sm.`exam`) as exam FROM `courses`
          LEFT JOIN student_marks sm ON sm.course = courses.id
          LEFT JOIN students s ON s.id = sm.student
          LEFT JOIN terms t ON sm.term = t.id
          WHERE sm.session='{$_POST['session']}' AND sm.school='{$_POST['school_level']}' AND sm.term='{$_POST['term']}'  AND sm.class='{$_POST['classe']}' GROUP BY s.gender");

          if (mysqli_num_rows($sql) > 0){
              while ($rows = mysqli_fetch_array($sql)){

                $total_max = $rows['maxexam'] + $rows['maxexam'];

                 $percentage =(($rows['cat'] + $rows['exam']) / $total_max * 100);

                 $p_gender[] = round($percentage);
                 $label_gender[] = $rows['gender'];

              }
              echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }else{
            echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }
      }
      if ($_POST['gender'] && $_POST['term'] !== 'all_terms' && $_POST['course'] == 'all_courses' && $_POST['classe'] === 'all_classes') {
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id` AS courseid, t.term AS term1,
          s.gender, SUM(courses.maxcat) AS maxcat, SUM(courses.maxexam) AS maxexam, SUM(sm.`cat`) as cat, SUM(sm.`exam`) as exam FROM `courses`
          LEFT JOIN student_marks sm ON sm.course = courses.id
          LEFT JOIN students s ON s.id = sm.student
          LEFT JOIN terms t ON sm.term = t.id
          WHERE sm.session='{$_POST['session']}' AND sm.school='{$_POST['school_level']}' AND sm.term='{$_POST['term']}' GROUP BY s.gender");

          if (mysqli_num_rows($sql) > 0){
              while ($rows = mysqli_fetch_array($sql)){

                $total_max = $rows['maxexam'] + $rows['maxexam'];

                 $percentage =(($rows['cat'] + $rows['exam']) / $total_max * 100);

                 $p_gender[] = round($percentage);
                 $label_gender[] = $rows['gender'];

              }
              echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }else{
            echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }
      }else if ($_POST['gender'] && $_POST['term'] === 'all_terms' && $_POST['course'] !== 'all_courses' && $_POST['classe'] !== 'all_classes') {
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id` AS courseid, t.term AS term1,
          s.gender, SUM(courses.maxcat) AS maxcat, SUM(courses.maxexam) AS maxexam, SUM(sm.`cat`) as cat, SUM(sm.`exam`) as exam FROM `courses`
          LEFT JOIN student_marks sm ON sm.course = courses.id
          LEFT JOIN students s ON s.id = sm.student
          LEFT JOIN terms t ON sm.term = t.id
          WHERE sm.session='{$_POST['session']}' AND sm.school='{$_POST['school_level']}'  AND sm.course='{$_POST['course']}'  AND sm.class='{$_POST['classe']}' GROUP BY s.gender");

          if (mysqli_num_rows($sql) > 0){
              while ($rows = mysqli_fetch_array($sql)){

                $total_max = $rows['maxexam'] + $rows['maxexam'];

                 $percentage =(($rows['cat'] + $rows['exam']) / $total_max * 100);

                 $p_gender[] = round($percentage);
                 $label_gender[] = $rows['gender'];

              }
              echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }else{
            echo json_encode(array("p_gender" => $p_gender, "label_gender" => $label_gender));
          }
      }
    }
?>
