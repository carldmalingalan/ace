<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="reservation";
$active_sub_dir = "reservation_archive";
$dir = "../../";
$color = "red";

$rooms = $con->myQuery("SELECT * FROM room_type WHERE is_deleted = 0");
$mop = $con->myQuery("SELECT * FROM mop WHERE is_deleted = 0");
$res_stat = $con->myQuery("SELECT * FROM reservation_status WHERE is_deleted = 0");
$room_available = $con->myQuery("SELECT A.room_id, A.room_number, B.room_name, B.room_type_id FROM rooms A JOIN room_type B ON A.room_type = B.room_type_id WHERE A.is_deleted = 0");

require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>ARCHIVE</h2>
        </div>
        <div class="card">  
            <div class="header"><h4>Archive Reservations</h4></div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable">
                        <thead class="bg-<?php echo $color; ?>">
                            <th>ID</th>
                            <th>Username</th>
                            <th>Created</th>
                            <th>Status</th>
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
    $('#dataTable').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/all_archive.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [
        {
            className: "text-center",
            searchable: false, 
            orderable: false,
            "targets":[4]
            }
        ]
        
}).api();
</script>

<?php
require_once "../template-admin/footer.php";
?>
