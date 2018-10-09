<?php 
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}

if(isset($_POST) && !empty($_POST['payment_transaction_id'])){
    $_POST['payment_cash'] = dbPeso($_POST['payment_cash']);
    try{
        $data = $con->myQuery("SELECT * FROM transaction WHERE BINARY transaction_id = ? AND is_deleted = 0",array($_POST['payment_transaction_id']));
        if($data->rowCount() == 1){
            $data = $data->fetch(PDO::FETCH_ASSOC);
            print_ar($data);
            print_ar($_POST);
            if($data['balance'] > 0){
        $change = $current_balance = (float)$data['balance'] - (float)$_POST['payment_cash'];
        $change = $data['balance'] > $_POST['payment_cash'] ? 0 : dbPeso(abs($change));
        $current_balance = $current_balance <= 0 ? 0 : $current_balance;
        try{
            print_ar(array($data['user_id'],$data['transaction_id'],$data['reservation_id'],$data['fee'],dbPeso($_POST['payment_cash']),$current_balance,$change,$_SESSION[WEB]['id']));
            $con->beginTransaction();
            $con->myQuery("INSERT INTO payment_records(payee_id,transaction_id,reservation_id,fee,payment_total,balance_total,change_total,payment_recipient) VALUES(?,?,?,?,?,?,?,?)",array($data['user_id'],$data['transaction_id'],$data['reservation_id'],$data['fee'],dbPeso($_POST['payment_cash']),$current_balance,$change,$_SESSION[WEB]['id']));
            $con->myQuery("UPDATE transaction SET balance = ? WHERE transaction_id = ?",array($current_balance,$data['transaction_id']));
            if($current_balance == 0 ){
                $con->myQuery("UPDATE transaction SET date_paid = NOW(), received_id = ? WHERE transaction_id = ?",array($_SESSION[WEB]['id'],$data['transaction_id']));
            }
            $con->commit();
            
            echo $val = TRUE;
        }catch(PDOExecption $a){
            echo $val = FALSE;
            die;
        }
            }

        }
    }catch(PDOExecption $e){
        echo $val = FALSE;
        die;
    }
}
