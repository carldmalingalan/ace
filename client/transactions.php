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
            <h2>TRANSACTIONS</h2>
        </div>
        <div class="card clearfix">
            <div class="header">
                <h4>All Transactions</h4>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" style="width:100%">
                        <thead>
                        <th>ID</th>
                        <th>Date Paid</th>
                        <th>Cash</th>
                        <th>Cashier</th>
                        <th>Actions</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var dt = $('#dataTable').dataTable({
        "responsive": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/all_transaction.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [{
            className: "text-center",
            "targets": [3,4]
        },{searchable: false, orderable: false,"targets":[3,4]}]

    }).api();
</script>

<?php
require_once "template-client/footer.php";
?>