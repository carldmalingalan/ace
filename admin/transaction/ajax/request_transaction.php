<?php
    require_once "../../../support/config.php";
    
    if(isset($_POST) && !empty($_POST['id'])){
            $data = $con->myQuery(
                "SELECT transaction_id,A.reservation_id,A.checkin,A.checkout,
                A.stay_duration,A.fee,A.balance,A.date_paid,A.received_id, 
                B.f_name, B.m_name, B.l_name, C.mop_name AS mop, D.room_name AS room_type,
                E.room_number FROM transaction A
                JOIN users B ON A.user_id = B.id
                JOIN mop C ON A.mop = C.mop_id
                JOIN room_type D ON A.room_type = D.room_type_id
                JOIN rooms E ON A.room_number = E.room_id            
                WHERE transaction_id = ? AND A.is_deleted = 0",array($_POST['id']))->fetch(PDO::FETCH_ASSOC);
            $data['checkin'] = dateFormat($data['checkin']);
            $data['checkout'] = dateFormat($data['checkout']);
            $data['m_name'] = empty($data['m_name']) ? "" : substr($data['m_name'],0,1).". ";
            $data['username'] = htmlspecialchars($data['f_name']." ".$data['m_name']."".$data['l_name']);
            $data['date_paid'] = !empty($data['date_paid']) ? date_format(date_create($data['date_paid']),"F d, Y h:i a") : '';
            $table = $con->myQuery("SELECT * FROM payment_records WHERE transaction_id = ?",array($_POST['id']));
            if(!empty($data['received_id'])){
                $receiver = $con->myQuery("SELECT f_name,m_name,l_name FROM users WHERE id = ?",array($data['received_id']))->fetch(PDO::FETCH_ASSOC);
                $receiver['m_name'] = empty($receiver['m_name']) ? "" : substr($receiver['m_name'],0,1).". ";
                $data['received_id'] = htmlspecialchars($receiver['f_name']." ".$receiver['m_name']."".$receiver['l_name']);
            }
            if($table->rowCount() > 0){
                $data['payment_details'] = "";
                while($row = $table->fetch(PDO::FETCH_ASSOC)){
                    $data['payment_details'] .= "<tr> <td>".cleanPeso($row['payment_total'])."</td> <td> ".date_format(date_create($row['payment_date']),"F d, Y h:i a")." </td> <td> <form> <input type='hidden' name='id' value='".$row['payment_id']."'> <button type='submit' class='btn btn-default waves-effect'> Print <span class='fa fa-print'></span> </button></form> </td> </tr>";
                }
            }else{ $data['payment_details'] = "<tr><td colspan='3'> No Record Found. </td></tr>"; }
            
            echo json_encode($data);    
    }