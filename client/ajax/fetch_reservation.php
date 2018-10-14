<?php
require_once "../../support/config.php";

if(isset($_POST['res_id']) && !empty($_POST['res_id'])){
    try{
        $dets = $con->myQuery('SELECT reservation_id As save_id,checkin,checkout,pax,room_type,mop FROM account_reservations WHERE reservation_id = :res_id',$_POST)->fetch(PDO::FETCH_ASSOC);
        $dets['checkin'] = date_format(date_create($dets['checkin']),"F d, Y");
        $dets['checkout'] = date_format(date_create($dets['checkout']),"F d, Y");
        echo json_encode($dets);
    }catch(PDOException $e){}
}