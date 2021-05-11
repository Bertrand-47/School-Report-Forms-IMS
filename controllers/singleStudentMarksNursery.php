<?php
header('Content-Type: application/json');
$array = array();
//connect to DB
if (file_exists("../controllers/database/connection.php")) {
    require_once("../controllers/database/connection.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sessionID'])
    && isset($_POST['sessionID'])
    && isset($_POST['termID'])
    && isset($_POST['schoolkey'])
    && isset($_POST['school_level'])
    && isset($_POST['studentID'])
    && isset($_POST['classID'])) {
    $sql_t = mysqli_query($connect, "SELECT `teacher_key`, `email` FROM `teachers` WHERE email='{$_GET['email']}' and teachers.school = '{$_GET['schoolkey']}' AND teachers.session = '{$_GET['sessionID']}' AND teachers.school_level = '{$_GET['school_level']}' GROUP BY teachers.teacher_key");
    if (mysqli_num_rows($sql_t) > 0) {
        $r = mysqli_fetch_array($sql_t);
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id`, `coursename`, sm.quotation FROM `courses` LEFT JOIN nursery_marks sm ON sm.course = courses.id and sm.student= '{$_POST['studentID']}'
        WHERE sm.session = '{$_POST['sessionID']}'
        AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}'
        UNION ALL SELECT courses.`id`, `coursename`, '' FROM `courses` WHERE courses.session = '{$_POST['sessionID']}' and courses.id NOT IN (SELECT courses.`id` FROM `courses` LEFT JOIN nursery_marks sm
        ON sm.course = courses.id and sm.student= '{$_POST['studentID']}' WHERE courses.teacher = '{$r['teacher_key']}' OR courses.assistant ='{$r['teacher_key']}' AND courses.session = '{$_POST['sessionID']}' AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}')") or die("Error, fetch data" . mysqli_error($connect));

        if (mysqli_num_rows($sql) > 0) {
            while ($rows = mysqli_fetch_array($sql)) {
                $array[] = $rows;
            }
            echo json_encode($array);
        } else {
            echo json_encode($array);
        }
    } else {
        $sql = mysqli_query($connect, "SELECT DISTINCT courses.`id`, `coursename`, sm.quotation FROM `courses` LEFT JOIN nursery_marks sm ON sm.course = courses.id and sm.student= '{$_POST['studentID']}'
    WHERE sm.session = '{$_POST['sessionID']}'
    AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}'
    UNION ALL SELECT courses.`id`, `coursename`, '' FROM `courses` WHERE courses.session = '{$_POST['sessionID']}' and courses.id NOT IN (SELECT courses.`id` FROM `courses` LEFT JOIN nursery_marks sm
    ON sm.course = courses.id and sm.student= '{$_POST['studentID']}' WHERE courses.session = '{$_POST['sessionID']}' AND sm.term = '{$_POST['termID']}' AND sm.student = '{$_POST['studentID']}')") or die("Error, fetch data" . mysqli_error($connect));

        if (mysqli_num_rows($sql) > 0) {
            while ($rows = mysqli_fetch_array($sql)) {
                $array[] = $rows;
            }
            echo json_encode($array);
        } else {
            echo json_encode($array);
        }
    }
}
?>
