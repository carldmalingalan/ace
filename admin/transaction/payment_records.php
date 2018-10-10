<?php
require_once "../../support/config.php";
if(!AllowUser("Admin")){
    redirect("../index.php");
    die;
}
$active_dir ="transactions";
$active_sub_dir = "transaction_PR";
$dir = "../../";
$color = "red";
require_once "../template-admin/header.php";
require_once "../template-admin/sidebar.php";
RunAlert(); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
        <h2>PAYMENT RECORDS</h2>
        </div>
        <div class="row clearfix">
            <div class="card">
                <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" style="width:100%">
                        <thead class="bg-<?php echo cleanHTML($color); ?>">
                            <th>Payment Id</th>
                            <th>Transaction Id</th>
                            <th>Reservation Id</th>
                            <th>Payee</th>
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

<div class="modal fade" id="showPaymentInfo" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
            <form action="print_payment.php" target="_blank" method="POST">
            <div class="pull-right">
            <input type="hidden" name="print_id" id="print_id" value ="">
             <button type="submit" class="btn btn-defautl waves-effect waves-float waves-light" data-toggle="tooltip" data-placement="left" title="Print payment"><span class="fa fa-print"></span></button> 
             </div>
            </form>
            <h4 style="display:inline">Payment Information</h4>
            </div>
            <div class="modal-body row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Payment Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="payment_id" id="payment_id" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Trasaction Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="transaction_id" id="transaction_id" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <b>Reservation Id</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="reservation_id" id="reservation_id" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Payment Fee</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" name="fee" id="fee" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Balance</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" name="balance_total" id="balance_total" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Cash Received</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" name="payment_total" id="payment_total" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <b>Change</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control peso" name="change_total" id="change_total" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Payment Date</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="payment_date" id="payment_date" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Payment Recipient</b>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="payment_recipient" id="payment_recipient" disabled>
                        </div>
                    </div>
                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"> Cancel </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(() => {
    $('.modal').on('hidden.bs.modal',() => {
        $('[type="text"]').val('');
    });
});
    var dt = $('#dataTable').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "ajax/payment_records.php"
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

function showInfo(id){
    var modal = $('#showPaymentInfo');
    modal.modal({show:true});
    $.ajax({
        url: "ajax/request_payment_records.php",
        method: "post",
        data: {id: id},
        dataType: "json",
        beforeSend: () => {
            modal.find('.modal-dialog').waitMe({
                effect: "pulse",
                text: "Loading data..",
                bg: 'rgba(255,255,255,0.90)',
                color: $.AdminBSB.options.colors['<?php echo cleanHTML($color); ?>']
                });
        },
        complete: () =>{ modal.find('.modal-dialog').waitMe('hide'); },
        success: data => {
            $.each(data,(index,element) => {
                $('#'+index).val(element);
            });
        }
        ,error: msg => { console.log(msg.responseText); }
    });
}

</script>


<?php
require_once "../template-admin/footer.php";
?>