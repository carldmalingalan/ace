<?php 

require_once "../support/config.php";
if(isset($_POST)){
    try{
        $inputs['new_pass'] = encrypt_pass($_POST['new_pass']);
        $con->beginTransaction();
        $auth = $con->myQuery("UPDATE users SET password = :new_pass WHERE id = {$_SESSION[WEB]['id']}",$inputs);
        $con->commit();
        
        Alert('Successfully reset password!','success','Reset Password!');
        redirect('settings.php');
        die;
    }catch(PDOException $e){}
}
