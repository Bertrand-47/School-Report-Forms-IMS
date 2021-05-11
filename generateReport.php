<?php

//connect to DB
if (file_exists("./controllers/database/connection.php")) {
    require_once("./controllers/database/connection.php");
}

function fetch_student_name($connect, $student_id, $classID)
{
    $student_name = '';
    $classname = '';
    $sql = mysqli_query($connect, "SELECT `firstname`, `lastname`, sl.level, cl.numbericname, cl.section, sess.academic_year FROM `students` LEFT JOIN classes cl ON cl.id = students.classname LEFT JOIN school_levels sl on sl.id = cl.classname LEFT JOIN sessions sess on sess.id= students.session WHERE students.id='$student_id' AND students.classname='$classID'");
    $row = mysqli_fetch_array($sql);
    if ( $row['level'] == 'Primary'){
        $classname ='P'.$row['numbericname'].$row['section'];
    }else if ( $row['level'] == 'Nursery'){
        $classname ='N'.$row['numbericname'].$row['section'];
    }
    $student_name .= '<tr>
                        <td align="left"><b>Name: ' . $row['firstname'] . ' ' . $row['lastname'] . '</b></td>
                        <td align="center"><b>Class: ' . strtoupper($classname) . '</b></td>
                        <td align="right"><b>Academic Year: ' . $row['academic_year'] . '</b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';
    return $student_name;
}

function fetch_header_table(){
    $output = '';
    $output .= '<tr>
            <td rowspan="2" align="center" width="20%"><b>SUBJECTS</b></td>
            <td colspan="3" align="center"  width="13%"><b>MAXIMA</b></td>
            <td colspan="3" align="center"  width="13%"><b>1st TERM MARKS</b></td>
            <td colspan="3" align="center"><b>2nd TERM MARKS</b></td>
            <td colspan="3" align="center"><b>3rd TERM MARKS</b></td>
            <td colspan="5" align="center"><b>ANNUAL TOTALS</b></td>
        </tr>
        <tr>
            <td><b>CATS</b></td>
            <td><b>EXAM</b></td>
            <td><b>TOTAL</b></td>
            <td><b>CATS</b></td>
            <td><b>EXAM</b></td>
            <td><b>TOTAL</b></td>
            <td><b>CATS</b></td>
            <td><b>EXAM</b></td>
            <td><b>TOTAL</b></td>
            <td><b>CATS</b></td>
            <td><b>EXAM</b></td>
            <td><b>TOT</b></td>
            <td><b>CATS</b></td>
            <td><b>EXAM</b></td>
            <td><b>MAX</b></td>
            <td><b>TOT</b></td>
            <td><b>%</b></td>
        </tr>';
    return $output;
}

//save percentages for terms
function save_percentages($connect, $school_level, $studentID, $sessionID, $termID, $classID, $percentage, $term ){
    //get term by session
	$sql_t = mysqli_query($connect, "SELECT `id` FROM `terms` WHERE session_id='$sessionID' AND term = '$term' ") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_t) > 0 ) {
		$t_data=mysqli_fetch_array($sql_t);
        //check if is exist on position table
		$sql_pos = mysqli_query($connect, "SELECT `term_id`, `percentage` FROM `student_positions` 
		WHERE student_id='$studentID' AND term_id='{$t_data['id']}' AND session_id='$sessionID' AND class ='$classID'") or die("Could't fetch data".mysqli_error($connect));
		if (mysqli_num_rows($sql_pos) > 0 ) {
			//update
			$sql_update = mysqli_query($connect, "UPDATE `student_positions` SET `percentage`='$percentage', `class`= '$classID' WHERE student_id='$studentID' AND class='$classID' AND term_id='{$t_data['id']}'")or die("Could't update data".mysqli_error($connect));;
		}
		//create new
		else {
			$sql_new = mysqli_query($connect, "INSERT INTO `student_positions`(`id`,school_level, `student_id`, `session_id`, `term_id`, `class`, `percentage`) 
			VALUES (0,'$school_level','$studentID','$sessionID','{$t_data['id']}','$classID','$percentage')") or die("Could't add data".mysqli_error($connect));
		}
	}
}

//save percentages yearly
function yearly_percentages($connect, $school_level, $studentID, $sessionID, $termID, $classID, $percentage ){
	//check if is exist on position table
	$sql_pos = mysqli_query($connect, "SELECT `id`, `school_level`, `student_id`, `session_id`, `term_id`, `percentage` FROM `student_positions` 
	WHERE student_id='$studentID' AND term_id='$termID' AND session_id='$sessionID'") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_pos) > 0 ) {
		//update
		$sql_update = mysqli_query($connect, "UPDATE `student_positions` SET `percentage`='$percentage', class='$classID' WHERE student_id='$studentID' AND class='$classID' AND term_id='y_0' ")or die("Could't update data".mysqli_error($connect));;
	}
	//create new
	else {
		$sql_new = mysqli_query($connect, "INSERT INTO `student_positions`(`id`,school_level, `student_id`, `session_id`, `term_id`, `class`, `percentage`) 
		VALUES (0,'$school_level','$studentID','$sessionID','$termID','$classID','$percentage')") or die("Could't add data".mysqli_error($connect));
	}
}

function fetch_data($connect, $classID, $studentID, $sessionID, $school_level)
{
    $lasts_subject_ame = '';
    $output = '';
    $total_maxexam = 0;
    $total_maxcat = 0;
    $general_total_exam1 = 0;
    $general_total_cat1 = 0;
    $general_total_exam2 = 0;
    $general_total_cat2 = 0;
    $general_total_exam3 = 0;
    $general_total_cat3 = 0;
    $term1 = '';
    $term2 = '';
    $term3 = '';
    $term2_date = '';
    $term3_date = '';
    $percentage_t_1 = '';
    $percentage_t_2 = '';
    $percentage_t_3 = '';
    $comment_t_1 = '';
    $comment_t_2 = '';
    $comment_t_3 = '';
    $term_id1 = 0;

    $sql_link= mysqli_query($connect, "SELECT * FROM (SELECT DISTINCT courses.`id` AS courseid, courses.`school`, sm.session,  sm.term as term_id1, t.term, courses.coursename,courses.maxcat, courses.maxexam, sm.`student`, sm.`cat`, sm.`exam`, courses.`date_created`, sub.subjectname
    , sp.percentage AS percentage_t_1, sc.comment AS comment_t_1 FROM `courses`
    LEFT JOIN subjects s ON s.id = courses.subjectname
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    LEFT JOIN terms t ON sm.term = t.id AND t.session_id='$sessionID'
    LEFT JOIN student_positions sp ON  sp.student_id = sm.student AND sp.school_level = '$school_level' AND sp.term_id = t.id AND sp.session_id = sm.session
    LEFT JOIN student_comments sc on sc.student = sm.student AND sc.term = t.id AND sc.session = sm.session
    WHERE sm.student= '$studentID' AND sm.session='$sessionID' GROUP BY courses.id

    UNION ALL
    SELECT DISTINCT courses.`id` AS courseid, courses.`school`, courses.session,  '','', courses.coursename,courses.maxcat, courses.maxexam, '', '', '', courses.`date_created`, sub.subjectname, '', '' FROM `courses`
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    WHERE courses.session='$sessionID' AND courses.school_level = '$school_level' AND courses.coursename NOT IN (SELECT DISTINCT courses.coursename FROM `courses`
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    WHERE sm.student= '$studentID' AND sm.session='$sessionID')) as marker1

    LEFT JOIN (SELECT DISTINCT courses.`id` AS courseid, sm.term as term_id2, t.term AS term2,  t.startingdate AS startingdate2, sm.student, `cat` AS cat2, 
    `exam` AS exam2, sp.percentage AS percentage_t_2, sc.comment AS comment_t_2 FROM `courses`
    LEFT JOIN subjects s ON s.id = courses.subjectname
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    LEFT JOIN terms t ON sm.term = t.id
    LEFT JOIN school_levels sl ON sl.id = courses.school_level
    LEFT JOIN student_positions sp ON  sp.student_id = sm.student AND sp.school_level = '$school_level' AND sp.term_id = t.id AND sp.session_id = sm.session
    LEFT JOIN student_comments sc on sc.student = sm.student AND sc.term = t.id AND sc.session = sm.session
    WHERE sm.school = '$school_level' AND sm.student='$studentID' AND sm.session= '$sessionID' AND t.term='Term 2'

    UNION ALL
    SELECT DISTINCT courses.`id` AS courseid, '','',  '', '', '', '', '', '' FROM `courses`
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    WHERE courses.session='$sessionID' AND courses.school_level = '$school_level' AND courses.coursename NOT IN (SELECT DISTINCT courses.coursename FROM `courses`
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    LEFT JOIN terms t ON sm.term = t.id
    WHERE sm.student= '$studentID' AND sm.session='$sessionID' AND t.term='Term 2')

    ) AS marks2 on marker1.courseid=marks2.courseid AND marker1.student = marks2.student

    LEFT JOIN (SELECT DISTINCT courses.`id` AS courseid, sm.term as term_id3, t.term AS term3, t.startingdate AS startingdate3, sm.student, `cat` AS cat3, `exam` AS exam3 , sp.percentage AS percentage_t_3, sc.comment AS comment_t_3 FROM `courses`
    LEFT JOIN subjects s ON s.id = courses.subjectname
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    LEFT JOIN terms t ON sm.term = t.id
    LEFT JOIN school_levels sl ON sl.id = courses.school_level
    LEFT JOIN student_positions sp ON  sp.student_id = sm.student AND sp.school_level = '$school_level' AND sp.term_id = t.id AND sp.session_id = sm.session
    LEFT JOIN student_comments sc on sc.student = sm.student AND sc.term = t.id AND sc.session = sm.session
    WHERE sm.school = '$school_level' AND sm.student= '$studentID' AND sm.session= '$sessionID' AND t.term='Term 3'

    UNION ALL
    SELECT DISTINCT courses.`id` AS courseid, '', '',  '', '', '', '', '', '' FROM `courses`
    LEFT JOIN subjects sub ON sub.id = courses.subjectname
    WHERE courses.session= '$sessionID' AND courses.school_level = '$school_level' AND courses.coursename NOT IN (SELECT DISTINCT courses.coursename FROM `courses`
    LEFT JOIN student_marks sm ON sm.course = courses.id AND sm.class='{$_GET['classID']}'
    LEFT JOIN terms t ON sm.term = t.id
    WHERE sm.student= '$studentID' AND sm.session='$sessionID' AND t.term='Term 3')
    ) AS marks3 on marker1.courseid=marks3.courseid AND marker1.student = marks3.student")
    or die("Could't fetch data".mysqli_error($connect));
    while ($rows_link = mysqli_fetch_array($sql_link)){
        if ($lasts_subject_ame !== $rows_link['subjectname']){
            $output .= '
            <tr>
                <td><b style="text-transform:capitalize">'.$rows_link['subjectname'].'</b></td>
                <td colspan="13"></td>
            </tr>';
        }
        $lasts_subject_ame = $rows_link['subjectname'];

        $maxcat =$rows_link['maxcat'];
        $maxexam =$rows_link['maxexam'];
        $total_maxexam += $maxexam;
        $total_maxcat += $maxcat;

        $term1 = $rows_link['term'];
        $term2 = $rows_link['term2'];
        $term3 = $rows_link['term3'];
		$class = $rows_link['class'];
		$term_id1 = $rows_link['term_id1'];
		$term_id2 = $rows_link['term_id2'];
		$term_id3 = $rows_link['term_id3'];
		
        //percentage
        $percentage_t_1 = $rows_link['percentage_t_1'];
        $percentage_t_2 = $rows_link['percentage_t_2'];
        $percentage_t_3 = $rows_link['percentage_t_3'];

        //comment
        $comment_t_1 = $rows_link['comment_t_1'];
        $comment_t_2 = $rows_link['comment_t_2'];
        $comment_t_3 = $rows_link['comment_t_3'];

        //term date
        $term2_date = $rows_link['startingdate2'];
        $term3_date = $rows_link['startingdate3'];

        $general_total_cat1 += $rows_link['cat'];
        $general_total_exam1 += $rows_link['exam'];
        $general_total_cat2 += $rows_link['cat2'];
        $general_total_exam2 += $rows_link['exam2'];
        $general_total_cat3 += $rows_link['cat3'];
        $general_total_exam3 += $rows_link['exam3'];

        $output .='<tr>';
        $output .='<td><span style="text-transform:capitalize">'.$rows_link['coursename'].'</span></td>
            <td align="right" bgcolor="#dddddd">'.$maxcat.'</td>
            <td align="right" bgcolor="#dddddd">'.$maxexam.'</td>
            <td align="right" bgcolor="#dddddd">'.($maxcat + $maxexam).'</td>';

        if ($rows_link['term'] !== null && $rows_link['term'] == 'Term 1'){
           $output .='
            <td align="right">'.$rows_link['cat'].'</td>
            <td align="right">'.$rows_link['exam'].'</td>
            <td align="right"><b>'.($rows_link['cat'] + $rows_link['exam']).'</b></td>';
        }else{
            $output .='
            <td></td>
            <td></td>
            <td></td>';
        }
        if ($rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2'){
            $output .='
            <td align="right">'.$rows_link['cat2'].'</td>
            <td align="right">'.$rows_link['exam2'].'</td>
            <td align="right"><b>'.($rows_link['cat2'] + $rows_link['exam2']).'</b></td>';
        }else{
            $output .='
            <td></td>
            <td></td>
            <td></td>';
        }
        if ($rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
            $output .='
            <td align="right">'.$rows_link['cat3'].'</td>
            <td align="right">'.$rows_link['exam3'].'</td>
            <td align="right"><b>'.($rows_link['cat3'] + $rows_link['exam3']).'</b></td>';
        }else{
            $output .='
            <td></td>
            <td></td>
            <td></td>';
        }

        if ($rows_link['term'] !== null && $rows_link['term'] == 'Term 1' && $rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2' && $rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
            $output .= '
            <td  align="right">'.($rows_link['cat'] + $rows_link['cat2'] + $rows_link['cat3']).'</td>
            <td align="right">'.($rows_link['exam'] + $rows_link['exam2'] + $rows_link['exam3']).'</td>';
        }else{
            $output .= '<td></td><td></td>';
        }

        $output .= '<td bgcolor="#dddddd" align="right"><b>'.(($maxcat + $maxexam) * 3).'</b></td>';

        if ($rows_link['term'] !== null && $rows_link['term'] == 'Term 1' && $rows_link['term2'] !== null && $rows_link['term2'] == 'Term 2' && $rows_link['term3'] !== null && $rows_link['term3'] == 'Term 3'){
            $output .= '<td align="right"><b>'.(($rows_link['cat'] + $rows_link['cat2'] + $rows_link['cat3']) + ($rows_link['exam'] + $rows_link['exam2'] + $rows_link['exam3'])).'</b></td>
                        <td></td>';
        }else{
            $output .= '<td></td><td></td>';
        }

        $output .= '</tr>';
    }

    $output .= '<tr>';
    $output .= '<td><b>GENERAL TOTAL</b></td>';
	
	$output .='
	<td bgcolor="#dddddd" align="right"><b>'.$total_maxcat.'</b></td>
    <td bgcolor="#dddddd" align="right"><b>'.$total_maxexam.'</b></td>
	<td bgcolor="#dddddd" align="right"><b>'.($total_maxcat+$total_maxexam).'</b></td>';
	if($general_total_cat1 != 0){
		$output .='
        <td align="right"><b>'.$general_total_cat1.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if($general_total_exam1 != 0){
		$output .='
        <td align="right"><b>'.$general_total_exam1.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if(($general_total_cat1 + $general_total_exam1) != 0){
		$output .='
        <td align="right"><b>'.($general_total_cat1 + $general_total_exam1).'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if($general_total_cat2 != 0){
		$output .='
        <td align="right"><b>'.$general_total_cat2.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if($general_total_exam2 != 0){
		$output .='
        <td align="right"><b>'.$general_total_exam2.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if(($general_total_cat2 + $general_total_exam2) != 0){
		$output .='
        <td align="right"><b>'.($general_total_cat2 + $general_total_exam2).'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
    
	if($general_total_cat3 != 0){
		$output .='
        <td align="right"><b>'.$general_total_cat3.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if($general_total_exam3 != 0){
		$output .='
        <td align="right"><b>'.$general_total_exam3.'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	if(($general_total_cat3 + $general_total_exam3) != 0){
		$output .='
        <td align="right"><b>'.($general_total_cat3 + $general_total_exam3).'</b></td>';
	}else{
		$output .='
            <td></td>';
	}
	
	$sql_t_g = mysqli_query($connect, "SELECT `term` FROM `terms` WHERE session_id='$sessionID' AND term = 'Term 3' ") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_t_g) > 0 && ($total_maxcat+$total_maxexam) != 0 && ($general_total_cat2 + $general_total_exam2) != 0 && ($general_total_cat3 + $general_total_exam3) != 0){
        $output .='
        <td align="right"><b>'.($general_total_cat1 + $general_total_cat2 + $general_total_cat3).'</b></td>
        <td align="right"><b>'.($general_total_exam1 + $general_total_exam2 + $general_total_exam3).'</b></td>';
    }else{
        $output .= '<td></td>
                    <td></td>';
    }
    /*if ($term1 !== null && $term2 !== null && $term3 !== null){
        $output .='
        <td align="right"><b>'.($general_total_cat1 + $general_total_cat2 + $general_total_cat3).'</b></td>
        <td align="right"><b>'.($general_total_exam1 + $general_total_exam2 + $general_total_exam3).'</b></td>';
    }else{
        $output .= '<td></td>
                    <td></td>';
    }*/

    $output .= '<td align="right"><b>'.(($total_maxcat+$total_maxexam) * 3).'</b></td>';
	if (mysqli_num_rows($sql_t_g) > 0 && ($general_total_cat2 + $general_total_exam2) != 0 && ($general_total_cat3 + $general_total_exam3) != 0) {
		$output .='<td align="right"><b>'.(($general_total_cat1 + $general_total_cat2 + $general_total_cat3) + ($general_total_exam1 + $general_total_exam2 + $general_total_exam3)).'</b></td>';
	}else{
        $output .= '<td></td>';
    }
    /*if ($term1 !== null && $term2 !== null && $term3 !== null){
        $output .='<td align="right"><b>'.(($general_total_cat1 + $general_total_cat2 + $general_total_cat3) + ($general_total_exam1 + $general_total_exam2 + $general_total_exam3)).'</b></td>';
    }else{
        $output .= '<td></td>';
    }*/
    $output .= '</tr>';

    //percantage
    $output .= '<tr>
    <td align="center"><b>%</b></td>';
	if((((($general_total_cat1 + $general_total_exam1) / ($total_maxcat+$total_maxexam)) * 100)) != 0){
		$output .= '<td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td bgcolor="#ffffff" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td align="right"><b>'.number_format(((($general_total_cat1 + $general_total_exam1) / ($total_maxcat+$total_maxexam)) * 100),1,".","").'%</b></td>';

		save_percentages($connect, $school_level, $studentID, $sessionID, $term_id1, $_GET['classID'], number_format(((($general_total_cat1 + $general_total_exam1) / ($total_maxcat+$total_maxexam)) * 100),1,".","") , 'Term 1');
	}else{
        $output .= '<td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td bgcolor="#ffffff" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td></td>';
    }
	if(((($general_total_cat2 + $general_total_exam2) / ($total_maxcat+$total_maxexam)) * 100) !=0){
		$output .= '<td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td align="right"><b>'.number_format(((($general_total_cat2 + $general_total_exam2) / ($total_maxcat+$total_maxexam)) * 100),1,".","").'%</b></td>';
		save_percentages($connect, $school_level, $studentID, $sessionID, $term_id2, $_GET['classID'], number_format(((($general_total_cat2 + $general_total_exam2) / ($total_maxcat+$total_maxexam)) * 100),1,".","") , 'Term 2');
	}else{
        $output .= '<td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td></td>';
    }
	if(((($general_total_cat3 + $general_total_exam3) / ($total_maxcat+$total_maxexam)) * 100) !=0){
		$output .= '
        <td bgcolor="#777777"></td>
		<td bgcolor="#777777"></td>
        <td align="right"><b>'.number_format(((($general_total_cat3 + $general_total_exam3) / ($total_maxcat+$total_maxexam)) * 100),1,".","").'%</b></td>';
		
		save_percentages($connect, $school_level, $studentID, $sessionID, $term_id3, $_GET['classID'], number_format(((($general_total_cat3 + $general_total_exam3) / ($total_maxcat+$total_maxexam)) * 100),1,".","") , 'Term 3');
	}else{
        $output .= '<td bgcolor="#777777" align="right"></td>
        <td bgcolor="#777777" align="right"></td>
        <td></td>';
    }
	if ($term1 !== null && $term2 !== null && $term3 !== null){
		$output .= '
			<td></td>
			<td></td>
            <td bgcolor="#777777" align="right"></td>
            <td></td>
			<td align="right"><b>'.number_format((((($general_total_cat1 + $general_total_cat2 + $general_total_cat3) + ($general_total_exam1 + $general_total_exam2 + $general_total_exam3)) / (($total_maxcat+$total_maxexam) * 3)) * 100), 1, ".","").'%</b></td>
			
			</tr>';
		
		yearly_percentages($connect, $school_level, $studentID, $sessionID, 'y_0', $_GET['classID'], number_format((((($general_total_cat1 + $general_total_cat2 + $general_total_cat3) + ($general_total_exam1 + $general_total_exam2 + $general_total_exam3)) / (($total_maxcat+$total_maxexam) * 3)) * 100), 1, ".","") );
	}else{
		$output .= '
        <td></td>
        <td></td>
        <td bgcolor="#777777" align="right"></td>
        <td align="right"><b></b></td>
        <td></td>
        </tr>';
	}
    $output .= '<tr>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>';

    $output .= '<tr><td><b>POSITION</b></td>';
	
	$sql_t1 = mysqli_query($connect, "SELECT id, `term` FROM `terms` WHERE session_id='$sessionID' AND term = 'Term 1' ") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_t1) > 0 ) {
		$t_data1=mysqli_fetch_array($sql_t1);
		
		if ($t_data1['term'] == 'Term 1' && ($total_maxcat+$total_maxexam) != 0){
			$sql_pos = mysqli_query($connect, "SELECT t1.id, student_id, term_id, percentage,session_id,
            (SELECT COUNT(*) FROM student_positions t2 WHERE t2.percentage > t1.percentage and t1.term_id='{$t_data1['id']}' and t2.term_id='{$t_data1['id']}'  AND t1.class='{$_GET['classID']}' AND t2.class='{$_GET['classID']}') +1
            AS position
            FROM student_positions t1 WHERE t1.term_id='{$t_data1['id']}' AND t1.session_id='$sessionID' AND t1.student_id='$studentID' AND t1.class='{$_GET['classID']}' order by position;") or die("Could't fetch data".mysqli_error($connect));
			$rows_pos = mysqli_fetch_array($sql_pos);
			$sql_count_st = mysqli_query($connect, "SELECT COUNT(*) AS count FROM `students` WHERE students.school_level='$school_level' AND students.session='$sessionID' AND students.classname='{$_GET['classID']}'") or die("Could't fetch data".mysqli_error($connect));
            $rows_count = mysqli_fetch_array($sql_count_st);
            if($rows_pos['position'] > 0){
                $output .= '
                <td colspan="3"></td>
                <td colspan="3" align="right"><u><b>'. $rows_pos['position']." / ".$rows_count['count'].'</b></u></td>';
            }else{
                $output .= '
                <td colspan="3"></td>
                <td colspan="3"></td>';
            }
		}
		else{
			$output .= '
			<td colspan="3"></td>
			<td colspan="3"></td>';
		}
	}else{
		$output .= '
		<td colspan="3"></td>
		<td colspan="3"></td>';
	}
	
	$sql_t2 = mysqli_query($connect, "SELECT `id`,`term` FROM `terms` WHERE session_id='$sessionID' AND term = 'Term 2' ") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_t2) > 0 ) {
		$t_data2=mysqli_fetch_array($sql_t2);
		
		if ($t_data2['term'] == 'Term 2' && ($general_total_cat2 + $general_total_exam2) != 0){
			$sql_pos = mysqli_query($connect, "SELECT t1.id, student_id, term_id, percentage,session_id,
            (SELECT COUNT(*) FROM student_positions t2 WHERE t2.percentage > t1.percentage and t1.term_id='{$t_data2['id']}' and t2.term_id='{$t_data2['id']}'  AND t1.class='{$_GET['classID']}' AND t2.class='{$_GET['classID']}') +1
            AS position
            FROM student_positions t1 WHERE t1.term_id='{$t_data2['id']}' AND t1.session_id='$sessionID' AND t1.student_id='$studentID' AND t1.class='{$_GET['classID']}' order by position;") or die("Could't fetch data".mysqli_error($connect));
			$rows_pos = mysqli_fetch_array($sql_pos);
			$sql_count_st = mysqli_query($connect, "SELECT COUNT(*) AS count FROM `students` WHERE students.school_level='$school_level' AND students.session='$sessionID' AND students.classname='{$_GET['classID']}'") or die("Could't fetch data".mysqli_error($connect));
			$rows_count = mysqli_fetch_array($sql_count_st);
			$output .= '
			<td colspan="3" align="right"><u><b>'. $rows_pos['position']." / ".$rows_count['count'].'</b></u></td>';
		}
		else{
			$output .= '
			<td colspan="3"></td>';
		}
	}else{
        $output .= '
        <td colspan="3"></td>
        <td colspan="3"></td>';
    }
	
	
	$sql_t3 = mysqli_query($connect, "SELECT `id`,`term` FROM `terms` WHERE session_id='$sessionID' AND term = 'Term 3' ") or die("Could't fetch data".mysqli_error($connect));
	if (mysqli_num_rows($sql_t3) > 0 ) {
		$t_data3=mysqli_fetch_array($sql_t3);
		
		if ($t_data3['term'] == 'Term 3' && ($general_total_cat3 + $general_total_exam3) != 0){
			$sql_pos = mysqli_query($connect, "SELECT t1.id, student_id, term_id, percentage,session_id,
            (SELECT COUNT(*) FROM student_positions t2 WHERE t2.percentage > t1.percentage and t1.term_id='{$t_data3['id']}' and t2.term_id='{$t_data3['id']}'  AND t1.class='{$_GET['classID']}' AND t2.class='{$_GET['classID']}') +1
            AS position
            FROM student_positions t1 WHERE t1.term_id='{$t_data3['id']}' AND t1.session_id='$sessionID' AND t1.student_id='$studentID' AND t1.class='{$_GET['classID']}' order by position;") or die("Could't fetch data".mysqli_error($connect));
			$rows_pos = mysqli_fetch_array($sql_pos);
			$sql_count_st = mysqli_query($connect, "SELECT COUNT(*) AS count FROM `students` WHERE students.school_level='$school_level' AND students.session='$sessionID' AND students.classname='{$_GET['classID']}'") or die("Could't fetch data".mysqli_error($connect));
			$rows_count = mysqli_fetch_array($sql_count_st);
			
			$sql_pos_y = mysqli_query($connect, "SELECT t1.id, student_id, term_id, percentage,session_id,
            (SELECT COUNT(*) FROM student_positions t2 WHERE t2.percentage > t1.percentage and t1.term_id='y_0' and t2.term_id='y_0'  AND t1.class='{$_GET['classID']}' AND t2.class='{$_GET['classID']}') +1
            AS position
            FROM student_positions t1 WHERE t1.term_id='y_0' AND t1.session_id='$sessionID' AND t1.student_id='$studentID' AND t1.class='{$_GET['classID']}' order by position;") or die("Could't fetch data".mysqli_error($connect));
			$rows_pos_y = mysqli_fetch_array($sql_pos_y);
			
			$output .= '<td colspan="3" align="right"><u><b>'. $rows_pos['position']." / ".$rows_count['count'].'</u></b></td><td colspan="5" align="right"><b><u>'.$rows_pos_y['position']." / ".$rows_count['count'].'</u></b></td>';
		}
		else{
			$output .= '<td colspan="5"></td>';
		}
	}else{
        $output .= '<td colspan="5"></td>';
    }

    $output .= '</tr>';

    $classname = '';
    $sql = mysqli_query($connect, "SELECT `firstname`, `lastname`, sl.level, cl.numbericname, cl.section, sess.academic_year FROM `students` LEFT JOIN classes cl ON cl.id = students.classname LEFT JOIN school_levels sl on sl.id = cl.classname LEFT JOIN sessions sess on sess.id= students.session WHERE students.id='$studentID' AND students.classname='{$_GET['classID']}'");
    $row = mysqli_fetch_array($sql);

    $first_name = $row['firstname'];
    $last_name = $row['lastname'];
    $academic_year = $row['academic_year'];

    if ( $row['level'] == 'Primary'){
        $classname ='P'.$row['numbericname'].$row['section'];
    }else if ( $row['level'] == 'Nursery'){
        $classname ='N'.$row['numbericname'].$row['section'];
    }

    $output .= '
    <tr>
        <td><b>APPLICATION</b></td>
        <td rowspan="3" colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="7"></td>
    </tr>
    <tr>
        <td><b>TEACHER SIGNATURE</b></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td><b>PARENT SIGNATURE</b></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="5"></td>
    </tr>
</table>
<table>
        <tr>
            <td align="left"><b>CATS= Continuous Assessment Tests</b></td>
        </tr>
        <tr>
            <td align="left"><b>EX= Exam</b></td>
        </tr>
</table>
<br pagebreak="true"></br>
<table cellspacing="10">
    <tr>
        <td>
            <tr>
                <td>
                    <h1><b>REGULATIONS</b></h1>
                    <p>1- School fees must be paid at the beginning of the term.</p>
                    <p>2- All pupils must be at school at 7: 00 am and leave at 4 0pm.</p>
                    <p>3- Pupils must be dressed in complete school uniform.</p>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="border: 2px solid #000000;padding-right: 10">
                        <div style="height: 50">
                            <span style="font-size: 10pt; font-weight: bold">OBSERVATION AND RECOMMANDATIONS</span>
                        </div>
                        <div></div>
                        <div>
                            <span>1<small>st</small> TERM</span>
                            <div></div>
                            <div>
                                <b>'.$comment_t_1.'</b>
                            </div>
                            <div></div>
                            <div>
                                Next term will begin on: <b>'.$term2_date.'</b>
                            </div>
                        </div>
                        <div>
                            <span>2<small>nd</small> TERM</span>
                            <div></div>
                            <div>
                                <b>'.$comment_t_2.'</b>
                            </div>
                            <div></div>
                            <div>
                                Next term will begin on: <b>'.$term3_date.'</b>
                            </div>
                        </div>
                        <div>
                            <span>3<small>rd</small> TERM</span>
                            <div></div>
                            <div>
                                <b>'.$comment_t_3.'</b>
                            </div>
                            <div></div>
                        </div>
                        <div>
                            <span>Headmaster signature: _________________________________________________________</span>
                            <div></div>
                            <div>
                                <table>
                                    <tr>
                                        <td></td>
                                        <td align="right">School stamp</td>
                                    </tr>
                                </table>
                            </div>
                            <div></div>
                        </div>
                        <div>
                            Final decision of the yeah
                            <div></div>
                        </div>
                        <div>
                            <table>
                            <tr>
                                <td>Promoted</td>
                                <td>
                                    <table border="2">
                                        <tr>
                                            <td width="10%" height="10%"></td>
                                        </tr>
                                     </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Advised to repeat</td>
                                <td>
                                    <table border="2">
                                        <tr>
                                            <td width="10%" height="10%"></td>
                                        </tr>
                                     </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Expulsion</td>
                                <td>
                                    <table border="2">
                                        <tr>
                                            <td width="10%" height="10%"></td>
                                        </tr>
                                     </table>
                                </td>
                            </tr>
                            </table>
                            <div></div>
                        </div>
                    </div>
                </td>
            </tr>
        </td>
        <td>
            <div style="border: 2px solid #000000;padding-right: 10">
                <div style="text-align: center;">
                    <h1 style="font-size: 30px"><b>IMENA SCHOOL</b></h1>
                    <img src="./Primary Report form 2017.fld/image001.png" height="200px" width="200px"/>
                </div>
                <table>
                    <tr>
                        <td width="40%"></td>
                        <td>
                            <p><b>Email: imenaschool2014@gmail.com</b></p>
                            <p><b>Tel: +250788560615</b></p>
                            <p><b>B.P: 2489 KIGALI</b></p>
                        </td>
                    </tr>
                </table>
                <div></div>
                <div style="text-align: center;">
                    <h1 style="font-size: 30px"><b>REPORT CARD</b></h1>
                </div>
                <div>
                    <table>
                    <tr>
                        <td>
                            <p><b>First Name: __<b>'.$first_name.'</b>________________________________________</b></p>
                            <p><b>Last Name: ____<b>'.$last_name.'</b>_______________________________________</b></p>
                            <p><b>Class: ___<b>'.$classname.'</b>____________________________________________</b></p>
                            <p><b>Academic Year: __<b>'.$academic_year.'</b>_____________________________________</b></p>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </td>
    </tr></table>';

    return $output;
}

require_once('./plugin/tcpdf/tcpdf.php');
require_once('./plugin/tcpdf/config/lang/eng.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    public function Header()
    {
        $this->Write(0, $this->CustomHeaderText);
    }
}

if ($_GET['studentID']) {

  $pdf = new MYPDF();
  $pdf->CustomHeaderText = "";
  $pdf = new TCPDF('L', 'pt', array(900, 700), true,'UTF-8', false);
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetTitle("Student_report");
  $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  $pdf->SetDefaultMonospacedFont('helvetica');
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  $pdf->SetMargins(PDF_MARGIN_LEFT, '30', 75);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);
  $pdf->SetAutoPageBreak(TRUE, 10);
  $pdf->SetFont('helvetica', '', 8);
  $pdf->AddPage();

  //HEADER
  $content .= "<html>";
  $content .= "<table>";
  $content .= fetch_student_name($connect, $_GET['studentID'], $_GET['classID']);
  $content .= "</table>";
  $content .= '<table border="1" cellspacing="0" cellpadding="3">';
  $content .=fetch_header_table();
  $content .=fetch_data($connect, $_GET['termID'], $_GET['studentID'],$_GET['sessionID'], $_GET['school_level']);
  $content .= "</table>";
  $content .= '</table></html';
  $pdf->writeHTML($content, true, false, true, false, 'J');
  ob_end_clean();
  $pdf->Output('example.pdf', 'I');
}else{

  $pdf = new MYPDF();
  $pdf->CustomHeaderText = "";
  $pdf = new TCPDF('L', 'pt', array(900, 700), true,'UTF-8', false);
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetTitle("Student_report");
  $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  $pdf->SetDefaultMonospacedFont('helvetica');
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
  $pdf->SetMargins(PDF_MARGIN_LEFT, '30', 75);
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);
  $pdf->SetAutoPageBreak(TRUE, 10);
  $pdf->SetFont('helvetica', '', 8);
  $pdf->AddPage();

  $sql = mysqli_query($connect, "SELECT `student` FROM `student_marks` LEFT JOIN terms t on t.id = student_marks.term WHERE student_marks.class='{$_GET['classID']}' GROUP BY student_marks.student");
  $array = array();
  if(mysqli_num_rows($sql) == 0){
    $sql = mysqli_query($connect, "SELECT `student` FROM `student_marks` LEFT JOIN terms t on t.id = student_marks.term LIMIT 1");
    $array = array();
    while ($row = mysqli_fetch_array($sql)) {
        $array[] = $row;
    }
  }else{
    while ($row = mysqli_fetch_array($sql)) {
        $array[] = $row;
    }
  }
  for ($i = 0; $i < count($array); $i++){
      //HEADER
      $content .= "<html>";
      $content .= "<table>";
      $content .= fetch_student_name($connect, $array[$i]['student'], $_GET['classID']);
      $content .= "</table>";
      $content .= '<table border="1" cellspacing="0" cellpadding="3">';
      $content .=fetch_header_table();
      $content .=fetch_data($connect, $_GET['termID'], $array[$i]['student'],$_GET['sessionID'], $_GET['school_level']);
      $content .= "</table>";
  }
  //$content .= fetch_data($connect, $_GET['student_id'], $_GET['t_id']);
  $content .= '</table></html';
  $pdf->writeHTML($content, true, false, true, false, 'J');
  ob_end_clean();
  $pdf->Output('example.pdf', 'I');
}
