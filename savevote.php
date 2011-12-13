<?php
header('P3P: CP="CAO PSA OUR"');
require_once('includes/facebook.php');
require_once('includes/config.php');
require_once('includes/functions.php');
	
	$facebook = new Facebook(array(
	  	'appId'  => FACEBOOK_APP_ID,
	  	'secret' => FACEBOOK_SECRET_KEY,
	  	'cookie' => true, // enable optional cookie support
		'domain' => 'branding-machine.com'
	));

	$session = $facebook->getSession();
	
	$d 			= $_GET['d'];
	$salt		= 'd2812co9dliho2';
	
	$enc_ar 	= decrypt_url($_GET['jshd']);
	$encar		= explode('|',$enc_ar);
	$compd		= $encar[0];
	$comps		= $encar[1];
	
	$oid = decrypt_url($_GET['aeudj']);
	if($oid == ''){ decrypt_url($_POST['aeudj']); }
	$vid = decrypt_url($_GET['iejydh']);
	if($vid == ''){ decrypt_url($_POST['iejydh']); }
	
	
	$where = $_GET['f'];
	if($where == ''){ $_POST['f']; }
	$pista = $_GET['pista'];
	if($pista == ''){ $_POST['pista']; }
	
	$date = date('Y-m-d H:i:s',strtotime ("+1 hour"));
	
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
			
	
if($d == $compd){ // Verifica la fecha de presion del boton y la que viene encriptada
//if($salt == $comps){ // Verifica la sal que viene encriptada con lo que se que viene
if(strlen($vid) >= 4){ // Revisa el largo minimo de un id para facebook
	if(ctype_digit($vid) == true){ // Revisa si el ID del usuario que vota es numerico
		
		$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
		mysql_select_db(BD_NAME);
		$res = mysql_query("SELECT * FROM cpass_votes WHERE oauth_uid = '".$oid."' AND vote_uid = '".$vid."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f'");
		$aff = mysql_affected_rows($con);
			
		if($aff == 0){ //Revisa si ha votado previamente por este usuario en esta fecha				
			if ($session) {
				$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$vid;
					$response = $facebook->api(array(
						'method' => 'fql.query',
						'query' =>$fql,
					));
 				if(is_array($response)){ // Revisa si existe el usuario en facebook
				
					$ra = $response[0];
					if($ra['uid'] != ''){ // Si existe pasa e inserta el valor en la bdd sino lo pasa por alto
						mysql_query("INSERT INTO cpass_votes (oauth_uid, vote_uid, fecha_vote) VALUES ('".$oid."','".$vid."','$date')");
					}
				}
			}
		}
	}
	
	/*
	$facebook = new Facebook(array(
	  'appId'  => FACEBOOK_APP_ID,
	  'secret' => FACEBOOK_SECRET_KEY,
	  'cookie' => true, // enable optional cookie support
	));

	$session = $facebook->getSession();

	if ($session) {
		$attachment = array('message' => 'Yo vote por mi amigo para que gane su pasaporte a Ensancha 2011!',
                'name' => 'Corre por tu pasaporte',
                'link' => FACEBOOK_CANVAS_URL,
                'description' => 'Corre por tu pasaporte de Ensancha 2011! Participa, Vota y Gana!',
                'picture' => FACEBOOK_SITE_URL.'/images/jugador_pic.jpg'
                );


	    $result = $facebook->api('/me/feed/',
                                'post',
                                $attachment);
	}
	*/
	
	if($where == 'ficha'){
		echo "<script type='text/javascript'>top.location.href = '".FACEBOOK_CANVAS_URL."?p=participar&pista=".$pista."&msg=1';</script>";
	}else{
		echo "<script type='text/javascript'>top.location.href = '".FACEBOOK_CANVAS_URL."?p=posiciones';</script>";
	}
}
//}
}
?>