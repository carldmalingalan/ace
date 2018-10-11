
<?php
require_once "../support/config.php";

if(isset($_POST) && !empty($_POST)){
    $inputs = $_POST;
    $un = $inputs['username'];
    $val = $con->myQuery("SELECT * FROM users A JOIN user_role B ON A.user_role_id = B.role_id  WHERE BINARY username = ?",array($un))->fetch(PDO::FETCH_ASSOC);
    unset($_POST);
    if(!empty($val) && verify_pass($inputs['pass'],$val['password'])){
        if(in_array($val['is_activated'],array(2,3))){
            if($val['is_activated'] == 2){
                Alert("Your account is deactivated!","error","Oops..",4000);
            }
            
            if($val['is_activated'] == 3){
                Alert("Your account is for activation!","error","Oops..",4000);
            }
           
            redirect('../index.php');    
            die;
        }
        $_SESSION[WEB]['is_active'] = TRUE;
        $_SESSION[WEB]['name'] = fullName($val['f_name'],$val['m_name'],$val['l_name']);
        $_SESSION[WEB]['id'] = $val['id'];
        $_SESSION[WEB]['role'] = encrypt_pass($val['user_role_id']);
        $_SESSION[WEB]['role_type'] = strtoupper($val['role_name']);
        switch($_SESSION[WEB]['role_type']){
            case "ADMIN":
            Alert("","success","Welcome back, ".$val['f_name']."!",2500);
            redirect('../admin/');
            break;
            case "MEMBER":
            Alert("","success","Welcome back, ".$val['f_name']."!",2500);
            redirect('../client/');
            break;
        }
    }else{
        Alert("Username/Password are not found","error","Oops..");
        redirect('../index.php');
        die;
    }
    
}

?>