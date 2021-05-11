<?php
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$html=require('./PrimaryReport.php');

$pdf->WriteHTML($html);
$pdf->Output();
?>