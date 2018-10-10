<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="transactions";
$active_sub_dir = "transaction_index";
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
                <label for="makePayment" class="m-r-10"> Payment </label>
                <button type="button" data-toggle="modal" data-target="#getPayment" aria-expanded="true" class="btn btn-circle-lg bg-<?php echo cleanHTML($color); ?> waves-effect waves-float waves-circle"><i class="material-icons">payment</i></button>
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

<div class="modal fade" id="getPayment" tabindex="-2">
    <div class="modal-dialog" role="document">
        <form class="payment_validate">
        <div class="modal-content body">
            <div class="modal-header"> <i class="material-icons waves-effect pull-right" style="cursor:pointer" data-dismiss="modal">clear</i> <h4 style="display:inline;">Payment Proccessing</h4> </div>
            <div class="modal-body row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Transaction Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control numeric" name="payment_transaction_id" id="payment_transaction_id">
                        </div>
                    </div>
                </div>
                <div class="collapse" id="paymentInfo">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Client Name</b>
                        <div class="form-group from-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="payment_username" id="payment_username" disabled>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Reservation Id</b>
                        <div class="form-group from-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="payment_reservation_id" id="payment_reservation_id" disabled>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Duration of Stay</b>
                        <div class="form-group from-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="payment_stay_duration" id="payment_stay_duration" disabled>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Balance</b>
                        <div class="form-group from-float">
                            <div class="form-line">
                                <input type="text" class="form-control peso" name="payment_balance" id="payment_balance" disabled>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Payment Cash</b>
                        <div class="form-group from-float">
                            <div class="form-line">
                                <input type="text" class="form-control peso" name="payment_cash" id="payment_cash" required>
                            </div>    
                        </div>
                    </div>
                </div>
                <hr>
                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn bg-<?php echo cleanHTML($color);?> waves-effect" id="pay"> Pay </button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"> Cancel </button>
            </div>
        </div>
        </form>
    </div>
</div>

<div class="modal fade" id="showTran" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content body">
            <div class="modal-header">
                <i class="material-icons pull-right" id="modalPayment" style="cursor:pointer" data-dismiss="modal" data-toggle="modal" data-target="#getPayment">payment</i>
                <h4 style="display:inline"> Transaction Information </h4>
            </div>
            <div class="modal-body row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Transaction Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Reservation Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="reservation_id" name="reservation_id" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>User</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="username" name="username" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Check-In</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control datepicker" id="checkin" name="checkin" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Check-Out</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control datepicker" id="checkout" name="checkout" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Duration of Stay</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="stay_duration" name="stay_duration" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Room Number</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="room_number" name="room_number" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Room Type</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="room_type" name="room_type" disabled> 
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>M.O.P</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="mop" name="mop" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Fee</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" id="fee" name="fee" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Balance</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" id="balance" name="balance" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Date Paid</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="date_paid" name="date_paid" disabled>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Received By</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" id="received_id" name="received_id" disabled>
                        </div>
                    </div>
                </div> 
                <br>
                <hr> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>Payment</th>
                            <th>Payment Date</th>
                            <th>Receipt</th>
                        </thead>
                        <tbody id="payment_details">
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <!-- <button type="submit" class="btn bg-<?php echo cleanHTML($color); ?> waves-effect"> Submit </button> -->
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"> Cancel </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    setInterval(function(){
        checkArchive();
    },3000);
    $('#showTrans').on("hidden.bs.modal",function(){
        $(this).find('[type="text"]').each(()=>{ $(this).val('') });
    });

    $('#getPayment').on('hidden.bs.modal',()=>{ 
        $(this).find('[type="text"]').each(function(){ $(this).val('') }); 
        $('#paymentInfo').collapse('hide');
        })
        
    $('#payment_transaction_id').on('blur', function(){
        var result = checkTransId($(this).val());
        if(result && result !== "0"){
            $('#paymentInfo').collapse('show');
        }else{
            $('#paymentInfo').collapse('hide');
        }
    });

    $('.payment_validate').submit(function(e) {
        var    form = $(this),
                id = form.find('#payment_transaction_id').val(),
                cash = form.find('#payment_cash').val();
        e.preventDefault();
        makePayment(id,cash);
    });

    $('#modalPayment').on('click',() => {
        var id = $('#transaction_id').val();
        $('#payment_transaction_id').val(id);
    });

    $('.payment_validate').validate({
        rules: {
            "payment_transaction_id": {validTransId:true}
        },
        submitHandler : function(form) {
            var btn = $("button[type='submit']"),
                    id = $('#payment_transaction_id').val(),
                    cash = $('#payment_cash').val();
                    refreshDT();
            // makePayment(id,cash);
            // checkTransId(id);
            // btn.attr('disabled',true).text(btn.data("title") ? btn.data("title") : "Saving data...");
            // form.submit();
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

$.validator.addMethod('validTransId',value => {    
    return checkTransId(value) && value !== "0" ? true : false;
},"Invalid credential.");


function makePayment(id,cash){
    var modal = $('#getPayment').find('.modal-dialog');
    $.ajax({
        url: "save_payment.php",
        global: true,
        method: "POST",
        data: {payment_transaction_id : id , payment_cash: cash},
        beforeSend: () => {
            modal.waitMe({
                effect: "pulse",
                text: "Processing Payment..",
                bg: 'rgba(255,255,255,0.90)',
                color: $.AdminBSB.options.colors['<?php echo cleanHTML($color); ?>']
                });
        },
        complete: () => { modal.waitMe('hide'); },
        success: data => {
            $('#payment_cash').val('');
            checkTransId(id);
            refreshDT();
        }
    });
}

function checkTransId(val){
    var modal = $('#getPayment').find('.modal-dialog');
    $.ajax({
        url: "ajax/validate_trans_id.php",
        method: "post",
        async: false,
        global: true,
        data: {id: val},
        dataType: "json",
        beforeSend: () => {
            modal.waitMe({
                effect: "pulse",
                text: "Processing info..",
                bg: 'rgba(255,255,255,0.90)',
                color: $.AdminBSB.options.colors['<?php echo cleanHTML($color); ?>']
                });
        },
        complete: () => { modal.waitMe("hide"); },
        success: data => { 
            $('#payment_cash').val('');
            if(data){
                val = true;
                $.each(data,(index,element) => {
                    $('#payment_'+index).val(element);
                });
            }else{
                val = false
            }
            refreshDT();
         }
     
    });
return val;
}

var dt = $('#dataTable').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/all_transaction.php"
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


function checkArchive(){
    var val = false;
    $.ajax({
        url: "ajax/generate_archive.php",
        dataType: "HTML",
        global: true,
        async: false,
        success : data => {
            val = data;
        }
    });
    if(val == true){
        refreshDT();
    }
}

function refreshDT(){
    dt.ajax.reload();
}

function showTrans(id){
    var modal = $('#showTran'),
        modalLoading = modal.find('.modal-dialog');
        modal.modal({show:true});
    
    $.ajax({
        url: "ajax/request_transaction.php",
        global: true,
        method: "post",
        data: {id: id},
        dataType: "json",
        beforeSend: () => {
        modalLoading.waitMe({
                effect: "pulse",
                text: "Loading data..",
                bg: 'rgba(255,255,255,0.90)',
                color: $.AdminBSB.options.colors['<?php echo cleanHTML($color); ?>']
                });
        },
        complete: () => {
            modalLoading.waitMe('hide');      
        },
        success: data => {
            $.each(data, (index,element) => {
                if(index == "payment_details"){
                    $('#'+index).html(element);
                }else{ $('#'+index).val(element); } 
                                
            });
            refreshDT();
        }
    });
}

</script>

<?php
require_once "../template-admin/footer.php";
?>