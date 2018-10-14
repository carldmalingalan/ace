<?php
    require_once "../../../support/config.php";
    
    if(isset($_POST) && !empty($_POST['id'])){
    
        try{
            $data = $con->myQuery(
                "SELECT A.reservation_id, A.stay_duration, A.balance, B.f_name,
                 B.m_name, B.l_name
                 FROM transaction A
                 JOIN users B ON A.user_id = B.id
                 WHERE BINARY transaction_id = ?",array($_POST['id']));
            if($data->rowCount() == 1){
                $data = $data->fetch(PDO::FETCH_ASSOC);
                $data['m_name'] = empty($data['m_name']) ? "" : substr($data['m_name'],0,1).". ";
                $data['username'] = htmlspecialchars($data['f_name']." ".$data['m_name']."".$data['l_name']);
                $data['payment_cash'] = "";
                
                echo json_encode($data);
            }else{
                $data = "";
                echo json_encode($data);
            }
        }catch(PDOException $e){
            $data = "";
            echo json_encode($data);
        }
    }