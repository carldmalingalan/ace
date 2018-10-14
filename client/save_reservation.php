<?php
require_once "../support/config.php";
if(!AllowUser("Member") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}
if(isset($_POST)){
    $inputs = $_POST;
    unset($_POST);
    $inputs['user_id'] = $_SESSION[WEB]['id'];
    $inputs['checkin'] = dbDate($inputs['checkin']);
    $inputs['checkout'] = dbDate($inputs['checkout']);
    $auth = $con->myQuery("SELECT * FROM users WHERE id = ? AND is_activated = 1 AND is_deleted = 0",array($inputs['user_id']));
    if($auth->rowCount() !== 1 || $inputs['pax'] > 50){
        Alert("Invalid Parameters!","error","Error!",2000);
        redirect("reservations.php");
        unset($inputs);
        die;
    }
    
}

// print_ar($inputs);
// die;
if(isset($inputs['type']) && $inputs['type'] === "Reserve"){
    unset($inputs['type']);
    unset($inputs['save_id']);
    $con->beginTransaction();
    $authQuery = $con->myQuery("INSERT INTO account_reservations(user_id, checkin, checkout,pax,room_type,mop) VALUES(:user_id, :checkin, :checkout, :pax, :room_type, :mop)",$inputs);
    if($authQuery){
        $con->commit();
        Alert("Reservation is processing..","success","Success!",3500);
        redirect("reservations.php");
        die;
    }else{
        Alert("Something went wrong!","error","Oops..",3000);
        redirect("reservations.php");
        die;
    }
}
if(isset($inputs['type']) && $inputs['type'] === "Update"){
    unset($inputs['type']);    
    try{
        $con->beginTransaction();
        $con->myQuery('UPDATE account_reservations SET checkin = :checkin,checkout = :checkout,pax = :pax,room_type = :room_type,mop = :mop WHERE reservation_id = :save_id AND user_id = :user_id',$inputs);
        $con->commit();
        Alert('Reservation updated.','success','Updated!',3000);
        
    }catch(PDOException $e){
        Alert($e,'error','Update failed!');
    }finally{
        redirect('reservations.php');
        die;
    }
}

