<?php 

require_once "../support/config.php";
try{
    
$con->beginTransaction();
$con->myQuery("UPDATE account_reservations SET is_deleted = 1 WHERE reservation_id = :reservation_id",$_POST);
$con->commit();
Alert('Reservation canceled!','success','Success!',3000);
redirect('reservations.php');
die;
}catch(PDOException $e){

}