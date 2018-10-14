<?php
require_once "../support/config.php";
require_once "../support/fpdf.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}

$data = [];
for($i=1;$i<32;$i++){
    $data[''.$i] = 0;
}



$currData = $con->myQuery('SELECT  DAY(date_paid) AS DayOfThisMonth, SUM(fee) AS Sales FROM TRANSACTION WHERE MONTHNAME(date_paid) = "'.date('F').'" AND YEAR(date_paid) = "'.date('Y').'" GROUP BY DAY(date_paid)')->fetchAll(PDO::FETCH_ASSOC);

foreach($currData AS $key => $val){
    foreach($data AS $index => $element){
        if($val['DayOfThisMonth'] == $index){
            $data[$index] = $val['Sales'];
        }
    }
}

$NETTotal = $con->myQuery('SELECT SUM(fee) As NET FROM transaction WHERE MONTHNAME(date_paid) = "'.date('F').'" AND YEAR(date_paid) = "'.date('Y').'"')->fetch(PDO::FETCH_ASSOC);
$NETTotal =  $NETTotal['NET'];



$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetTitle('Payment Record');
$pdf->SetFont('Arial','I',16);
$pdf->Cell('100','5','Ace Water Spa Reservation',0,1,'l');
$pdf->SetFont('Arial','',11);
$pdf->Cell('95','5','Date Report Generated: '.date('F d, Y'),0,1,'L');
$pdf->SetFont('Arial','I',15);
$pdf->Cell('195','10',strtoupper(date('F'))." Sales Report",0,1,'C');
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
