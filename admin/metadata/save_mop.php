<?php 
require_once "../../support/config.php";

if(isset($_POST)){
    $inputs = $_POST;
    unset($_POST);
    if(empty($inputs['mop_id'])){ unset($inputs['mop_id']); }
    $inputs['mop_name'] = ucfirst(rtrim($inputs['mop_name']));
        foreach ($inputs As $val){
            if(empty($val) || is_null($val)){
                Alert("Fill all fields properly","error","Invalid Parameters.",2300);
                redirect("mop_meta.php");
                die;
            }
        }
}


if(isset($inputs['type']) && $inputs['type'] == "create"){
    unset($inputs['mop_id']);
    unset($inputs['type']);
    $con->beginTransaction();
    $auth = $con->myQuery("INSERT INTO mop(mop_name,mop_subtext) VALUES(:mop_name,:mop_subtext)",$inputs);
    if($auth) {
        Alert("Room successfully added!","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("mop_meta.php");
        die;
    }else{
        Alert("Something went wrong in saving data..","warning","Opps..",3000);    
        redirect("mop_meta.php");
        die;
    }    
}


if(isset($inputs['type']) && $inputs['type'] == "edit"){
    unset($inputs['type']);
    $authId = $con->myQuery("SELECT * FROM mop WHERE mop_id = ? AND is_deleted = 0",array($inputs['mop_id']))->rowCount();
    if($authId == 1){
        $con->beginTransaction();   
        $con->myQuery("UPDATE mop SET mop_name = :mop_name, mop_subtext = :mop_subtext WHERE mop_id = :mop_id",$inputs);
        Alert("M.O.P successfully updated","success","Success!",2500);
        $con->commit();
        unset($inputs);
        redirect("mop_meta.php");
        die;
    }
}