<?php
include './controllers/sessions.php';

//reset session
unset($_SESSION['sessionid']);
unset($_SESSION['status']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - School Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/morris.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="container-wraper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/schoolreport/setupaccount.php">
                    <div class="school-logo"></div>
                    <span class="componyname"><?php
                        if ($_SESSION['school'] ){
                            echo $_SESSION['schoolname'];
                        }
                        ?></span>
                    <div class="menubox">
                        <span><i class="fa fa-gear"></i> </span>
                    </div>
                </a></div>
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/schoolreport/setupaccount.php" class="btn-navbar"><i class="fa fa-user"></i> <?php
                            if ($_SESSION['school'] ){
                                echo $_SESSION['fullname'];
                            }
                            ?></a>
                    </li>
                    <li><a href="/schoolreport/logout.php" class="btn-navbar"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="outer-container">
        <div class="row">
            <div class="col-sm-2" style="padding-right: 0px">
                <div class="sidebar">
                    <ul>
                        <a href="/schoolreport/setupaccount.php">
                            <li class="active"><i class="fa fa-home"></i> Home</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10" style="padding-left: 0px">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-info">
                                <p>You are most welcome, <?php if ($_SESSION['school'] ){
                                        echo $_SESSION['fullname'];
                                    }
                                    ?></a></p>
                            </div>
                            <?php
                            if ($_SESSION['school'] ){
                                //set session
                                if (isset($_GET['session']) !== null) {
                                    $_SESSION['sessionid'] = $_GET['session'];
                                }
                                ?>
                                <input type="hidden" class="form-control schoolkey"
                                       name="schoolkey" value="<?php echo $_SESSION['school'] ?>">
                                <input type="hidden" class="form-control schoolname"
                                       name="schoolname" value="<?php echo $_SESSION['schoolname'] ?>">
                                <input type="hidden" class="form-control classname"
                                       name="classname" value="<?php echo $_SESSION['class'] ?>">
                                <input type="hidden" class="form-control sessionid"
                                       name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                <input type="hidden" class="form-control classID"
                                       name="classID" value="<?php echo $_SESSION['classID'] ?>">
                                <input type="hidden" class="form-control school_level"
                                name="school_level" value="<?php echo $_SESSION['school_level'] ?>">
                                <input type="hidden" class="form-control permission"
                                       name="permission" value="<?php echo $_SESSION['permission'] ?>">
                                <input type="hidden" class="form-control sessionid"
                                       name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-12">
                             <div style="margin-bottom: 10px">
                                <a href='/schoolreport/sessions.php?session=<?php echo $_SESSION['sessionid'] ?>' class="btn btn-primary add_session">Add Session</a>
                                <a href='/schoolreport/sitemanagement.php?session=<?php echo $_SESSION['sessionid'] ?>' class="btn btn-default add_school">School</a>
                                <a href='/schoolreport/backup.php' class="btn btn-primary backup_system">Backup System</a>
                            </div>
                            <div class="user-details">
                                <div>
                                    <?php
                                    //get the sessions
                                    if ($_SESSION['school'] ){
                                        ?>
                                        <input type="hidden" class="form-control schoolkey"
                                               name="schoolkey" value="<?php echo $_SESSION['school'] ?>">
                                        <input type="hidden" class="form-control schoolname"
                                               name="schoolname" value="<?php echo $_SESSION['schoolname'] ?>">
                                        <input type="hidden" class="form-control user_key"
                                               name="user_key" value="<?php echo $_SESSION['user_key'] ?>">
                                        <input type="hidden" class="form-control sessionid"
                                               name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                        <input type="hidden" class="form-control classID"
                                               name="classID" value="<?php echo $_SESSION['classID'] ?>">
                                        <input type="hidden" class="form-control permission"
                                               name="permission" value="<?php echo $_SESSION['permission'] ?>">
                                        <input type="hidden" class="form-control sessionid"
                                               name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="alert alert-danger endalertdialog">Warning ! System is temporarily closed .</div>
                                <div class="row sessions"></div>
                            </div>
                            <span class="loader"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="assets/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="assets/bootstrap/js/popper.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="assets/daterangepicker/moment.min.js"></script>
<script src="assets/Chart.min.js"></script>
<!--===============================================================================================-->
<script src="assets/countdowntime/countdowntime.js"></script>
<script src="assets/morris.min.js"></script>
<!--===============================================================================================-->
<script src="js/setupaccount.js"></script>
</body>
</html>