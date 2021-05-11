<?php
    $connect = mysqli_connect("localhost", "imena","","smsdb") or die("Could't connect to server". mysqli_error());
    $connect->set_charset("utf8");
?>   