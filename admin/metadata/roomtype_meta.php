<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_roomtype";
$color = "blue";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>ROOM TYPES</h2>
        </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <button type="button" data-toggle="modal" data-target="#addRT" class="btn bg-<?php echo $color; ?> btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">add</i></button>
                    <label for="addRT" class="p-l-20">Room Type</label>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" style="width: 100%">
                            <thead class="bg-<?php echo $color; ?>">
                                <th>Id</th>
                                <th>Room Name</th>
                                <th>Room Capacity</th>
                                <th>Room Cost</th>
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

<div class="modal fade" id="addRT" tabindex="-1">
    <div class="modal-dialog body" role="document">
        <form method="post" action="save_room_type.php" class="form_validate">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Room Information</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="room_type_id" id="room_type_id">
                    <b>Room Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="room_name" id="room_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Room Cost</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                            <input type="text" class="form-control peso" name="room_cost" id="room_cost" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Room Capacity</b>
                        <div class="input-group form-group form-float" data-trigger="spinner">
                            <div class="form-line">
                            <input type="text" name="room_capacity" id="room_capacity" class="form-control numeric text-center" data-rule="quantity" data-max="50" data-min="1" required>
                                </div>
                                <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                </span>
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
            "url" : "ajax/roomtype_ajax.php"
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
                url: "ajax/request_room_type.php",
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
            url: "ajax/request_room_type.php",
            method: "post",
            data: { id : id },
            dataType: "json",
            success : data => {
                $.each(data, (index,elem) => {
                    $('#'+index).val(elem);
                });
            }
        });
    }

   
</script>
<?php
require_once "../template-admin/footer.php";
?>