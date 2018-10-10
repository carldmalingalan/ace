<?php
require_once "../support/config.php";
$active_dir = "client";
$active_sub_dir = "reservations";
$dir = "../";
$color = "red";
if(!AllowUser("Member") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}

$rooms = $con->myQuery("SELECT * FROM room_type WHERE is_deleted = 0");
$mop = $con->myQuery("SELECT * FROM mop WHERE is_deleted = 0");
$reserve = $con->myQuery(
"SELECT * FROM account_reservations A
JOIN room_type B ON A.room_type = B.room_type_id
JOIN mop C ON A.mop = C.mop_id 
JOIN reservation_status D ON A.reservation_status = D.status_id
WHERE A.is_deleted = 0 AND A.user_id = ?",array($_SESSION[WEB]['id']));
require_once "template-client/header.php";
require_once "template-client/sidebar.php";
RunAlert();
?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>RESERVATIONS</h2>    
            </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <label for="addRess" class="p-r-20">Make a reservation</label>
                    <button id="addRes" data-toggle="modal" data-target="#modalRes" type="button" class="btn bg-<?php echo $color; ?> btn-circle-lg waves-effect waves-circle waves-float">
                        <i class="material-icons">add</i>
                    </button>
                </div>
            </div>
        </div>
        <?php if($reserve->rowCount() == 0) :?>
                        <blockquote>
                        <p>You can add a reservation by clicking the <b>Add Button</b> above.</p>
                        <footer>ACE Water Spa System</footer>
                        </blockquote>
                    <?php else: ?>
                        <?php while($row = $reserve->fetch(PDO::FETCH_ASSOC)): ?>    
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="header bg-<?php echo cleanHTML($color); ?>">
                                    <h3><?php echo ucfirst(cleanHTML($row['status_name'])); ?> <br><small><?php echo cleanHTML(date_format(date_create($row['checkin']),"M d")); ?> to <?php echo cleanHTML(date_format(date_create($row['checkout']),"M d")); ?></small> </h3>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <ul class="dropdown-menu pull-right">
                                            <?php if($row['reservation_status'] == 1) : ?>
                                                <li><a href="javascript:void(0)">Edit</a></li>
                                            <?php endif; ?>
                                            <?php if(in_array($row['reservation_status'],array(1,2))):?>
                                            <form class="hide" id="cancel_form" action="cancel_reservation.php" method="POST">
                                            <input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $row['reservation_id'] ?>">
                                            </form>
                                            <li><a href="javascript:void(0)" onclick="submitForm();">Cancel Reservation</a></li>
                                            
                                            <?php endif; ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">
                            <button class="btn bg-<?php echo cleanHTML($color); ?> waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapse<?php echo cleanHTML($row['reservation_id']); ?>" aria-expanded="false" aria-controls="collapseExample">
                                More Info..
                            </button>
                            <div class="collapse" id="collapse<?php echo cleanHTML($row['reservation_id']); ?>">
                                <div class="well">
                                            <b>Reservation Id: </b> <i><?php echo cleanHTML($row['reservation_id']); ?></i><br>
                                            <b>Check-In: </b> <i><?php echo cleanHTML(date_format(date_create($row['checkin']),"M d, Y")); ?></i><br>
                                            <b>Check-Out: </b> <i><?php echo cleanHTML(date_format(date_create($row['checkout']),"M d, Y")); ?></i><br>
                                            <b>Persons: </b> <i><?php echo cleanHTML($row['pax']); ?></i><br>
                                            <b>Room Type: </b> <i><?php echo cleanHTML($row['room_name']); ?></i><br>
                                            <b>M.O.P: </b> <i><?php echo cleanHTML($row['mop_name']); ?></i><br>
                                            <b>Status: </b> <i><?php echo cleanHTML($row['status_name']); ?></i><br>
                                            <b>Date Created: </b> <i><?php echo cleanHTML(date_format(date_create($row['reservation_date']),"M d, Y h:i A")); ?></i><br>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php endif;?>
    </div>
    </section>

    <div class="modal fade" id="modalRes" tabindex="-1">
        <div class="modal-dialog body" role="document">
            <form method="post" class="form_validate" action="save_reservation.php">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4>Reservation Details</h4>
                    </div>
                    <div class="modal-body row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <b>Check-in Date</b>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="checkin" id="checkin" required>
                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION[WEB]['id']?>">
                                            <input type="hidden" name="type" value="create">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <b>Check-out Date</b>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="checkout" id="checkout" disabled required>
                                        </div>
                                    </div>                     
                                </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <b>Number of Pax.</b>
                            <div class="input-group form-group form-float spinner" data-trigger="spinner">
                                <div class="form-line">
                                <input type="text" name="pax" class="form-control numeric text-center" value="1" data-rule="quantity" data-max="50" data-min="1" required>
                                </div>
                                <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                </span>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <b>Mode of Payment</b>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select name="mop" id="mop" class="form-control show-tick" title="Select a Mode of Payment" required>
                                        <?php while($row = $mop->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['mop_id']}' data-subtext='".htmlspecialchars($row['mop_subtext'])."'> ".htmlspecialchars($row['mop_name'])." </option>";
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm bg-<?php echo $color; ?> waves-effect" data-title="Checking info..">Reserve</button>
                        <button class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">

function submitForm(){
var form = $('#cancel_form');
form.submit();
}
    $(document).ready(function() {
        
     $('.datepicker').bootstrapMaterialDatePicker({
        format: 'MMMM DD, YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });
    
$('#checkin').bootstrapMaterialDatePicker({weekStart: 0}).on("change",function(e,date){
        var co = $('#checkout');
    if(date){
        co.attr('disabled', false);
        co.bootstrapMaterialDatePicker('setMinDate',date);
    }else{
        co.attr('disabled',true)
        co.val('')
    }
    
});

    });
</script>
<?php
require_once "template-client/footer.php";
?>