<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- Se define el documento como una app de angular con ng-app para referenciarlo en el app.js-->
<html lang="es" ng-app="raidStuff">
	<head>
		<title>Raid</title>
		<!-- Se incluye bootstrap para darle estilo, angular y app.js donde encontrará todas las referencias-->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
		<script type="text/javascript" src="angular.min.js"></script>
		<script type="text/javascript" src="app.js"></script>
	</head>

	<!-- Se define el body referenciandolo a un controller definido en el app.js-->
	<body ng-controller= "RaidController as store">
		<div class='img-wrap' >
			<img class= 'img-responsive center-block' ng-src='images/GW2Logo.png'/>
		</div>
		<div id="inicio" class="list-group">
			<?php
				//Se obtiene cada carpeta de cada boss de cada ala
				$bosses = array('.', '..');
				$cntBoss = 0;

			
				//Para cada boss
				foreach(glob('./*', GLOB_ONLYDIR) as $dir) 
				{
					echo "<div class='list-group-item container-fluid' ng-show='store.jefes[$cntBoss].showBoss'>";

					echo "<div class='col-md-4'><h3>{{store.jefes[$cntBoss].name}}</h3>";

					echo "<div>
							<div class='img-wrap'>
								<img ng-src='{{store.jefes[$cntBoss].image}}'/>
							</div>
						</div>";

					echo "</div>";				


					
					//Div contenedor que se ajusta con la imagen y nombre del boss
					echo "<div class='col-md-8'>";
					/*
					 * Sección con tabs para elegir entre el grupo 1 y el 2. Se define el controlador al TabController.
					 * Cada boton selector tiene un ng-click que cambia el tab y asigna el nuevo valor al controlador.
					 * Más abajo se mostrará un div u otro en función del valor del tab.
					 */
					echo "	<section class='tab' ng-controller='TabController as tab'>	
									<ul class='nav nav-pills list-inline'>
										<li ng-class='{ active: tab.isSet(0) }'>
											<a href ng-click='tab.setTab(0)'>Grupo 1</a>
										</li>
										<li ng-class='{ active: tab.isSet(1) }'>
											<a href ng-click='tab.setTab(1)'>Grupo 2</a>
										</li>
									</ul>
									<div class='row'>";


					//Se obtiene cada grupo dentro de cada boss
					$groups = glob($dir . '/*' , GLOB_ONLYDIR);
					$cntGroup = 0;
					//Para cada grupo dentro de cada boss
					foreach($groups as $group) 
					{
						/*
						 * Muestra el div del grupo si este se seleccíonó previamente.
						 */
						echo "<div ng-show='tab.isSet($cntGroup)'>
								<h5>".str_replace($dir."/", '', $group)."</h5>\n";



						$files = scandir($group);						
						foreach ($files as &$value) 
							{
								if(!in_array($value, $bosses))
								{
								echo "<p><a href='./".$group."/".$value."'>".$value."</a></p>\n";
								}
							}
						echo "</div>\n";
						$cntGroup++;
					}

					echo "</div>";
					echo "</section>";
					echo "</div>";
					echo "</div>\n";
					$cntBoss ++;

				}
			 ?>
		</div>
	</body>
</html>