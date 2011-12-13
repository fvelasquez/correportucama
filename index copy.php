<?php
require_once('includes/facebook.php');
require_once('includes/config.php');
require_once('includes/functions.php');

$fecha_i = date('Y-m-d 09:00:00');
$fecha_f = date('Y-m-d 21:00:00');
					
$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_SECRET_KEY,
  'cookie' => true, // enable optional cookie support
));

$session = $facebook->getSession();

if (!$session) {
 
	$url = $facebook->getLoginUrl(array(
		'req_perms'=> 'publish_stream,offline_access',
		'canvas' => 1,
		'fbconnect' => 0
	));
 
	echo "<script type='text/javascript'>top.location.href = '$url';</script>";
	
} else {
 
	try {
 
		$uid = $facebook->getUser();
		$me = $facebook->api('/me');
		$oauth_uid = $me['id'];

		$updated = date("l, F j, Y", strtotime($me['updated_time']));

		$likeID = $facebook->api(array(
    	'method' => 'fql.query',
    	'query' => 'SELECT target_id FROM connection WHERE source_id = '.$oauth_uid.' AND target_id = 81356739217'
    	));

if(empty($likeID)) {
    
  include_once('nosoyfan.php');
			    
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Corre por tu Pasaporte</title>
		<link href="css/app.css" media="screen" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
		<script>
			var j = jQuery.noConflict();
			function cargarCorredor(ouid)
			{
				j('#appheadertab_id').fadeOut('fast').load('corredorrandom.php',{'ouid':ouid},function(){ j('#appheadertab_id').fadeIn('slow'); } );
			}
		</script>
		<script type="text/javascript" src="js/jquery.spritely-0.4.js"></script>
		<script type="text/javascript" src="js/jquery.countdown.pack.js"></script>
		<script type="text/javascript" src="js/jquery.countdown-es.js"></script>
		<script type="text/javascript" src="js/jquery.countdown.css"></script>

	</head>
	<body>
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script>
		  FB.init({
		    appId  : '221055834571782',
		    status : true,
		    cookie : true,
		    xfbml  : true
		  });
		  //Altura del Canvas del Juego en FB
		  FB.Canvas.setSize({ height: 1200 });
		</script>
		<div id="container">
			<?php 
			$horarestriccion = date('Y-m-d H:i:s',strtotime ("+1 hour"));

			if(($horarestriccion < $fecha_i) || ($horarestriccion > $fecha_f)){
			//
			// SI YA LLEGO A LA HORA DE RESTRICCION
			//
			?>
			<div id="body">			
				<div id="appcorredordetalle" style="margin:120px 0px 0px 20px">
					<div id="appcorredordetalle_logo"></div>
					<div id="appcorredordetalle_content">
						<div id="fichacolleft">
							<div id="ficha_player">
								<div id="ficha_face">
								</div>
							</div>
						</div>
						<div id="fichacolright">
							<div id="cerrardialogo">
								<h2>LA CARRERA HA TERMINADO</h2>
								Puedes participar el dia de mañana de las 9:00 a las 21:00	
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="clearfix">&nbsp;</div>
				<div class="clearfix">&nbsp;</div>
			</div>
			<?php 
			}else{ 
			//
			// SI AUN SE PUEDE JUGAR
			//
			?>
			<div id="header">
				<a href="javascript: void(0);" onclick="top.location = 'http://apps.facebook.com/correportupasaporte/';"><img src="images/logocarrera.png" alt="logocarrera" border="0"/></a>
				<?php include('appmenu.php'); ?>
				<div id="appheadertab">
					<div id="appheadertab_id">
					<?php
					$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
					mysql_select_db(BD_NAME);

					$query = "SELECT cpu.* FROM cpass_user cpu WHERE cpu.oauth_provider = 'facebook' and oauth_uid = '".$oauth_uid."'";
					$res = mysql_query($query);
					$aff = mysql_affected_rows($con);
					
					//SI NUNCA HA PARTICIPADO
					if($aff == 0){
					?>
					<a href="quieroparticipar.php?uid=<?php echo $oauth_uid; ?>&d=<?php echo date('Y-m-d H:i:s');?>"><img src="images/tabparticipa.png" alt="tabparticipa" border="0"/></a>
					<?php }
					
					//SI QUIERO PARTICIPAR PERO NO HA GANADO, HAY CUPO Y NO LE DI AL BOTON
					if($aff != 0){
						$r = mysql_fetch_assoc($res);
						//ESTOY PARTICIPANDO YA?
						$con2 = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
						mysql_select_db(BD_NAME);
						$query2 = "SELECT cpu.* FROM cpass_user cpu WHERE cpu.oauth_provider = 'facebook' and oauth_uid = '".$oauth_uid."' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f'";
						$res2 = mysql_query($query2);
						$aff2 = mysql_affected_rows($con2);
						mysql_close($con2);
						if($aff2 == 0){
							//HA GANADO?
							$gano = $r['gano'];
							if($gano == 'N'){
								//HAY CUPO?
								$con3 = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
								mysql_select_db(BD_NAME);
								$query3 = "SELECT * FROM cpass_user WHERE oauth_provider = 'facebook' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f'";
								$res3 = mysql_query($query3);
								$aff3 = mysql_affected_rows($con3);
								mysql_close($con3);
								if($aff3 <100){
								?>
								<a href="quieroparticipar.php?uid=<?php echo $oauth_uid; ?>&d=<?php echo date('Y-m-d H:i:s');?>"><img src="images/tabparticipa.png" alt="tabparticipa" border="0"/></a>
					<?php 
								}else{
								?>
									<script>
										cargarCorredor();
										setInterval('cargarCorredor()',15000);
									</script>
								<?php
								}
							}else{
							?>
								<script>
									cargarCorredor();
									setInterval('cargarCorredor()',15000);
								</script>
							<?php
							}
						}else{
						?>
							<script>
								cargarCorredor('<?php echo $oauth_uid; ?>');
							</script>
						<?php
						}
					} 
					
					//SI PARTICIPO Y GANO
					if($aff != 0){
						$r = mysql_fetch_assoc($res);
						$gano = $r['gano'];
						if($gano == 'S'){
						?>
							<script>
								cargarCorredor();
								setInterval('cargarCorredor()',15000);
							</script>
						<?php 
						}
					}
					
					//SI PUEDE PARTICIPAR, PERO YA NO HAY CUPO
					
					?>
					</div>
				</div>
			</div>
			<div id="body">
				<?php
				if(isset($_GET['msg']) && $_GET['msg'] != ''){
					$msg = $_GET['msg'];
					$mmsg =($msg==1)?"Tu voto ha sido registrado correctamente!":"";
				?>
				<script>
					j(function(){
						j('#messages').fadeOut(5000);
					});
				</script>
				<div id="messages"><?php echo $mmsg; ?></div>
				<?php 
				}
				?>
			<?php
    			// user HAS Liked the page/whatever
				$pagina = $_GET['p'];
				
				switch($pagina){
					case "participa":
						include_once('participa.php');
					break;
					case "posiciones":
						include_once('posiciones.php');
					break;
					case "ganadores":
						include_once('ganadores.php');
					break;
					case "instrucciones":
						include_once('instrucciones.php');
					break;
					case "confirmaparticipa":
						include_once('participa_confirma.php');
					break;
					default:
						include_once('participa.php');
					break;
				}
			?>
			</div>
			<?php 
			}
			?>
			<div id="footer"></div>
			<div id="comments">
				<div id="fb-root"></div>
				<fb:comments href="http://apps.facebook.com/correportupasaporte/" num_posts="3" width="600"></fb:comments>
			</div>
		</div>
	</body>
</html>
<?php
		}

	} catch (FacebookApiException $e) {
		echo "Error:" . print_r($e, true);
	}
}


?>