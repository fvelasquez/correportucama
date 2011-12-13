<?php
include ('includes/config.php');
include ('includes/functions.php');

$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
mysql_select_db(BD_NAME);

//$fecha_i = date('Y-m-d 09:00:00');
//$fecha_f = date('Y-m-d 21:00:00');

//$fecha_i = date('Y-m-d 09:00:00',strtotime('-1 day'));
//$fecha_f = date('Y-m-d 21:00:00',strtotime('-1 day'));
$fecha_i = '2011-08-08 09:00:00';
$fecha_f = '2011-08-12 15:00:00';
//$date = date('Y-m-d H:i:s');
//$date = date('Y-m-d H:i:s',strtotime('-1 day'));
$date = '2011-08-12 15:00:00';
if(isset($_POST['p']) && $_POST['p'] == 'cerrar'){

	//
	$res = mysql_query("SELECT *, (SELECT COUNT(*) FROM cpass_votes WHERE oauth_uid = cpass_user.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A') as vpart FROM cpass_user WHERE estatus = 'A' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f' ORDER BY vpart DESC LIMIT 0,1");
	//$res = mysql_query("SELECT *, (SELECT COUNT(*) FROM cpass_votes WHERE oauth_uid = cpass_user.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A') as vpart FROM cpass_user WHERE estatus = 'A' AND oauth_uid = '100000985075017' ORDER BY vpart DESC LIMIT 0,1");

	//$res = mysql_query("SELECT cp.*, (SELECT count(*) from cpass_votes WHERE estatus = 'A' AND fecha_vote BETWEEN '2011-05-18 09:00:00' AND '2011-05-18 21:00:00' AND oauth_uid = cp.oauth_uid) vpart FROM `cpass_user` cp  ORDER BY vpart DESC LIMIT 0,1");
	$i = 0;
	while($aff = mysql_fetch_assoc($res))
	{
		if($i == 0)
		{
			//mysql_query("UPDATE cpass_user SET gano = 'S' WHERE oauth_uid = ".$aff['oauth_uid']);
			//mysql_query("INSERT INTO cpass_winners (uid, oauth_uid, fecha_gano, pista, votos) VALUES ('".$aff['id']."','".$aff['oauth_uid']."','".$date."','".$aff['pista']."','".$aff['vpart']."')");
			echo "<h3>Proceso Terminado, el usuario ".$aff['oauth_uid']." ha ganado</h3>";
		}
		$i++;
	}

}

if(isset($_POST['p']) && $_POST['p'] == 'procesarcola'){

	$res = mysql_query("SELECT *, (SELECT COUNT(*) FROM cpass_votes WHERE oauth_uid = cpass_user.oauth_uid AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f') as vpart FROM cpass_user WHERE ESTATUS = 'A' AND fecha_jugando BETWEEN '$fecha_i' AND '$fecha_f' ORDER BY vpart DESC LIMIT 0,3");
		
	$i = 0;
	while($aff = mysql_fetch_assoc($res))
	{
		if($i == 0)
		{
			mysql_query("UPDATE cpass_user SET gano = 'S' WHERE oauth_uid = ".$aff['oauth_uid']);
			mysql_query("INSERT INTO cpass_winners (uid, oauth_uid, fecha_gano) VALUES ('".$aff['id']."','".$aff['oauth_uid']."','".$date."')");
			echo "<h3>Proceso Terminado, el usuario ".$aff['oauth_uid']." ha ganado</h3>";
		}
		$i++;
	}

}

?>
<form action="proceso.php" method="post">
<input type="submit" name="enviar" value="Proceso de Cierre" />
<input type="hidden" name="p" value="cerrar"/>
</form>

<form action="proceso.php" method="post">
<input type="submit" name="enviar" value="Proceso de Cola" />
<input type="hidden" name="p" value="procesarcola"/>
</form>
