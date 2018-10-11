<?php 
require_once "../support/config.php";

if(isset($_POST)){
    $inputs = $_POST;    
    $inputs['f_name'] = cleanDB($inputs['f_name']); 
    $inputs['m_name'] = cleanDB($inputs['m_name']); 
    $inputs['l_name'] = cleanDB($inputs['l_name']); 
    $inputs['b_day'] = dbDate($inputs['b_day']); 
    $inputs['email'] = cleanDB($inputs['email']); 
    $inputs['mobile_no'] = str_replace('+63 ','',$inputs['mobile_no']);
    
    try{
        $con->beginTransaction();
        $con->myQuery('UPDATE users SET f_name = :f_name, m_name =  :m_name, l_name = :l_name, b_day = :b_day, email = :email, mobile_no = :mobile_no WHERE id =' .$_SESSION[WEB]['id'],$inputs);
        $con->commit();
        $_SESSION[WEB]['name'] = fullName($inputs['f_name'],$inputs['m_name'],$inputs['l_name']);
        Alert('Successfully update profile.','success','Success!');
        redirect('settings.php');
        die;
    }catch(PDOException $e){}

}