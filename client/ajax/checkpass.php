<?php
require_once "../../support/config.php";

$oldpass = $con->myQuery("SELECT password FROM users WHERE id = ?",array($_SESSION[WEB]['id']))->fetch(PDO::FETCH_ASSOC);



echo $val = verify_pass($_POST['pass'],$oldpass['password']) ? true : false;