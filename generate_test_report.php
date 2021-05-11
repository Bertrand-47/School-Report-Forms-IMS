<?php
//connect to DB
if (file_exists("./controllers/database/connection.php")) {
    require_once("./controllers/database/connection.php");
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

if (isset($_GET['student_id'])) {

    $pdf = new MYPDF();
    $pdf->CustomHeaderText = "";
    $pdf = new TCPDF('P', 'pt', PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle("" . fetch_fullname($connect, $_GET['student_id'], $_GET['t_id']));
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '25', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->AddPage();

    //HEADER
    $content .= "<html>";
    $content .= "<table>";
    $content .= fetch_student_name($connect, $_GET['student_id'], $_GET['t_id']);
    $content .= "</table>";
    $content .= '
    <table border="1" cellpadding="4">
        <tr>
            <td>
               <b>COURSE</b>
            </td>
            <td>
               <b>MAX MARKS</b>
            </td>
            <td>
               <b>MARKS</b>
            </td>
        </tr>';

    $content .= fetch_data($connect, $_GET['student_id'], $_GET['t_id']);
    $content .= '</table></html';

    $pdf->writeHTML($content, true, false, true, false, 'J');
    $pdf->Output("" . fetch_fullname($connect, $_GET['student_id'], $_GET['t_id']) . "_report.pdf", 'I');
} //multiple students
else if (isset($_GET['multiple_student'])) {
    $pdf = new MYPDF();
    $pdf->CustomHeaderText = "";
    $pdf = new TCPDF('P', 'pt', PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle("Student_test_reports");
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '25', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->AddPage();

    $sql = mysqli_query($connect, "SELECT DISTINCT `id`, `t_id`, `student`, `course`, `marks`, `date_created` FROM `test_period_marks` WHERE t_id= '{$_GET['t_id']}' GROUP  BY student");
    $array = array();
    while ($row = mysqli_fetch_array($sql)) {
        $array[] = $row;
    }
    for ($i = 0; $i < count($array); $i++){
        //HEADER
        $content .= "<html>";
        $content .= "<table>";
        $content .= fetch_student_name($connect, $array[$i]['student'], $_GET['t_id']);
        $content .= "</table>";
        $content .= '
        <table border="1" cellpadding="4">
            <tr>
                <td>
                   <b>COURSE</b>
                </td>
                <td>
                   <b>MAX MARKS</b>
                </td>
                <td>
                   <b>MARKS</b>
                </td>
            </tr>';

        $content .= fetch_data($connect, $array[$i]['student'], $_GET['t_id']);
        $content .= '</table></html>';
        $content .='<br pagebreak="true"/>';
    }

    $pdf->writeHTML($content, true, false, true, false, 'J');
    $pdf->Output("Student_test_reports.pdf", 'I');
}
function fetch_data($connect, $student_id, $t_id)
{
    $output = '';
    $result = mysqli_query($connect, "SELECT DISTINCT test_period_marks.`id`, s.firstname, s.lastname, tc.courname, tc.maxmark, `marks`,t.term, tp.name, test_period_marks.`date_created` FROM `test_period_marks` LEFT JOIN students s ON s.id = test_period_marks.student LEFT JOIN test_period_courses tc ON tc.id = test_period_marks.course LEFT JOIN test_period tp on tp.id= test_period_marks.t_id LEFT JOIN terms t ON t.id = tp.term WHERE test_period_marks.student='$student_id' AND test_period_marks.t_id='$t_id'");
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<tr>
                          <td><b>' . $row["courname"] . '</b></td>
                          <td align="right" bgcolor="#eeeeee"><b>' . $row["maxmark"] . '</b></td>
                          <td align="right"><b>' . $row["marks"] . '</b></td>
                     </tr>
                          ';
    }
    return $output;
}

function fetch_student_name($connect, $student_id, $t_id)
{
    $student_name = '';
    $sql = mysqli_query($connect, "SELECT DISTINCT s.firstname, s.lastname, tp.name, t.term FROM `test_period_marks` LEFT JOIN students s ON s.id = test_period_marks.student LEFT JOIN test_period tp on tp.id = test_period_marks.t_id LEFT JOIN terms t ON t.id = tp.term  WHERE test_period_marks.student='$student_id' AND test_period_marks.t_id='$t_id'");
    $row = mysqli_fetch_array($sql);
    $student_name .= '<tr>
                        <td align="left"><b>Name: ' . $row['firstname'] . ' ' . $row['lastname'] . '</b></td>
                        <td align="center"><b>Term: ' . $row['term'] . '</b></td>
                        <td align="right"><b>Test: ' . $row['name'] . '</b></td>
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

function fetch_fullname($connect, $student_id, $t_id)
{
    $sql = mysqli_query($connect, "SELECT DISTINCT s.firstname, s.lastname FROM `test_period_marks` LEFT JOIN students s ON s.id = test_period_marks.student WHERE test_period_marks.student='$student_id' AND test_period_marks.t_id='$t_id'");
    $row = mysqli_fetch_array($sql);
    $fullname = $row['firstname'] . ' ' . $row['lastname'];

    return $fullname;
}