<?php
$dir = "../../";
require_once $dir."support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="metadata";
$active_sub_dir = "metadata_promo";
$color = "blue";

$foods = $con->myQuery("SELECT * FROM food_service WHERE is_deleted = 0");
$rooms = $con->myQuery("SELECT * FROM room_type WHERE is_deleted = 0");

require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header"> <h2>PROMOS</h2> </div>
        <div class="row clearfix">
            <div class="card">
                <div class="header">
                    <button type="button" data-toggle="modal" data-target="#promo" class="btn btn-circle-lg bg-<?php echo $color;?> waves-effect waves-circle waves-float"><i class="material-icons">add</i></button>
                    <label for="addBTn" class="p-l-20">Promo</label>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead class="bg-<?php echo $color; ?>">
                                <th>Id</th>
                                <th>Promo Name</th>
                                <th>Due</th>
                                <th>Pax</th>
                                <th>Cost</th>
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
<div class="modal fade" id="promo" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 style="display:inline">Promo Details</h4>
            <i class="material-icons pull-right waves-effect" style="cursor:pointer" data-dismiss="modal">close</i>
            </div>
            <form action="save_promo.php" id="validate_form" method="POST">
            <div class="modal-body row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <b>Name</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="promo_name" id="promo_name" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <b>Duration</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control datepicker" name="promo_duration" id="due" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        
                <b>Food Service</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select name="food_service[]" id="food_service" class="form-control show-tick" data-selected-text-format="count > 5" data-title="Select Food Services" data-live-search="true" data-actions-box="true" multiple required>
                                <?php while($row = $foods->fetch(PDO::FETCH_ASSOC)):?>
                                <option value="<?php echo $row['id']?>" data-token="<?php echo cleanHTML($row['service_duration'])?>" data-subtext="<?php echo cleanHTML($row['service_duration'])?>"><?php echo cleanHTML($row['food_type'])?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <b>Room Type</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select name="room_type[]" id="room_type" class="form-control show-tick" data-actions-box="true" data-selected-text-format="count > 5" data-title="Select Room Type" data-live-search="true" multiple required>
                                <?php while($rows = $rooms->fetch(PDO::FETCH_ASSOC)):?>
                                <option value="<?php echo cleanHTML($rows['room_type_id']);?>" data-subtext="Cost: <?php echo cleanHTML($rows['room_cost']);?>, Pax: <?php echo cleanHTML($rows['room_capacity']);?>"><?php echo cleanHTML($rows['room_name']);?></option>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <b>Number of Pax.</b>
                            <div class="input-group form-group form-float spinner" data-trigger="spinner">
                                <div class="form-line">
                                <input type="text" name="pax" id="pax" class="form-control numeric text-center" data-rule="quantity" data-max="50" data-min="1" required>
                                </div>
                                <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                </span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Cost</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" name="cost" id="cost" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="type" value="create">
                <input type="hidden" name="ID" id="ID" value="">
                <button type="submit" class="btn bg-<?php echo $color;?> waves-effect"> Create </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"> Cancel </button>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

       var dt = $('#dataTable').dataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "ajax" : {
            "url" : "ajax/promo_ajax.php"
        },
        "pageLength": 10,
        "realtime": true,
        "paging": true,
        "columnDefs": [{
            className: "text-center",
            "targets": [5]
        },{searchable: false, orderable: false,"targets":[5]}]
    }).api();
    $('#room_type').on("change",() => {
        var arr = [];
        var data = $(this).find("option:selected");
        $.each(data,(index,elem) => {
            arr.push(elem.value)
        });
         console.log(arr);
    });
    $('.modal').on('hidden.bs.modal', () => {
        $(this).find('select').val('').selectpicker('refresh');
        $(this).find('[type="text"]').val('');
        $(this).find('[name="type"]').val('create');
        $(this).find('[name="ID"]').val('');
        $(this).find('[type="submit"]').text('Create');
    });
    $('.datepicker').bootstrapMaterialDatePicker({
        
        format: 'MMMM DD, YYYY',
        clearButton: true,
        weekStart: 1,
        year: false,
        time: false
    });
    $('#promo_duration').bootstrapMaterialDatePicker('setMinDate',moment());
        $('#validate_form').validate({
        submitHandler: function(form) {
            $("[type='submit']").attr('disabled',true).text('Creating promo...');
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
                url: "ajax/request_promo.php",
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
            url: "ajax/request_promo.php",
            method: "post",
            data: { id : id },
            dataType: "json",
            success : data => {
                console.log(data);
                $.each(data, (index,elem) => {
                    if(index == "room_type" || index == "food_service"){
                        $('#'+index).selectpicker('val',elem.split(','));
                        $('#'+index).selectpicker('refresh')
                    }else{
                        $('#'+index).val(elem);
                    }
                    $('[type="submit"]').text("Update");
                });
            }
        });
    }    
</script>
<?php require_once "../template-admin/footer.php"; ?>