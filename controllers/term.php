<?php
header('Content-Type: application/json');
$array = array();
//connect to DB
if(file_exists("../controllers/database/connection.php")){
    require_once("../controllers/database/connection.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //do the logic part
    if(isset($_POST['schoolkey']) && isset($_POST['term']) && isset($_POST['session_id']) && isset($_POST['startdate'])  && isset($_POST['enddate'])){
        //update
        if (isset($_POST['isUpdate'])){
            //check
            $sql_sql = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, `term`, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE school = '{$_POST['schoolkey']}' AND session_id = '{$_POST['session_id']}' AND id = '{$_POST['id']}'");
            if (mysqli_num_rows($sql_sql) == 1){
                $sql = mysqli_query($connect, "UPDATE `terms` SET `term`='{$_POST['term']}',`startingdate`='{$_POST['startdate']}',`endingdate`='{$_POST['enddate']}' WHERE  school = '{$_POST['schoolkey']}' AND session_id = '{$_POST['session_id']}' AND id = '{$_POST['id']}'")or die("Could't update data".mysqli_error($connect));
                if ($sql == 1){
                    echo json_encode(array("status" => "success"));
                }
            }
        }
        else{
            //check if session is ended
            $startdate = new DateTime($_POST['startdate']);
            $enddate = new DateTime($_POST['enddate']);
            $now = new DateTime();

            //check
            $sql_sql = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, `term`, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE school = '{$_POST['schoolkey']}' AND session_id = '{$_POST['session_id']}'  AND term = '{$_POST['term']}' AND startingdate = '{$_POST['startdate']}' AND endingdate = '{$_POST['enddate']}'");
            if (mysqli_num_rows($sql_sql) > 0){
                echo json_encode(array("status" => "exist"));
            }
            else{
                //check date
                if($enddate <= $now) {
                    echo json_encode(array("status" => "date_ended"));
                    exit();
                }else if ($enddate < $startdate){
                    echo json_encode(array("status" => "date_ended_less_startdate"));
                    exit();
                }
                //add
                $sql = mysqli_query($connect, "INSERT INTO `terms`(`id`, `school`, `session_id`, `term`, `startingdate`, `endingdate`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['session_id']}','{$_POST['term']}','{$_POST['startdate']}','{$_POST['enddate']}',NOW())") or die("Could't insert data".mysqli_error($connect));
                if($sql){
                    echo json_encode(array("status" => "success"));
                }else{
                    echo json_encode(array("status" => "notsaved"));
                }
            }
        }
    }else if (isset($_POST['new_test_period']) && isset($_POST['schoolkey']) && isset($_POST['term']) && isset($_POST['session_id']) && isset($_POST['test_starting_date'])  && isset($_POST['test_end_date'])){
        //add new period
        $sql = mysqli_query($connect, "INSERT INTO `test_period`(`id`, `school_key`, `school_level`, `session`, `term`, `name`, `starting_date`, `end_date`, `date_created`) 
        VALUES (0,'{$_POST['schoolkey']}','{$_POST['school_level']}','{$_POST['session_id']}','{$_POST['term']}','{$_POST['name']}','{$_POST['test_starting_date']}','{$_POST['test_end_date']}',NOW())");
        if ($sql == 1){
            echo json_encode(array("status" => "success"));
        }
    }

    else if (isset($_POST['update_test_period'])){
        //add new period
        $sql = mysqli_query($connect, "UPDATE `test_period` SET `name`='{$_POST['name']}',`starting_date`='{$_POST['test_starting_date']}',`end_date`='{$_POST['test_end_date']}' WHERE id='{$_POST['id']}'");
        if ($sql == 1){
            echo json_encode(array("status" => "success"));
        }
    }

    else if (isset($_POST['isDelete'])){
        $sql = mysqli_query($connect, "DELETE from `terms` WHERE id = '{$_POST['id']}' AND school = '{$_POST['schoolkey']}' AND session_id = '{$_POST['session_id']}'")or die("Could't delete users".mysqli_error($connect));
        if ($sql == 1){
            echo json_encode(array("status" => "success"));
        }
    }
}
//terms by id
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['schoolkey']) && isset($_GET['id'])){
    $sql = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, `term`, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE  id = '{$_GET['id']}' AND school = '{$_GET['schoolkey']}' ORDER BY date_created")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//show all terms in the session
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['schoolkey']) && isset($_GET['sessionid'])){
    $sql = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, `term`, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE  school = '{$_GET['schoolkey']}' AND session_id = '{$_GET['sessionid']}' ORDER BY date_created")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//view test period by term id
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['view_test_period'])){
    $sql = mysqli_query($connect, "SELECT DISTINCT test_period.id, test_period.`school_key`, test_period.`school_level`, test_period.`session`, t.term, `name`, `starting_date`, `end_date`, test_period.`date_created` FROM `test_period` LEFT JOIN terms t on t.id=test_period.term WHERE test_period.term = '{$_GET['termID']}'")or die("Could't fetch data".mysqli_error($connect));
    if (mysqli_num_rows($sql) > 0){
        while ($rows = mysqli_fetch_array($sql)){
            $array[] = $rows;
        }
        echo json_encode($array);
    }else{
        echo json_encode($array);
    }
}

//view test period by period id
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['period_id'])){
    $sql = mysqli_query($connect, "SELECT test_period.id, test_period.`school_key`, test_period.`school_level`, test_period.`session`, t.term, `name`, `starting_date`, `end_date`, test_period.`date_created` FROM `test_period` LEFT JOIN terms t on t.id=test_period.term WHERE test_period.id = '{$_GET['period_id']}'")or die("Could't fetch data".mysqli_error($connect));
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