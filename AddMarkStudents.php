<?php
include './controllers/sessions.php';
require_once("./controllers/database/connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Marks - School Management System</title>
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
    <script src="assets/jquery/jquery-3.2.1.min.js"></script>
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
                            echo $_SESSION['schoolname'] . " " . $_SESSION['level'];
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
                        <a href="/schoolreport/subject.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>"">
                        <li><i class="fa fa-fighter-jet"></i> Subject</li>
                        </a>
                        <a href="/schoolreport/courses.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">
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
                        <ol class="breadcrumb">
                            <li>
                                <a href="/schoolreport/home.php?session=<?php echo $_SESSION['sessionid'] ?>&school_level=<?php echo $_SESSION['school_level'] ?>">Home</a>
                            </li>
                            <li class="active">Add Marks</li>
                        </ol>
                        <?php
                        if ($_SESSION['school']) {
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
                            <input type="hidden" class="form-control teacher_id"
                                name="teacher_id" value="<?php echo $_SESSION['teacher_id'] ?>">
                                <input type="hidden" class="form-control status"
                                name="status" value="<?php echo $_SESSION['status'] ?>">
                            <?php
                        }
                        ?>
                        <div class="col-sm-12">
                            <div class="action-btn">
                                <button type="button" class="btn btn-primary viewResults">Preview All Students</button>
                                <button type="button"
                                        class="btn btn-default generate_sample_report">
                                    <i class="fa fa-file" aria-hidden="true"></i> Sample Report
                                </button>
                                <div class="btn-group viewStudentByClass" style="margin-right: 5px"></div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading">
                                    <p>Class: <span class="studentclass" style="text-transform: uppercase"></span></p>
                                    <p>Term: <span class="studentterm"></span></p>
                                    <input type="hidden" class="form-control s_class"
                                           name="s_class">
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <div class="alert alert-dismissible alert-danger alert-form-danger"
                                             role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <span class="text-alert"></span>
                                        </div>
                                        <table class="table table-bordered " id="myTable">
                                            <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th colspan="100">Courses</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['schoolkey'])) {
												
                                                $sql_t = mysqli_query($connect, "SELECT `id`,`teacher_key`, `email` FROM `teachers` WHERE email='{$_SESSION['email']}' and teachers.school = '{$_GET['schoolkey']}' AND teachers.session = '{$_GET['sessionID']}' AND teachers.school_level = '{$_GET['school_level']}' GROUP BY teachers.teacher_key");
												if (mysqli_num_rows($sql_t) > 0) {
                                                    $r = mysqli_fetch_array($sql_t);
                                                    $sql = mysqli_query($connect, "SELECT DISTINCT students.`id` AS student_id,
                                                    students.school,students.school, `firstname`, `lastname`, c.id AS classID, 
                                                    sl.level,sl.id AS school_level_id,section, c.numbericname, `date_birth`,gender, 
                                                    `fathername`, `mothername`, `phonenumber`, `address`, students.`date_created` 
                                                    FROM `students`
                                                    LEFT JOIN classes c ON c.id = students.classname
                                                    LEFT JOIN school_levels sl ON sl.id = students.school_level
                                                    INNER JOIN teacher_classes tc on tc.teacher_key='{$r['id']}'
                                                    WHERE students.school ='{$_GET['schoolkey']}'
                                                    AND students.school_level='{$_GET['school_level']}'
                                                    AND students.session='{$_GET['sessionID']}' AND c.id='{$_GET['classID']}'
                                                    ORDER BY students.`date_created` DESC") or die(mysqli_error($connect));

                                                    if (mysqli_num_rows($sql) > 0) {
                                                        while ($rows = mysqli_fetch_array($sql)) {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                                <b><?php echo $rows['firstname'] . " " . $rows['lastname'] ?></b>
                                                            </td>
                                                            <?php

                                                            // primary
                                                            if ($rows['level'] == 'Primary') {
                                                                $sql_course = mysqli_query($connect, "SELECT DISTINCT st.id AS student_id,st.firstname,st.lastname, classes.`date_created`,c.id AS courseID, c.coursename, c.maxcat, c.maxexam FROM `classes`
                                                                LEFT JOIN students st on st.classname = classes.id 
                                                                LEFT JOIN courses c ON c.school_level = classes.classname
                                                                INNER JOIN terms t ON t.session_id = classes.session AND t.id='{$_GET['termID']}'
                                                                INNER JOIN teacher_courses tc on tc.course_id = c.id AND tc.teacher_key='{$r['teacher_key']}'
                                                                LEFT JOIN student_marks st_m ON st_m.student = st.id AND st_m.school= st.school AND st_m.class = classes.id AND c.id=st_m.course
                                                                WHERE st.id = '{$rows['student_id']}' GROUP BY c.id") or die(mysqli_error($connect));

                                                                //count the courses input fields
                                                                ?><input type="hidden" class="count_courses"
                                                                         value="<?php echo mysqli_num_rows($sql_course) ?>"><?php

                                                                if (mysqli_num_rows($sql_course) > 0) {
                                                                    $count = 0;
                                                                    while ($rows_course = mysqli_fetch_array($sql_course)) {
                                                                        ?>
                                                                        <td style="text-transform: capitalize">
                                                                            <b><?php echo $rows_course['coursename'] ?></b>
                                                                            <table>
                                                                                <tr index='<?php echo $count ?>'
                                                                                    class="course_tr">
                                                                                    <?php
                                                                                    if ($rows['level'] == 'Primary') {
                                                                                        ?>
                                                                                        <td>
                                                                                            <input
                                                                                                    type="text"
                                                                                                    name=""
                                                                                                    class="form-control cat<?php echo $count ?>"
                                                                                                    style="width: 100px"
                                                                                                    value='<?php echo $rows_course['cat'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                                    max='<?php echo $rows_course['maxcat'] ?>'>
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorcat<?php echo $count ?>">>>>CAT= <?php echo $rows_course['maxcat'] ?></span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input
                                                                                                    type="text"
                                                                                                    name=""
                                                                                                    class="form-control exam<?php echo $count ?>"
                                                                                                    style="width: 100px"
                                                                                                    value='<?php echo $rows_course['exam'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                                    max='<?php echo $rows_course['maxexam'] ?>'
                                                                                            >
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorexam<?php echo $count ?>"
                                                                                                    max='<?php echo $rows_course['maxexam'] ?>'>>>>EXAM= <?php echo $rows_course['maxexam'] ?></span>
                                                                                        </td>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        <?php
                                                                        $count++;
                                                                    }
                                                                }
                                                            } else {
                                                                $sql_nursery_course = mysqli_query($connect, "SELECT DISTINCT st.id AS student_id,st.firstname,st.lastname, classes.`date_created`,c.id AS courseID, c.coursename, st_m.quotation FROM `classes`
                                                                LEFT JOIN students st on st.classname = classes.id 
                                                                LEFT JOIN courses c ON c.school_level = classes.classname
                                                                INNER JOIN terms t ON t.session_id = classes.session AND t.id='{$_GET['termID']}'
                                                                INNER JOIN teacher_courses tc on tc.course_id = c.id AND tc.teacher_key='{$r['teacher_key']}'
                                                                LEFT JOIN nursery_marks st_m ON st_m.student = st.id AND st_m.school= st.school AND st_m.class = classes.id AND c.id=st_m.course
                                                                WHERE st.id = '{$rows['student_id']}' GROUP BY c.id") or die(mysqli_error($connect));
                                                                //count the courses input fields
                                                                ?><input type="hidden" class="count_courses"
                                                                         value="<?php echo mysqli_num_rows($sql_nursery_course) ?>"><?php

                                                                if (mysqli_num_rows($sql_nursery_course) > 0) {
                                                                    $count = 0;
                                                                    while ($rows_course = mysqli_fetch_array($sql_nursery_course)) {
                                                                        ?>
                                                                        <td style="text-transform: capitalize">
                                                                            <b><?php echo $rows_course['coursename'] ?></b>
                                                                            <table>
                                                                                <tr index='<?php echo $count ?>'
                                                                                    class="course_tr">
                                                                                    <td>
                                                                                        <select
                                                                                                name=""
                                                                                                class="form-control cotation<?php echo $count ?>"
                                                                                                style="width: 200px"
                                                                                                value='<?php echo $rows_course['quotation'] ?>'
                                                                                                data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                        >
                                                                                            <?php
                                                                                            if ($rows_course['quotation'] == 'EXCELENT NO COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'VERY GOOD NO COLOR') {
                                                                                                ?>
                                                                                                <option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'GOOD NO COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'FAIL NO COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            }
                                                                                            if ($rows_course['quotation'] == 'EXCELENT COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'VERY GOOD COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'GOOD COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == 'FAIL COLOR') {
                                                                                                ?>
																								<option><?php echo $rows_course['quotation'] ?></option>
                                                                                                <option>EXCELENT
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD COLOR
                                                                                                </option>
                                                                                                <option>FAIL COLOR
                                                                                                </option>
                                                                                                <option>EXCELENT NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>VERY GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>GOOD NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <option>FAIL NO
                                                                                                    COLOR
                                                                                                </option>
                                                                                                <?php
                                                                                            } else if ($rows_course['quotation'] == '') {
                                                                                                ?>
                                                                                                <optgroup>
                                                                                                    <option>Select
                                                                                                        quotation
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY
                                                                                                        GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                </optgroup>
                                                                                                <optgroup>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY
                                                                                                        GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                </optgroup>
                                                                                                <?php
                                                                                            }
                                                                                            ?>

                                                                                        </select>
                                                                                        <span
                                                                                                style="color: #777; font-size: 11px"
                                                                                                class="errorcotation<?php echo $count ?>"></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        <?php
                                                                        $count++;
                                                                    }
                                                                }
                                                            }
                                                            ?></tr><?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td align="center" colspan="2">Choose a class to see the
                                                                datas
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    $sql = mysqli_query($connect, "SELECT classes.`id`, classes.`school`, sl.level,`numbericname`,section,t.term, st.id AS student_id, st.firstname, st.lastname, classes.`date_created`, c.coursename, c.maxcat, c.maxexam FROM `classes`
                                                        LEFT JOIN students st on st.classname = classes.id
                                                        LEFT JOIN school_levels sl on sl.id = classes.classname AND sl.id='{$_GET['school_level']}'
                                                        LEFT JOIN courses c ON c.school=sl.id
                                                        INNER JOIN terms t ON t.session_id = classes.session AND t.id='{$_GET['termID']}'
                                                        WHERE classes.id='{$_GET['classID']}' AND classes.session='{$_GET['sessionID']}' AND st.session='{$_GET['sessionID']}'
                                                        GROUP BY st.id ORDER BY st.id ASC") or die(mysqli_error($connect));

                                                    if (mysqli_num_rows($sql) > 0) {
                                                        while ($rows = mysqli_fetch_array($sql)) {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                                <b><?php echo $rows['firstname'] . " " . $rows['lastname'] ?></b>
                                                            </td>
                                                            <?php

                                                            // primary
                                                            if ($rows['level'] == 'Primary') {
                                                                $sql_course = mysqli_query($connect, "SELECT classes.`id`, classes.`school`, classes.`classname`, `numbericname`,t.term, st.id AS student_id,
                                                                st.firstname, st.lastname, classes.`date_created`,c.id AS courseID, c.coursename, c.maxcat, c.maxexam,
                                                                st_m.cat, st_m.exam FROM `classes` 
                                                                LEFT JOIN students st on st.classname = classes.id 
                                                                LEFT JOIN courses c ON c.school_level = classes.classname 
                                                                INNER JOIN terms t ON t.session_id = classes.session AND t.id='{$_GET['termID']}'
                                                                LEFT JOIN student_marks st_m ON st_m.student = st.id AND st_m.school= st.school AND st_m.class = classes.id AND c.id=st_m.course AND st_m.term='{$_GET['termID']}'

                                                                WHERE st.id = '{$rows['student_id'] }' AND classes.session='{$_GET['sessionID'] }' AND st.session='{$_GET['sessionID'] }' GROUP BY c.id") or die(mysqli_error($connect));

                                                                //count the courses input fields
                                                                ?><input type="hidden" class="count_courses"
                                                                         value="<?php echo mysqli_num_rows($sql_course) ?>"><?php

                                                                if (mysqli_num_rows($sql_course) > 0) {
                                                                    $count = 0;
                                                                    while ($rows_course = mysqli_fetch_array($sql_course)) {
                                                                        ?>
                                                                        <td style="text-transform: capitalize">
                                                                            <b><?php echo $rows_course['coursename'] ?></b>
                                                                            <table>
                                                                                <tr index='<?php echo $count ?>'
                                                                                    class="course_tr">
                                                                                    <?php
                                                                                    if ($rows['level'] == 'Primary') {
                                                                                        ?>
                                                                                        <td>
                                                                                            <input
                                                                                                    type="text"
                                                                                                    name=""
                                                                                                    class="form-control cat<?php echo $count ?>"
                                                                                                    style="width: 100px"
                                                                                                    value='<?php echo $rows_course['cat'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                                    max='<?php echo $rows_course['maxcat'] ?>'>
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorcat<?php echo $count ?>">>>>CAT= <?php echo $rows_course['maxcat'] ?></span>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input
                                                                                                    type="text"
                                                                                                    name=""
                                                                                                    class="form-control exam<?php echo $count ?>"
                                                                                                    style="width: 100px"
                                                                                                    value='<?php echo $rows_course['exam'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                                    max='<?php echo $rows_course['maxexam'] ?>'
                                                                                            >
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorexam<?php echo $count ?>"
                                                                                                    max='<?php echo $rows_course['maxexam'] ?>'>>>>EXAM= <?php echo $rows_course['maxexam'] ?></span>
                                                                                        </td>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                        <?php
                                                                        $count++;
                                                                    }
                                                                }
                                                            } else {
                                                                $sql_t = mysqli_query($connect, "SELECT `teacher_key`, `email` FROM `teachers` WHERE email='{$_SESSION['email']}' and teachers.school = '{$_GET['schoolkey']}' AND teachers.session = '{$_GET['sessionID']}' AND teachers.school_level = '{$_GET['school_level']}' GROUP BY teachers.teacher_key");
                                                                if (mysqli_num_rows($sql_t) > 0) {
                                                                    $r = mysqli_fetch_array($sql_t);
                                                                    $sql_nursery_course = mysqli_query($connect, "SELECT DISTINCT st.id AS student_id,st.firstname,st.lastname, classes.`date_created`,c.id AS courseID, c.coursename, st_m.quotation FROM `classes`
                                                                    LEFT JOIN students st on st.classname = classes.id 
                                                                    INNER JOIN teacher_courses tc on tc.course_id=c.id
                                                                    LEFT JOIN courses c ON c.school_level = classes.school AND tc.teacher_key = '{$r['teacher_key']}' OR c.assistant = '{$r['teacher_key']}'
                                                                    INNER JOIN terms t ON t.school = classes.school AND t.id='{$_GET['termID']}'
                                                                    LEFT JOIN nursery_marks st_m ON st_m.student = st.id AND st_m.school= st.school AND st_m.class = classes.id AND c.id=st_m.course

                                                                    WHERE st.id = '{$rows['student_id']}'  GROUP BY c.id") or die(mysqli_error($connect));

                                                                    //count the courses input fields
                                                                    ?><input type="hidden" class="count_courses"
                                                                             value="<?php echo mysqli_num_rows($sql_nursery_course) ?>"><?php

                                                                    if (mysqli_num_rows($sql_nursery_course) > 0) {
                                                                        $count = 0;
                                                                        while ($rows_course = mysqli_fetch_array($sql_nursery_course)) {
                                                                            ?>
                                                                            <td style="text-transform: capitalize">
                                                                                <b><?php echo $rows_course['coursename'] ?></b>
                                                                                <table>
                                                                                    <tr index='<?php echo $count ?>'
                                                                                        class="course_tr">
                                                                                        <td>
                                                                                            <select
                                                                                                    name=""
                                                                                                    class="form-control cotation<?php echo $count ?>"
                                                                                                    style="width: 200px"
                                                                                                    value='<?php echo $rows_course['exam'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                            >
                                                                                                <?php
                                                                                                if ($rows_course['quotation'] == 'EXCELENT NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'VERY GOOD NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'GOOD NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'FAIL NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                }
                                                                                                if ($rows_course['quotation'] == 'EXCELENT COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'VERY GOOD COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'GOOD COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'FAIL COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == '') {
                                                                                                    ?>
                                                                                                    <optgroup>
                                                                                                        <option>Select
                                                                                                            quotation
                                                                                                        </option>
                                                                                                        <option>EXCELENT
                                                                                                            NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>VERY
                                                                                                            GOOD NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>GOOD NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>FAIL NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                    </optgroup>
                                                                                                    <optgroup>
                                                                                                        <option>EXCELENT
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>VERY
                                                                                                            GOOD
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>GOOD
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>FAIL
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                    </optgroup>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                            </select>
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorcotation<?php echo $count ?>"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <?php
                                                                            $count++;
                                                                        }
                                                                    }
                                                                } else {
                                                                    $sql_nursery_course = mysqli_query($connect, "SELECT DISTINCT st.id AS student_id,st.firstname,st.lastname, classes.`date_created`,c.id AS courseID, c.coursename, st_m.quotation FROM `classes`
                                                                    LEFT JOIN students st on st.classname = classes.id 
                                                                    LEFT JOIN courses c ON c.school_level = classes.classname
                                                                    INNER JOIN terms t ON t.session_id = classes.session AND t.id='{$_GET['termID']}'
                                                                    LEFT JOIN nursery_marks st_m ON st_m.student = st.id AND st_m.school= st.school AND st_m.class = classes.id AND c.id=st_m.course

                                                                    WHERE st.id = '{$rows['student_id']}' GROUP BY c.id") or die(mysqli_error($connect));

                                                                    //count the courses input fields
                                                                    ?><input type="hidden" class="count_courses"
                                                                             value="<?php echo mysqli_num_rows($sql_nursery_course) ?>"><?php

                                                                    if (mysqli_num_rows($sql_nursery_course) > 0) {
                                                                        $count = 0;
                                                                        while ($rows_course = mysqli_fetch_array($sql_nursery_course)) {
                                                                            ?>
                                                                            <td style="text-transform: capitalize">
                                                                                <b><?php echo $rows_course['coursename'] ?></b>
                                                                                <table>
                                                                                    <tr index='<?php echo $count ?>'
                                                                                        class="course_tr">
                                                                                        <td>
                                                                                            <select
                                                                                                    name=""
                                                                                                    class="form-control cotation<?php echo $count ?>"
                                                                                                    style="width: 200px"
                                                                                                    value='<?php echo $rows_course['exam'] ?>'
                                                                                                    data-student='<?php echo $rows_course['student_id'] ?>'
                                                                                                    data-course='<?php echo $rows_course['courseID'] ?>'
                                                                                            >
                                                                                                <?php
                                                                                                if ($rows_course['quotation'] == 'EXCELENT NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'VERY GOOD NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'GOOD NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'FAIL NO COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                }
                                                                                                if ($rows_course['quotation'] == 'EXCELENT COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'VERY GOOD COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'GOOD COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == 'FAIL COLOR') {
                                                                                                    ?>
                                                                                                    <option selected><?php echo $rows_course['quotation'] ?></option>
                                                                                                    <option>EXCELENT
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL COLOR
                                                                                                    </option>
                                                                                                    <option>EXCELENT NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>VERY GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>GOOD NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <option>FAIL NO
                                                                                                        COLOR
                                                                                                    </option>
                                                                                                    <?php
                                                                                                } else if ($rows_course['quotation'] == '') {
                                                                                                    ?>
                                                                                                    <optgroup>
                                                                                                        <option>Select
                                                                                                            quotation
                                                                                                        </option>
                                                                                                        <option>EXCELENT
                                                                                                            NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>VERY
                                                                                                            GOOD NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>GOOD NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>FAIL NO
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                    </optgroup>
                                                                                                    <optgroup>
                                                                                                        <option>EXCELENT
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>VERY
                                                                                                            GOOD
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>GOOD
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                        <option>FAIL
                                                                                                            COLOR
                                                                                                        </option>
                                                                                                    </optgroup>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                            </select>
                                                                                            <span
                                                                                                    style="color: #777; font-size: 11px"
                                                                                                    class="errorcotation<?php echo $count ?>"></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                            <?php
                                                                            $count++;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></tr><?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td align="center" colspan="2">Choose a class to see the
                                                                datas
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }

                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
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
<!-- <script src="assets/jquery/jquery-3.2.1.min.js"></script> -->
<!--===============================================================================================-->
<script src="assets/bootstrap/js/popper.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="assets/daterangepicker/moment.min.js"></script>
<!--===============================================================================================-->
<script src="assets/countdowntime/countdowntime.js"></script>
<script src="assets/notify.js"></script>
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
<script src="js/addMarkesStudents.js"></script>

</body>
</html>
