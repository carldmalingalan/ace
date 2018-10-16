<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="reservation";
$active_sub_dir = "reservation_index";
$dir = "../../";
$color = "brown";

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
        <h2>RESERVATIONS</h2>
        </div>
        <div class="row clearfix">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" style="width:100%">
                            <thead class="bg-<?php echo cleanHTML($color); ?>">
                                <th>ID</th>
                                <th>Username</th>
                                <th>Created</th>   
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="showReservation" tabindex="-1">
    <div class="modal-dialog body" role="document">
        <form method="post" class="form_validate" action="alter_reservation.php">
            <div class="modal-content">
                <div class="modal-header"> 
                <h4 style="display:inline">Reservation Information</h4> 
                <span class="pull-right" style="cursor:pointer;" id="lock"><i class="material-icons">lock_outline</i></span>
                </div>
                <div class="modal-body row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>User</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" id="username" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Reservation Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="reservation_id" id="reservation_id" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Check-in</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="checkin" id="checkin" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Check-out</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="checkout" id="checkout" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Room Type</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select name="room_type" id="room_type" class="form-control show-tick" title="Select a room type" disabled required>
                            <?php while($row = $rooms->fetch(PDO::FETCH_ASSOC)){
                                echo "<option value='{$row['room_type_id']}' data-subtext='Limit: {$row['room_capacity']}' data-token='{$row['room_capacity']}'>{$row['room_name']}</option>";

                            } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <b>Number of Pax.</b>
                            <div class="input-group form-group form-float spinner" data-trigger="spinner">
                                <div class="form-line">
                                <input type="text" name="pax" id="pax" class="form-control numeric text-center" data-rule="quantity" data-max="50" data-min="1" disabled required>
                                </div>
                                <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                </span>
                            </div>
                        </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Mode of Payment</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select name="mop" id="mop" class="form-control show-tick" title="Select a Mode of Payment" disabled required>
                                <?php while($row = $mop->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['mop_id']}' data-subtext='".htmlspecialchars($row['mop_subtext'])."'> ".htmlspecialchars($row['mop_name'])." </option>";
                                }?>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Date Created</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <input type="text" class="form-control" name="date_created" id="date_created" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Reservation Status</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select name="reservation_status" id="reservation_status" class="form-control show-tick" title="Select status" disabled required>
                                <?php while($row = $res_stat->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['status_id']}'> ".htmlspecialchars($row['status_name'])." </option>";
                                }?>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Assigned Room</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select name="assigned_room" id="assigned_room" class="form-control show-tick" title="Select room" disabled required>
                                <?php while($row = $room_available->fetch(PDO::FETCH_ASSOC)) : ?>
                                <option value="<?php echo cleanHTML($row['room_id']); ?>" data-subtext="<?php echo cleanHTML($row['room_name']); ?>" data-token="<?php echo cleanHTML($row['room_type_id']); ?>">Room <?php echo cleanHTML($row['room_number']); ?></option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="SaveThis" class="btn bg-<?php echo cleanHTML($color); ?> waves-effect" data-title="Updating information.." disabled> Save </button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $(".modal").on("hidden.bs.modal",function(){
        var icon = $('#lock').find('.material-icons').text();
        $('input[type="text"], select').each(function(){
            $(this).val('');
            $(this).select('refresh');
        });        
        if(icon == "lock_open"){
            $('#lock').find('.material-icons').text('lock_outline');
            $('select, #pax').each(function(){
                $(this).attr('disabled',true);
                $(this).selectpicker('refresh');
            });
            $('#SaveThis').attr('disabled',true);
        }
        $('option').each(function(){ $(this).attr('disabled',false); });
    });
    $('#lock').on("click",function(){
        var icon =  $(this).find('.material-icons').text();
        $(this).find('.material-icons').text(icon == "lock_outline" ? "lock_open" : "lock_outline");
        if(icon == "lock_outline"){
            $('select, #pax').each(function(){
                $(this).attr('disabled',false);
                $(this).selectpicker('refresh');
                $('#SaveThis').attr('disabled',false);
            });
        }else{
            $('select, #pax').each(function(){
                $(this).attr('disabled',true);
                $(this).selectpicker('refresh');
                $('#SaveThis').attr('disabled',true);
            });
        }
    })
});
var dt = $('#dataTable').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/all_reservation.php"
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

function reloadDt(){
    dt.ajax.reload();
    dt.ajax.reload();
    dt.ajax.reload();
}

function showInfo(id){
    $('#showReservation').modal({show:true});
    $.ajax({
        url: "ajax/request_reservation.php",
        method: "post",
        data: {id : id},
        dataType: "json",
        success: data => {
            $.each(data,(index,element) => {
                $('#'+index).val(element);
                $('#'+index).selectpicker('refresh');

                if(index == "room_type"){
                    $('#assigned_room').find('option').each(function(){
                        // console.log('Token: '+$(this).data('token')+", Element: "+element);
                        if($(this).data('token') != element){
                            $(this).attr('disabled',true);
                        }
                    });
                    $('#assigned_room').selectpicker('refresh');
                }
            });
        }
    });
}

function archiveInfo(id){
    swal({
        confirmButtonClass: "btn btn-danger waves-effect m-l-10",
        cancelButtonClass: "btn btn-default waves-effect",
        buttonsStyling: false,
        title: "Are you sure?",
        text:  "This record will be stored temporarly in archives.",
        type:  "warning",
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonText:  "Confirm!",
        cancelButtonText:   "Cancel"
    }).then((isConfirm) => {
        if(isConfirm.value){
            swal({
                showConfirmButton: false,
                title: "Record Stored Success!",
                type: "error",
                timer: 2000
            })
            $.ajax({
                url: "ajax/archive_rec.php",
                method: "POST",
                data:{ deact : id },
                error: function(msg){console.log(msg.responseText)},
                success : data => { console.log(data);}
            });
            reloadDt();
        }
    });
}
</script>
<?php
require_once "../template-admin/footer.php";
?>