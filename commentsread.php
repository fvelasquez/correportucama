<?php
header('P3P: CP="CAO PSA OUR"');
require_once('includes/facebook.php');
require_once('includes/config.php');
require_once('includes/functions.php');

?>

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
		  FB.Canvas.setSize({ height: 1600 });
		</script>
<div style="overflow:auto; height:1500px">
		<fb:comments href="<?php echo FACEBOOK_CANVAS_URL; ?>" num_posts="3" width="600"></fb:comments>
</div>