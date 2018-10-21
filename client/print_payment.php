<?php
require_once "../support/config.php";
require_once "../support/fpdf.php";


$details = "";

if(isset($_POST) && !empty($_POST)){
    $details = $con->myQuery(
        "SELECT A.*,E.*,G.*,H.room_number As roomnumba,F.*,B.f_name As payee_f_name,B.l_name As payee_l_name,B.m_name As payee_m_name,C.*,D.f_name As cashier_f_name,D.l_name As cashier_l_name,D.m_name As cashier_m_name FROM payment_records A 
        JOIN users B ON A.payee_id = B.id
        JOIN transaction C ON A.transaction_id = C.transaction_id
        JOIN users D ON A.payment_recipient = D.id
        JOIN account_reservations E ON A.reservation_id = E.reservation_id
        JOIN room_type F ON E.room_type = F.room_type_id
        JOIN mop G ON E.mop = G.mop_id
        JOIN rooms H ON E.assigned_room = H.room_id
        WHERE A.payment_id = ?",array($_POST['print_id']))->fetch(PDO::FETCH_ASSOC);
}

if(empty($details)){
    Alert("The record you're trying to print is inaccessible.",'error','Opps..',4000);
    redirect("payment_records.php");
    die;
}
// print_ar($details);
$hrs = explode(':',$details['stay_duration']);
$days = $hrs[0] / 24;
$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetTitle('Payment Record');
$pdf->SetFont('Arial','I',16);
$pdf->Cell('100','5','Hotel Reservation System',0,0,'l');
$pdf->SetFont('Arial','',11);
$pdf->Cell('95','5','Reciept No. : '.$details['payment_id'],0,1,'R');
$pdf->Cell('20','5','Cashier',0,0,'L');
$pdf->Cell('2','5',':',0,0,'C');
$pdf->Cell('73','5',''.fullName($details['cashier_f_name'],$details['cashier_m_name'],$details['cashier_l_name']),0,0,'L');
$pdf->Cell('100','5','Customer : '.fullName($details['payee_f_name'],$details['payee_m_name'],$details['payee_l_name']),0,1,'R');
$pdf->Cell('20','5','Date',0,0,'L');
$pdf->Cell('2','5',':',0,0,'C');
$pdf->Cell('73','5',''.date_format(date_create($details['payment_date']),"m/d/Y h:i:s A"),0,1,'L');
$pdf->Cell('20','5','Check-in',0,0,'L');
$pdf->Cell('2','5',':',0,0,'C');
$pdf->Cell('30','5',''.date_format(date_create($details['checkin']),'m/d/Y'),0,0,'L');
$pdf->Cell('20','5','Check-out',0,0,'L');
$pdf->Cell('2','5',':',0,0,'C');
$pdf->Cell('73','5',''.date_format(date_create($details['checkout']),'m/d/Y'),0,1,'L');
$pdf->Cell('20','5','M.O.P',0,0,'L');
$pdf->Cell('2','5',':',0,0,'C');
$pdf->Cell('30','5',''.$details['mop_name']." - ".$details['mop_subtext'],0,1,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell('195','10','Reservation Details',0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell('70','8','Name',1,0,'C');
$pdf->Cell('70','8','Qty.',1,0,'C');
$pdf->Cell('59','8','Price',1,1,'C');
$pdf->Cell('70','8','Stay Duration',1,0,'C');
$pdf->Cell('70','8',''.(int)$days." day(s), ". ((int)$days - 1)." night(s)",1,0,'C');
$pdf->Cell('59','8','',1,1,'L');
$pdf->Cell('70','8','Pax.',1,0,'C');
$pdf->Cell('70','8',''.$details['pax'],1,0,'C');
$pdf->Cell('59','8','',1,1,'L');
$pdf->Cell('70','8','Room Type',1,0,'C');
$pdf->Cell('70','8',''.$details['room_name'],1,0,'C');
$pdf->Cell('59','8','P '.cleanWoPeso($details['room_cost']),1,1,'C');
$pdf->Cell('70','8','Room Number',1,0,'C');
$pdf->Cell('70','8',''.$details['roomnumba'],1,0,'C');
$pdf->Cell('59','8','',1,1,'C');

$pdf->Cell('70','8','','',0,'C');
$pdf->Cell('70','8','Total :','',0,'C');
$pdf->Cell('59','8','P '.cleanWoPeso($details['fee']),'',1,'C');
$pdf->Cell('70','8','','',0,'C');
$pdf->Cell('70','8','Cash :','',0,'C');
$pdf->Cell('59','8','P '.cleanWoPeso($details['payment_total']),'B',1,'C');
$pdf->Cell('70','8','','',0,'C');
$pdf->Cell('70','8','Change :','',0,'C');
$pdf->Cell('59','8','P '.cleanWoPeso($details['change_total']),'',1,'C');
$pdf->Cell('195','8','Balance : P '.cleanWoPeso($details['balance_total']),'',1,'L');



$pdf->Output();
