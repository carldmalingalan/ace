<?php
require_once "../../../support/config.php";
if(!AllowUser("Admin")){
    die;
}
$con->beginTransaction();
$auth = $con->myQuery("UPDATE transaction SET is_deleted = 1 WHERE transaction_id = ?",array($_POST['deact']));
$con->commit();