<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_room";
$color = "brown";

$rooms = $con->myQuery("SELECT * FROM room_type WHERE is_deleted = 0");

require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>ROOMS</h2>
        </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <button type="button" data-toggle="modal" data-target="#addR" class="btn bg-<?php echo $color; ?> btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">add</i></button>
                    <label for="addRT" class="p-l-20">Room</label>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" style="width: 100%">
                            <thead class="bg-<?php echo $color; ?>">
                                <th>Id</th>
                                <th>Room Number</th>
                                <th>Room Type</th>
                                <th>Room Capacity</th>
                                <th>Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="addR" tabindex="-1">
    <div class="modal-dialog body" role="document">
        <form method="post" action="save_room.php" class="form_validate">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Room Information</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="room_id" id="room_id">
                    <b>Room Number</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control numeric" name="room_number" id="room_number" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Room Type</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                            <select name="room_type" id="room_type" class="form-control show-tick" title="Select a room type" required>
                                    <?php while($row = $rooms->fetch(PDO::FETCH_ASSOC)){
                                        echo "<option value='{$row['room_type_id']}' data-subtext='Limit: {$row['room_capacity']}' data-token='{$row['room_capacity']}'>{$row['room_name']}</option>";
                                    } ?>
                                    </select>
                            </div>
                        </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-<?php echo $color; ?> " title="Saving room info"> Save </button>
                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cancel </button>
                </div>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript">
$(document).ready(function(){
    $('.modal').on("hidden.bs.modal",function(){
        $(this).find('input[name="id"]').val('');
        $(this).find('input[name="type"]').val('create');
        $(this).find('input[type="text"]').each(function(){
            $(this).val('');
        });
    });
});

    var dt = $('#dataTable').dataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            "url" : "ajax/room_ajax.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [{
            className: "text-center",
            "targets": [4]
        },{searchable: false, orderable: false,"targets":[4]}]
    }).api();


function deleteMeta(id){
    swal({
        confirmButtonClass: "btn btn-danger waves-effect m-l-10",
        cancelButtonClass: "btn btn-default waves-effect",
        buttonsStyling: false,
        title: "Are you sure?",
        text:  "This data will be deleted.",
        type:  "warning",
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonText:  "Confirm!",
        cancelButtonText:   "Cancel"
    }).then((isConfirm) => {
        if(isConfirm.value){
            swal({
                showConfirmButton: false,
                title: "Record has been deleted!",
                type: "error",
                timer: 2000
            })
            $.ajax({
                url: "ajax/request_room.php",
                method: "POST",
                data:{ deact : id },
                error: msg => {console.log(msg.responseText)}
            });
            dt.ajax.reload();
        }
    });

}

 function editMeta(id){
        var modal = $('.modal');
        modal.modal({show:true});
        modal.find('input[name="id"]').val(''+id);
        modal.find('input[name="type"]').val('edit');
        $.ajax({
            url: "ajax/request_room.php",
            method: "post",
            data: { id : id },
            dataType: "json",
            success : data => {
                $.each(data, (index,elem) => {
                    $('#'+index).val(elem);
                    $('#'+index).selectpicker('refresh');
                });
            }
        });
    }

   
</script>
<?php
require_once "../template-admin/footer.php";
?>