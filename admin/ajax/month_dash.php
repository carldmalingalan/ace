<?php 

require_once "../../support/config.php";
if(!AllowUser("Admin") || !isset($_SESSION[WEB])){
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
echo json_encode($data);