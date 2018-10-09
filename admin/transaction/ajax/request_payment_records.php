<?php
    require_once "../../../support/config.php";
    
    if(isset($_POST) && !empty($_POST['id'])){
        try{
            $data = $con->myQuery("SELECT A.*,B.f_name,B.m_name,B.l_name FROM payment_records A JOIN users B ON A.payment_recipient = B.id WHERE A.payment_id = ? AND A.is_deleted = 0",array($_POST['id']))->fetch(PDO::FETCH_ASSOC);
            $data['payment_recipient'] = cleanHTML(fullName($data['f_name'],$data['m_name'],$data['l_name']));
            $data['payment_date'] = date_format(date_create($data['payment_date']),"F d, Y H:i a");
            unset($data['is_deleted']);
            sleep(2);
            echo json_encode($data);
        }catch(PDOException $e){
            echo $e->error();
        }
    }