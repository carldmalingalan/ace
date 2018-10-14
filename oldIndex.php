<?php 
$disable = "asd";
require_once "support/config.php";
require_once("template/header.php"); 
	RunAlert();
	if(isset($_SESSION[WEB])){
		switch($_SESSION[WEB]['role_type']){
			case "ADMIN":
			redirect('admin/index.php');
			break;
			case "MEMBER":
			redirect("client");
			break;
			default:
			unset($_SESSION[WEB]);
			break;
		}
	}
?>

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="validate/user_validate.php">
					<span class="login100-form-title p-b-34">
						Account Login
					</span>
                        <div class="wrap-input100">
							<div class="form-group form-float">
								<div class="form-line">
									<input id="username" class="form-control" type="text" name="username" placeholder="Username" required>	
								</div>
							</div>
                        </div>
						<div class="wrap-input100 p-b-27">
						<div class="form-group form-float">
							<div class="form-line">
							<input class="form-control" type="password" name="pass" placeholder="Password" required>
							</div>
						</div>
                        </div>
					<div class="container-login100-form-btn">
						<button type="submit" class="btn btn-block btn-primary waves-effect">
							Sign in
						</button>
					</div>

					<div class="w-full text-center p-t-27 p-b-10">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="text-primary">
							Username / Password?
						</a>
					</div>

					<div class="w-full text-center p-b-50">
						<a href="signup.php" class="text-primary">
							Sign Up
						</a>
					</div>
				</form>

				<div class="login100-more imgBG" style="background-image: url('assets/css/BG.jpg');"></div>
			</div>
		</div>
	</div>
<?php require_once "template/footer.php";?>
<script type="text/javascript">
	$('.validate-form').validate({
		submitHandler : function(form) {
        	$("button[type='submit']").attr('disabled',true).text('Logging in...');
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
</script>