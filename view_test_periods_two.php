<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test Period - School Management System</title>
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
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" />
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
                            echo $_SESSION['schoolname']." ".$_SESSION['level']." - ".$_SESSION['academic_year'];
                        }
                        ?></span>
                    <div class="menubox">
                        <span><i class="fa fa-gear"></i> </span>
                    </div>
                </a>
            </div>
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
                        <a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-home"></i> Home</li>
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
                        <li class="active"><i class="fa fa-file"></i> Mark sheet</li>
                        </a>
                        <a href="/schoolreport/accounts.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                        <li><i class="fa fa-users"></i> Accounts</li>
                        </a>
                        <a href="/schoolreport/sitemanagement.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                        <li><i class="fa fa-gears"></i> Site Management</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10" style="padding-left: 0px">
                <div class="content">
                    <div class="row">
                        <?php
                        if ($_SESSION['school']) {
                            //set session
                            if ($_GET['session'] !== null) {
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
                            <input type="hidden" class="form-control permission"
                                   name="permission" value="<?php echo $_SESSION['permission'] ?>">
                            <input type="hidden" class="form-control sessionid"
                                   name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                            <input type="hidden" class="form-control status"
                                   name="status" value="<?php echo $_SESSION['status'] ?>">
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <ol class="breadcrumb">
                                    <li><a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>">Home</a></li>
                                    <li><a href="/schoolreport/markersheet.php?session=<?php echo $_SESSION['sessionid'] ?>">Terms</a></li>
                                    <li class="active">Test Period</li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group" style="float: right;margin-right: 20px; display: flex;">
                                    <button class="btn btn-primary newcourse"><i class="fa fa-plus"></i> New Courses</button>
                                    <button class="btn btn-default newmarks"><i class="fa fa-plus"></i> New Marks</button>
                                    <div class="action-btn">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-print"></i> Print Marks <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="printall"><a href="#"><i class="fa fa-list"></i> All</a></li>
                                                <li class="printbystudent"><a href="#"><i class="fa fa-user"></i> By Student</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span>Courses</span>
                                    <div class="right_add-course">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered" id="myTable-courses">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Max Marks</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span class="titlemarks">Test Marks</span>
                                    <div class="right_add-marks">
                                        <span><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered" id="myTable-marks">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student</th>
                                            <th>Course</th>
                                            <th>Marks</th>
                                            <th>Action</th>
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
        <!--modal for adding courses to test period-->
        <div class="modal fade" id="modalAddCourseTestPeriod" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> Add Course
                        </h4>
                    </div>
                    <form id="submitTestPeriodForm-course">
                        <div class="modal-body">
                            <div class="alert alert-dismissible alert-danger alert-form-danger-test-period-add-course"
                                 role="alert">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <span class="text-alert-test-period-add-course">All fields are required</span>
                            </div>
                            <div class="well">
                                <div class="form-group coursename_group">
                                    <label>Course</label>
                                    <input type="text" class="form-control coursename" name="course">
                                    <small class="courseHelp"></small>
                                </div>
                                <div class="form-group maxmark_group">
                                    <label>Max Mark</label>
                                    <input type="number" class="form-control maxmark" name="maxmark">
                                    <small class="maxmarkHelp"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary submit_course">
                                Submit
                            </button>
                            <button type="submit" class="btn btn-primary updatebtn_course">
                                Update
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>

<!--        marks-->
        <!--modal for adding marks to test period-->
        <div class="modal fade" id="modalAddMarksTestPeriod" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> Add Mark
                        </h4>
                    </div>
                    <form id="submitTestPeriodForm-marks">
                        <div class="modal-body">
                            <div class="alert alert-dismissible alert-danger alert-form-danger-test-period-add-marks"
                                 role="alert">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <span class="text-alert-test-period-add-marks">All fields are required</span>
                            </div>
                            <div class="well">
                                <div class="form-group student_group">
                                    <label>Student</label>
                                    <select type="text" class="form-control student" name="student">
                                        <option>Select student</option>
                                    </select>
                                    <small class="studentHelp"></small>
                                </div>
                                <div class="form-group course_mark_group">
                                    <label>Student</label>
                                    <select type="text" class="form-control course_mark" name="course_mark">
                                        <option>Select Course</option>
                                    </select>
                                    <small class="course_markHelp"></small>
                                </div>
                                <div class="form-group student_mark_group">
                                    <label>Mark</label>
                                    <input type="number" class="form-control student_mark" name="student_mark">
                                    <small class="student_markHelp"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary submit_marks">
                                Submit
                            </button>
                            <button type="submit" class="btn btn-primary updatebtn_mark">
                                Update
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>


        <!--modal for choosing a student-->
        <div class="modal fade" id="modalChooseStudentTestPeriod" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> Choose students
                        </h4>
                    </div>
                    <form id="submitTestPeriodForm-choose">
                        <div class="modal-body">
                            <div class="well">
                                <div class="form-group student_group">
                                    <label>Student</label>
                                    <select type="text" class="form-control student" name="student">
                                        <option>Select student</option>
                                    </select>
                                    <small class="studentHelp"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-primary generate_student_report">
                                Generate
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
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
    <script type="text/javascript" src="js/tableExport.js"></script>
    <script type="text/javascript" src="js/jquery.base64.js"></script>
    <script type="text/javascript" src="js/html2canvas.js"></script>
    <script type="text/javascript" src="js/sprintf.js"></script>
    <script type="text/javascript" src="js/jspdf.js"></script>
    <script type="text/javascript" src="js/base64.js"></script>
    <script type="text/javascript" src="js/FileSaver.min.js"></script>
    <script type="text/javascript" src="js/xlsx.core.min.js"></script>
    <script type="text/javascript" src="js/jspdf.plugin.autotable.js"></script>
    <script src="js/bootstrap-multiselect.js"></script>
    <script src="js/main.js"></script>
    <script src="js/view_test_period.js"></script>

</body>
</html>