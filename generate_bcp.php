<?php
include './controllers/sessions.php';
require_once("./controllers/database/connection.php");

$student_name='';
$classname='';
$academic_year='';
$positionArray = [];

$sql_student_name= mysqli_query($connect, "SELECT `id`, `school`, `firstname`, `lastname`, `classname`, `date_birth`, `gender`, `fathername`, `mothername`, `phonenumber`, `address`, `date_created` FROM `students` WHERE id='{$_GET['studentID']}' and school = '{$_GET['schoolkey']}'");
if (mysqli_num_rows($sql_student_name) == 1){
    $rows_student_name = mysqli_fetch_array($sql_student_name);
    $student_name = $rows_student_name['firstname'].' '.$rows_student_name['lastname'];
}

//class
$sql_class= mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section,t.name, classes.`date_created` FROM `classes` LEFT JOIN teachers t ON t.class = classes.id LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.`id` = '{$_GET['classID']}'") or die("Could't fetch data".mysqli_error($connect));;

if (mysqli_num_rows($sql_class) == 1){
    $rows_class = mysqli_fetch_array($sql_class);

    if ( $rows_class['level'] == 'Primary'){
        $classname ='P'.$rows_class['numbericname'].$rows_class['section'];
    }else if ( $rows_class['level'] == 'Nursery'){
        $classname ='N'.$rows_class['numbericname'].$rows_class['section'];
    }
}

//session

$sql = mysqli_query($connect, "SELECT `id`, school, academic_year, `startdate`,`enddate`, `date_created` FROM `sessions` WHERE
    id = '{$_GET['sessionID']}'")or die("Could't fetch data".mysqli_error($connect));
if (mysqli_num_rows($sql) == 1){
    while ($rows = mysqli_fetch_array($sql)){
        $array[] = $rows;

        $academic_year = $rows['academic_year'];
    }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        <!--table
        {mso-displayed-decimal-separator:"\.";
            mso-displayed-thousand-separator:"\,";}
        @page
        {margin:.75in .2in .75in .39in;
            mso-header-margin:.28in;
            mso-footer-margin:.31in;
            mso-page-orientation:landscape;}
        .font6
        {color:black;
            font-size:10.0pt;
            font-weight:700;
            font-style:normal;
            text-decoration:none;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;}
        .font7
        {color:black;
            font-size:10.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;}
        .style0
        {mso-number-format:General;
            text-align:general;
            vertical-align:bottom;
            white-space:nowrap;
            mso-rotate:0;
            mso-background-source:auto;
            mso-pattern:auto;
            color:black;
            font-size:11.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            border:none;
            mso-protection:locked visible;
            mso-style-name:Normal;
            mso-style-id:0;}
        td
        {mso-style-parent:style0;
            padding-top:1px;
            padding-right:1px;
            padding-left:1px;
            mso-ignore:padding;
            color:black;
            font-size:11.0pt;
            font-weight:400;
            font-style:normal;
            text-decoration:none;
            font-family:Calibri, sans-serif;
            mso-font-charset:0;
            mso-number-format:General;
            text-align:general;
            vertical-align:bottom;
            border:none;
            mso-background-source:auto;
            mso-pattern:auto;
            mso-protection:locked visible;
            white-space:nowrap;
            mso-rotate:0;}
        .xl65
        {mso-style-parent:style0;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;}
        .xl66
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;}
        .xl67
        {mso-style-parent:style0;
            font-size:8.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            border:.5pt solid windowtext;}
        .xl68
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            border:.5pt solid windowtext;}
        .xl69
        {mso-style-parent:style0;
            font-size:9.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:right;
            border:.5pt solid windowtext;}
        .xl70
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-style:italic;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            border:.5pt solid windowtext;}
        .xl71
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:right;
            border:.5pt solid windowtext;}
        .xl72
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border:.5pt solid windowtext;}
        .xl73
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:.5pt solid windowtext;}
        .xl74
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl75
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl76
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:none;
            border-left:.5pt solid windowtext;}
        .xl77
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:none;
            border-left:none;}
        .xl78
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:none;
            border-left:none;}
        .xl79
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:none;
            border-right:none;
            border-bottom:none;
            border-left:.5pt solid windowtext;}
        .xl80
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;}
        .xl81
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:none;
            border-right:.5pt solid windowtext;
            border-bottom:none;
            border-left:none;}
        .xl82
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:none;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:.5pt solid windowtext;}
        .xl83
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:none;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl84
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:none;
            border-right:.5pt solid windowtext;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl85
        {mso-style-parent:style0;
            font-size:8.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:.5pt solid windowtext;}
        .xl86
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:none;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl87
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            border-top:.5pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:.5pt solid windowtext;
            border-left:none;}
        .xl88
        {mso-style-parent:style0;
            font-size:8.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            vertical-align:top;
            border-top:.5pt solid windowtext;
            border-right:.5pt solid windowtext;
            border-bottom:none;
            border-left:.5pt solid windowtext;}
        .xl89
        {mso-style-parent:style0;
            font-size:10.0pt;
            font-weight:700;
            font-family:"Times New Roman", serif;
            mso-font-charset:0;
            text-align:center;
            vertical-align:top;
            border-top:none;
            border-right:.5pt solid windowtext;
            border-bottom:.5pt solid windowtext;
            border-left:.5pt solid windowtext;}
        -->
    </style>
</head>

<body link=blue vlink=purple class=xl65>
    <div class="container-wraper">
        <div class="outer-container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="content">
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
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <table id="myTable" >
                                    <tr height=21 style='height:16.0pt; border: none'>
                                        <td height=21 width=256 style='height:16.0pt;width:192pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=125 style='width:94pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                        <td width=87 style='width:65pt'></td>
                                    </tr>
                                    <tr height=21 style='height:16.0pt; border: none'>
                                        <td height=21 class=xl70 style='height:16.0pt; border: none'>Name: <?php echo $student_name ?></td>
                                        <td colspan=5 class=xl71  style="border: none"></td>
                                        <td colspan=2 style='mso-ignore:colspan;border: none'></td>
                                        <td class=xl70 style="border: none">Class: <?php echo $classname ?></td>
                                        <td colspan=2 class=xl71  style="border: none"></td>
                                        <td colspan=2 style='mso-ignore:colspan; border: none'></td>
                                        <td class=xl70  style="border: none">Academic year<span style='display:none'>:</span> <?php echo $academic_year ?></td>
                                        <td colspan=4 class=xl71  style="border: none"></td>
                                    </tr>
                                    <tr height=21 style='height:16.0pt'>
                                        <td height=21 colspan=18 style='height:16.0pt;mso-ignore:colspan'></td>
                                    </tr>
                                    <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                        <td rowspan=2 height=32 class=xl88 width=216 style='border-bottom:.5pt solid black;
                      height:24.0pt;width:162pt'>SUBJECTS</td>
                                        <td colspan=3 class=xl85 width=157 style='border-right:.5pt solid black;
                      border-left:none;width:117pt'>MAXIMA</td>
                                        <td colspan=3 class=xl85 width=165 style='border-right:.5pt solid black;
                      border-left:none;width:123pt'>1st TERM MARKS</td>
                                        <td colspan=3 class=xl85 width=165 style='border-right:.5pt solid black;
                      border-left:none;width:123pt'>2nd TERM<span style='mso-spacerun:yes'>&nbsp;
                      </span>MARKS</td>
                                        <td colspan=3 class=xl85 width=165 style='border-right:.5pt solid black;
                      border-left:none;width:123pt'>3rd TERM<span style='mso-spacerun:yes'>&nbsp;
                      </span>MARKS</td>
                                        <td colspan=5 class=xl85 width=267 style='border-right:.5pt solid black;
                      border-left:none;width:199pt'>ANNUAL TOTALS</td>
                                    </tr>
                                    <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                        <td height=16 class=xl67 style='height:12.0pt;border-top:none;border-left:
                      none'>CATS</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>EXAM</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>TOT</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>CATS</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>EXAM</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>TOT</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>CATS</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>EXAM</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>TOT</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>CATS</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>EXAM</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>TOT</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>CATS</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>EXAM</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>MAX</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>TOT</td>
                                        <td class=xl67 style='border-top:none;border-left:none'>%</td>
                                    </tr>

                                    <?php
                                    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['studentID']){
                                        $sql = mysqli_query($connect, "SELECT classes.`id`, classes.`school`, sl.level,`numbericname`,section,t.term, st.id AS student_id, st.firstname, st.lastname, classes.`date_created`, c.coursename, c.maxcat, c.maxexam, c.p_percentage, sub.subjectname FROM `classes`
                                            LEFT JOIN students st on st.classname = classes.id
                                            LEFT JOIN school_levels sl on sl.id = classes.classname
                                            LEFT JOIN courses c ON c.school=sl.id
                                            INNER JOIN terms t ON t.school = classes.school AND t.id='{$_GET['termID']}'
                                            LEFT JOIN subjects sub on sub.school_level = sl.id
                                            WHERE st.id='{$_GET['studentID']}'
                                            GROUP BY st.id ORDER BY st.id ASC") or die("Could't fetch data".mysqli_error($connect));
                                        if (mysqli_num_rows($sql) > 0){
                                            $total_maxcat=0;
                                            $total_maxexam=0;
                                            $general_total_cat=0;
                                            $general_total_exam=0;
                                            while ($rows = mysqli_fetch_array($sql)){
                                                ?>
                                                    <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                        <td height=16 colspan="18" class=xl68 style='height:12.0pt;border-top:none; text-transform: uppercase;'><?php echo $rows['subjectname'] ?></td>
                                                    </tr>
                                                <?php
                                                $sql_link= mysqli_query($connect, "SELECT * FROM (SELECT DISTINCT courses.`id` AS courseid, courses.`school`, sm.session, courses.`class`, t.term, courses.coursename,courses.maxcat, courses.maxexam, sm.`student`, sm.`cat`, sm.`exam`, courses.`date_created`, sub.subjectname FROM `courses` LEFT JOIN subjects s ON s.id = courses.subjectname
                                                   LEFT JOIN student_marks sm ON sm.course = courses.id
                                                   LEFT JOIN subjects sub ON sub.id = courses.subjectname
                                                   LEFT JOIN terms t ON sm.term = t.id
                                                   WHERE sub.subjectname='{$rows['subjectname']}'  AND sm.student= '{$_GET['studentID']}' AND sm.session='{$_GET['sessionID']}'
                                                   GROUP BY courses.id) as marker1

                                                   LEFT JOIN (SELECT DISTINCT courses.`id` AS courseid, t.term AS term2, `student`, `cat` AS cat2, `exam`                AS exam2 FROM `courses` LEFT JOIN subjects s ON s.id = courses.subjectname
                                                              LEFT JOIN student_marks sm ON sm.course = courses.id
                                                              LEFT JOIN subjects sub ON sub.id = courses.subjectname
                                                              LEFT JOIN terms t ON sm.term = t.id
                                                              LEFT JOIN school_levels sl ON sl.id = courses.school_level
                                                              WHERE sl.level = '{$_GET['school_level']}' AND sm.student='{$_GET['studentID']}' AND sm.session='{$_GET['sessionID']}' AND t.term='Term 2') AS marks2 on                              marks2.term2 != marker1.term AND marker1.courseid=marks2.courseid AND marker1.student = marks2.student
                                                               LEFT JOIN (SELECT DISTINCT courses.`id` AS courseid, t.term AS term3, `student`, `cat` AS cat3, `exam`                AS exam3 FROM `courses` LEFT JOIN subjects s ON s.id = courses.subjectname
                                                              LEFT JOIN student_marks sm ON sm.course = courses.id
                                                              LEFT JOIN subjects sub ON sub.id = courses.subjectname
                                                              LEFT JOIN terms t ON sm.term = t.id
                                                              LEFT JOIN school_levels sl ON sl.id = courses.school_level
                                                              WHERE sl.level = '{$_GET['school_level']}' AND sm.student='{$_GET['studentID']}' AND sm.session='{$_GET['sessionID']}' AND t.term='Term 3') AS marks3 on                              marks2.term2 != marker1.term AND marker1.courseid=marks3.courseid AND marker1.student = marks3.student

                                                              ") or die("Could't fetch data".mysqli_error($connect));

                                                            $total_cat_1 = 0;
                                                            $total_exam_1 = 0;
                                                            $total_cat_2 = 0;
                                                            $total_exam_2 = 0;
                                                            $total_cat_3 = 0;
                                                            $total_exam_3 = 0;
                                                            $max_total_cat=0;
                                                            $max_total_exam=0;

                                                            //annual
                                                            $total_annual_cat = 0;
                                                            $total_annual_exam = 0;
                                                            $total_all_cats=0;
                                                            $total_annual_max=0;
                                                            $general_totals=0;

                                                            while ($rows_link = mysqli_fetch_array($sql_link)){
                                                                $total_maxcat +=$rows_link['maxcat'];
                                                                $total_maxexam+=$rows_link['maxexam'];

                                                                $max_total_cat +=$rows_link['maxcat'];
                                                                $max_total_exam +=$rows_link['maxexam'];

                                                                //term1
                                                                $total_cat_1 += $rows_link['cat'];
                                                                $total_exam_1 += $rows_link['exam'];

                                                                $general_total_cat +=$rows_link['cat'];
                                                                $general_total_exam+=$rows_link['exam'];

                                                                //term2
                                                                $total_cat_2 += $rows_link['cat2'];
                                                                $total_exam_2 += $rows_link['exam2'];

                                                                $general_total_cat_2 +=$total_cat_2;
                                                                $general_total_exam_2+=$total_exam_2;

                                                                //term3
                                                                $total_cat_3 += $rows_link['cat3'];
                                                                $total_exam_3 += $rows_link['exam3'];

                                                                $general_total_cat_3 +=$total_cat_3;
                                                                $general_total_exam_3+=$total_exam_3;

                                                                //annual
                                                                $total_annual_cat = ($rows_link['cat'] + $rows_link['cat2'] + $rows_link['cat3']);
                                                                $total_annual_exam = ($rows_link['exam'] + $rows_link['exam2'] + $rows_link['exam3']);
                                                                $total_all_cats = ($total_cat_1 + $total_cat_2 + $total_cat_3);
                                                                $total_all_exam = ($total_exam_1 + $total_exam_2 + $total_exam_3);

                                                                $total_annual_max=(($max_total_cat + $max_total_exam) * 3);

                                                                $general_totals = ($total_all_cats + $total_all_exam);

                                                                ?>
                                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                                    <td height=16 class=xl70 style='height:12.0pt;border-top:none; text-transform: capitalize;'><?php echo $rows_link['coursename'] ?></td>
                                                                    <td class=xl69 style='border-top:none;border-left:none'><?php echo  $rows_link['maxcat']  ?></td>
                                                                    <td class=xl69 style='border-top:none;border-left:none'><?php echo  $rows_link['maxexam']  ?></td>
                                                                    <td class=xl69 style='border-top:none;border-left:none'><?php echo  ($rows_link['maxcat'] + $rows_link['maxexam'])  ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo  $rows_link['cat']  ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo  $rows_link['exam']  ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'><?php echo  ($rows_link['cat'] + $rows_link['exam']) ?></td>

<!--                                                                    term 2-->
                                                                    <?php
                                                                        if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2'){
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right''><?php echo  $rows_link['cat2']  ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right''><?php echo  $rows_link['exam2']  ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'><?php echo  ($rows_link['cat2'] + $rows_link['exam2']) ?></td>
                                                                            <?php
                                                                        }else {
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                                            <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    <?php
                                                                    if ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right''><?php echo  $rows_link['cat3']  ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right''><?php echo  $rows_link['exam3']  ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold''><?php echo  ($rows_link['cat3'] + $rows_link['exam3']) ?></td>
                                                                        <?php
                                                                    }else {
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                                        <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                        if (($rows_link['term'] !== null && $rows_link['term'] == 'Term 1') && ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') && ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3')){
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_annual_cat ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_annual_exam ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right; font-weight: 900'><?php echo  (($rows_link['maxcat'] + $rows_link['maxexam']) * 3)  ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right'><?php echo $total_annual_cat + $total_annual_exam ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right'></td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right; font-weight: 900'><?php echo  (($rows_link['maxcat'] + $rows_link['maxexam']) * 3)  ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none;text-align: right'></td>
<!--                                                                            --><?php //echo round(($total_annual_cat + $total_annual_exam) / (($rows_link['maxcat'] + $rows_link['maxexam']) * 3) * 100, 1) ?>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </tr>
                                                                <?php
                                                            }

                                                            ?>
                                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                                    <td height=16 class=xl71 style='height:12.0pt;border-top:none'>TOTAL</td>
                                                                    <td class=xl71 style='border-top:none;border-left:none'><?php echo $max_total_cat ?></td>
                                                                    <td class=xl71 style='border-top:none;border-left:none'><?php echo $max_total_exam ?></td>
                                                                    <td class=xl71 style='border-top:none;border-left:none; text-align: right'><?php echo  ($max_total_cat + $max_total_exam) ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_cat_1 ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_exam_1 ?></td>
                                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo  ($total_cat_1 + $total_exam_1) ?></td>
                                                                    <?php
                                                                        if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2'){
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'><?php echo  ($total_cat_2 + $total_exam_2) ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_cat_2 ?></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_exam_2 ?></td>
                                                                            <?php
                                                                        }else{
                                                                            ?>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                            <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>

                                                                            <?php
                                                                        }
                                                                    ?>

                                                                    <?php
                                                                    if ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_cat_3 ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $total_exam_3 ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'><?php echo  ($total_cat_3 + $total_exam_3) ?></td>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'></td>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                    <?php
                                                                    if (($rows_link['term'] !== null && $rows_link['term'] == 'Term 1') && ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') && ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3')){
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'><?php echo $total_all_cats ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;'><?php echo $total_all_exam ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right; font-weight: 900'><?php echo  $total_annual_max  ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo  ($total_all_cats + $total_all_exam) ?></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo  round((($total_all_cats + $total_all_exam) / ($total_annual_max)) * 100, 1) ?>%</td>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;font-weight: bold'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right;'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right; font-weight: 900'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                            <?php
                                                            $total_cat_1 = 0;
                                                            $total_exam_1 = 0;
                                                            $total_cat_2 = 0;
                                                            $total_exam_2 = 0;
                                                            $total_cat_3 = 0;
                                                            $total_exam_3 = 0;
                                                            $max_total_cat = 0;
                                                            $max_total_exam = 0;
                                                            $total_annual_cat = 0;
                                                            $total_annual_exam = 0;
                                                            $total_all_cats=0;
                                                            $total_annual_max=0;
                                                            $general_totals = 0;
                                                        }
                                                    }
                                                    $total_max =  (($total_maxcat + $total_maxexam) * 3);
                                                ?>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl68 style='height:12.0pt;border-top:none'>GENERAL TOTAL</td>
                                                    <td class=xl71 style='border-top:none;border-left:none'><?php echo $total_maxcat ?></td>
                                                    <td class=xl71 style='border-top:none;border-left:none'><?php echo $total_maxexam ?></td>
                                                    <td class=xl71 style='border-top:none;border-left:none'><?php echo ($total_maxcat + $total_maxexam) ?></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_cat ?></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_exam ?></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo ($general_total_cat + $general_total_exam) ?></td>
                                                    <?php
                                                    if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2'){
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_cat_2 ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_exam_2 ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo ($general_total_cat_2 + $general_total_exam_2) ?></td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_cat_3 ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo $general_total_exam_3 ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo ($general_total_cat_3 + $general_total_exam_3) ?></td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if (($rows_link['term'] !== null && $rows_link['term'] == 'Term 1') && ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') && ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3')){
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo ($general_total_cat + $general_total_cat_2 + $general_total_cat_3) ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo ($general_total_exam + $general_total_exam_2 + $general_total_exam_3) ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; font-weight: 900; text-align: right'><?php echo  (($total_maxcat + $total_maxexam) * 3)  ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none;text-align: right'><?php echo ($general_total_cat + $general_total_cat_2 + $general_total_cat_3 + $general_total_exam + $general_total_exam_2 + $general_total_exam_3) ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; font-weight: 900; text-align: right'><?php echo  (($total_maxcat + $total_maxexam) * 3)  ?></td>
                                                        <td class=xl67 style='border-top:none;border-left:none;text-align: right'></td>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <?php
                                                    }
                                                    ?>


                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl68 style='height:12.0pt;border-top:none'>%</td>
                                                    <td class=xl71 style='border-top:none;border-left:none'></td>
                                                    <td class=xl71 style='border-top:none;border-left:none'></td>
                                                    <td class=xl71 style='border-top:none;border-left:none'></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                    <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo round(($general_total_cat + $general_total_exam) / ($total_maxcat + $total_maxexam) * 100, 1) ?>%</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <?php
                                                    if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') {
                                                        ?>
                                                        <td class=xl67
                                                            style='border-top:none;border-left:none; text-align: right'><?php echo round(($general_total_cat_2 + $general_total_exam_2) / ($total_maxcat + $total_maxexam) * 100, 1) ?>
                                                            %
                                                        </td>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <?php
                                                    if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') {
                                                        ?>
                                                        <td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo round(($general_total_cat_3 + $general_total_exam_3) / ($total_maxcat + $total_maxexam) * 100, 1) ?>%</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                    <?php
                                                        if (($rows_link['term'] !== null && $rows_link['term'] == 'Term 1') && ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2') && ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3')){
                                                            ?><td class=xl67 style='border-top:none;border-left:none; text-align: right'><?php echo (round(($general_total_cat + $general_total_exam) / ($total_maxcat + $total_maxexam) * 100, 1) + (round(($general_total_cat_2 + $general_total_exam_2) / ($total_maxcat + $total_maxexam) * 100, 1)) + round(($general_total_cat_3 + $general_total_exam_3) / ($total_maxcat + $total_maxexam) * 100, 1)) ?>%</td><?php
                                                        }else{
                                                            ?><td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                            <td class=xl67 style='border-top:none;border-left:none'>&nbsp;</td>
                                                            <?php
                                                        }
                                                    ?>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 colspan="" class=xl67 style='height:12.0pt;border-top:none'>POSITION</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>

                              <?php

                              //GET POSITION
                                 $sql_pos = mysqli_query($connect, "SELECT COUNT(*) AS position, t.term FROM student_positions  LEFT JOIN terms AS t ON t.id= student_positions.term_id  WHERE percentage >= (SELECT percentage FROM student_positions WHERE student_id='{$_GET['studentID']}')") or die("Could't fetch data".mysqli_error($connect));

                                 //get all student in the class

                                 $sql_count_st = mysqli_query($connect, "SELECT *, (select count(*) FROM student_positions WHERE student_positions.class='{$_GET['classID']}') AS count FROM student_positions WHERE  student_positions.class='{$_GET['classID']}' GROUP BY student_positions.class") or die("Could't fetch data".mysqli_error($connect));

                                 $rows_pos = mysqli_fetch_array($sql_pos);
                                 $rows_count = mysqli_fetch_array($sql_count_st);

                                 if ($rows_pos['term'] == 'Term 1') {
                                     ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'><b><?php echo $rows_pos['position']." / ".$rows_count['count'] ?></b></td><?php
                                 }else {
                                    ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'></td><?php
                                 }
                                 if ($rows_pos['term'] == 'Term 2') {
                                     ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'><b><?php echo $rows_pos['position']." / ".$rows_count['count'] ?></b></td><?php
                                 }else {
                                    ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'></td><?php
                                 }
                                 if ($rows_pos['term'] == 'Term 3') {
                                     ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'><b><?php echo $rows_pos['position']." / ".$rows_count['count'] ?></b></td><?php
                                 }else {
                                    ?><td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                                        none'></td><?php
                                 }
                              ?>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'></td>
                                                    <td colspan=5 class=xl72 style='border-left:none'>&nbsp;</td>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl67 style='height:12.0pt;border-top:none'>APPLICATION</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=5 class=xl72 style='border-left:none'>&nbsp;</td>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl67 style='height:12.0pt;border-top:none'>TEACHER'S
                                                        SIGNATURE</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=5 class=xl72 style='border-left:none'>&nbsp;</td>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl67 style='height:12.0pt;border-top:none'>PARENT'S
                                                        SIGNATURE</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=3 class=xl73 style='border-right:.5pt solid black;border-left:
                              none'>&nbsp;</td>
                                                    <td colspan=5 class=xl72 style='border-left:none'>&nbsp;</td>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt; border: none;'>
                                                    <td height=16 class=xl66 colspan=3 style='height:12.0pt;mso-ignore:colspan'><font
                                                                class="font6">CATS </font><font class="font7">= Continuous Assessment Tests</font></td>
                                                </tr>
                                                <tr class=xl66 height=16 style='mso-height-source:userset;height:12.0pt'>
                                                    <td height=16 class=xl66 style='height:12.0pt'><font class="font6">EX</font><font
                                                                class="font7"> = Exam<span
                                                                    style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></font></td>
                                                </tr>
                                            <?php
                                    }

                                    ?>
                                </table>
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
<script src="js/generate_report.js"></script>
</body>

</html>
