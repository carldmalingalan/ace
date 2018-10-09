<?php 
require_once "../../support/config.php";



if(isset($_POST)){
    $inputs = $_POST;
    unset($_POST);
    $inputs['room_name'] = ucfirst(rtrim($inputs['room_name']));
    $inputs['room_cost'] = dbPeso($inputs['room_cost']);
    if(empty($inputs['room_type_id'])){ unset($inputs['room_type_id']); }
        foreach ($inputs As $val){
            if(empty($val) || is_null($val) || !filter_var($inputs['room_cost'],FILTER_VALIDATE_FLOAT)){
                Alert("Fill all fields properly","error","Invalid Parameters.",2300);
                redirect("roomtype_meta.php");
                die;
            }
        }
}


if(isset($inputs['type']) && $inputs['type'] == "create"){
    unset($inputs['room_id']);
    unset($inputs['type']);
    $con->beginTransaction();
    $auth = $con->myQuery("INSERT INTO room_type(room_name,room_capacity,room_cost) VALUES(:room_name,:room_capacity,:room_cost)",$inputs);
    if($auth) {
        Alert("Room successfully added!","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("roomtype_meta.php");
        die;
    }else{
        Alert("Something went wrong in saving data..","warning","Opps..",3000);    
        redirect("roomtype_meta.php");
        die;
    }    
}

if(isset($inputs['type']) && $inputs['type'] == "edit"){
    unset($inputs['type']);
    $authId = $con->myQuery("SELECT * FROM room_type WHERE room_type_id = ? AND is_deleted = 0",array($inputs['room_type_id']))->rowCount();
    if($authId == 1){
        $con->beginTransaction();   
        $con->myQuery("UPDATE room_type SET room_name = :room_name, room_capacity = :room_capacity, room_cost = :room_cost WHERE room_type_id = :room_type_id",$inputs);
        Alert("Room successfully updated","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("roomtype_meta.php");
        die;
    }
}