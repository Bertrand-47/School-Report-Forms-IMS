<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Backup - School Management System</title>
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
                            echo $_SESSION['schoolname']." ".$_SESSION['level'];
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
                        <div class="unpermitted_menus">
                            <a href="/schoolreport/setupaccount.php">
                                <li class="active"><i class="fa fa-home"></i> Home</li>
                            </a>
                        </div>
                        <div class="permitted_menus">
                            <a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                                <li class="active"><i class="fa fa-home"></i> Home</li>
                            </a>
                            <a href="/schoolreport/sessions.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-clock-o"></i> Session</li>
                            </a>
                            <a href="/schoolreport/class.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-building"></i> Class</li>
                            </a>
                            <a href="/schoolreport/subject.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-fighter-jet"></i> Subject</li>
                            </a>
                            <a href="/schoolreport/courses.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-book"></i> Course</li>
                            </a>
                            <a href="/schoolreport/student.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-user-circle"></i> Student</li>
                            </a>
                            <a href="/schoolreport/teacher.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-briefcase"></i> Teacher</li>
                            </a>
                            <a href="/schoolreport/markersheet.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-file"></i> Mark sheet</li>
                            </a>
                            <a href="/schoolreport/accounts.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-users"></i> Accounts</li>
                            </a>
                            <a href="/schoolreport/sitemanagement.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li><i class="fa fa-gears"></i> Site Management</li>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10" style="padding-left: 0px">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-info">
                                <p>Backup / Restore data for selected session</p>
                            </div>
                            <?php
                            if ($_SESSION['school'] ){
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
                                <input type="hidden" class="form-control permission"
                                       name="permission" value="<?php echo $_SESSION['permission'] ?>">
                                <input type="hidden" class="form-control sessionid"
                                       name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-12">
                             <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-default btn-lg backup">BACKUP</button>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <input type="file" name="choosefile" multiple="true" class="form-control input-lg">
                                    <button class="btn btn-primary btn-lg btn-block">RESTORE</button>
                                </div> -->
                             </div>
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px">
                            <div class="panel">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>File Name</th>
                                            <th>URL</th>
                                            <th>Date Backup</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
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
<script src="js/backup.js"></script>
</script>
</body>
</html>