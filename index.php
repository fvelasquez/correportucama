<?php
header('P3P: CP="CAO PSA OUR"');
require_once('includes/facebook.php');
require_once('includes/config.php');
require_once('includes/functions.php');

$fecha_i = getFecha('i');
$fecha_f = getFecha('f');
$juegoactivo = juegoActivo();
	
$facebook = new Facebook(array(
  	'appId'  => FACEBOOK_APP_ID,
  	'secret' => FACEBOOK_SECRET_KEY,
  	'cookie' => true, // enable optional cookie support
	'domain' => 'branding-machine.com'
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
    	'query' => 'SELECT target_id FROM connection WHERE source_id = '.$oauth_uid.' AND target_id = 172113839511790'
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

	</head>
	<body>
		<div id="fb-root"></div>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script>
		  FB.init({
		    appId  : '<?php echo FACEBOOK_APP_ID; ?>',
		    status : true,
		    cookie : true,
		    xfbml  : true,
		    channelUrl  : 'http://carrerapasaporte.branding-machine.com/channel.html'  // custom channel
		  });
		  
		  (function() {
				var e = document.createElement('script');
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				e.async = true;
				document.getElementById('fb-root').appendChild(e);
			}());
  
		  //Altura del Canvas del Juego en FB
		  FB.Canvas.setSize({ height: 1200 });
		</script>
		<div id="container">
			<div id="header">
				<a href="javascript: void(0);" onclick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>';"><img src="images/logocarrera.png" alt="logocarrera" border="0"/></a>
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
						//SI HAY CUPO
						$hcupo = getTotalParticipantes();
						if($hcupo <= 400){
						//'<a href="quieroparticipar.php?aedrf=< ?php echo $oauth_uid; ? >&euu=< ?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2');? >&d=< ? php echo date('Y-m-d H:i:s');? >"><img src="images/tabparticipa.png" alt="tabparticipa" border="0"/></a>'
							if($juegoactivo == true){
					?>
							<a href="quieroparticipar.php?aedrf=<?php echo $oauth_uid; ?>&euu=<?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2');?>&d=<?php echo date('Y-m-d H:i:s'); ?>"><img src="images/tabparticipa.png" alt="tabparticipa" border="0"/></a>
					<?php 
							}else{
						?>
							<img src="images/carreracerrada_tab.png" border="0" />
						<?php
							}
						}else{
							if($juegoactivo == true){
					?>
						<img src="images/cupolleno_tab.png" border="0" /	>
					<?php
							}else{
					?>
						<img src="images/carreracerrada_tab.png" border="0" />
					<?php
							}
						}
					}
					
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
								$aff3 = getTotalParticipantes();
								if($aff3 <= 400){
									if($juegoactivo == true){
								?>
									<a href="quieroparticipar.php?aedrf=<?php echo $oauth_uid; ?>&euu=<?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2');?>&d=<?php echo date('Y-m-d H:i:s');?>"><img src="images/tabparticipa.png" alt="tabparticipa" border="0"/></a>
								<?php 
									}else{
								?>
									<img src="images/cupolleno_tab.png" border="0">
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
					if($msg == "1"){ $mmsg = "Tu voto ha sido registrado correctamente!"; }
					if($msg == "2"){ $mmsg = "Ya estas participando por tu pasaporte!<br />Consigue votos y gana!"; }
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
			<div id="footer"></div>
			<div id="comments">
				<fb:comments href="<?php echo FACEBOOK_CANVAS_URL; ?>" num_posts="3" width="600"></fb:comments>
			</div>
		</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24458684-1']);
  _gaq.push(['_setDomainName', '.branding-machine.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>
<?php
		}

	} catch (FacebookApiException $e) {
		echo "Error: " . print_r($e, true);
	}
}


?>