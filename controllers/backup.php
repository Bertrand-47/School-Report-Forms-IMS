<?php

    //header
    header('Content-Type: application/json');

    //connect to DB
    if(file_exists("../controllers/database/connection.php")){
        require_once("../controllers/database/connection.php");
    }

    $array = array();
    //MySQL server and database
    $dbhost = 'localhost';
    $dbuser = 'imena';
    $dbpass = '';
    $dbname = 'smsDB';
    $tables = '*';
    $tables_session = false;

    //receive the requests
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //do the logic part
        if(isset($_POST['all'])){
            //backup all tables
            backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);
        }else if (isset($_POST['sessionID'])) {
            backup_Session_tables($dbhost, $dbuser, $dbpass, $dbname, $tables_session);
        }else if (isset($_POST['isDelete']) && isset($_POST['id'])) {
            //select file
            $sql = mysqli_query($connect,"SELECT `filename` FROM `database_backups` WHERE id='{$_POST['id']}' LIMIT 1");
            if (mysqli_num_rows($sql) == 1) {

                $rows = mysqli_fetch_array($sql);
                $filepath = './database/backup/'.$rows['filename'];
                if (is_file($filepath))
                {
                    unlink($filepath);

                    //delete from databse
                    $sql = mysqli_query($connect, "DELETE FROM `database_backups` WHERE id='{$_POST['id']}'");

                    if ($sql == 1) {
                        echo json_encode(array("status" => "success"));
                    }
                }
            }
        }else if (isset($_POST['isRestore']) && isset($_POST['r_id']) && isset($_POST['_all'])){
            restoreAllDB($connect,$_POST['r_id']);
        }else if (isset($_POST['isRestore']) && isset($_POST['r_id']) && isset($_POST['isSessionExist'])){
            restoreSessionDB($connect,$_POST['r_id'],$_POST['sessionID']);
        }
      }

      //Core function
    function backup_tables($host, $user, $pass, $dbname, $tables = '*') {
        $link = mysqli_connect($host,$user,$pass, $dbname);

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }

        mysqli_query($link, "SET NAMES 'utf8'");

        //get all of the tables
        if($tables == '*')
        {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        $return = '';
        //cycle through
        foreach($tables as $table)
        {
            $result = mysqli_query($link, 'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);
            $num_rows = mysqli_num_rows($result);

            $return.= 'DROP TABLE IF EXISTS '.$table.';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
            $counter = 1;

            //Over tables
            for ($i = 0; $i < $num_fields; $i++) 
            {   //Over rows
                while($row = mysqli_fetch_row($result))
                {   
                    if($counter == 1){
                        $return.= 'INSERT INTO '.$table.' VALUES(';
                    } else{
                        $return.= '(';
                    }

                    //Over fields
                    for($j=0; $j<$num_fields; $j++) 
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }

                    if($num_rows == $counter){
                        $return.= ");\n";
                    } else{
                        $return.= "),\n";
                    }
                    ++$counter;
                }
            }
            $return.="\n\n\n";
        }

        //save file
        $fileName = './database/backup/allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql';
        $handle = fopen($fileName,'w+');
        fwrite($handle,$return);
        if(fclose($handle)){
            //save file to db
            saveBackupToDB($link,'allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql',"http://localhost/schoolreport/controllers/database/backup/".'allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql');
            exit; 
        }
    }

    function backup_Session_tables($host, $user, $pass, $dbname, $tables = false) {
        $link = mysqli_connect($host,$user,$pass, $dbname);

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }

        mysqli_query($link, "SET NAMES 'utf8'");

        //get all of the tables

        $sql = mysqli_query($link, "SELECT DISTINCT TABLE_NAME, COLUMN_NAME 
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE COLUMN_NAME IN ('session','session_id')
            AND TABLE_SCHEMA='smsDB'");

        if($tables == false)
        {
            $tables = array();
            while($row = mysqli_fetch_row($sql))
            {
                $tables[] = $row[0];
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        $return = '';

        //working here later

        //save file
        // $fileName = './database/backup/allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql';
        // $handle = fopen($fileName,'w+');
        // fwrite($handle,$return);
        // if(fclose($handle)){
        //     //save file to db
        //     saveBackupToDB($link,'allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql',"http://localhost:8888/schoolreport/controllers/database/backup/".'allTables-'.time().'-'.(md5(implode(',',$tables))).'.sql');
        //     exit; 
        // }
    }

    function saveBackupToDB($connect,$fileName, $url){
        if(isset($_POST['all'])){
            $sql = mysqli_query($connect, "INSERT INTO `database_backups`(`id`, `schoolkey`, `session`, `filename`, `file_url`, `date_created`) VALUES (0,'{$_POST['schoolkey']}',0,'$fileName','$url',NOW())") or die("Could't insert data".mysqli_error($connect));
            if ($sql == 1) {
                echo json_encode(array("status" => "success"));
            }
        }else if (isset($_POST['sessionID'])) {
            $sql = mysqli_query($connect, "INSERT INTO `database_backups`(`id`,`schoolkey`, `session`, `filename`, `file_url`, `date_created`) VALUES (0,'{$_POST['schoolkey']}','{$_POST['sessionID']}','$fileName','$url',NOW())") or die("Could't insert data".mysqli_error($connect));
            if ($sql == 1) {
                echo json_encode(array("status" => "success"));
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        //do the logic part
        if(isset($_GET['all'])){
            
            //backup all FILES
            $sql = mysqli_query($connect, "SELECT `id`, `schoolkey`, `session`, `filename`, `file_url`, `date_created` FROM `database_backups` WHERE schoolkey='{$_GET['schoolkey']}'")or die("Could't fetch data".mysqli_error($connect));
            if (mysqli_num_rows($sql) > 0){
                while ($rows = mysqli_fetch_array($sql)){
                    $array[] = $rows;
                }
                echo json_encode($array);
            }else{
                echo json_encode($array);
            }

        }else if (isset($_POST['sessionID'])) {
            # code...
            $sql = mysqli_query($connect, "SELECT `id`, `schoolkey`, `session`, `filename`, `file_url`, `date_created` FROM `database_backups` WHERE session='{$_GET['sessionID']}'")or die("Could't fetch data".mysqli_error($connect));
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

  function restoreAllDB($connect,$id){
    //select file
    $sql = mysqli_query($connect,"SELECT `filename` FROM `database_backups` WHERE id='{$_POST['r_id']}' LIMIT 1");

    if (mysqli_num_rows($sql) == 1) {

        $rows = mysqli_fetch_array($sql);
        $filepath = './database/backup/'.$rows['filename'];
        echo json_encode(array("status" => restoreMysqlDB($filepath, $connect)));
    }
  }

  function restoreMysqlDB($filePath, $conn)
    {
        $sql = '';
        $error = '';
        
        if (file_exists($filePath)) {
            $lines = file($filePath);
            
            foreach ($lines as $line) {
                
                // Ignoring comments from the SQL script
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                
                $sql .= $line;
                
                if (substr(trim($line), - 1, 1) == ';') {
                    $result = mysqli_query($conn, $sql);
                    if (! $result) {
                        $error .= mysqli_error($conn) . "\n";
                    }
                    $sql = '';
                }
            } // end foreach
            
            if ($error) {
                $response = array(
                    "type" => "error",
                    "message" => $error
                );
            } else {
                $response = array(
                    "type" => "success",
                    "message" => "Database Restore Completed Successfully."
                );
            }
        } // end if file exists
        return $response;
    }

  function restoreSessionDB(){

  }
?>