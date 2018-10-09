<?php
require_once "../../../support/config.php";
    if(isset($_POST['id']) && !empty($_POST['id'])){ // || isset($_GET['id']) <= for debugging
        $id = !isset($_POST['id']) ? $_GET['id'] : $_POST['id'];
        $validate = $con->myQuery("SELECT id,username,f_name,l_name,m_name,b_day,email,mobile_no,sex,date_created,B.role_id FROM users A JOIN user_role B ON A.user_role_id = B.role_id WHERE id = ?",array($id));
        if($validate->rowCount() === 1){
            $output = $validate->fetch(PDO::FETCH_ASSOC);
            $output['date_created'] = date_format(date_create($output['date_created']),"l F d, Y h:i:s a");
            $output['b_day'] = date_format(date_create($output['b_day']),"l F d, Y");
        
            echo json_encode($output);
        }
    }
?>