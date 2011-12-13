<div id="appbody">
	<div id="posbody">
	<table cellpadding="3" cellspacing="0" border="0" width="700">
		<?php
		$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
		mysql_select_db(BD_NAME);
				
		$i = 0;
		$query = "SELECT * FROM cpass_winners ORDER by fecha_gano";

		$res2 = mysql_query($query);
		
		while($re = mysql_fetch_assoc($res2)){
			$i++;
			$ouid 			= $re['oauth_uid'];
			$uid 			= $re['uid'];
			$fecha_gano 	= $re['fecha_gano'];
			$pista 			= $re['pista'];
			$votos			= $re['votos'];
			
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
				<img src="images/listonganador.png" border="0" />
			</td>
			<td>
				<div style="width:50px; height: 50px; overflow:hidden; float:left">
					<img src="<?php echo $r['pic']?>" border="0" width="50">
				</div>
			</td>
			<td valign="top">
				<div class="postitle"><?php echo $r['name'];?></div>
				<div class="posbody">
					<strong>Obtuve <?php echo $votos;?> votos</strong> en la carrera del 
					<strong>
					<?php 
					$fecha = new DateTime($fecha_gano);
					echo $fecha->format('d M Y');
					?>
					</strong>
				</div>
			</td>
			<td>
				<script>
	   	   	function cpassShare(){
				FB.init({ 
		            appId:'<?php echo FACEBOOK_APP_ID; ?>', cookie:true, 
		            status:true, xfbml:true 
		         });

				FB.ui({ method: 'feed',
					name: 'Corre por tu Pasaporte de Ensancha 2011', 
					message: 'Yo participe y gane mi pasaporte! Participa y gana tu tambien!',
					link: '<?php echo FACEBOOK_CANVAS_URL; ?>',
					picture: '<?php echo FACEBOOK_SITE_URL; ?>/images/jugador_pic.jpg',
					description: 'Participa en la "Carrera por tu Pasaporte" de Ensancha 2011 y se uno de los ganadores de los 30 pasaportes gratis!<br> Corre, Vota y Gana!'
            	});
			}
			</script>
			<a href="http://twitter.com/share?url=http%3A%2F%2Fapps.facebook.com%2Fcorreportupasaporte%2F&via=ensancha&text=Yo Gane mi pasaporte a Ensancha 2011 Corriendo por mi pasaporte! Participa y gana tu tambien!" target="_blank"><img src="images/compartir-twitter.png" alt="compartir en twitter" width="170"/></a><br />
      		<a href="#" onclick="cpassShare();" ><img src="images/compartir-fb.png" alt="compartir en facebook" border="0" width="170"/></a>
			</td>
		</tr>
		<?		
		}
		?>
		</table>
	</div>
</div>