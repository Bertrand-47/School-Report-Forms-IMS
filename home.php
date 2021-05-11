<?php
include './controllers/sessions.php';
include("./fusioncharts.php");
require_once("./controllers/database/connection.php");

$total_student = 0;
$total_teacher=0;
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
    <script type="text/javascript" src="./js/Chart.min.js"></script>
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
                            <li class="active"><i class="fa fa-home"></i> Home</li>
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
                            <li><i class="fa fa-user-circle"></i> Student</li>
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
                        <div class="col-sm-12">
                            <div class="alert alert-info">
                                <p>You are most welcome, <?php if ($_SESSION['school'] ){
                                        echo $_SESSION['fullname'];
                                    }
                                    ?></a></p>
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
                                       name="school_level" value="<?php echo $_SESSION['school_level'] ?>">
                                <input type="hidden" class="form-control school_level"
                                       name="permission" value="<?php echo $_SESSION['permission'] ?>">
                                <input type="hidden" class="form-control sessionid"
                                       name="sessionid" value="<?php echo $_SESSION['sessionid'] ?>">
                                <input type="hidden" class="form-control teacher_id"
                                    name="status" value="<?php echo $_SESSION['teacher_id'] ?>">
                                <input type="hidden" class="form-control teacher_key"
                                    name="status" value="<?php echo $_SESSION['teacher_key'] ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-12">
                             <div class="row">
                                <!-- active student -->
                                <div class="col-sm-3">
                                    <div class='panel panel1'>
                                        <?php
                                            if($_SESSION['teacher_id'] != '' && $_SESSION['permission'] == 'Teacher'){
                                                //total students
                                                $sql_st = mysqli_query($connect, "SELECT DISTINCT COUNT(students.`id`) AS total_student FROM `students`
                                                LEFT JOIN classes c ON c.id = students.classname
                                                LEFT JOIN teacher_classes tc ON tc.classID = students.classname
                                                LEFT JOIN school_levels sl ON sl.id = students.school_level
                                                WHERE tc.teacher_key = '{$_SESSION['teacher_id']}'
                                                AND students.session = '{$_SESSION['sessionid']}'
                                                AND students.school_level='{$_SESSION['school_level']}'") or die("Erro count student".mysqli_error($connect));
                                                if(mysqli_num_rows($sql_st) > 0){
                                                    $rows = mysqli_fetch_array($sql_st);
                                                    $total_student = $rows['total_student'];
                                                }
                                            }
                                            else{
                                                //total students
                                                $sql_st = mysqli_query($connect, "SELECT COUNT(`id`) AS total_student FROM `students` WHERE students.school_level='{$_GET['school_level']}' AND students.session='{$_GET['session']}'") or die("Erro count student".mysqli_error($connect));
                                                if(mysqli_num_rows($sql_st) > 0){
                                                    $rows = mysqli_fetch_array($sql_st);
                                                    $total_student = $rows['total_student'];
                                                }
                                            }
                                        ?>
                                        <span class='count'><?php echo $total_student ?></span>
                                        <span class='title'>
                                            <?php if($total_student > 1){
                                                echo "Students";
                                            }else{
                                                echo "Student";
                                            }
                                            ?></span>
                                    </div>
                                </div>

                                <!-- total teacher -->
                                <div class="col-sm-3">
                                    <div class='panel panel2'>
                                        <?php
                                            if($_SESSION['teacher_id'] != '' && $_SESSION['permission'] == 'Teacher'){
                                                //total teacher
                                                $sql_st = mysqli_query($connect, "SELECT COUNT(DISTINCT teacher_key) AS total_teacher FROM teachers WHERE teachers.school_level='{$_GET['school_level']}' AND teachers.id='{$_SESSION['teacher_id']}' AND teachers.session='{$_GET['session']}'") or die("Erro count teacher".mysqli_error($connect));
                                                if(mysqli_num_rows($sql_st) > 0){
                                                    $rows = mysqli_fetch_array($sql_st);
                                                    $total_teacher = $rows['total_teacher'];
                                                }
                                            }else{
                                                //total teacher
                                                $sql_st = mysqli_query($connect, "SELECT  COUNT(DISTINCT teacher_key) AS total_teacher FROM teachers WHERE teachers.school_level='{$_GET['school_level']}' AND teachers.session='{$_GET['session']}'") or die("Erro count teacher".mysqli_error($connect));
                                                if(mysqli_num_rows($sql_st) > 0){
                                                    $rows = mysqli_fetch_array($sql_st);
                                                    $total_teacher = $rows['total_teacher'];
                                                }
                                            }
                                        ?>
                                        <span class='count'><?php echo $total_teacher ?></span>
                                        <span class='title'>
                                            <?php if($total_teacher > 1){
                                                echo "Teachers";
                                            }else{
                                                echo "Teacher";
                                            }
                                            ?></span>
                                    </div>
                                </div>

                                <!-- total course, subject -->
                              <div class="col-sm-3">
                                <div class='panel panel4'>
                                    <ul class="list_panel list-group">
                                        <li class='list-group-item'>Academic Year: <?php echo $_SESSION['academic_year'] ?></li>
                                        <?php
                                            //session dates
                                            $sql_st = mysqli_query($connect, "SELECT `academic_year`, `startdate`, `enddate` FROM `sessions` WHERE sessions.id='{$_GET['session']}'") or die("Erro count session".mysqli_error($connect));
                                            if(mysqli_num_rows($sql_st) > 0){
                                                $rows = mysqli_fetch_array($sql_st);
                                                ?><li class='list-group-item'><?php echo $rows['startdate'] ?> - <?php echo $rows['enddate'] ?></li><?php
                                            }
                                        ?>
                                    </ul>
                                </div>
                              </div>

                              <!-- total student marks -->
                              <div class="col-sm-3">
                                <div class='panel panel3'>
                                    <?php
                                        //total teacher
                                        if($_SESSION['classID'] != '' && $_SESSION['permission'] == 'Teacher'){
                                            $sql_st = mysqli_query($connect, "SELECT COUNT(`id`) AS total_courses FROM courses WHERE courses.school_level='{$_GET['school_level']}' AND courses.teacher='{$_SESSION['classID']}' AND courses.session='{$_GET['session']}'") or die("Erro count teacher".mysqli_error($connect));
                                            if(mysqli_num_rows($sql_st) > 0){
                                                $rows = mysqli_fetch_array($sql_st);
                                                $total_courses = $rows['total_courses'];
                                                ?>
                                                    <span class='count'><?php echo $total_courses ?></span>
                                                    <span class='title'>
                                                        <?php if($total_teacher > 1){
                                                            echo "Courses";
                                                        }else{
                                                            echo "Course";
                                                        }
                                                        ?></span>
                                                <?php
                                            }
                                        }
                                        else{
                                            $sql_st = mysqli_query($connect, "SELECT COUNT(`id`) AS total_courses FROM courses WHERE courses.school_level='{$_GET['school_level']}'  AND courses.session='{$_GET['session']}'") or die("Erro count teacher".mysqli_error($connect));
                                            if(mysqli_num_rows($sql_st) > 0){
                                                $rows = mysqli_fetch_array($sql_st);
                                                $total_courses = $rows['total_courses'];
                                                ?>
                                                    <span class='count'><?php echo $total_courses ?></span>
                                                    <span class='title'>
                                                        <?php if($total_teacher > 1){
                                                            echo "Courses";
                                                        }else{
                                                            echo "Course";
                                                        }
                                                        ?></span>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                              </div>
                        </div>
                        <?php 
                            if (isset($_GET['school_level'])) {
                                if ($_GET['school_level'] == 1) {
                                    ?>
                                        <div class="col-sm-12" style='padding-left: 0; padding-right: 0'>
                                            <?php
                                                if ($_SESSION['school'] ){
                                                    ?>
                                                    <input type="hidden" class="form-control schoolname"
                                                           name="schoolname" value="<?php echo $_SESSION['school'] ?>">
                                                    <?php
                                                }
                                            ?>
                                            <div class="row">
                                              <div class="col-sm-12">
                                                <div class="panel panel-default">

                                                    <div class="panel-heading">
                                                      <center class='row'>
                                                        <div class="col-sm-4">
                                                          <div class="form-group">
                                                            <select class="form-control term">
                                                              <!-- terms -->
                                                              <?php
                                                                $sql_terms = mysqli_query($connect, "SELECT `id`, `term` FROM `terms` WHERE session_id = '{$_GET['session']}'") or die("Erro count TERMS ".mysqli_error($connect));
                                                                if(mysqli_num_rows($sql_terms) > 0){
                                                                    ?><option value="all_terms"> All Terms </option> <?php
                                                                    while($row = mysqli_fetch_array($sql_terms)){
                                                                      ?>
                                                                      <option value="<?php echo  $row['id'] ?>"> <?php echo $row['term'] ?> </option>

                                                                      <?php
                                                                    }
                                                                }else{
                                                                  ?><option> No Term Available </option><?php
                                                                }
                                                              ?>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                          <div class="form-group">
                                                            <select class="form-control course">
                                                              <!-- courses -->
                                                              <?php
                                                                $sql_course = mysqli_query($connect, "SELECT `id`, `coursename` FROM `courses` WHERE session = '{$_GET['session']}'") or die("Erro count TERMS ".mysqli_error($connect));
                                                                if(mysqli_num_rows($sql_course) > 0){
                                                                    ?><option value="all_courses"> All Courses </option> <?php
                                                                    while($row = mysqli_fetch_array($sql_course)){
                                                                      ?>
                                                                      <option value="<?php echo  $row['id'] ?>"> <?php echo $row['coursename'] ?> </option>

                                                                      <?php
                                                                    }
                                                                }else{
                                                                  ?><option> No Term Available </option><?php
                                                                }
                                                              ?>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                          <div class="form-group">
                                                            <select class="form-control class">
                                                              <!-- classes -->
                                                              <?php
                                                                $sql_class = mysqli_query($connect, "SELECT DISTINCT  classes.`id`, `numbericname`, sl.level, section FROM `classes` LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.session = '{$_GET['session']}' AND classes.classname = '{$_GET['school_level']}'") or die("Erro count TERMS ".mysqli_error($connect));
                                                                if(mysqli_num_rows($sql_class) > 0){
                                                                    ?><option value="all_classes"> All Classes </option> <?php
                                                                    while($row = mysqli_fetch_array($sql_class)){
                                                                      $cname = '';
                                                                      if ($row['level'] == 'Primary') {
                                                                        $cname = 'P'.$row['numbericname'].$row['section'];
                                                                      }else if($row['level'] == 'Nursery'){
                                                                        $cname = 'N'.$row['numbericname'].$row['section'];
                                                                      }
                                                                      ?>
                                                                        <option value="<?php echo  $row['id'] ?>" style="text-transform: uppercase"> <?php echo $cname ?> </option>
                                                                      <?php
                                                                    }
                                                                }else{
                                                                  ?><option> No Term Available </option><?php
                                                                }
                                                              ?>
                                                            </select>
                                                          </div>
                                                        </div>
                                                      </center>
                                                    </div>
                                                    <div class="panel-body" style="padding-top: 0px;">

                                                      <div class="row">
                                                        <div class="jumbotron" style="margin-bottom: 0px; padding-bottom: 0px">
                                                           <div>
                                                               <canvas id="myChart1" width="400" height="200"></canvas>
                                                           </div>
                                                       </div>
                                                      </div>
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-5">
                                                <div class="jumbotron" style="margin-bottom: 0px; padding-bottom: 0px">
                                                   <div>
                                                       <canvas id="myChart2" width="400" height="400"></canvas>
                                                   </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-7">
                                                <div class="jumbotron" style="margin-bottom: 0px; padding-bottom: 0px">
                                                   <div>
                                                       <canvas id="myChart3" width="400" height="281"></canvas>
                                                   </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }
                            
                        ?>
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
<script src="js/main.js"></script>
<script>
FusionCharts.setCurrentRenderer('javascript');
<script>
</body>
</html>
