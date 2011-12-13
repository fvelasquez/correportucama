<?php
function encrypt_url($string) {
        $key = "1j2h3g1kj23hg1k2jh3g1k"; //preset key to use on all encrypt and decrypts.
        $result = '';
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));
     $result.=$char;
   }
   return urlencode(base64_encode($result));
}

function decrypt_url($string) {
        $key = "1j2h3g1kj23hg1k2jh3g1k";
        $result = '';
        $string = base64_decode(urldecode($string));
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)-ord($keychar));
     $result.=$char;
   }
   return $result;
}

function getFecha($t)
{
	switch($t)
	{
		case 'i':
			//$f = date('Y-m-d 00:00:00');
			//$f = '2011-7-18 09:00:00';
			//$f = '2011-7-11 09:00:00';
			//$f = '2011-7-25 09:00:00';
			$f = '2011-08-08 09:00:00';
		break;
		case 'f':
			//$f = date('Y-m-d 23:59:59');
			//$f = '2011-7-22 15:00:00';
			//$f = '2011-7-15 15:00:00';
			//$f = '2011-7-29 15:00:00';
			$f = '2011-08-12 18:00:00';
		break;
		default:
			$f = date('Y-m-d H:i:s');
		break;
	}
	
	return $f;
}

function getTotalParticipantes()
{
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
	
	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$res = mysql_query("SELECT count(*) total FROM cpass_user WHERE gano = 'N' AND estatus = 'A' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f'");
	$aff = mysql_fetch_assoc($res);
	
	return $aff['total'];
	
}

function juegoActivo(){
	
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
	
	$hr = date('Y-m-d H:i:s',strtotime ("+60 minutes"));
	//$horarestriccion = date('Y-m-d H:i:s');
	//echo $horarestriccion;
	$v = false;
	if(($hr > $fecha_i) && ($hr < $fecha_f))
	{
		$v = true;
	}
	//$v = false;
	
	return $v;
}

function jugadorActivo($id)
{
	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
	
	$res = mysql_query("SELECT count(*) as tot FROM cpass_user WHERE id = $id AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f'");
	$aff = mysql_fetch_assoc($res);

	if($aff['tot'] > 0){ $ja = true; }else{ $ja = false; }

	return $ja;
}

function getOauthUid($id){

	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$res = mysql_query("SELECT oauth_uid FROM cpass_user WHERE id = $id");
	$aff = mysql_fetch_assoc($res);
	
	return $aff['oauth_uid'];


}
?>