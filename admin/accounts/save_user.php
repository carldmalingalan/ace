<?php 
require_once "../../support/config.php";

if(isset($_POST['type']) && $_POST['type'] = "create"){
    
    unset($_POST['type']);
        $inputs = $_POST;
        $mname = $_POST['m_name'];
        unset($_POST);
        unset($inputs['m_name']);
        $inputs['username'] = rtrim($inputs['username']);
        $inputs['f_name'] = ucfirst(rtrim($inputs['f_name']));
        $inputs['l_name'] = ucfirst(rtrim($inputs['l_name']));
        $inputs['email'] = rtrim($inputs['email']);
        $inputs['pass'] = rtrim($inputs['pass']);
        $inputs['re_pass'] = rtrim($inputs['re_pass']);
        $inputs['mobile_no'] = str_replace('+63 ','',$inputs['mobile_no']);
        $inputs['b_day'] = date_format(date_create($inputs['b_day']),'Y-m-d');
  
        foreach($inputs as $val){
            if(empty($val) || $val == "" || $inputs['pass'] !== $inputs['re_pass'] || !valid_email($inputs['email']) || !valid_username($inputs['username']) || !valid_pass($inputs['pass'])){
                Alert("Fill all required fields.","error","Invalid Fields.");
                // print_r($_SESSION['alert']);
                redirect('index.php');
                die;        
            }
        }
        $inputs['m_name'] = ucfirst(rtrim($mname));
        unset($inputs['re_pass']);
        $inputs['pass'] = encrypt_pass($inputs['pass']);
        
        $con->beginTransaction();
        $auth = $con->myQuery("INSERT INTO users (username,password,f_name,m_name,l_name,b_day,email,mobile_no,sex,user_role_id) 
                                VALUES(:username,:pass,:f_name,:m_name,:l_name,:b_day,:email,:mobile_no,:sex,:role_name)",$inputs);
        $con->commit();
        if($auth){
            Alert("User created successfully!","success","Complete!",2500);
            redirect("index.php");
        }
        
}


if(isset($_POST['class']) && $_POST['class'] = "edit"){
    unset($_POST['class']);
    unset($_POST['date_created']);
    unset($_POST['username']);
    
    $inputs = $_POST;
    $mname = $_POST['m_name'];
    unset($inputs['m_name']);
    $inputs['f_name'] = rtrim($inputs['f_name']);
    $inputs['l_name'] = rtrim($inputs['l_name']);
    $inputs['email'] = rtrim($inputs['email']);
    $inputs['mobile_no'] = str_replace('+63 ','',$inputs['mobile_no']);
    $inputs['b_day'] = date_format(date_create($inputs['b_day']),'Y-m-d');

    $authId = $con->myQuery("SELECT * FROM users WHERE id = ? AND is_deleted = 0",array($inputs['id']));
    
    foreach($inputs as $val){
        if(empty($val) || valid_email($inputs['email']) || $authId->rowCount() > 1){
            Alert("Fill all required fields.","error","Invalid Fields.");
            // print_r($_SESSION['alert']);
            redirect('index.php');
            die;        
        }
    }
    $inputs['m_name'] = rtrim($mname); 
    $con->beginTransaction();
    $authQuery = $con->myQuery("UPDATE users 
    SET f_name = :f_name, m_name = :m_name, l_name = :l_name, email = :email,sex = :Usex, mobile_no = :mobile_no, b_day = :b_day, user_role_id = :role_name
    WHERE id = :id AND is_deleted = 0",$inputs);
    if($authQuery){
        $con->commit();
        Alert("User information updated.","success","Updated!");
        redirect('index.php');
    die;
    }else{
        Alert("Invalid parameters.","error","Error");
        redirect('index.php');
    die;
    }

    
    
}
