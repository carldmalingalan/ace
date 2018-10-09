<?php 
require_once "../support/config.php";

if(isset($_POST) && !empty($_POST['username'])){
    try{
        $username = rtrim($_POST['username']);
        $auth = $con->myQuery("SELECT * FROM users WHERE BINARY username = ? AND is_deleted = 0",array($username));
        echo $auth->rowCount() > 0 ? true : false;
    }catch(PDOException $e){
        
    }
}