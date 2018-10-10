<?php
require_once "../support/config.php";
$active_dir = "client";
$dir = "../";
$color = "red";
// print_ar($_SESSION[WEB]);
// die;
if(!AllowUser("Member") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}
require_once "template-client/header.php";
require_once "template-client/sidebar.php";
RunAlert();
?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>    
            </div>

    </section>

<?php
require_once "template-client/footer.php";
?>