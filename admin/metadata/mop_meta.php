<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_mop";
$color = "brown";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>MODE OF PAYMENT</h2>
        </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    
                    <button type="button" data-toggle="modal" data-target="#addMOP" class="btn bg-<?php echo $color; ?> btn-circle-lg waves-effect waves-circle waves-float"><i class="material-icons">add</i></button>
                    <label for="addMOP" class="p-l-20">M.O.P</label>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" style="width: 100%">
                            <thead class="bg-<?php echo $color; ?>">
                                <th>Id</th>
                                <th>Name</th>
                                <th>Subtext</th>
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
<div class="modal fade" id="addMOP" tabindex="-1">
    <div class="modal-dialog body" role="document">
        <form method="post" action="save_mop.php" class="form_validate">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>M.O.P Information</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="mop_id" id="mop_id">
                    <b>M.O.P Name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="mop_name" id="mop_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Subtext</b>
                    <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="mop_subtext" id="mop_subtext" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-<?php echo $color; ?> " data-title="Saving mode of payme..."> Save </button>
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
            "url" : "ajax/mop_ajax.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [{
            className: "text-center",
            "targets": [3]
        },{searchable: false, orderable: false,"targets":[3]}]
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
                url: "ajax/request_mop.php",
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
            url: "ajax/request_mop.php",
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