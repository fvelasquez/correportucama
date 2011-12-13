<script>
	   	   	function cpassShareP(pista,mid){
				FB.init({ 
		            appId:'<?php echo FACEBOOK_APP_ID; ?>', cookie:true, 
		            status:true, xfbml:true 
		         });

				FB.ui({ method: 'feed',
					name: 'Corre por tu Cama Sublime', 
					message: 'Ayuda a mi amigo a ganar la "Carrera por tu Cama" de Camas Sublime!',
					link: '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista='+pista+'&id='+mid,
					picture: '<?php echo FACEBOOK_SITE_URL; ?>/images/iconofb.png',
					description: 'Participa en la "Carrera por tu Cama" y se uno de los ganadores de una cama semanal completamente gratis!<br> Corre, Vota y Gana!'
            	});
			}
</script>
<div id="appbody">
	<div id="posbody">
	<table cellpadding="3" cellspacing="0" border="0" width="700">
		<?php
		$juegoactivo = juegoActivo();
		
		$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
		mysql_select_db(BD_NAME);
		
		$i = 0;
		$query = "SELECT cpu.*, (SELECT count(*) as total FROM cpass_votes WHERE oauth_uid = cpu.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A') as totalvotos FROM cpass_user cpu WHERE cpu.oauth_provider = 'facebook' AND cpu.estatus = 'A'  AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f' ORDER by totalvotos DESC LIMIT 0,400";

		$res2 = mysql_query($query);
		
		while($re = mysql_fetch_assoc($res2)){
			$i++;
			$ouid 	= $re['oauth_uid'];
			$uid 	= $re['id'];
			$votos 	= $re['totalvotos'];
			$pista 	= $re['pista'];
			
			$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$ouid;
			$response = $facebook->api(array(
				'method' => 'fql.query',
				'query' =>$fql,
			));
 
			$r = $response[0];
			$color = '#ffffff';
			if(($i%2)==0){ $color = '#f0f0f0'; }
		?>
		<tr style="background-color: <?php echo $color; ?> !important;">
			<td>
				<div class="posNumber"><a name="<?php echo $i; ?>"/><?php echo $i; ?></div>
			</td>
			<td>
				<div style="width:50px; height: 50px; overflow:hidden; float:left">
					<img src="<?php echo $r['pic']?>" border="0" width="50">
				</div>
			</td>
			<td valign="top">
				<div class="postitle"><?php echo $r['name'];?></div>
				<div class="posbody">
					<strong>Tengo <?php echo $votos;?> votos</strong><br/>
					Encuentrame en la <a href="<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=<?php echo $pista; ?>&id=<?php echo $uid; ?>">Pista <?php echo $pista; ?></a>
				</div>
			</td>
			<td valign="top">
			<a href="http://twitter.com/share?url=http%3A%2F%2Fapps.facebook.com%2Fcorreportucama%2F&via=camassublime&text=Estoy corriendo por mi cama de Camas Sublime!! Ayudame a ganar y participa tu tambien!" target="_blank"><img src="images/compartir-twitter.png" alt="compartir en twitter" width="170"/></a><br />
      		<a href="#" onclick="cpassShareP('<?php echo $pista; ?>','<?php echo $uid; ?>');" ><img src="images/compartir-fb.png" alt="compartir en facebook" border="0" width="170"/></a>
			</td>
			<td valign="top">
		<?php			
			$ress = mysql_query("SELECT count(*) as total FROM cpass_votes WHERE vote_uid = '".$me['id']."' AND oauth_uid = '".$ouid."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A' ");
			$num_rows = mysql_fetch_assoc($ress);
			?>
			<?php
			if($num_rows['total'] == 0){
				if($juegoactivo == true){
			?>
				<a href="savevote.php?aeudj=<?php echo encrypt_url($ouid); ?>&iejydh=<?php echo encrypt_url($me['id']); ?>&num=<?php echo $i; ?>&f=posiciones&d=<?php echo date('Y-m-d H:i:s'); ?>&jshd=<?php echo encrypt_url(date('Y-m-d H:i:s').'|d2812co9dliho2'); ?>"><img src="images/votar_btn_small.png" alt="votar_btn_small" width="59" height="36"/></a>
			<?php
				}else{
			?>
				<img src="images/votar_btn_small_dis.png" alt="votar_btn_small" width="59" height="36"/>
			<?php
				}
			}else{
			?>
			<img src="images/votar_btn_small_dis.png" alt="votar_btn_small" width="59" height="36"/>
			<?php
			}?>
			</td>
		</tr>
		<?		
		}
		?>
		</table>
		<?php// echo date('Y-m-d H:i:s',strtotime ("+60 minutes")); ?>
	</div>
</div>