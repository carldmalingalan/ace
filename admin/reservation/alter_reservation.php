<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}

if(isset($_POST['reservation_id'])){
    $authId = $con->myQuery("SELECT * FROM account_reservations A JOIN room_type B ON A.room_type = B.room_type_id WHERE reservation_id = ? AND A.is_deleted = 0",array($_POST['reservation_id']));
    $authRoom = $con->myQuery("SELECT * FROM room_availability WHERE reservation_id = ?",array($_POST['reservation_id']))->fetch(PDO::FETCH_ASSOC);
    $authPayment = $con->myQuery("SELECT * FROM transaction WHERE reservation_id = ? AND is_deleted = 0",array($_POST['reservation_id']))->fetch(PDO::FETCH_ASSOC);
    
    if($authId->rowCount() == 1){
        $data = $authId->fetch(PDO::FETCH_ASSOC);
        $stay = stayDuration($data['checkin'],$data['checkout']);
        $stay = explode(',',$stay);
        $DBstay = $stay[1] * 24 . ":00:00";
        $DBCost = (float)$stay[1] * $data['room_cost'];

        $transaction = array(
            'reservation_id' => $data['reservation_id'],
            'user_id' => $data['user_id'],
            'checkin' => $data['checkin'],
            'checkout'=> $data['checkout'],
            'stay_duration' => $DBstay,
            'room_number' => $_POST['assigned_room'],
            'room_type' => $data['room_type'],
            'mop' => $_POST['mop'],
            'fee' => $DBCost,
            'balance' => $DBCost
        );    
        // print_ar($transaction);
        // print_ar($_POST);
        // die;
        $con->beginTransaction();
        
        $authQuery = $con->myQuery("UPDATE account_reservations SET room_type = :room_type, pax = :pax, mop = :mop, reservation_status = :reservation_status, assigned_room = :assigned_room WHERE reservation_id = :reservation_id AND is_deleted = 0",$_POST);
        if($_POST['reservation_status'] == 2 && empty($authPayment)){
            $authTransaction = $con->myQuery("INSERT INTO transaction(reservation_id,user_id,checkin,checkout,stay_duration,room_number,room_type,mop,fee,balance) VALUES(:reservation_id,:user_id,:checkin,:checkout,:stay_duration,:room_number,:room_type,:mop,:fee,:balance)",$transaction);
        }
        if($_POST['reservation_status'] == 2 && empty($authRoom)){
            $authInsert = $con->myQuery("INSERT INTO room_availability(checkin,checkout,room_number,room_type,user_id,reservation_id) VALUES(?,?,?,?,?,?)",array($data['checkin'],$data['checkout'],$_POST['assigned_room'],$_POST['room_type'],$data['user_id'],$_POST['reservation_id']));            
        }else{
            $authInsert = TRUE;
        }

        if($_POST['transaction'] !== 2 && !empty($authPayment)){
            $con->myQuery("UPDATE transaction SET is_deleted = 1 WHERE reservation_id = ?",array($data['reservation_id']));
        }
        if($_POST['transaction'] == 2 && !empty($authPayment)){
            $con->myQuery("UPDATE transaction SET is_deleted = 0 WHERE reservation_id = ?",array($data['reservation_id']));
        }
        


        if(!empty($authRoom) && $authRoom['is_deleted'] == 0 && in_array($_POST['reservation_status'],array(1,2))){
            $subQuery = $con->myQuery("UPDATE room_availability SET is_deleted = 1 WHERE avail_id = ?",array($authRoom['avail_id']));
        }

        if(!empty($authRoom) && $authRoom['is_deleted'] == 1 && $_POST['reservation_status'] == 2 ){
            $subQuery = $con->myQuery("UPDATE room_availability SET is_deleted = 0 WHERE avail_id = ?",array($authRoom['avail_id']));
        }
        
        if($authQuery && $authInsert){
            $con->commit();
            Alert("Updated reservation details.","success","Success!");
            redirect("index.php");
            die;
        }
    }
    if(!$authQuery || !$authInsert){
        Alert("Invalid User.","error","Error!",2500);
        redirect("index.php");
        die;
    }
    unset($_POST);
}



