				<div id="appmenu2">
					<a href="javascript: void(0);" onclick="top.location = 'http://www.facebook.com/pages/Camas-Sublime/172113839511790?sk=wall';">Muro</a>
				</div>
				<div id="appmenu">
					<?php 
						$pista1 = 'pistas_02.png';
						$pista2 = 'pistas_03.png';
						$pista3 = 'pistas_04.png';
						$pista4 = 'pistas_05.png';
						$pista5 = 'pistas_06.png';
						$pista6 = 'pistas_07.png';
						
						$pista7 = 'pistas_08.png';
						$pista8 = 'pistas_09.png';
						$pista9 = 'pistas_10.png';
						$pista10 = 'pistas_11.png';
						$pista11 = 'pistas_12.png';
						$pista12 = 'pistas_13.png';
						
						
						$posiciones = 'gp_02.png';
						$ganadores = 'gp_03.png';
						$instrucciones = 'instrucciones.png';
						
						$pista = $_GET['pista'];
						
						if(isset($_GET['pista'])){				
							if($pista == '1'){ $pista1 = 'pistas_2_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
							if($pista == '2'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_2_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
							if($pista == '3'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_2_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
							if($pista == '4'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_2_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
							if($pista == '5'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_2_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
							if($pista == '6'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_2_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }

							if($pista == '7'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_2_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
              if($pista == '8'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_2_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
              if($pista == '9'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_2_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
              if($pista == '10'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_2_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_13.png'; }
              if($pista == '11'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_2_12.png'; $pista12 = 'pistas_13.png'; }
              if($pista == '12'){ $pista1 = 'pistas_02.png'; $pista2 = 'pistas_03.png'; $pista3 = 'pistas_04.png'; $pista4 = 'pistas_05.png'; $pista5 = 'pistas_06.png'; $pista6 = 'pistas_07.png'; $pista7 = 'pistas_08.png'; $pista8 = 'pistas_09.png'; $pista9 = 'pistas_10.png'; $pista10 = 'pistas_11.png'; $pista11 = 'pistas_12.png'; $pista12 = 'pistas_2_13.png'; }
							
						}else{
							if($_GET['p'] == 'participa' || $_GET['p'] == ''){ $pista1 = 'pistas_2_02.png'; }
							if($_GET['p'] == 'posiciones'){ $posiciones = 'gp_2_02.png'; }
							if($_GET['p'] == 'ganadores'){ $ganadores = 'gp_2_03.png'; }
							if($_GET['p'] == 'instrucciones'){ $instrucciones = 'instrucciones_2.png'; }
						}
					?>
					<table width="480" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=instrucciones';"><img src="images/<?php echo $instrucciones; ?>" alt="Instrucciones" border="0"/></a></td>
                        <td><img src="images/gp_01.png" alt="Posiciones y Ganadores" border="0"/>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=posiciones';"><img src="images/<?php echo $posiciones; ?>" alt="Posiciones" border="0"/></a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=ganadores';"><img src="images/<?php echo $ganadores; ?>" alt="Ganadores" border="0"/></a></td>
                        <td><img src="images/pistas_01.png" alt="pista_a" border="0" style="margin-bottom:2px"/></td>
                        <td>
            <div id="maintop">
            <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=1';">
					    <img src="images/<?php echo $pista1; ?>" alt="Ve los competidores de la pista 1" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=2';">
					    <img src="images/<?php echo $pista2; ?>" alt="Ve los competidores de la pista 2" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=3';">
					    <img src="images/<?php echo $pista3; ?>" alt="Ve los competidores de la pista 3" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=4';">
					    <img src="images/<?php echo $pista4; ?>" alt="Ve los competidores de la pista 4" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=5';">
					    <img src="images/<?php echo $pista5; ?>" alt="Ve los competidores de la pista 5" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=6';">
					    <img src="images/<?php echo $pista6; ?>" alt="Ve los competidores de la pista 6" border="0"/>
				      </a>
				    </div>
            <div id="mainbot">          
            <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=7';">
					    <img src="images/<?php echo $pista7; ?>" alt="Ve los competidores de la pista 7" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=8';">
					    <img src="images/<?php echo $pista8; ?>" alt="Ve los competidores de la pista 8" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=9';">
					    <img src="images/<?php echo $pista9; ?>" alt="Ve los competidores de la pista 9" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=10';">
					    <img src="images/<?php echo $pista10; ?>" alt="Ve los competidores de la pista 10" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=11';">
					    <img src="images/<?php echo $pista11; ?>" alt="Ve los competidores de la pista 11" border="0"/>
				      </a>
					  <a href="javascript: void(0);" onClick="top.location = '<?php echo FACEBOOK_CANVAS_URL; ?>?p=participa&pista=12';">
					    <img src="images/<?php echo $pista12; ?>" alt="Ve los competidores de la pista 12" border="0"/>
				      </a>
				    </div>
                        </td>
                      </tr>
</table>
				</div>