<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mark sheet - School Management System</title>
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
    <link rel="stylesheet" href="assets/bootstrap-datepicker.min.css"/>
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
                        if ($_SESSION['school']) {
                            echo $_SESSION['schoolname'] . " " . $_SESSION['level'] . " - " . $_SESSION['academic_year'];
                        }
                        ?></span>
                    <div class="menubox">
                        <span><i class="fa fa-gear"></i> </span>
                    </div>
                </a></div>
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/schoolreport/setupaccount.php" class="btn-navbar"><i class="fa fa-user"></i> <?php
                            if ($_SESSION['school']) {
                                echo $_SESSION['fullname'];
                            }
                            ?></a>
                    </li>
                    <li><a href="/schoolreport/logout.php" class="btn-navbar"><i class="fa fa-sign-out"></i> Logout</a>
                    </li>
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
                            <input type="hidden" class="form-control teacher_id"
                                name="status" value="<?php echo $_SESSION['teacher_id'] ?>">
                            <?php
                        }
                        ?>
                        <div class="col-sm-12">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active">
                                    <a href="#home" data-toggle="tab"> Manage Terms
                                    </a></li>
                                <li><a href="#marks_box" data-toggle="tab">Manage Marks</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="home">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-dismissible alert-danger alert-form-danger"
                                                 role="alert">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                                            </div>
                                            <div class="panel  form-box">
                                                <div class="panel-body">
                                                    <form method="post" class="add" id="addTermForm">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-group-attendancetype">
                                                                    <label class="label-term">Term</label>
                                                                    <select class="form-control term"
                                                                            name="term">
                                                                        <option>Choose term</option>
                                                                        <option>Term 1</option>
                                                                        <option>Term 2</option>
                                                                        <option>Term 3</option>
                                                                    </select>
                                                                    <span class="text-danger error-term"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-group-startdate">
                                                                    <label class="label-date">Starting Date</label>
                                                                    <input type="text" class="form-control startdate"
                                                                           name="startdate"
                                                                           style="color: #000; font-size: 14px"/>
                                                                    <span class="text-danger error-startdate"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group form-group-enddate">
                                                                    <label class="label-date">Ending Date</label>
                                                                    <input type="text" class="form-control enddate"
                                                                           name="enddate"
                                                                           style="color: #000; font-size: 14px"/>
                                                                    <span class="text-danger error-enddate"></span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" style="border: 0px">
                                                                <button type="submit" class="btn btn-primary submit">
                                                                    Submit
                                                                </button>
                                                                <button type="button" class="btn btn-primary updatebtn">
                                                                    Update
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <table class="table table-bordered" id="myTable">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Term</th>
                                                            <th>Start date</th>
                                                            <th>End Date</th>
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
                                <div class="tab-pane fade" id="marks_box">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="btn-group">
                                                <button type="button"
                                                        class="btn btn-default addMarksforMultipleStudent">
                                                    <i class="fa fa-plus" aria-hidden="true"></i> Add Students Marks
                                                </button>
                                            </div>
                                            <table class="table table-bordered" id="MarksTable">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Class</th>
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
            </div>
            <div class="modal fade" id="myModalComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"> Add Comment
                </h4> </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <textarea cols=4 rows=4 class="form-control comment" id='comment'></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary submitcomment">
                            Submit
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!-- remarques -->
        <div class="modal fade" id="myRemarqueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"> Add Remarque
                </h4> </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <textarea cols=4 rows=4 class="form-control remarques" id='remarques'></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-primary submitremarques">
                            Submit
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
        <!-- //Average -->
        <div class="modal fade" id="myModalAverage" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"><div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel student_name">
            </h4> </div>
                <div class="modal-body">
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>Course</th>
                          <th>MAX CAT</th>
                          <th>MAX EXAM</th>
                          <th>CAT</th>
                          <th>EXAM</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody class="averageData"></<tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
      </div>
        </div>
    </div>

    <!--add marks on single account for primary-->
    <div class="modal fade" id="myModalMarks" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel student_name">Add Marks</h4>
            </div>
            <div class="modal-body">
                <table class='table table-bordered'>
                  <thead>
                    <tr>
                      <th>Course</th>
                      <th>MAX CAT</th>
                      <th>MAX EXAM</th>
                      <th>CAT</th>
                      <th>EXAM</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="averageData"></<tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary generate_report_single">Generate Report
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
    </div>
    <!--add marks on single account for primary-->
    <div class="modal fade" id="myModalMarksNursery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"><div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel student_name">Add Marks</h4>
            </div>
            <div class="modal-body">
                <table class='table table-bordered'>
                  <thead>
                    <tr>
                      <th>Course</th>
                      <th>MARK</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="averageData"></<tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary generate_report_single">Generate Report
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
  <script src="assets/bootstrap-datepicker.min.js"></script>
  <script src="js/markersheet.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
