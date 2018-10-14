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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="align-center"><?php echo date('Y'); ?> SALES REPORT</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="print_year.php" target="_blank">Print</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <canvas id="sales_monthly" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 class="align-center"><?php echo strtoupper(date('F')); ?> SALES REPORT</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown toggle" data-toggle="dropdown" role="button" aria-haspop="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="print_month.php" target="_blank">Print</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <canvas id="sales_daily" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script type="text/javascript">
    var monthly = new Chart(document.getElementById('sales_monthly').getContext('2d'),getMonthly());
    var daily = new Chart(document.getElementById('sales_daily').getContext('2d'),getDaily());
    function getMonthly(){
        var dataS = [], label = [];
        $.ajax({
            url: "ajax/year_dash.php",
            dataType: "JSON",
            global : true,
            async: false,
            success : data => {
                $.each(data,(index,elem)=>{
                    dataS.push(elem);
                    label.push(index);
                });
            }
        });
        var config = {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: "Total Sales",
                    data: dataS,
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
        return config;
        
    }
    function getDaily(){
        var dataS = [], label = [];
        $.ajax({
            url: "ajax/month_dash.php",
            dataType: "JSON",
            global : true,
            async: false,
            success : data => {
                $.each(data,(index,elem)=>{
                    dataS.push(elem);
                    label.push(index);
                });
            }
        });
        var config = {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: "Total Sales",
                    data: dataS,
                    borderColor: 'rgba(233, 30, 99, 0.75)',
                    backgroundColor: 'rgba(233, 30, 99, 0.3)',
                    pointBorderColor: 'rgba(233, 30, 99, 0)',
                    pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
        return config;
        
    }
    $(document).ready(() => {
        getMonthly();
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