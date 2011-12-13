<script>
function cp_openDialog(usrid,oauid){

	j('#appcorredordetalle').fadeIn('slow');
	j('#appcorredordetalle_content').load('fichacorredor.php',{'oid':oauid,'uid':usrid});
};

function cp_closeDialog(usrid){

	j('#appcorredordetalle').fadeOut('slow');
};
	
j(function(){
	/*
	j('#nubes').pan({fps: 20, speed: 1, dir: 'left'});
	j('#montanias').pan({fps: 30, speed: 3, dir: 'left'});
	j('#pista').pan({fps: 30, speed: 4, dir: 'left'});
	*/
	
	j('#nubes').pan({fps: 30, speed: 2, dir: 'left'});
	j('#montanias').pan({fps: 30, speed: 4, dir: 'left'});
	j('#pista').pan({fps: 30, speed: 5, dir: 'left'});
	
	j('#appdowncounternums').countdown({until: new Date(2011, 5 - 1, <?php echo date('d')?>, 21, 0, 0),compact: true,format: 'HMS'});
	
	<?php 
	if($juegoactivo == false){
	?>
		j('#appcorredordetalle').fadeIn('slow');
		j('#appcorredordetalle_content').load('fincarrera.php');
	<?php 
	}
	?>
	
	<?php
	if(isset($_GET['pista']) && isset($_GET['id']) && $_GET['id'] != '')
	{
		if($juegoactivo == true){
	?>
		cp_openDialog('<?php echo $_GET['id']?>','<?php $ouid = getOauthUid($_GET['id']); echo $ouid; ?>');	
	<?php
		}
	}
	
	?>
	
	<?php
		for($i = 1;$i<=34;$i++){
			/* CORREDORES EN PISTA
			echo "
			j('#corredor_".$i."').sprite({fps: 12, no_of_frames: 4});
			";
			*/
			echo "
			j('#corredor_".$i."').sprite({fps: 32, no_of_frames: 4});
			";
		}
	?>

	//TOOLTIP CODE
	//Select all anchor tag with rel set to tooltip
    j('a[rel=tooltip]').mouseover(function(e) {
         
        //Grab the title attribute's value and assign it to a variable
        var tip = j(this).attr('title');   
         
        //Remove the title attribute's to avoid the native tooltip from the browser
        j(this).attr('title','');
         
        //Append the tooltip template and its value
        j(this).append('<div id="tooltip"><div class="tipBody">' + tip + '</div></div>');
         
        //Set the X and Y axis of the tooltip
        var offset = j(this).offset();
  		var relativeX = (e.pageX - offset.left);
 		var relativeY = (e.pageY - offset.top);
 		
        j('#tooltip').css('top', relativeY - 40);
        j('#tooltip').css('left', relativeX - 30);
         
        //Show the tooltip with faceIn effect
        j('#tooltip').fadeIn('500');
        j('#tooltip').fadeTo('10',0.8);
         
    }).mousemove(function(e) {
     
        //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
        var offset = j(this).offset();
  		var relativeX = (e.pageX - offset.left);
 		var relativeY = (e.pageY - offset.top);

        j('#tooltip').css('top', relativeY - 40);
        j('#tooltip').css('left', relativeX - 30);
         
    }).mouseout(function() {
     
        //Put back the title attribute's value
        j(this).attr('title',j('.tipBody').html());
     
        //Remove the appended tooltip template
        j(this).children('div#tooltip').remove();
         
    });

});
</script>
<style>
<?php
	$conn = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$i = 0;
	$j = 1;
	$limit = "LIMIT 0,33";
	if($pista == '1'){ $limit = "LIMIT 0,33"; }
	if($pista == '2'){ $limit = "LIMIT 33,33"; }
	if($pista == '3'){ $limit = "LIMIT 66,34"; }
	if($pista == '4'){ $limit = "LIMIT 100,33"; }
	if($pista == '5'){ $limit = "LIMIT 133,33"; }
	if($pista == '6'){ $limit = "LIMIT 166,34"; }
	
	$fecha_i = getFecha('i');
	$fecha_f = getFecha('f');

	$query = "SELECT cpu.*, (SELECT count(*) as total FROM cpass_votes WHERE oauth_uid = cpu.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A') as totalvotos FROM cpass_user cpu WHERE cpu.oauth_provider = 'facebook' and cpu.gano = 'N' AND cpu.estatus = 'A' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f' ORDER by cpu.fecha_jugando ASC ".$limit;
	
	$res = mysql_query($query);
	$res2 = mysql_query($query);
	//Variables Calculo de Distancia
	$maxvotos = 1;
	while($r = mysql_fetch_assoc($res)){
		if($r['totalvotos'] > $maxvotos) { $maxvotos = $r['totalvotos']; }
	}
	$totpix = 610;
	$minpix = 1;
	$mleft = 1;
	
	while($r = mysql_fetch_assoc($res2)){
		$i++;
		
		$votos = $r['totalvotos'];
		
		if($votos == $maxvotos){ 
			$mleft = $totpix; 
		}else{ 
			$mleft = (($votos*$totpix)/$maxvotos); 
			if($mleft == ''){ $mleft = 1; }
			if($mleft == 0){ $mleft = 1; }
		}
		
		echo "
		#corredor_".$i."{
			background: url(../images/cars/cuerpo_".$j.".png) no-repeat top center;
			height: 50px;
			width: 76px;
			float: left;
			position: relative;
			clear:left;
			margin-top:-34.5px;
			margin-left: ".$mleft."px;
		}";
			$j++;
			if($j == 16){
				$j = 1;
			}
		}
	?>
</style>
<div id="appbody_shadow"></div>
<div id="appbody">
	<div id="appdowncounter">La carrera termina en: <span id="appdowncounternums">00:00:00</span></div>
	<?php 
		$totpart = getTotalParticipantes();
		$appnextpista = 0;
		
		if($totpart > 33 && ($pista == '1' || $pista == '')){ $appnextpista = 1; }
		if($totpart > 66 && $pista == '2'){ $appnextpista = 1; }
		if($totpart > 100 && $pista == '3'){ $appnextpista = 1; }
		if($totpart > 133 && $pista == '4'){ $appnextpista = 1; }
		if($totpart > 166 && $pista == '5'){ $appnextpista = 1; }
		if($totpart > 200 && $pista == '6'){ $appnextpista = 1; }
		
		if($appnextpista == 1)
		{
	?>
	<div id="appnextpista">
	<?php
		$pistanexticon = 'pista_next_1.png';
		if($pista == '1' || $pista == '') { $pistanexticon = 'pista_next_2.png'; $pistalink = '2'; }
		if($pista == '2') { $pistanexticon = 'pista_next_3.png'; $pistalink = '3'; }
		if($pista == '3') { $pistanexticon = 'pista_next_4.png'; $pistalink = '4'; }
		if($pista == '4') { $pistanexticon = 'pista_next_5.png'; $pistalink = '5'; }
		if($pista == '5') { $pistanexticon = 'pista_next_6.png'; $pistalink = '6'; }
		if($pista == '6') { $pistanexticon = 'pista_next_1.png'; $pistalink = '1'; }
	?>
		<a href="javascript: void(0);" onclick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=<?php echo $pistalink; ?>';"><img src="images/<?php echo $pistanexticon; ?>" alt="Ve a la siguiente pista para ver mas corredores" border="0"/></a>
	<?php ?>
	</div>
	<?php } ?>
	<div id="appanimation">
		<div id="cielo"></div>
		<div id="nubes"></div>
		<div id="montanias"></div>
		<div id="pista"></div>
		<div id="corredores">
		<?php
		$i = 0;
		$query = "SELECT cpu.*, (SELECT count(*) as total FROM cpass_votes WHERE oauth_uid = cpu.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A') as totalvotos FROM cpass_user cpu WHERE cpu.oauth_provider = 'facebook' and cpu.gano = 'N' AND cpu.estatus = 'A'  AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f' ORDER by cpu.fecha_jugando ASC ".$limit;
		
		$res2s = mysql_query($query);
		
		while($ra = mysql_fetch_assoc($res2s)){
			$i++;
			$ouid = $ra['oauth_uid'];
			$uid = $ra['id'];
			$votos = $ra['totalvotos'];
			
			$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$ouid;
			$response = $facebook->api(array(
				'method' => 'fql.query',
				'query' =>$fql,
			));
 
			$r = $response[0];
			if($votos == 1) { $titlevoto = "voto"; }else{ $titlevoto = "votos"; } 
			echo '
			<div id="corredor_'.$i.'">
				<div id="corredorhead">
					<a href="#" onclick="cp_openDialog(\''.$uid.'\',\''.$ouid.'\');" rel="tooltip" title="'.$r['name'].' / '.$votos.' '.$titlevoto.'">
						<img src="'.$r['pic_square'].'" border="0" height="32" width="32">
					</a>
				</div>
			</div>';
		}
		?>
		</div>
		<div id="appcorredordetalle" style="display: none;">
			<div id="appcorredordetalle_cerrar"><a href="javascript: void(0);" onclick="cp_closeDialog();">x cerrar</a></div>
			<div id="appcorredordetalle_logo"></div>
			<div id="appcorredordetalle_content"></div>
		</div>
	</div>
</div>
<div class="clearfix">&nbsp;</div>