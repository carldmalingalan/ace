<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_food";
$color = "brown";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>FOOD SERVICES</h2>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                
                    <button id="addBtn" type="button" data-target="#createService" data-toggle="modal" class="btn btn-circle-lg bg-<?php echo $color?> waves-effect waves-float waves-circle"> <i class="material-icons">add</i> </button>
                    <label for="addBtn" class="p-l-20"> Food Service </label>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" style="width:100%">
                            <thead class="bg-<?php echo $color; ?>">
                                <th>Id</th>
                                <th>Food Type</th>
                                <th>Service Duration</th>
                                <th>Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="createService" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form method="POST" id="validate_form" action="save_food.php">
            <div class="modal-header">
                <h4 style="display:inline"> Food Services Info </h4>
                <i class="material-icons waves-effect pull-right" style="cursor:pointer" data-dismiss="modal">close</i>
            </div>
            <div class="modal-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <b>Food Type</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="food_type" id="food_type" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <b>Service Duration</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="service_duration" id="service_duration" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="type" id="type" value="create">
                <input type="submit" id="btnName" class="btn bg-<?php echo $color;?> waves-effect" value="Create">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"> Cancel </button>
            </div>
            </form>            
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    $('.modal').on("hidden.bs.modal",function(){
        $(this).find('input[name="id"]').val('');
        $(this).find('input[name="type"]').val('create');
        $(this).find('#btnName').val('Create');
        $(this).find('input[type="text"]').each(function(){
            $(this).val('');
        });
    });

    $('#validate_form').validate({
        submitHandler: function(form) {
            $("[type='submit']").attr('disabled',true).text('Creating user...');
            form.submit();
        },
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });
});
    var dt = $('#dataTable').dataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            "url" : "ajax/food_ajax.php"
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
                url: "ajax/request_food.php",
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
            url: "ajax/request_food.php",
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

<?php require_once "../template-admin/footer.php"; ?>