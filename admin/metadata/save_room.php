<?php 
require_once "../../support/config.php";


if(isset($_POST)){
    $inputs = $_POST;
    unset($_POST);
    if(empty($inputs['room_id'])){ unset($inputs['room_id']); }
    // $inputs['room_name'] = ucfirst(rtrim($inputs['room_name']));
        foreach ($inputs As $val){
            if(empty($val) || is_null($val)){
                Alert("Fill all fields properly","error","Invalid Parameters.",2300);
                redirect("room_meta.php");
                die;
            }
        }
}
// print_ar($inputs);
// die;

if(isset($inputs['type']) && $inputs['type'] == "create"){
    unset($inputs['room_id']);
    unset($inputs['type']);
    $con->beginTransaction();
    $auth = $con->myQuery("INSERT INTO rooms(room_number,room_type) VALUES(:room_number,:room_type)",$inputs);
    if($auth) {
        Alert("Room successfully added!","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("room_meta.php");
        die;
    }else{
        Alert("Something went wrong in saving data..","warning","Opps..",3000);    
        redirect("room_meta.php");
        die;
    }    
}

if(isset($inputs['type']) && $inputs['type'] == "edit"){
    unset($inputs['type']);
    $authId = $con->myQuery("SELECT * FROM rooms WHERE room_id = ? AND is_deleted = 0",array($inputs['room_id']))->rowCount();
    if($authId == 1){
        $con->beginTransaction();   
        $con->myQuery("UPDATE rooms SET room_number = :room_number, room_type = :room_type WHERE room_id = :room_id",$inputs);
        Alert("Room successfully updated","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("room_meta.php");
        die;
    }
}
