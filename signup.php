<?php 

$dir = "./";
$disable = "adf";
require_once "support/config.php";
require_once "template/header.php";

    RunAlert();
    if(isset($_POST) && isset($_POST['submitBtn'])){
        
        $inputs = $_POST;
        $inputs['username'] = rtrim($inputs['username']);
        $inputs['f_name'] = rtrim($inputs['f_name']);
        $inputs['l_name'] = rtrim($inputs['l_name']);
        $inputs['m_name'] = rtrim($inputs['m_name']); 
        $inputs['email'] = rtrim($inputs['email']);
        $inputs['pass'] = rtrim($inputs['pass']);
        $inputs['re_pass'] = rtrim($inputs['re_pass']);
        $inputs['mobile_no'] = str_replace('+63 ','',$inputs['mobile_no']);
        $inputs['b_day'] = date_format(date_create($inputs['b_day']),'Y-m-d');
        if(empty($inputs['m_name'])){ unset($inputs['m_name']); }
            unset($inputs['submit']);
            unset($inputs['submitBtn']);
        foreach($inputs as $val){
            if(empty($val) || $val == "" || $inputs['pass'] !== $inputs['re_pass'] || !valid_email($inputs['email']) || !valid_username($inputs['username']) || !valid_pass($inputs['pass'])){
                $_SESSION['warning'] = TRUE;
                Alert("Fill all required fields.","error","Invalid Fields.");
                redirect('signup.php');
                die;        
            }
        }
        $inputs['pass'] = encrypt_pass($inputs['pass']);
        unset($inputs['submit']);
        unset($inputs['re_pass']);
        $con->beginTransaction();
        $exec = $con->myQuery("INSERT INTO users(username, password, f_name, l_name, m_name, b_day, email, mobile_no, sex) VALUES (:username, :pass, :f_name, :l_name, :m_name, :b_day, :email, :mobile_no, :sex)",$inputs);
        $con->commit();
        if($exec){
            Alert("Your account is being process waiting for activation.","success","Welcome to Ace Reservation System",3500);
            redirect('index.php');
            die;
        }
        
        
       

    }
?>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="" id="main_form">
					<span class="login100-form-title p-b-34">
						Account Register
					</span>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input class="form-control" placeholder="Username" id="username" type="text" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input id="f_name" class="form-control" type="text" name="f_name" placeholder="First Name" required>
                                </div>
                            </div>
                        </div>
						<div class="wrap-input100">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input class="form-control" id="l_name" type="text" name="l_name" placeholder="Last Name" required>
                            </div>
                        </div>
                        </div>
                        <div class="wrap-input100">
                        <div class="form-group form-line">
                            <div class="form-line">
                                <input class="form-control" id="m_name" type="text" name="m_name" placeholder="Middle Name">
                            </div>
                        </div>
                        </div>
                        <div class="wrap-input100">
                        <div class="form-group form-float">
                            <div class=" input-group form-line">
                            <input class="form-control" id="pass" type="password" name="pass" placeholder="Password" required>
                            <span class="input-group-addon"><i class="material-icons" style="cursor:pointer;" id="showPass">visibility</i></span>
                            </div>
                        </div>
                        </div>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input class="form-control" id="re_pass" type="password" name="re_pass" placeholder="Re-type Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input class="form-control datepicker" id="b_day" type="text" name="b_day" placeholder="Birth Day" required>    
                                </div>
                            </div>
                        </div>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input class="form-control" id="email" type="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-input100">
                            <div class="form-group form-float">
                                <div class="form-line">
                                <input class="form-control mob" id="mobile_no" type="text" name="mobile_no" placeholder="Mobile No." required>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-input100">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                    <select name="sex" id="sex" class="form-control show-tick" title="Sex">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    </div>
                                </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <input type="hidden" name="submitBtn" value="create">
                            <button class="btn btn-primary waves-effect m-r-30" id="submit" type="submit" name="submit">Register</button>
                            <a href="index.php" class="btn btn-success waves-effect">Login</a>
                        </div>
				</form>

				<div class="login100-more imgBG" style="background-image: url('assets/css/BGREG.jpg');"></div>
			</div>
		</div>
	
    </div>
<?php require_once "template/footer.php";?>
<script type="text/javascript">

$(document).ready(function(){
    $('#showPass').on("click",function(){
        var text = $(this).text(),
            pass = text == "visibility" ? "text" : "password";
        $(this).text( text == "visibility" ? "visibility_off" : "visibility");
        $('#pass').attr({type: pass});
        $('#re_pass').attr({type: pass});
    });
});

        $('.validate-form').validate({
        rules: {
            'username' : {validateUser:true,whiteSpaces:true},
            're_pass' : {validatePass:true,whiteSpaces:true},
            'email': {validateEmail:true,whiteSpaces:true},
            'mobile_no' : {validateMobile:true,whiteSpaces:true},
            'f_name' : {whiteSpaces:true},
            'l_name' : {whiteSpaces:true},
            'pass' : {whiteSpaces:true}
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

    $.validator.addMethod("validateUser" , (value,element) => { return validateUsername(value); },"Username is taken");
    $.validator.addMethod("validatePass", (value) => { 
        var pass = $('#pass').val();
        return pass == value ? true : false;
     },"Password must match");
     $.validator.addMethod("validateEmail", (value) => {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(value);
     },"Invalid email!");

     $.validator.addMethod("validateMobile",(value)=>{ 
         var number = value.split('+63 ').join("").split("_").join("");
         return number.indexOf('9') == 0 && number.length == 10 ? true : false; 
      },"Mobile number must start at '9' and a length of 10 digits!(Ex. +63 9...)");

      $.validator.addMethod("whiteSpaces",value => { return value.trim() == "" ? false : true; },"Empty spaces are consider as blank");
    function validateUsername(uname){
        var val;
        $.ajax({
            url: "ajax/validate_username.php",
            global: true,
            async: false,
            method: "POST",
            data: {username: uname},
            success: data => {
                console.log(data);
                val = data ? false : true;
            }
            ,error: msg => { console.log(msg.responseText); }
        });
        return val;
    }

</script>
<!-- <script type="text/javascript" src="ajax/ajax_signup.js"></script> -->

