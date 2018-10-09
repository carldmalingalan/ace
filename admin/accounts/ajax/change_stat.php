<?php 
require_once "../../../support/config.php";

    if(isset($_POST['deact']) && !empty($_POST['deact'])){        
        $auth = $con->myQuery("SELECT * FROM users WHERE id = :deact",$_POST)->rowCount();
        if($auth === 1){
            $con->beginTransaction();
            $data = $con->myQuery('UPDATE users SET is_activated = 2 WHERE id = :deact',$_POST);            
            $con->commit();
        }
    }

    if(isset($_POST['activate']) && !empty($_POST['activate'])){        
        $auth = $con->myQuery("SELECT * FROM users WHERE id = :activate",$_POST)->rowCount();
        if($auth === 1){
            $con->beginTransaction();
            $data = $con->myQuery('UPDATE users SET is_activated = 1 WHERE id = :activate',$_POST);            
            $con->commit();
        }
    }
