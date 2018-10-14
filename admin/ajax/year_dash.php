<?php 

require_once "../../support/config.php";
if(!AllowUser("Admin") || !isset($_SESSION[WEB])){
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

echo json_encode($data);