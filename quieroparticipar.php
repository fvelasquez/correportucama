<?php	
	include('includes/facebook.php');
	include('includes/config.php');	
	include('includes/functions.php');
	
	$userid 	= $_GET['aedrf'];
	$salt 	= 'd2812co9dliho2';
	
	$enca 	= decrypt_url($_GET['euu']);
	
	$encaa 	= explode('|',$enca);
	$d		= $_GET['d'];
	$ea		= $encaa[0];
	$es		= $encaa[1];
	

	$facebook = new Facebook(array(
	  	'appId'  => FACEBOOK_APP_ID,
	  	'secret' => FACEBOOK_SECRET_KEY,
	  	'cookie' => true, // enable optional cookie support
		'domain' => 'branding-machine.com'
	));

	$session = $facebook->getSession();
	
	$date = date('Y-m-d H:i:s',strtotime ("+1 hour"));
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
	
	// ************************************************************************************************
	// AQUI SE VERIFICA TODO
	// ************************************************************************************************	
	
		$pista = 1;
		$encola = 0;
		$aceptado = 1;
		$totpart = getTotalParticipantes();
		
		if($totpart <= 33){ $pista = 1; $encola = 0; }
		if($totpart > 33 && $totpart <= 66){ $pista = 2; $encola = 0; }
		if($totpart > 66 && $totpart <= 100){ $pista = 3; $encola = 0; }
		//Cuando aumentemos a 200 descomentar esto
		
		if($totpart > 100 && $totpart <= 133){ $pista = 4; $encola = 0; }
		if($totpart > 133 && $totpart <= 166){ $pista = 5; $encola = 0; }
		if($totpart > 166 && $totpart <= 200){ $pista = 6; $encola = 0; }
		
		if($totpart > 200 && $totpart <= 233){ $pista = 7; $encola = 0; }
		if($totpart > 233 && $totpart <= 266){ $pista = 8; $encola = 0; }
		if($totpart > 266 && $totpart <= 300){ $pista = 9; $encola = 0; }
		
		if($totpart > 300 && $totpart <= 333){ $pista = 10; $encola = 0; }
		if($totpart > 333 && $totpart <= 366){ $pista = 11; $encola = 0; }
		if($totpart > 366 && $totpart <= 400){ $pista = 12; $encola = 0; }
		
		
		//if($totpart > 300){ $encola = 1; $aceptado = 2; }
		if($totpart > 400){ $encola = 2; $aceptado = 2; }
		if($totpart > 500){ $encola = 3; $aceptado = 2; }
	
	// ************************************************************************************************
//if($ea == $d){
if(strlen($userid) >= 4){ // Revisa el largo minimo de un id para facebook
if(ctype_digit($userid) == true){ // Revisa si el ID del usuario que vota es numerico

	$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$res = mysql_query("SELECT * FROM cpass_user WHERE oauth_uid = '".$userid."'");
	$aff = mysql_affected_rows($con);
	if($aff == 0){
/*		if ($session) {
			$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$userid;
					$response = $facebook->api(array(
						'method' => 'fql.query',
						'query' =>$fql,
				));
			if(is_array($response)){ // Revisa si existe el usuario en facebook
				
				$ra = $response[0];
				if($ra['uid'] != ''){ // Si existe pasa e inserta el valor en la bdd sino lo pasa por alto
*/					mysql_query("INSERT INTO cpass_user (oauth_uid, oauth_provider, fecha_crea, fecha_jugando, participo, pista, encola) VALUES ('".$userid."','facebook','$date','$date',1,'$pista','$encola')");
//				}
//			}
		//}
	}else{
		
		$con2 = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
		mysql_select_db(BD_NAME);
		$res2 = mysql_query("SELECT * FROM cpass_user WHERE oauth_uid = '".$userid."' and gano = 'N'");
		$aff2 = mysql_affected_rows($con2);

		if($aff2 != 0){
			$res22 = mysql_fetch_assoc($res2);
			$par = $res22['participo'];
			$par = $par + 1;
			
			mysql_query("UPDATE cpass_user SET fecha_jugando = '$date', participo = $par, pista = $pista, encola = $encola WHERE oauth_uid = '".$userid."'");
		}
	}
}
}
//}
	if($aceptado == "1"){
		echo "<script type='text/javascript'>top.location.href = '".FACEBOOK_CANVAS_URL."?p=participa&msg=2';</script>";
	}
	if($aceptado == "2"){
		echo "<script type='text/javascript'>top.location.href = '".FACEBOOK_CANVAS_URL."?p=participa&msg=3';</script>";
	}
		
?>