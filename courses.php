<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Courses - School Management System</title>
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
						<?php 
							if($_SESSION['school_level'] != 2){
								?>
									<a href="/schoolreport/subject.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
										<li><i class="fa fa-fighter-jet"></i> Subject</li>
									</a>
								<?php
							}
						?>
                        <a href="/schoolreport/courses.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                            <li class="active"><i class="fa fa-book"></i> Course</li>
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
                    </ul>
                </div>
            </div>
            <div class="col-sm-10" style="padding-left: 0px">
                <div class="content">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>">Home</a></li>
                            <li class="active">Courses</li>
                        </ol>
                        <div class="col-sm-8 panel-data">
                            <div class="action-btn">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-download" aria-hidden="true"></i> Export <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="exportexcel"><a href="#">Excel</a></li>
                                        <li class="exportpdf"><a href="#">PDF</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <a href="/schoolreport/teacher_course.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>" type="button" class="btn btn-success">
                                      Teacher Courses </a>
                                </div>
                            </div>
                            <div class="panel table-responsive">
                                <table class="table table-bordered" id="myTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>School</th>
                                        <th>Subject</th>
                                        <th>Course</th>
                                        <!-- <th>Assistant</th> -->
										<?php 
											if($_SESSION['school_level'] != 2){
												?>
													<th>Max CAT</th>
													<th>Max EXAM</th>
												<?php
											}
										?>
                                        <!-- <th>Passing percentage</th> -->
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-4 form-box">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span>Add course</span>
                                </div>
                                <div class="panel-body">
                                    <form method="post" class="addcourse" id="addcourse">
                                        <div class="modal-body">
                                            <div class="alert alert-dismissible alert-danger alert-form-danger" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                                            </div>
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
                                                <input type="hidden" class="form-control teacher_school_level"
                                                       name="teacher_school_level" value="<?php echo $_SESSION['school_level'] ?>">
                                                <input type="hidden" class="form-control user_key"
                                                       name="user_key" value="<?php echo $_SESSION['user_key'] ?>">
                                                <input type="hidden" class="form-control status"
                                                       name="status" value="<?php echo $_SESSION['status'] ?>">
                                                <input type="hidden" class="form-control email"
                                                       name="email" value="<?php echo $_SESSION['email'] ?>">
                                                <input type="hidden" class="form-control teacher_key"
                                                       name="teacher_key" value="<?php echo $_SESSION['teacher_key'] ?>">
                                                <?php
                                            }
                                            ?>
                                            <div class="form-group form-group-school_level">
                                                <label class="label-school_level">School level:</label>
                                                <select type="text" class="form-control school_level" name="school_level">
                                                    <option>Select level</option>
                                                </select>
                                                <small class="text-danger error-school_level"></small>
                                            </div>
                                            <!-- <div class="form-group form-group-classname">
                                                <label class="label-classname">Class:</label>
                                                <select class="form-control classname" name="classname">
                                                    <option>Select class</option>
                                                </select>
                                                <small class="text-danger error-classname"></small>
                                            </div> -->
                                            <div class="form-group form-group-subjectname">
                                                <label class="label-subjectname">Subject:</label>
                                                <select class="form-control subjectname" name="subjectname">
                                                    <option>Select a subject</option>
                                                </select>
                                                <small class="text-danger error-subjectname"></small>
                                            </div>
                                            <div class="form-group form-group-coursename">
                                                <label class="label-subjectname">Course:</label>
                                                <input type="text" class="form-control coursename" name="coursename" style="text-transform: capitalize"/>
                                                <small class="text-danger error-coursename"></small>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-cat">
                                                        <label class="label-cat">MAX CAT:</label>
                                                        <input type="number" min="0" class="form-control cat" name="cat"/>
                                                        <small class="text-danger error-cat"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group form-group-exam">
                                                        <label class="label-exam">MAX EXAM:</label>
                                                        <input type="text" class="form-control exam" name="exam"/>
                                                        <small class="text-danger error-exam"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-teacher">
                                                <label class="label-teacher">Teacher:</label>
                                                <select class="form-control teacher" name="teacher" style="text-transform: capitalize">
                                                    <option>Select a teacher</option>
                                                </select>
                                                <small class="text-danger error-teacher"></small>
                                            </div>
                                            <!-- <div class="form-group form-group-assistant">
                                                <label class="label-assistant">Assistant:</label>
                                                <select class="form-control assistant" name="assistant" style="text-transform: capitalize">
                                                    <option>Select an assistant</option>
                                                </select>
                                                <small class="text-danger error-assistant"></small>
                                            </div> -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary submit">Submit</button>
                                            <button type="button" class="btn btn-primary updatebtn">Update</button>
                                        </div>
                                    </form>
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
<script type="text/javascript" src="js/tableExport.js"></script>
<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script type="text/javascript" src="js/sprintf.js"></script>
<script type="text/javascript" src="js/jspdf.js"></script>
<script type="text/javascript" src="js/base64.js"></script>
<script type="text/javascript" src="js/FileSaver.min.js"></script>
<script type="text/javascript" src="js/xlsx.core.min.js"></script>
<script type="text/javascript" src="js/jspdf.plugin.autotable.js"></script>
<script src="js/main.js"></script>
<script src="js/course.js"></script>

</body>
</html>