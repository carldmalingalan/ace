<?php 
require_once "../../support/config.php";


try{
    $con->beginTransaction();
    switch($_POST['type']){
        case "create":
        $con->myQuery("INSERT INTO promos(promo_name, food_service, room_type, pax, cost, due) VALUES(?,?,?,?,?,?)",array(trim($_POST['promo_name']),implode(",",$_POST['food_service']),implode($_POST['room_type']),$_POST['pax'],dbPeso($_POST['cost']),dbDate($_POST['promo_duration'])));
        Alert("Promo successfully created.","success","Success!");
        break;
        case "edit":
        $con->myQuery("UPDATE promos SET promo_name = ? , food_service = ?, room_type = ?, pax = ?, cost = ?, due = ? WHERE ID = ?",array(trim($_POST['promo_name']),implode(",",$_POST['food_service']),implode($_POST['room_type']),$_POST['pax'],dbPeso($_POST['cost']),dbDate($_POST['promo_duration']),$_POST['ID']));
        Alert("Promo successfully updated.","success","Success!");            
        break;
    }
    redirect("promo_meta.php");
    $con->commit();
}catch(PDOException $e){
    Alert($e,"error","Something went wrong!");
    redirect("promo_meta.php");
}