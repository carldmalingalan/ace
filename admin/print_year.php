<?php
require_once "../support/config.php";
require_once "../support/fpdf.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}

$data = [
    "January" => 0,
    "February" => 0,
    "March" => 0,
    "April" => 0,
    "May" => 0,
    "June" => 0,
    "July" => 0,
    "August" => 0,
    "September" => 0,
    "October" => 0,
    "November" => 0,
    "December" => 0,
];

$currData = $con->myQuery('SELECT MONTHNAME(date_paid) As Month, SUM(fee) As Sales FROM transaction WHERE YEAR(date_paid) = "'.date('Y').'" AND balance = 0 GROUP BY MONTH(date_paid)')->fetchAll(PDO::FETCH_ASSOC);

foreach($currData AS $key => $val){
    foreach($data AS $index => $element){
        if($val['Month'] === $index){
            $data[$index] = $val['Sales'];
        }
    }
}
$NETTotal = $con->myQuery('SELECT SUM(fee) As NET FROM transaction WHERE balance = 0 AND YEAR(date_paid) = "'.date('Y').'"')->fetch(PDO::FETCH_ASSOC);
$NETTotal =  $NETTotal['NET'];
// print_ar($details);
// $hrs = explode(':',$details['stay_duration']);
// $days = $hrs[0] / 24;


$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetTitle('Payment Record');
$pdf->SetFont('Arial','I',16);
$pdf->Cell('100','5','Hotel Reservation System',0,1,'l');
$pdf->SetFont('Arial','',11);
$pdf->Cell('95','5','Date Report Generated: '.date('F d, Y'),0,1,'L');
$pdf->SetFont('Arial','I',15);
$pdf->Cell('195','10',date('Y')." Sales Report",0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell('65','5',"Month",1,0,'C');
$pdf->Cell('65','5',"Sales",1,0,'C');
$pdf->Cell('65','5',"Percentage",1,1,'C');

foreach($data AS $key => $val){
    $percent = ((float)$val / $NETTotal ) * 100;
        $pdf->Cell('65','5',$key,1,0,'C');
        $pdf->Cell('65','5','P '.cleanWoPeso((float)$val),1,0,'C');
        $pdf->Cell('65','5',number_format($percent,2,'.',',')." %",1,1,'C');
    
}
$pdf->Cell('65','5',"",0,0,'C');
$pdf->Cell('65','5',"",0,0,'C');
$pdf->Cell('65','5',"",0,1,'C');
$pdf->Cell('65','5',"",0,0,'C');
$pdf->Cell('65','5',"P ".number_format($NETTotal,2,'.',','),"B",0,'C');
$pdf->Cell('65','5',"100%",'B',1,'C');


$pdf->Output();
