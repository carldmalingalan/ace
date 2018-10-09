<?php 
require_once "../../../support/config.php";

if(isset($_POST['id'])){
    $authId = $con->myQuery(
"SELECT reservation_id, checkin, checkout, pax, room_type, mop, reservation_status, assigned_room , reservation_date AS date_created, B.f_name, B.m_name, B.l_name
FROM account_reservations A
JOIN users B ON A.user_id = B.id
WHERE reservation_id = ? AND A.is_deleted = 0",array($_POST['id']));
    if($authId->rowCount() === 1){
        $data = $authId->fetch(PDO::FETCH_ASSOC);
        $data['checkin'] = date_format(date_create($data['checkin']),"F d, Y"); 
        $data['checkout'] = date_format(date_create($data['checkout']),"F d, Y"); 
        $data['date_created'] = date_format(date_create($data['date_created']),"F d, Y h:i a"); 
        $data['m_name'] = empty($data['m_name']) ? "" : substr($data['m_name'],0,1).".";
        $data['username'] = htmlspecialchars($data['f_name']." ".$data['m_name']." ".$data['l_name']);
        unset($data['m_name'],$data['f_name'],$data['l_name']);
        echo json_encode($data);
    }
}