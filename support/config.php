<?php
	ob_start();
	session_start();
	date_default_timezone_set("Asia/Manila");
	define("WEB", 'Ace reservation System');

	//$_SESSION[WEBAPP]=array();
	// function __autoload($class)
	// {
	// 	require_once 'class.'.$class.'.php';
	// }

	function redirect($url)
	{
		header("location:".$url);
	}

	function jsredirect($url)
	{
		echo "<script>window.history.back()</script>";
		echo "<a href='{$url}'>Click here if you are not redirected.</a>";
	}

	function getFileExtension($filename){
		return substr($filename, strrpos($filename,"."));
	}
	function DisplayDate($unformatted_date)
	{
		return date("m/d/Y", strtotime($unformatted_date));
	}

	function format_date($date_string)
	{
		$date=new DateTime($date_string);
		return $date->format("Y-m-d");
	}
	function inputmask_format_date($date_string){
		$date=new DateTime($date_string);
		return $date->format("m/d/Y");	
	}

	function floatConvert($num){
		return number_format((float)$num,2,'.',',');
	}

	function stripFloat($num){
		return str_replace(',','',$num);
	}

	function cStat($stat){
		return $stat = $stat==1?'Old':'New';
	 }

	 function isEmptyFloat($num = ""){
			return !empty($num) && $num != "0.0" ? number_format((float)$num,2,'.',',') : "";
	 }

	 function isFloat($num = ""){
		 return (float)$num != 0.00 ? (float)$num : "";
	 }

	 function isEmptyInt($num = ""){
		 return (int)$num != 0 ? $num : "";
	 }

	 function isFloatAddon($num = ""){
	 return (float)$num != 0.00 ? (float)$num : "0.00";	
	 }

	 function isEmptyDate($date){
		 $date .= "";
		 return $date == "0000-00-00" || $date == "" ? "" : date_format(date_create($date),'m/d/Y');
	 }
//=============================== NEW FUNCTION ============================================================

	 function fullName($f,$m,$l){
		$m = empty($m) ? "" : substr($m,0,1).". ";
		return $f." ".$m."".$l;
	 }

	 function dateFormat($date){
		$date = New DateTime($date);
		return $date->format('F d, Y');
	 }

	 function stayDuration($date1,$date2){
		$date1 = New DateTime($date1);
		$date2 = New DateTime($date2);
		$diff = $date1->diff($date2);
		return $diff->format('%R,%a');
	 }


	 function dbPeso($curr){
		 return number_format(str_replace('₱ ','',str_replace(',','',$curr)),2,'.','');
	 }

	 function dbDate($date){
		 $format = New DateTime($date);
		 return $format->format('Y-m-d');	 
	 }
	 
	 function cleanHTML($string){
		 return htmlspecialchars($string);
	 }

	 function cleanPeso($peso){
		 return htmlspecialchars("₱ " . number_format($peso,2,'.',','));
	 }

	 function cleanDB($param){
		 return rtrim($param);
	 }

	 function print_ar($arr) {
		 echo "<pre>";
		 print_r($arr);
		 echo "</pre>";
	 }
/*
Validation functions
*/
function valid_username($username) {
	global $con;
	$valid = $con->myQuery("SELECT * FROM users WHERE BINARY username = ?",array($username))->fetch(PDO::FETCH_ASSOC);
	$stat = strlen($username) < 6 ? TRUE : FALSE;
	return $valid > 0 || preg_match("/[^[:alnum:]]/",$username) || $stat ? FALSE : TRUE;
}

function valid_email($email){
	global $con;
	$valid_e = $con->myQuery("SELECT * FROM users WHERE BINARY email = ?",array($email))->fetch(PDO::FETCH_ASSOC);
	return $valid_e <= 0 && filter_var($email,FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE) ? TRUE : FALSE;
}

function valid_pass($pass){
	$stat = strlen($pass) < 6 ? TRUE: FALSE;
	return $stat ? FALSE : TRUE;
}
/* End Validation Function */

/*Password Hashing */
function encrypt_pass($pass) {
	$options = [
		'cost' => 12,
		'salt' => mcrypt_create_iv(22,MCRYPT_DEV_URANDOM)
	];
	return password_hash($pass,PASSWORD_BCRYPT,$options);
}

function verify_pass($pass,$hash){
	return password_verify($pass,$hash);
}
/*End Password Hashing */

function archiveAuditLog()
{
    if (file_exists("./audit_log.txt")) {
        $current=new DateTime();
        rename("./audit_log.txt", "./archive/Audit log ".$current->format("Y-m-d h-i-s").".txt");
    }
}

/* User FUNCTIONS */
	// function isLoggedIn()
	// {
	// 	if(empty($_SESSION[WEBAPP]['user']))
	// 	{
	// 		return false;
	// 	}
	// 	else
	// 	{
	// 		return true;
	// 	}
	// }
	function toLogin($url=NULL)
	{
		if(empty($url))
		{
			Alert('Please Log in to Continue',"danger");
			header("location: ../frmlogin.php");
		}
		else{
			header("location: ".$url);
		}
	}
	// function Login($user)
	// {
	// 	$_SESSION[WEBAPP]['user']=$user;
	// }
/* End User FUnctions */
//HTML Helpers
	// function makeHead($pageTitle=WEBAPP, $level=0)
	// {
	// 	require_once str_repeat('../', $level).'template/head.php';
	// 	unset($pageTitle);
	// }
	// function makeFoot($pageTitle=WEBAPP,$level=0)
	// {
	// 	global $request_type;
	// 	require_once str_repeat('../', $level).'template/foot.php';
	// 	unset($pageTitle);
	
	// }
	

	function makeOptions($array,$placeholder="",$checked_value=NULL){
		$options="";
		// if(!empty($placeholder)){
			$options.="<option value=''>{$placeholder}</option>";
		// }
		foreach ($array as $row) {
			list($value,$display) = array_values($row);
				if($checked_value!=NULL && $checked_value==$value){

					$options.="<option value='".htmlspecialchars($value)."' checked>".htmlspecialchars($display)."</option>";
				}
				else
				{
					$options.="<option value='".htmlspecialchars($value)."'>".htmlspecialchars($display)."</option>";
				}
		}
		return $options;
	}
//END HTML Helpers
/* BOOTSTRAP Helpers */
	function Alert($content= "", $type = "info",$title= "",$timer= 1500){
		
		$_SESSION['alert'] = array(
			"content" => $content,
			"type" => $type,
			"title" => $title,
			"timer" => $timer	
		);
		echo  "<script>
			swal({
				type: '{$type}',
				title: '{$title}',
				text: '{$content}',
				position: 'center',
				showConfirmButton: false,
				timer: {$timer}
			});
			</script>";
	}

	function RunAlert(){
		if(isset($_SESSION['alert']) && !empty($_SESSION['alert'])){
			$data = $_SESSION['alert'];
			echo "<script>$(document).ready(function(){
				swal({
					title:'{$data['title']}',
					text: '{$data['content']}',
					type: '{$data['type']}',
					showConfirmButton: false,
					timer: {$data['timer']}
				});

			});</script>";
			unset($_SESSION['alert']);
		}
	}
	
	
	
/* End BOOTSTRAP Helpers */


function AllowUser($user_role){
	global $con;
	$user_role_id = $_SESSION[WEB]['role'];
	$data = $con->myQuery("SELECT * FROM user_role WHERE role_name = ?",array($user_role))->fetch(PDO::FETCH_ASSOC);
	return verify_pass($data['role_id'],$user_role_id) && isset($_SESSION[WEB]['role']) ? TRUE : FALSE;

}

function refresh_activity($user_id)
{
	global $con;
	$con->myQuery("UPDATE users SET last_activity=NOW() WHERE user_id=?",array($user_id));
}
function is_active($user_id)
{
	return true;
	global $con;
	$last_activity=$con->myQuery("SELECT last_activity FROM users  WHERE user_id=?",array($user_id))->fetchColumn();
	$inactive_time=60*5;
	// echo strtotime($last_activity)."<br/>";
	// echo time();
	if(time()-strtotime($last_activity) > $inactive_time){
		return false;
	}

	return true;
}

function getUserDetails($emp_id)
{
    global $con;

    return $con->myQuery("SELECT * FROM users WHERE user_id=? LIMIT 1", array($emp_id))->fetch(PDO::FETCH_ASSOC);
}
function user_is_active($user_id)
{
	global $con;
	$last_activity=$con->myQuery("SELECT is_active FROM users  WHERE user_id=?",array($user_id))->fetchColumn();
	if(!empty($last_activity)){
		return true;
	}
	else{
		return false;
	}
}

/* END SPECIFIC TO WEBAPP */
	require_once('class.myPDO.php');
	$con = new myPDO('ace_system','root','');

	// if(isLoggedIn()){
	// 	if(!user_is_active($_SESSION[WEBAPP]['user']['user_id'])){
	// 		refresh_activity($_SESSION[WEBAPP]['user']['user_id']);
	// 		session_destroy();
	// 		session_start();
	// 		Alert("Your account has been deactivated.","danger");
	// 		redirect('frmlogin.php');
	// 		die;
	// 	}
	// 	if(is_active($_SESSION[WEBAPP]['user']['user_id'])){

	// 		refresh_activity($_SESSION[WEBAPP]['user']['user_id']);
	// 	}
		// else{
			//echo 'You have been inactive.';
			// die;
			// refresh_activity($_SESSION[WEBAPP]['user']['user_id']);
			// // die;
			// $con->myQuery("UPDATE users SET is_login=0 WHERE user_id=?",array($_SESSION[WEBAPP]['user']['user_id']));
			// session_destroy();
			// session_start();
			// Alert("You have been inactive for 5 minutes and have been logged out.","danger");
			// redirect('frmlogin.php');
			// die;
	// 	}
	// }
	

	
?>
