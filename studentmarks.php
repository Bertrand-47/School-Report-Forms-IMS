<?php
include './controllers/sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Marks - School Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="main-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-menus">
                <div class="container-fluid">
                    <nav class="navbar navbar-default navbar-fixed-top">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> SMS <span></span></a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <span class="sr-only">(current)</span></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-folder-open" aria-hidden="true"></i> Class <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/schoolreport/manageClasses.php">Manage Class</a></li>
                                            <li><a href="/schoolreport/manageSection.php">Manage Section</a></li>
                                            <li><a href="/schoolreport/manageSubjects.php">Manage Subjects</a></li>
                                            <li><a href="/schoolreport/manageCourses.php">Manage Courses</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown active">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i> Student <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="/schoolreport/students.php">Manage Student</a></li>
                                            <li><a href="/schoolreport/studentmarks.php">Student marks</a></li>
                                            <li><a href="/schoolreport/parents.php">Parents</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="/schoolreport/teacher.php"><i class="fa fa-briefcase" aria-hidden="true"></i> Teacher</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-text" aria-hidden="true"></i> Markersheet <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-clock-o" aria-hidden="true"></i> Attendance <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-credit-card" aria-hidden="true"></i> Accounting <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="main-container">
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Manage Teacher</h3>
                        </div>
                        <div class="panel-body">
                            <div class="action-btn">
                                <button class="btn btn-default open-modal" data-toggle="modal" data-target="#addTeacher"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Teacher</button>
                            </div>
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone number</th>
                                    <th>Email</th>
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
        <!--        modals-->
        <div class="modal" id="addTeacher" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Add Student</h3>
                    </div>
                    <form method="post" class="addteacher">
                        <div class="modal-body">
                            <div class="alert alert-dismissible alert-danger alert-form-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="text-alert">All data should be corrected please check the red and enter correct data.</span>
                            </div>
                            <div class="form-group form-group-fname">
                                <label class="label-fname">Profile image:</label>
                                <input type="file" class="form-control profile-image" name="profile-image">
                                <small class="text-danger error-profile-image"></small>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-group-fname">
                                        <label class="label-fname">Firstname:</label>
                                        <input type="text" class="form-control fname" name="fname">
                                        <small class="text-danger error-fname"></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-group-lname">
                                        <label class="label-fname">Lastname:</label>
                                        <input type="text" class="form-control lname" name="lname">
                                        <small class="text-danger error-lname"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-phone">
                                <label class="label-phone">Class:</label>
                                <select type="text" class="form-control class" name="class"></select>
                                <small class="error-class text-danger"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary submit">Submit</button>
                            <button type="button" class="btn btn-primary updatebtn">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===============================================================================================-->
<script src="assets/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="assets/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="assets/bootstrap/js/popper.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--===============================================================================================-->
<script src="assets/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="assets/daterangepicker/moment.min.js"></script>
<script src="assets/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="assets/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="js/teacher.js"></script>
<!--===============================================================================================-->

</body>
</html>