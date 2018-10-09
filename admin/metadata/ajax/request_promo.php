<?php 
require_once "../../../support/config.php";

if(isset($_POST['deact'])) {
    $auth = $con->myQuery("SELECT * FROM promos WHERE id = ? AND is_deleted = 0",array($_POST['deact']));
    if($auth->rowCount() == 1){
      $con->beginTransaction();
      $authDel =  $con->myQuery("UPDATE promos SET is_deleted = 1 WHERE id= ? ",array($_POST['deact']));
      $con->commit();
    }
    unset($_POST);
    die;
}

if(isset($_POST['id'])) {
    $auth = $con->myQuery("SELECT * FROM promos WHERE id = ? AND is_deleted = 0",array($_POST['id']));
    if($auth->rowCount() == 1){
        $data = $auth->fetch(PDO::FETCH_ASSOC);
        $data['type'] = "Update";
        $data['due'] = date_format(date_create($data['due']),"F d, Y");
        unset($data['is_deleted']);
        echo json_encode($data);
    }
    unset($_POST);
    die;
}