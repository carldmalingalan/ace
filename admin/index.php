<?php
require_once "../support/config.php";
$active_dir = "admin";
$dir = "../";
$color = "red";
if(!AllowUser("Admin") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}
$data['users'] = $con->myQuery("SELECT id FROM users WHERE is_activated IN (1,3) AND is_deleted = 0")->rowCount();
    $data['deact'] = $con->myQuery("SELECT id FROM users WHERE is_activated IN (2) AND is_deleted = 0")->rowCount();
    $data['reservations'] = $con->myQuery("SELECT reservation_id FROM account_reservations WHERE is_deleted = 0")->rowCount();
    $data['payments'] = $con->myQuery("SELECT payment_id FROM payment_records WHERE is_deleted = 0")->rowCount();
require_once "template-admin/header.php";
require_once "template-admin/sidebar.php";
RunAlert();
?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>    
            </div>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box-3 hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons col-green">perm_identity</i>
                        </div>
                        <div class="content">
                            <div class="text">USER</div>
                            <div id="users" class="number"><?php echo $data['users']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box-3 hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons col-yellow">today</i>
                        </div>
                        <div class="content">
                            <div class="text">RESERVATION</div>
                            <div id="reservations" class="number"><?php echo $data['reservations']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box-3 hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons col-teal">payment</i>
                        </div>
                        <div class="content">
                            <div class="text">PAYMENT</div>
                            <div id="payments" class="number"><?php echo $data['payments']; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="info-box-3 hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons col-red">do_not_disturb</i>
                        </div>
                        <div class="content">
                            <div class="text">DEACTIVATED ACCOUNT</div>
                            <div id="deact" class="number"><?php echo $data['deact']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script type="text/javascript">
    $(document).ready(() => {
        setInterval(()=>{
            $.ajax({
                url: "ajax/dashboard.php",
                dataType: "json",
                success: data => {
                    $.each(data, (index,element) => {
                        $('#'+index).text(element);
                    })
                }
                ,error: sg => { console.log(sg.responseText); }
            });
        },3000);
    });
</script>

<?php
require_once "template-admin/footer.php";
?>