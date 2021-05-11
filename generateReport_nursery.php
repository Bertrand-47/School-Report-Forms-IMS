<?php
//connect to DB
if (file_exists("./controllers/database/connection.php")) {
    require_once("./controllers/database/connection.php");
}

$first_name = '';
$last_name = '';
$classname = '';
$academic_year = '';
$positionArray = [];

//NURSERY REPORT
if (isset($_GET['school_level']) && isset($_GET['studentID']) && isset($_GET['classID'])  && isset($_GET['schoolkey'])){
    $sql_student_name = mysqli_query($connect, "SELECT `id`, `school`, `firstname`, `lastname`, `classname`, `date_birth`, `gender`, `fathername`, `mothername`, `phonenumber`, `address`, `date_created` FROM `students` WHERE id='{$_GET['studentID']}' and school = '{$_GET['schoolkey']}' AND students.classname='$classID'");
    if (mysqli_num_rows($sql_student_name) == 1) {
        $rows_student_name = mysqli_fetch_array($sql_student_name);
        $first_name = $rows_student_name['firstname'];
        $last_name = $rows_student_name['lastname'];
    }

    //class
    $sql_class = mysqli_query($connect, "SELECT DISTINCT  classes.`id`,classes.school, classes.session, sl.level, `numbericname`, section, classes.`date_created` FROM `classes` LEFT JOIN school_levels sl ON sl.id = classes.classname WHERE classes.`id` = '{$_GET['classID']}'") or die("Could't fetch data" . mysqli_error($connect));

    if (mysqli_num_rows($sql_class) == 1) {
        $rows_class = mysqli_fetch_array($sql_class);

        if ($rows_class['level'] == 'Primary') {
            $classname = 'P' . $rows_class['numbericname'] . $rows_class['section'];
        } else if ($rows_class['level'] == 'Nursery') {
            $classname = 'N' . $rows_class['numbericname'] . $rows_class['section'];
        }
    }

    //session
    $sql = mysqli_query($connect, "SELECT `id`, school, academic_year, `startdate`,`enddate`, `date_created` FROM `sessions` WHERE id = '{$_GET['sessionID']}'") or die("Could't fetch data" . mysqli_error($connect));
    if (mysqli_num_rows($sql) == 1) {
        while ($rows = mysqli_fetch_array($sql)) {
            $array[] = $rows;

            $academic_year = $rows['academic_year'];
        }
    }

    //terms
    $sql_term = mysqli_query($connect, "select a.term term1,a.startingdate startingdate1, a.endingdate endingdate1, b.term term2,b.startingdate startingdate2, b.endingdate endingdate2, c.term term3,c.startingdate startingdate3, c.endingdate endingdate3
        from terms a
        left join terms b on a.session_id=b.session_id and a.term != b.term
        left join terms c on b.session_id=c.session_id and b.id < c.id
        where a.id = '{$_GET['termID']}' GROUP BY a.id ") or die("Could't fetch data" . mysqli_error($connect));
    if (mysqli_num_rows($sql_term) > 0) {
        $rowsTerm = mysqli_fetch_array($sql_term);
    }
}

function fetch_student_name($connect, $student_id)
{
    $student_name = '';
    $classname = '';
    $sql = mysqli_query($connect, "SELECT `firstname`, `lastname`, sl.level, cl.numbericname, cl.section, sess.academic_year FROM `students` LEFT JOIN classes cl ON cl.id = students.classname LEFT JOIN school_levels sl on sl.id = cl.classname LEFT JOIN sessions sess on sess.id= students.session WHERE students.id='$student_id'");
    $row = mysqli_fetch_array($sql);
    $classname ='N'.$row['numbericname'].$row['section'];
    $student_name .= '<tr>
                        <td align="left"><b>Names: ' . $row['firstname'] . ' ' . $row['lastname'] . '</b></td>
                        <td align="center"><b>Classe: ' . strtoupper($classname) . '</b></td>
                        <td align="right"><b>Anne Scolaire: ' . $row['academic_year'] . '</b></td>
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

function fetch_student_card($connect, $sessionID, $studentID,$class){
    $output ='';

    $firstname = '';
    $lastname = '';
    $classname = '';
    $sql = mysqli_query($connect, "SELECT `firstname`, `lastname`, sl.level, cl.numbericname, cl.section, sess.academic_year FROM `students` LEFT JOIN classes cl ON cl.id = students.classname LEFT JOIN school_levels sl on sl.id = cl.classname LEFT JOIN sessions sess on sess.id= students.session WHERE students.id='$studentID' AND students.classname='{$_GET['classID']}'");
    $row = mysqli_fetch_array($sql);

    $comment = mysqli_query($connect, "SELECT `student`, `session`, `class`, terms.term, `comment` FROM `student_comments` LEFT JOIN terms ON terms.id = student_comments.term WHERE student='$studentID' AND session='$sessionID' AND class='$class' AND terms.term='Term 1'");
    $comment_row = mysqli_fetch_array($comment);

    $term = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, terms.term, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE session_id='$sessionID' AND terms.term='Term 1'");
    $term_row = mysqli_fetch_array($term);
	
	$comment2 = mysqli_query($connect, "SELECT `student`, `session`, `class`, terms.term, `comment` FROM `student_comments` LEFT JOIN terms ON terms.id = student_comments.term WHERE student='$studentID' AND session='$sessionID' AND class='$class'AND terms.term='Term 2'");
    $comment_row2 = mysqli_fetch_array($comment2);
	
	$term2 = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, terms.term, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE session_id='$sessionID' AND terms.term='Term 2'");
    $term_row2 = mysqli_fetch_array($term2);
	
	$comment3 = mysqli_query($connect, "SELECT `student`, `session`, `class`, terms.term, `comment` FROM `student_comments` LEFT JOIN terms ON terms.id = student_comments.term WHERE student='$studentID' AND session='$sessionID' AND class='$class'AND terms.term='Term 3'");
    $comment_row3 = mysqli_fetch_array($comment3);
	
	$term3 = mysqli_query($connect, "SELECT `id`, `school`, `session_id`, terms.term, `startingdate`, `endingdate`, `date_created` FROM `terms` WHERE session_id='$sessionID' AND terms.term='Term 3'");
    $term_row3 = mysqli_fetch_array($term3);

    $comment_t_1 ='';
    if ($comment_row['term'] === 'Term 1'){
        $comment_t_1 .=$comment_row['comment'];
    }

    $comment_t_2 ='';
    if ($comment_row2['term'] === 'Term 2'){
        $comment_t_2 .=$comment_row2['comment'];
    }

    $comment_t_3 ='';
    if ($comment_row3['term'] === 'Term 3'){
        $comment_t_3 .=$comment_row3['comment'];
    }

    $term2_date ='';
    if ($term_row2['term'] === 'Term 2') {
        $term2_date .= $term_row2['startingdate'];
    }

    $term3_date ='';
    if ($term_row3['term'] === 'Term 3') {
        $term3_date .= $term_row3['startingdate'];
    }

    $classname ='N'.$row['numbericname'].$row['section'];
    $firstname = $row['firstname'];
    $lastname=$row['lastname'];
    $academic_year=$row['academic_year'];
    $output .= '
    <table cellspacing="10">
        <tr>
            <td>
                <tr>
                    <td>
                        <h1><b>REGULATIONS</b></h1>
                        <p>1 –Le minerval doit etre paye avant la rentree scolaire.</p>
                        <p>2 –Tous les eleves doivent etre a l’ecole a 7h00 et quitter a 12h00.</p>
                        <p>3 –Les eleves doivent porter l’uniforme de l’ecole.</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="border: 2px solid #000000;padding-right: 10px">
                            <div style="height: 50">
                                <span style="font-size: 10pt; font-weight: bold">OBSERVATION ET RECOMMANDATIONS</span>
                            </div>
                            <div></div>
                            <div>
                                <span>1<small>er</small> Trimestre:</span>
                                <div></div>
                                <div>
                                    <b>'.$comment_t_1.'</b>
                                </div>
                                <div></div>
                                <div>
                                    Le trimestre suivant commencera: <b>'.$term2_date.'</b>
                                </div>
                            </div>
                            <div>
                                <span>2<small>ème</small> Trimestre:</span>
                                <div></div>
                                <div>
                                    <b>'.$comment_t_2.'</b>
                                </div>
                                <div></div>
                                <div>
                                    Le trimestre suivant commencera: <b>'.$term3_date.'</b>
                                </div>
                            </div>
                            <div>
                                <span>3<small>ème</small> Trimestre:</span>
                                <div></div>
                                <div>
                                    <b>'.$comment_t_3.'</b>
                                </div>
                                <div></div>
                            </div>
                            <div>
                                <span>Signature du Directeur: _________________________________________________________</span>
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
                                La décision finale de l’année (cocher dans la case correspondante)
                                <div></div>
                            </div>
                            <div>
                                <table>
                                <tr>
                                    <td>Promus</td>
                                    <td>
                                        <table border="2">
                                            <tr>
                                                <td width="10%" height="10%"></td>
                                            </tr>
                                         </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Proposé au redoublement</td>
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
                        <h1 style="font-size: 30px"><b>BULLETIN DE L\'ECOLE</b></h1>
                    </div>
                    <div>
                        <table>
                        <tr>
                            <td>
                                <p><b>First Name: __<b>'.$firstname.'</b>________________________________________</b></p>
                                <p><b>Last Name: ____<b>'.$lastname.'</b>_______________________________________</b></p>
                                <p><b>Class: ___<b style="text-transform:capitalize">'.$classname.'</b>____________________________________________</b></p>
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

function fetch_data($connect, $studentID, $sessionID, $school_level)
{
    $output = '';
    $header =array();
    $row_term1 =array();
    $row_term2 =array();
    $row_term3 =array();
	$term1Data =array();
	$term2Data =array();
	$term3Data =array();
	$courses =array();
    $sql = mysqli_query($connect, "SELECT nursery_marks.`id`, nursery_marks.`school`, nursery_marks.`school_level`, t.term, nursery_marks.`session`, nursery_marks.`class`, nursery_marks.`student`, c.coursename as cname, `quotation`, nursery_marks.`date_created` FROM `nursery_marks` LEFT JOIN terms t ON t.id = nursery_marks.term left JOIN courses c on c.id = nursery_marks.course
	WHERE student='$studentID'  AND nursery_marks.session = '$sessionID' AND nursery_marks.class='{$_GET['classID']}'
	UNION ALL 
	SELECT '',  courses.school, courses.school_level, '', '', '', '', courses.coursename as cname, '','' FROM courses WHERE courses.school_level = 2 AND courses.id not IN (SELECT nursery_marks.course FROM `nursery_marks` LEFT JOIN terms t ON t.id = nursery_marks.term left JOIN courses c on c.id = nursery_marks.course WHERE student='$studentID' AND nursery_marks.session = '$sessionID' AND nursery_marks.class='{$_GET['classID']}')");

    $output .= '<table border="1" cellspacing="0" cellpadding="5">';
    $output .='<tr><td rowspan="2" bgcolor="#dddddd">ACTIVITES</td>';
    while ($row = mysqli_fetch_array($sql)) {
		$courses[] = $row['cname'];
		if($row['term'] == 'Term 1'){
			$term1Data[] = $row;	
		}
		if($row['term'] == 'Term 2'){
			  $term2Data[] = $row;	
		}
		if($row['term'] == 'Term 3'){
			  $term3Data[] = $row;	
		}		
    }
	
	if (count($courses) > 0){
	  $course_un = array_unique($courses);
	  for($i = 0; $i < count($course_un); $i++){
		  $output .= "<td bgcolor='#dddddd'>".$course_un[$i]."</td>";
	  }
	  $output .= '<td bgcolor="#dddddd">COTATION</td>
	  <td bgcolor="#dddddd">SIGNATURE DE PARENT</td></tr>';

	  $output .= '<tr>
	  <td><img src="./Nursery Report Card.fld/image002.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image004.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image005.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image007.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image009.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image011.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image013.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image015.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/VERT.png" width="80px" height="80px"/></td>
	  <td><img src="./Nursery Report Card.fld/image018.png" width="80px" height="80px"/></td>
	  </tr>';
	  $output .="<tr> <td bgcolor='#dddddd'>1st SEMESTER</td>";
	  for($i=0; $i < count($course_un); $i++){
		  if(!empty($term1Data[$i]['cname'])){
			if($term1Data[$i]['cname'] == $course_un[$i]){
				$output .='<td>';
                if($term1Data[$i]['quotation'] == 'EXCELENT NO COLOR'){
                    $output .= '<img src="./Nursery Report Card.fld/excellent.png" width="80" height="80"/>';  
                }else if ($term1Data[$i]['quotation'] == 'EXCELENT COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image023.png" width="80" height="80"/>';  
                }if($term1Data[$i]['quotation'] == 'VERY GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/tresbien.png" width="80" height="80"/>';  
                }else if ($term1Data[$i]['quotation'] == 'VERY GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image028.png" width="80" height="80"/>';  
                }if($term1Data[$i]['quotation'] == 'GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/bien.png" width="80" height="80"/>';  
                }else if ($term1Data[$i]['quotation'] == 'GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image030.png" width="80" height="80"/>';  
                }if($term1Data[$i]['quotation'] == 'FAIL NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/echec.png" width="80" height="80"/>';  
                }else if ($term1Data[$i]['quotation'] == 'FAIL COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image031.png" width="80" height="80"/>';  
                }
                $output .='</td>';
			}
		  }else{
			$output .= '<td bgcolor="#dddddd"></td>';
		  }
	  }
	  $output .='<td><img src="./Nursery Report Card.fld/blue.png" width="80px" height="80px"/></td>';
	  $output .= '<td></td>';
	  $output .="</tr>";
	  
	  $output .="<tr> <td bgcolor='#dddddd'>2nd SEMESTER</td>";
	  for($i=0; $i < count($course_un); $i++){
		  if(!empty($term2Data[$i]['cname'])){
			$output .='<td>';
                if($term2Data[$i]['quotation'] == 'EXCELENT NO COLOR'){
                    $output .= '<img src="./Nursery Report Card.fld/excellent.png" width="80" height="80"/>';  
                }else if ($term2Data[$i]['quotation'] == 'EXCELENT COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image023.png" width="80" height="80"/>';  
                }if($term2Data[$i]['quotation'] == 'VERY GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/tresbien.png" width="80" height="80"/>';  
                }else if ($term2Data[$i]['quotation'] == 'VERY GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image028.png" width="80" height="80"/>';  
                }if($term2Data[$i]['quotation'] == 'GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/bien.png" width="80" height="80"/>';  
                }else if ($term2Data[$i]['quotation'] == 'GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image030.png" width="80" height="80"/>';  
                }if($term2Data[$i]['quotation'] == 'FAIL NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/echec.png" width="80" height="80"/>';  
                }else if ($term2Data[$i]['quotation'] == 'FAIL COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image031.png" width="80" height="80"/>';  
                }
                $output .='</td>';
		  }else{
			$output .= '<td bgcolor="#dddddd"></td>';
		  }
	  }
	  $output .='<td><img src="./Nursery Report Card.fld/JAUNE.png" width="80px" height="80px"/></td>';
	  $output .= '<td></td>';
	  $output .="</tr>";
	  
	  $output .="<tr> <td bgcolor='#dddddd'>3eme SEMESTER</td>";
	  for($i=0; $i < count($course_un); $i++){
		  if(!empty($term3Data[$i]['cname'])){
			$output .='<td>';
                if($term3Data[$i]['quotation'] == 'EXCELENT NO COLOR'){
                    $output .= '<img src="./Nursery Report Card.fld/excellent.png" width="80" height="80"/>';  
                }else if ($term3Data[$i]['quotation'] == 'EXCELENT COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image023.png" width="80" height="80"/>';  
                }if($term3Data[$i]['quotation'] == 'VERY GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/tresbien.png" width="80" height="80"/>';  
                }else if ($term3Data[$i]['quotation'] == 'VERY GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image028.png" width="80" height="80"/>';  
                }if($term3Data[$i]['quotation'] == 'GOOD NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/bien.png" width="80" height="80"/>';  
                }else if ($term3Data[$i]['quotation'] == 'GOOD COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image030.png" width="80" height="80"/>';  
                }if($term3Data[$i]['quotation'] == 'FAIL NO COLOR'){
                  $output .= '<img src="./Nursery Report Card.fld/echec.png" width="80" height="80"/>';  
                }else if ($term3Data[$i]['quotation'] == 'FAIL COLOR') {
                    $output .= '<img src="./Nursery Report Card.fld/image031.png" width="80" height="80"/>';  
                }
                $output .='</td>';
		  }else{
			$output .= '<td bgcolor="#dddddd"></td>';
		  }
	  }
	  $output .='<td><img src="./Nursery Report Card.fld/ROUGE.png" width="80px" height="80px"/></td>';
	  $output .= '<td></td>';
	  $output .="</tr>";
	}
  
  $sql_result_remarque_t1 = mysqli_query($connect, "SELECT * FROM (SELECT t.id AS termID, t.term, student_remarques.remarques from student_remarques LEFT JOIN terms t ON t.id = student_remarques.term WHERE student_remarques.student = '$studentID' AND student_remarques.session = '$sessionID' ANd t.term='Term 1' ORDER BY student_remarques.date_created DESC) AS a GROUP BY termID ");
  
  $output .= '<tr><td height="100"><b>REMARQUES</b></td>';
  $remarques = array();
  while($row_r_term = mysqli_fetch_array($sql_result_remarque_t1)){
	  $remarques[] =$row_r_term;
  }
  if(count($remarques) > 0){
	  $output .='<td colspan="3" align="center" height="100" ><b>1er TRIMESTRE</b><br/><div>'.$remarques[0]['remarques'].'</div></td>';
  }else{
	$output .= '<td colspan="3" align="center" height="100" ><b>1er TRIMESTRE</b></td>';
  }
	  
  /*for($i=0; $i < count($remarques); $i++){
	  if ($remarques[$i]['term'] == 'Term 1') {
		$output .='<td colspan="3" align="center" height="100" ><b>1er TRIMESTRE</b><br/><div>'.$remarques[$i]['remarques'].'</div></td>';
	  }else{
		$output .= '<td colspan="3" align="center" height="100" ><b>1er TRIMESTRE</b></td>';
	  }
  }*/
  $sql_result_remarque_t2 = mysqli_query($connect, "SELECT * FROM (SELECT t.id AS termID, t.term, student_remarques.remarques from student_remarques LEFT JOIN terms t ON t.id = student_remarques.term WHERE student_remarques.student = '$studentID' AND student_remarques.session = '$sessionID' ANd t.term='Term 2' ORDER BY student_remarques.date_created DESC) AS a GROUP BY termID ");
  
  $remarques2 = array();
  while($row_r_term2 = mysqli_fetch_array($sql_result_remarque_t2)){
	  $remarques2[] =$row_r_term2;
  }
  if(count($remarques2) > 0){
	  $output .='<td colspan="3" align="center" height="100" ><b>2eme TRIMESTRE</b><br/><div>'.$remarques2[0]['remarques'].'</div></td>';
  }else{
	$output .= '<td colspan="3" align="center" height="100" ><b>2eme TRIMESTRE</b></td>';
  }
  /*for($i=0; $i < count($remarques2); $i++){
	  if ($remarques2[$i]['term'] == 'Term 2') {
		  $output .='<td colspan="3" align="center" height="100" ><b>2eme TRIMESTRE</b><br/><div>'.$remarques2[$i]['remarques'].'</div></td>';
	  }else{
		$output .= '<td colspan="3" align="center" height="100" ><b>2eme TRIMESTRE</b></td>';
	  }
  }*/
  $sql_result_remarque_t3 = mysqli_query($connect, "SELECT * FROM (SELECT t.id AS termID, t.term, student_remarques.remarques from student_remarques LEFT JOIN terms t ON t.id = student_remarques.term WHERE student_remarques.student = '$studentID' AND student_remarques.session = '$sessionID' ANd t.term='Term 3' ORDER BY student_remarques.date_created DESC) AS a GROUP BY termID ");
  
  $remarques3 = array();
  while($row_r_term3 = mysqli_fetch_array($sql_result_remarque_t3)){
	  $remarques3[] =$row_r_term3;
  }
  if(count($remarques3) > 0){
	  $output .='<td colspan="3" align="center" height="100" ><b>3eme TRIMESTRE</b><br/><div>'.$remarques3[0]['remarques'].'</div></td>';
  }else{
	$output .= '<td colspan="3" align="center" height="100" ><b>3eme TRIMESTRE</b></td>';
  }
  /*for($i=0; $i < count($remarques3); $i++){
	  if ($remarques3[$i]['term'] == 'Term 3') {
		  $output .='<td colspan="3" align="center" height="100" ><b>3eme TRIMESTRE</b><br/><div>'.$remarques3[$i]['remarques'].'</div></td>';
	  }else{
		$output .= '<td colspan="3" align="center" height="100" ><b>3eme TRIMESTRE</b></td>';
	  }
  }*/
  $output .= '</tr>';
  $output .= '
  </table>
  <br pagebreak="true"></br>';
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
$pdf->SetMargins(PDF_MARGIN_LEFT, '25', 20);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage();
$content .= "<html>";
$content .= "<table>";

if(!isset($_GET['studentID'])){
	$sql = mysqli_query($connect, "SELECT `student` FROM nursery_marks LEFT JOIN terms t on t.id = nursery_marks.term WHERE t.id= '{$_GET['termID']}' AND nursery_marks.session = '{$_GET['sessionID']}' AND nursery_marks.class='{$_GET['classID']}' GROUP BY nursery_marks.student");
	$array = array();
	while ($row = mysqli_fetch_array($sql)) {
		$array[] = $row;
	}
	if(count($array) > 0){
		for ($i = 0; $i < count($array); $i++){
			//HEADER
			$content .= fetch_student_name($connect, $array[$i]['student']);
			$content .=fetch_data($connect, $array[$i]['student'],$_GET['sessionID'], $_GET['school_level']);
			$content .= fetch_student_card($connect, $_GET['sessionID'], $array[$i]['student'], $_GET['classID']);
		}
	}	
}
else if(isset($_GET['studentID'])){
		$sql_2 = mysqli_query($connect, "SELECT students.id FROM students WHERE students.id ={$_GET['studentID']}");
		$row_2 = mysqli_fetch_array($sql_2);
		//HEADER
		$content .= fetch_student_name($connect, $row_2['id']);
		$content .=fetch_data($connect, $row_2['id'],$_GET['sessionID'], $_GET['school_level']);
		$content .= fetch_student_card($connect, $_GET['sessionID'], $row_2['id'], $_GET['classID']);
	}else{
		$sql_3 = mysqli_query($connect, "SELECT students.id FROM students WHERE students.classname ={$_GET['classID']}");
		while ($row_3 = mysqli_fetch_array($sql_3)) {
			$array_3[] = $row_3;
		}
		for ($i = 0; $i < count($array_3); $i++){
			//HEADER
			$content .= fetch_student_name($connect, $array_3[$i]['id']);
			$content .=fetch_data($connect, $array_3[$i]['id'],$_GET['sessionID'], $_GET['school_level']);
			$content .= fetch_student_card($connect, $_GET['sessionID'], $array_3[$i]['id'], $_GET['classID']);
		}
	}
$content .= '</table></html';
$pdf->writeHTML($content, true, false, true, false, 'J');
ob_end_clean();$pdf->Output('example.pdf', 'I');