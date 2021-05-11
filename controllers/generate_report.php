<?php
header('Content-Type: application/json');
$array = array();
//connect to DB
if (file_exists("../controllers/database/connection.php")) {
    require_once("../controllers/database/connection.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['studentID']){
    $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id`,courses.school,courses.class, s.id as sub_id,sub.subjectname, `coursename`, `maxcat`, `maxexam`,p_percentage, courses.`date_created`, sm.cat,sm.exam FROM `courses` LEFT JOIN subjects s ON s.id = courses.subjectname
            LEFT JOIN student_marks sm ON sm.course = courses.id
            LEFT JOIN subjects sub ON sub.id = courses.subjectname
            WHERE courses.class = 'Primary' AND courses.school = 'hd4GXgtrKN'") or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) == 1){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
            $titleArr[$row['subject_title']][] = $row['subjectname'];
        }
        foreach($titleArr as $subject => $productArr){
            echo '<h3>'. $menuTitle .'</h3>';
            foreach($productArr as $key =>$productname){
                echo '<p>'. $productname .'</p>';
            }
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}
?>