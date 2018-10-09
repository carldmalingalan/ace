<?php 

require_once "../../support/config.php";

try{
    $data['users'] = $con->myQuery("SELECT id FROM users WHERE is_activated IN (1,3) AND is_deleted = 0")->rowCount();
    $data['deact'] = $con->myQuery("SELECT id FROM users WHERE is_activated IN (2) AND is_deleted = 0")->rowCount();
    $data['reservations'] = $con->myQuery("SELECT reservation_id FROM account_reservations WHERE is_deleted = 0")->rowCount();
    $data['payments'] = $con->myQuery("SELECT payment_id FROM payment_records WHERE is_deleted = 0")->rowCount();
    echo json_encode($data);
}catch(PDOException $e){}