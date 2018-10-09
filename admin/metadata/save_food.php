<?php 
require_once "../../support/config.php";
if(isset($_POST)){
    $inputs = $_POST;
    $inputs['food_type'] = cleanDB($inputs['food_type']);
    $inputs['service_duration'] = cleanDB($inputs['service_duration']);
    foreach($inputs as $val => $key){
        if(empty($val) && $key !== "id"){
            Alert('Parameters invalid.','error','Error!');
            redirect("food_meta.php");
            die;
        }
    }
}
if(isset($_POST) && $_POST['type'] == "create"){
    unset($inputs['id']);
    unset($inputs['type']);
    try{
        $con->beginTransaction();
        $insert = $con->myQuery("INSERT INTO food_service(food_type,service_duration) VALUES(:food_type,:service_duration)",$inputs);
        $con->commit();
        Alert('Successfully added.','success','Success!');
        redirect("food_meta.php");
        die;
    }catch(PDOException $e){
        Alert('Something went wrong -'.$e,'error','Oops!');
        redirect("food_meta.php");
        die;
    }
}
if(isset($_POST) && $_POST['type']=='edit'){
    unset($inputs['type']);
    try{
        $con->beginTransaction();
        $update = $con->myQuery("UPDATE food_service SET food_type = :food_type, service_duration = :service_duration WHERE id = :id AND is_deleted = 0",$inputs);
        $con->commit();
        Alert('Successfully updated.','success','Success!');
        redirect("food_meta.php");
        die;
    }catch(PDOException $e){
        Alert('Something went wrong -'.$e,'error','Oops!');
        redirect("food_meta.php");
        die;
    }
}