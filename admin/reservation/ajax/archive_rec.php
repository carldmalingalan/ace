<?php
require_once "../../../support/config.php";
if(!AllowUser("Admin")){
    die;
}
$con->beginTransaction();
$auth = $con->myQuery("UPDATE account_reservations SET is_deleted = 1 WHERE reservation_id = ?",array($_POST['deact']));
$con->commit();