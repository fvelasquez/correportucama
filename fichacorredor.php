<?php
header('P3P: CP="CAO PSA OUR"');
require_once('includes/facebook.php');
require_once('includes/config.php');
require_once('includes/functions.php');

	$oid 		= $_POST['oid']; // OAUTH_UID DEL CORREDOR
	$uid 		= $_POST['uid']; // ID DEL REGISTRO
//	$pic		= $_POST['pic'];
//	$name		= $_POST['name'];
//	$oauth_uid 	= $_POST['ooid'];

$facebook = new Facebook(array(
  	'appId'  => FACEBOOK_APP_ID,
  	'secret' => FACEBOOK_SECRET_KEY,
  	'cookie' => true, // enable optional cookie support
	'domain' => 'branding-machine.com'
));

$session = $facebook->getSession();

if ($session) {
	
	$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$oid;
	$response = $facebook->api(array(
		'method' => 'fql.query',
		'query' =>$fql,
	));
				
	$ro = $response[0];
	
	$pic = $ro['pic_square'];
	$name = $ro['name'];
	
	$m = $facebook->api('/me');
	$voauth_uid = $m['id']; // ID de quien esta votando
	
					//Averigua si el juego aun esta activo por restriccion de hora y si el jugador buscado esta corriendo

	$juegoactivo = juegoActivo();
	$jugadoractivo = jugadorActivo($uid);

	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
				
	$res = mysql_query("SELECT * FROM cpass_user WHERE id = '".$uid."'");
	$aff = mysql_affected_rows($con);
	
	if($aff > 0 && $jugadoractivo == true)
	{
		$r = mysql_fetch_assoc($res);
		$pista = $r['pista'];
?>
	<div id="fichacolleft">
		<div id="ficha_player">
			<div id="ficha_face">
				<div id="ficha_face_mask">
				<img src="<?php echo $pic; ?>" border="0" width="100">
				</div>
			</div>
			<div id="ficha_number"><?php echo $uid; ?></div>
		</div>
	</div>
	<div id="fichacolright">
		<h3><?php echo $name; ?></h3>
		<div id="punteo">
			<?php
			$fecha_i = getFecha('i');
			$fecha_f = getFecha('f');
			
			$ress = mysql_query("SELECT count(*) as total FROM cpass_votes WHERE vote_uid = '".$voauth_uid."' AND oauth_uid = '".$oid."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A'");
			$num_rows = mysql_fetch_assoc($ress);
			
			$vot = mysql_query("SELECT count(*) as total FROM cpass_votes WHERE oauth_uid = '".$oid."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A'");

			$vots = mysql_fetch_assoc($vot);
			$votos = $vots['total'];
			?>
			<span>Tengo <?php echo $votos; ?> votos</span>
			<?php
			if($num_rows['total'] == 0){
				if($juegoactivo == true){
			?>
				<a href="savevote.php?aeudj=<?php echo encrypt_url($oid); ?>&iejydh=<?php echo encrypt_url($voauth_uid); ?>&pista=<?php echo $pista; ?>&f=ficha&d=<?php echo date('Y-m-d H:i:s'); ?>&jshd=<?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2'); ?>" id="votar_btn"><img src="images/votar_btn.png" alt="votar_btn" border="0"/></a>
			<?php 
				}else{
			?>
				<img src="images/votar_btn_dis.png" alt="votar_btn" id="votar_btn" border="0"/>			
			<?php
				}
			}else{
			?>
			<img src="images/votar_btn_dis.png" alt="votar_btn" id="votar_btn" border="0"/>
			<?php
			}?>
		</div>
		<div id="badge">
			<?php
				switch($votos){
					case $votos >= 0 && $votos < 10:
						$badge_title = 'Participante';
						$badge_image = 'images/star_participante.png';
					break;
					case $votos >= 10 && $votos < 50:
						$badge_title = 'Corredor';
						$badge_image = 'images/star_corredor.png';
					break;
					case $votos >= 50 && $votos < 100:
						$badge_title = 'Habilidoso';
						$badge_image = 'images/star_habilidoso.png';
					break;
					case $votos >= 100 && $votos < 200:
						$badge_title = 'Rapido';
						$badge_image = 'images/star_rapido.png';
					break;
					case $votos >= 200 && $votos < 400:
						$badge_title = 'Veloz';
						$badge_image = 'images/star_veloz.png';
					break;
					case $votos >= 400:
						$badge_title = 'Rayo';
						$badge_image = 'images/star_rayo.png';
					break;
					default:
						$badge_title = 'Participante';
						$badge_image = 'images/star_participante.png';
					break;
				}
			?>
			<h3><?php echo $badge_title; ?></h3>
			<img src="<?php echo $badge_image; ?>" alt="TU NIVEL"/>
		</div>
		<div id="sharesocial">
			<script src="http://connect.facebook.net/en_US/all.js"></script>
   	   		<script>
	   	   	function cpassShare(){
				FB.init({ 
		            appId:'<?php echo FACEBOOK_APP_ID; ?>',
		            cookie:true,
		            status:true,
		            xfbml:true,
		            channelUrl  : 'http://carrerapasaporte.branding-machine.com/channel.html'  // custom channel
				});
		  
			  (function() {
					var e = document.createElement('script');
					e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
					e.async = true;
					document.getElementById('fb-root').appendChild(e);
				}());

				FB.ui({ method: 'feed',
					name: 'Corre por tu Cama Sublime', 
					message: 'Ayuda a mi amigo a ganar la "Carrera por tu Cama" de Camas Sublime!',
					link: '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=<?php echo $pista; ?>&id=<?php echo $uid; ?>',
					picture: '<?php echo FACEBOOK_SITE_URL; ?>/images/iconofb.png',
					description: 'Participa en la "Carrera por tu Cama" y se uno de los ganadores de una cama semanal completamente gratis!<br> Corre, Vota y Gana!'
            	});
			}
			</script>
			<a href="http://twitter.com/share?url=http%3A%2F%2Fapps.facebook.com%2Fcorreportucama%2F&via=camassublime&text=Estoy corriendo por mi cama de Camas Sublime!! Ayudame a ganar y participa tu tambien!"/></a>
      		<a href="#" onclick="cpassShare();" ><img src="images/compartir-fb.png" alt="compartir en facebook" border="0"/></a>
			<br><br>
			<strong style="font-size:11px">Mi Link:</strong><br/>
			<input type="text" name="milink" value="<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=<?php echo $pista; ?>&id=<?php echo $uid; ?>" alt="Copiame!" size="40" onclick="this.focus(); this.select();" />
		</div>
	</div>
	<div id="fb-root"></div>
<?php
	}else{
?>
	<div id="fichacolleft">
		<div id="ficha_player">
			<div id="ficha_face">
			</div>
		</div>
	</div>
	<div id="fichacolright">
		
		<h5 style="width:300px; padding:15px; background-color:#e0e0e0;">El corredor que buscas no esta participando el dia de hoy.</h5>
		
	</div>
<?php
	}
}
?>