<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="transactions";
$active_sub_dir = "transaction_archive";
$dir = "../../";
$color = "red";

require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>TRANSACTIONS</h2>
        </div>
        <div class="row clearfix">
            <div class="card">
            <div class="header">
            <h4>Transactions Archive</h4>
                <!-- <label for="makePayment" class="m-r-10"> Payment </label>
                <button type="button" data-toggle="modal" data-target="#getPayment" aria-expanded="true" class="btn btn-circle-lg bg-<?php echo cleanHTML($color); ?> waves-effect waves-float waves-circle"><i class="material-icons">payment</i></button> -->
            </div>
                <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" style="width:100%">
                        <thead class="bg-<?php echo cleanHTML($color); ?>">
                            <th>Transaction Id</th>
                            <th>Reservation Id</th>
                            <th>User</th>
                            <th>Room Number</th>
                            <th>M.O.P</th>
                            <th>Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    var dt = $('#dataTable').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/transaction_archive.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [
        {
            className: "text-center",
            searchable: false, 
            orderable: false,
            "targets":[5]
            }
        ]
        
}).api();
</script>
<?php require_once "../template-admin/footer.php"; ?>