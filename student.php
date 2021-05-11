<?php
include './controllers/sessions.php';
$result='';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student - School Management System</title>
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
                        <a href="/schoolreport/sessions.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-clock-o"></i> Session</li>
                        </a>
                        <a href="/schoolreport/class.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
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
                        <a href="/schoolreport/courses.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-book"></i> Course</li>
                        </a>
                        <a href="/schoolreport/student.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li class="active"><i class="fa fa-user-circle"></i> Student</li>
                        </a>
                        <a href="/schoolreport/teacher.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-briefcase"></i> Teacher</li>
                        </a>
                        <a href="/schoolreport/markersheet.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-file"></i> Mark sheet</li>
                        </a>
                        <a href="/schoolreport/accounts.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
                            <li><i class="fa fa-users"></i> Accounts</li>
                        </a>
                        <a href="/schoolreport/sitemanagement.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
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
                            <li class="active">Students</li>
                        </ol>
                        <div class="col-sm-12 form-box">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <span>Add student</span>
                                </div>
                                <div class="panel-body">
                                    <form method="post" class="addstudent">
                                        <div class="modal-body">
                                            <div class="alert alert-dismissible alert-danger alert-form-danger" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                                            </div>
                                            <div class="row">
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
                                                    <input type="hidden" class="form-control status"
                                                           name="status" value="<?php echo $_SESSION['status'] ?>">
                                                    <input type="hidden" class="form-control teacher_id"
                                                       name="status" value="<?php echo $_SESSION['teacher_id'] ?>">
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-firstname">
                                                        <label class="label-school_level">School level (*):</label>
                                                        <select type="text" class="form-control school_level" name="school_level"></select>
                                                        <small class="text-danger error-school_level"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-firstname">
                                                        <label class="label-firstname">Firstname (*):</label>
                                                        <input type="text" class="form-control firstname" name="firstname">
                                                        <small class="text-danger error-firstname"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-lastname">
                                                        <label class="label-lastname">Lastname (*):</label>
                                                        <input type="text" class="form-control lastname" name="lastname">
                                                        <small class="text-danger error-lastname"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-datebth">
                                                        <label class="label-datebth">Date of birth:</label>
                                                        <input type="date" class="form-control datebth" name="datebth">
                                                        <small class="text-danger error-datebth"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-gender">
                                                        <label class="label-gender">Gender:</label>
                                                        <select type="date" class="form-control gender" name="gender">
                                                            <option>Select gender</option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                        <small class="text-danger error-gender"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-classname">
                                                        <label class="label-classname">Class (*):</label>
                                                        <select type="text" class="form-control classname" name="classname">
                                                            <option>Select class</option>
                                                        </select>
                                                        <small class="error-classname text-danger"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-fathername">
                                                        <label class="label-fathername">Father name:</label>
                                                        <input type="text" class="form-control fathername" name="fathername">
                                                        <small class="text-danger error-fathername"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-mothername">
                                                        <label class="label-mothername">Mother name:</label>
                                                        <input type="text" class="form-control mothername" name="mothername">
                                                        <small class="text-danger error-mothername"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-phonenumber">
                                                        <label class="label-phonenumber">Phone number:</label>
                                                        <input type="text" class="form-control phonenumber" name="phonenumber">
                                                        <small class="text-danger error-phonenumber"></small>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-group-address">
                                                        <label class="label-address">Address:</label>
                                                        <input type="text" class="form-control address" name="address">
                                                        <small class="text-danger error-address"></small>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary submit">Submit</button>
                                            <button type="button" class="btn btn-primary updatebtn">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="action-btn">
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Export <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="exportexcel"><a href="#">Excel</a></li>
                                                <li class="exportpdf"><a href="#">PDF</a></li>
                                            </ul>
                                        </div>
                                        <button type="button" class="btn btn-primary upload_student" >
                                            <i class="fa fa-upload"></i> Import
                                        </button>
                                     </div>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="myTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Class</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Father</th>
                                            <th>Mother</th>
                                            <th>Parent contact</th>
                                            <th>Address</th>
                                            <th class="buttons">Action</th>
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

        <!-- upload student modal -->
        <div class="modal fade" id="upload_student_modal" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Upload Students</h4>
              </div>
              <div class="modal-body">
                <span>Make sure it follows the following format</span>
                <div class="alert alert-info format-excel table-responsive">
                  <table class="table table-bordered">
				     <thead>
					  <tr>
						<td>#</td>
						<td>Firstname</td>
						<td>Lastname</td>
						<td>Class</td>
						<td>Date of birth</td>
						<td>Gender</td>
						<td>Father</td>
						<td>Mother</td>
						<td>Guardian Number</td>
						<td>Address</td>
					  </tr>
					  <thead>
					  <tbody>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					  </tbody>
				  </table>
                </div>
                <div class="alert alert-success">
                  <form enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Upload file</label>
                      <input type="file" class="form-control file-excel" accept=".csv">
                      <small>Only support (.csv)</small>
                    </div>
                  </form>
                </div>
              </div>
              <div id="progress-wrp">
              <div class="progress-bar"></div>
                  <div class="status">0%</div>
              </div>
            </div><!-- /.modal-content -->
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
<script src="js/student.js"></script>

</body>
</html>
