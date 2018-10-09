<?php 
require_once "../support/config.php";
    if(isset($_POST['username']) && !empty($_POST['username'])){
        echo valid_username($_POST['username']);
    }

    if(isset($_POST['email']) && !empty($_POST['email'])){
        echo valid_email($_POST['email']);
    }

    if(isset($_POST['pass']) && !empty($_POST['pass'])){
        echo valid_pass($_POST['pass']);
    }

  
?>