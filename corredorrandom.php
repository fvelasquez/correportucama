<?php
require_once('includes/facebook.php');
include('includes/config.php');
include('includes/functions.php');

$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_SECRET_KEY,
  'cookie' => true, // enable optional cookie support
));

	$session = $facebook->getSession();
	$me = $facebook->api('/me');
	$oauth_uid = $me['id'];	
	$juegoactivo = juegoActivo();

	$ouid = $_POST['ouid'];
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');
	
	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$qry = "SELECT * FROM cpass_user WHERE estatus = 'A' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f'";
	if($ouid != '' && $ouid !='undefined')
	{
		$qry .= " AND oauth_uid = ".$ouid;
	}else{
		$qry .= " ORDER BY RAND() LIMIT 0,1";
	}
	
	$res = mysql_query($qry);
	$aff = mysql_affected_rows($con);
	
	if($aff > 0)
	{
		$re = mysql_fetch_assoc($res);
		
			$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$re['oauth_uid'];
			$response = $facebook->api(array(
				'method' => 'fql.query',
				'query' =>$fql,
			));
 
			$r = $response[0];
?>
	<div id="fichacolleft_tab">
		<div id="ficha_player_tab">
			<div id="ficha_face_tab">
				<div id="ficha_face_mask_tab">
				<img src="<?php echo $r['pic_square']; ?>" border="0" width="50">
				</div>
			</div>
			<div id="ficha_number_tab"><?php echo $re['id']; ?></div>
		</div>
	</div>
	<div id="fichacolright_tab">
		<h3><?php echo $r['name']; ?></h3>
		<div id="punteo_tab">
			<?php
		
			$ress = mysql_query("SELECT * FROM cpass_votes WHERE vote_uid = '".$me['id']."' AND oauth_uid = '".$re['oauth_uid']."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' ");
			$num_rows = mysql_num_rows($ress);
			
			$vot = mysql_query("SELECT count(*) as total FROM cpass_votes WHERE oauth_uid = '".$re['oauth_uid']."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A'");
			
			$vots = mysql_fetch_assoc($vot);
			$votos = $vots['total'];
			
			if($ouid == 'undefined' || $ouid == ''){
			?>
				<span>Ay&uacute;dame a ganar!</span>
			<?php
				if($num_rows == 0){
					if($juegoactivo == true){
			?>				
				<a href="savevote.php?aeudj=<?php echo encrypt_url($re['oauth_uid']); ?>&iejydh=<?php echo encrypt_url($me['id']); ?>&f=ficha&d=<?php echo date('Y-m-d H:i:s'); ?>&jshd=<?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2'); ?>" id="votar_btn_tab"><img src="images/votar_btn_tab.png" alt="votar_btn" border="0"/></a>
			<?php 
					}else{
			?>
				<img src="images/votar_btn_tab_dis.png" alt="votar_btn" id="votar_btn_tab" border="0"/>
			<?php
					}
				}else{
			?>
				<img src="images/votar_btn_tab_dis.png" alt="votar_btn" id="votar_btn_tab" border="0"/>
			<?php
				}
			}else{
			?>
			<script>
	   	   	function cpassSharefr(pista,mid){
				FB.init({ 
		            appId:'<?php echo FACEBOOK_APP_ID; ?>', cookie:true, 
		            status:true, xfbml:true 
		         });

				FB.ui({ method: 'feed',
					name: 'Corre por tu Cama Sublime', 
					message: 'Necesito ayuda para ganar la "Carrera por tu Cama" de Camas Sublime!',
					link: '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista='+pista+'&id='+mid,
					picture: '<?php echo FACEBOOK_SITE_URL; ?>/images/iconofb.png',
					description: 'Participa en la "Carrera por tu Cama" y se uno de los ganadores de una cama semanal completamente gratis!<br> Corre, Vota y Gana!'
            	});
			}
			
			/*function cpassShareMass(){
				FB.init({ 
		            appId:'<?php echo FACEBOOK_APP_ID; ?>', cookie:true, 
		            status:true, xfbml:true 
		         });

				FB.ui({ method: 'apprequests',
					title: 'Corre Por Tu Pasaporte Ensancha 2011',
					message: 'Estoy corriendo por mi pasaporte de ensancha!! Ayudame a ganar y participa tu tambien!'
            	});
			
			}*/
			</script>
			<a href="http://twitter.com/share?url=http%3A%2F%2Fapps.facebook.com%2Fcorreportucama%2F&via=camassublime&text=Estoy corriendo por mi cama de Camas Sublime!! Ayudame a ganar y participa tu tambien!" target="_blank"><img src="images/compartir-twitter-small.png" alt="compartir en twitter"/></a>
      		<a href="javascript: void(0);" onclick="cpassSharefr('<?php echo $re['pista']; ?>','<?php echo $re['id']; ?>');" ><img src="images/compartir-fb-small.png" alt="compartir en facebook" border="0"/></a>
			<?php
			}
			?>
		</div>
		<?php if($ouid != 'undefined' && $ouid != ''){ ?>
		<!--a href="javascript: void(0);" onclick="cpassShareMass();" ><img src="images/consiguevotos.png" alt="compartir en facebook a tus amigos" border="0"/></a-->
		<a href="javascript: void(0);" onclick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>';"><img src="images/refresh.png" border="0" width="35" height="29"/></a>
		<?php } ?>
	</div>
<?php
	}
?>