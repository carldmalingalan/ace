<?php
require_once "../support/config.php";
$active_dir = "client";
$active_sub_dir = "";
$dir = "../";
$color = "red";
if(!AllowUser("Member") || !isset($_SESSION[WEB])){
    redirect("../index.php");
    die;
}
require_once "template-client/header.php";
require_once "template-client/sidebar.php";

$dets = $con->myQuery("SELECT f_name,m_name,l_name,b_day,email,mobile_no FROM users WHERE id = ? ",array($_SESSION[WEB]['id']))->fetch(PDO::FETCH_ASSOC);

RunAlert();

?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>SETTINGS</h2>
        </div>
        <div class="card clearfix">
            <div class="body">
            <form action="edit_setting.php" method="POST">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>First name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo cleanHTML($dets['f_name']);?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>Middle name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="m_name" id="m_name" value="<?php echo cleanHTML($dets['m_name']);?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>Last name</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="l_name" id="l_name" value="<?php echo cleanHTML($dets['l_name']);?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>Birthday</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control datepicker" name="b_day" id="b_day" value="<?php echo dateFormat($dets['b_day']);?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>Email</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo cleanHTML($dets['email']);?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <b>Mobile No.</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control mob" name="mobile_no" id="mobile_no" value="<?php echo cleanHTML($dets['mobile_no']);?>">
                            </div>
                        </div>
                    </div>
                    <div class="align-center">
                        <button type="submit" class="btn btn-success waves-effect waves-light"> <i class="material-icons">mode_edit</i> Change </button>
                        <button type="button" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#reset"> <i class="material-icons">lock</i> Re-set Password</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>
<div class="modal fade" id="reset" tabindex="-1">
    <div class="modal-dialog" role="document" id="modal-verify">
    <form action="reset_pass.php" method="POST" id="reset_pass">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="display:inline"> Re-set Password </h4>
                <i class="material-icons pull-right" data-dismiss="modal" style="cursor:pointer">close</i>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <b>Password</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="old_pass" id="old_pass" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>New Password</b> 
                        <div class="form-group input-group">
                            <div class="form-line">
                                <input type="password" class="form-control" name="new_pass" id="new_pass" required>
                            </div>
                            <span class="input-group-addon"><i class="material-icons" style="cursor:pointer;" id="visi">visibility_off</i></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <b>Retype Password</b> 
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" class="form-control" name="new_pass_retype" id="new_pass_retype" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" class="btn btn-warning waves-effect waves-light" value="Reset" >
                <button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal"> Cancel </button>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#visi').on("click",function(){
        var text = $(this).text(),
            pass = text == "visibility" ? "text" : "password";
        $(this).text( text == "visibility" ? "visibility_off" : "visibility");
        $('#new_pass').attr({type: pass});
        $('#new_pass_retype').attr({type: pass});
    });

    $('#reset_pass').validate({
        rules: {
            "old_pass": {checkPass:true},
            "new_pass_retype" : {isMatch:true}
        },
        submitHandler : function(form) {
        $("button[type='submit']").attr('disabled',true).text('Updating user info...');
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

    $.validator.addMethod('checkPass',(value,elem) => {
        
        
            var value = false,
                modal = $('#modal-verify');
            $.ajax({
            url: "ajax/checkpass.php",
            data: {pass : elem.value},
            global: true,
            async: false,
            method: "POST",
            beforeSend: () => {
                modal.waitMe({
                    effect: "pulse",
                    text: "Checking password..",
                    bg: 'rgba(255,255,255,0.90)',
                    color: $.AdminBSB.options.colors['green']
                });
            },
            complete: ()  => {
                modal.waitMe('hide');
            }, 
            success: data => {
                value = data
            }
        });
        return value;
        
        
    },'Password is incorrect!');
    });

    $.validator.addMethod('isMatch',(value,elem) => {
        return $('#new_pass').val() == value ? true :false;
    }, 'Password must match!');
</script>
<?php require_once "template-client/footer.php"; ?>