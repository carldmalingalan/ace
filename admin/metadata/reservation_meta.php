<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_reservation";
$color = "blue";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>RESERVATION</h2>
        </div>
</section>

<?php
require_once "../template-admin/footer.php";
?>