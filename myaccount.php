<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Account - School Management System</title>
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
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#example-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
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
                    <li class="active"><a href="/schoolreport/setupaccount.php" class="btn-navbar"><i class="fa fa-user"></i> <?php
                            if ($_SESSION['school'] ){
                                echo $_SESSION['fullname'];
                            }
                            ?></a>
                    </li>
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-defaultnavbar dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> Session <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu sessionmenus"></ul>
                        </div>
                    </li>
                    <li><a href="/schoolreport/sitemanagement.php" class="btn-navbar"><i class="fa fa-sign-out"></i> Site Management</a></li>
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
                        <a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>">
                            <li><i class="fa fa-home"></i> Home</li>
                        </a>
                        <a href="/schoolreport/sessions.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-clock-o"></i> Session</li>
                        </a>
                        <a href="/schoolreport/class.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-building"></i> Class</li>
                        </a>
                        <a href="/schoolreport/subject.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-fighter-jet"></i> Subject</li>
                        </a>
                        <a href="/schoolreport/courses.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-book"></i> Course</li>
                        </a>
                        <a href="/schoolreport/student.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-user-circle"></i> Student</li>
                        </a>
                        <a href="/schoolreport/teacher.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-briefcase"></i> Teacher</li>
                        </a>
                        <a href="/schoolreport/markersheet.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-file"></i> Mark sheet</li>
                        </a>
                        <a href="/schoolreport/accounts.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li class="active"><i class="fa fa-users"></i> Accounts</li>
                        </a>
                        <a href="/schoolreport/sitemanagement.php?session=<?php echo $_SESSION['sessionid'] ?>"">
                            <li><i class="fa fa-gears"></i> Site Management</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10" style="padding-left: 0px">
                <div class="content">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">My Account</li>
                        </ol>
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <form method="post" class="savedata">
                                                <div class="alert alert-dismissible alert-danger alert-form-danger" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <?php
                                                        if ($_SESSION['school'] ){
                                                            ?>
                                                            <input type="hidden" class="form-control schoolkey"
                                                                   name="schoolkey" value="<?php echo $_SESSION['school'] ?>">
                                                            <input type="hidden" class="form-control schoolname"
                                                                   name="schoolname" value="<?php echo $_SESSION['schoolname'] ?>">
                                                            <input type="hidden" class="form-control classID"
                                                                   name="classID" value="<?php echo $_SESSION['classID'] ?>">
                                                            <input type="hidden" class="form-control permission"
                                                                   name="permission" value="<?php echo $_SESSION['permission'] ?>">
                                                            <input type="hidden" class="form-control sessionid"
                                                                   name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                                            <input type="hidden" class="form-control school_level"
                                                                   name="school_level" value="<?php echo $_SESSION['school_level'] ?>">
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="label-startdate">Names</label>
                                                            <input type="text" class="form-control names"
                                                                   name="names">
                                                            <span class="text-danger error-names"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="label-email">Email / Phone number</label>
                                                            <input type="text" class="form-control email"
                                                                   name="email">
                                                            <span class="text-danger error-email"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label class="label-permission">Permission</label>
                                                        <select class="form-control permission"
                                                                name="permission">
                                                            <option>Select permission level</option>
                                                            <option>Administrator</option>
                                                            <option>Teacher</option>
                                                            <option>Accountant</option>
                                                        </select>
                                                        <span class="text-danger error-permission"></span>
                                                    </div>
                                                    <div class="col-sm-6 changepasswordbox">
                                                        <div class="form-group">
                                                            <label class="label-changepassword">Change Password</label>
                                                            <input type="password" class="form-control changepassword"
                                                                   name="changepassword">
                                                            <span class="text-danger error-changepassword"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group classnamebx" style="display: none">
                                                    <label class="label-classname">Class name</label>
                                                    <select class="form-control classname"
                                                            name="classname">
                                                        <option>Select class</option>
                                                    </select>
                                                    <span class="text-danger error-classname"></span>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary updatebtn">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <button type="button" class="btn btn-danger deleteaccount">DELETE ACCOUNT</button>
                                </div>
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
<!--===============================================================================================-->
<script src="assets/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<!--<script src="js/account.js"></script>-->
<script src="js/main.js"></script>
<script src="js/myaccount.js"></script>

</body>
</html>