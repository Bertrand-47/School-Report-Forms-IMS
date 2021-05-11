<?php
    session_start();
    if (empty($_SESSION['user_key']) && empty($_SESSION['email']) && empty($_SESSION['isLogin'])){
        include "logout.php";
    }
?>