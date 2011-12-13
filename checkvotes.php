<?php
	include('includes/facebook.php');
	include('includes/config.php');
	include('includes/functions.php');
	
	$facebook = new Facebook(array(
	  'appId'  => FACEBOOK_APP_ID,
	  'secret' => FACEBOOK_SECRET_KEY,
	  'cookie' => true, // enable optional cookie support
	  'domain' => 'branding-machine.com'
	));

	$session = $facebook->getSession();
	
	$date = date('Y-m-d H:i:s',strtotime ("+1 hour"));
	
	//$fecha_i = '2011-7-18 9:00:00';
	//$fecha_f = '2011-7-22 15:00:00';
	$fecha_i = '2011-08-08 09:00:00';
	$fecha_f = '2011-08-12 15:00:00';
//	$fecha_i = date('Y-m-d 09:00:00');
//	$fecha_f = date('Y-m-d 21:00:00');

	//1186941968 MARCELA
	//560175921 Kenny

	$con = mysql_connect(BD_HOST, BD_USER, BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$query = "SELECT * FROM cpass_votes WHERE oauth_uid = '".$_GET['ouid']."' AND fecha_vote BETWEEN '$fecha_i' AND '$fecha_f' AND estatus = 'A' order by vote_uid";

	$res = mysql_query($query);
	?>
<div style="width:740px; overflow:auto; height:600px; font-family:arial: font-size:10px;">
<table>
	<?php
	while($r = mysql_fetch_assoc($res))
	{
	$voteuid = $r['vote_uid'];
		if($voteuid != ''){
			if ($session) {	
				$fql = 'SELECT uid, name, pic_square, pic FROM user WHERE uid = '.$voteuid;
					$response = $facebook->api(array(
						'method' => 'fql.query',
						'query' =>$fql,
					));
 
				$ra = $response[0];
		
		//if($ra['uid'] == ''){
			//mysql_query("UPDATE `cpass_votes` SET ESTATUS = 'B' WHERE vote_uid in ('".$r['vote_uid']."') AND oauth_uid = '".$_GET['ouid']."'");
		//}else{
			echo '<tr><td><img src="'.$ra['pic_square'].'" border="0" width="40" />'.$ra['uid'].'</td><td><a href="http://www.facebook.com/profile.php?id='.$ra['uid'].'"/>'.$ra['name'].'</a></td><td>'.$r['estatus'].' [ '.$r['vote_uid'].' ]</td></tr>';
			//echo '<tr><td><a href="http://www.facebook.com/profile.php?id='.$ra['uid'].'"/>'.$ra['name'].'</a></td><td>'.$r['estatus'].' [ '.$r['vote_uid'].' ]</td></tr>';
		//}
			}
		}
	}
?>
</table>
</div>