
<?php
    require_once "../../../support/config.php";
    if(!AllowUser("Admin")){
        die;
    }

    $done = $con->myQuery("SELECT transaction_id FROM transaction WHERE balance = 0 AND is_deleted = 0")->fetchAll(PDO::FETCH_ASSOC);
    $con->beginTransaction();
    foreach($done AS $key => $val){
        $con->myQuery("UPDATE transaction SET is_deleted = 1 WHERE transaction_id = ?",array($val['transaction_id']));
    }
    $con->commit();

    echo $done = !empty($done) ? TRUE : FALSE;