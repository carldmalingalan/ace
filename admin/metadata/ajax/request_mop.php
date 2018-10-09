<?php 
require_once "../../../support/config.php";

if(isset($_POST['deact'])) {
    $auth = $con->myQuery("SELECT * FROM mop WHERE mop_id = ? AND is_deleted = 0",array($_POST['deact']));
    if($auth->rowCount() == 1){
      $con->beginTransaction();
      $authDel =  $con->myQuery("UPDATE mop SET is_deleted = 1 WHERE mop_id= ? ",array($_POST['deact']));
      $con->commit();
    }
    unset($_POST);
    die;
}
if(isset($_POST['id'])) {
    $auth = $con->myQuery("SELECT * FROM mop WHERE mop_id = ? AND is_deleted = 0",array($_POST['id']));
    if($auth->rowCount() == 1){
        $data = $auth->fetch(PDO::FETCH_ASSOC);
        unset($data['is_deleted']);
        echo json_encode($data);
    }
    unset($_POST);
    die;
}