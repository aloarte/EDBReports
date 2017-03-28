<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<!-- Se define el documento como una app de angular con ng-app para referenciarlo en el app.js-->
<html lang="es" ng-app="raidStuff" >
	<head>
		<title>Raid</title>
		<!-- Se incluye bootstrap para darle estilo, angular y app.js donde encontrará todas las referencias-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="app.css" media="screen" />
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
					echo "<div  class='list-group-item container-fluid' ng-show='store.jefes[$cntBoss].showBoss'>";

					echo "<div class='col-md-4'><h2 class='lead'><b>{{store.jefes[$cntBoss].name}}</b></h2>";

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
					echo "	<section 'class='tab' ng-controller='TabController as tab'>	
									<ul class='nav nav-pills list-inline'>
										<li ng-class='{ active: tab.isSet(0) }'>
											<a href ng-click='tab.setTab(0)'>Grupo 1</a>
										</li>
										<li ng-class='{ active: tab.isSet(1) }'>
											<a href ng-click='tab.setTab(1)'>Grupo 2</a>
										</li>
									</ul>
									";


					//Se obtiene cada grupo dentro de cada boss
					$groups = glob($dir . '/*' , GLOB_ONLYDIR);
					$cntGroup = 0;
					//Para cada grupo dentro de cada boss
					foreach($groups as $group) 
					{
						/*
						 * Muestra el div del grupo si este se seleccíonó previamente.
						 */
						echo "<div class='container-fluid testimonial-group' ng-show='tab.isSet($cntGroup)'>";
						echo "<div class='row text-left' >";


						$files = scandir($group);	
						$primero = true;
						$fechaTransformadaAnterior="";
						$cntReportes=0;

						//Recorre el directorio obteniendo los reportes y guardandolos en un array
						foreach ($files as &$refToFile) 
						{
							if(!in_array($refToFile, $bosses))
							{
								$array[$cntReportes] = $refToFile; //Meto el valor en el array
								$cntReportes++; //aumenta el contador       

							}
						}
						//recorro el array de forma decreciente desde atrás hacia el principio.
						for($i=($cntReportes-1);$i>=0; $i--){
								//Se parte la cadena por el '-'
								$refFirstSplit = explode('-',$array[$i]);								
								//Se saca la hora dividiendo el string sobrante de la anterior operación por '_' 
								$refSecondSplit = explode('_',$refFirstSplit[1]);
								//Se obtiene la fecha
								$fechaReporte = $refFirstSplit[0];
								$horaReporte = $refSecondSplit[0];

								$anio = substr($fechaReporte,0,4); 
								$mes = substr($fechaReporte,4,2); 
								$dia = substr($fechaReporte,6,2); 

								$hora = substr($horaReporte,0,2); 
								$minuto = substr($horaReporte,2,2); 
								$segundo = substr($horaReporte,4,2); 

								$fechaTransformada = "".$dia."/".$mes."/".$anio;
								$horaTransformada = "".$hora.":".$minuto.":".$segundo;

								if($primero){
									//guardo la fecha anterior
									$fechaTransformadaAnterior= $fechaTransformada;
									$primero = false;
									echo "<div class='col-xs-4'>";
									echo "<p> <b> Dia: $fechaTransformada</b></p>";
									echo "<p> Hora: $horaTransformada</p>";
									echo "<p><a class='btn btn-primary' href='./".$group."/".$array[$i]."'>Ver Reporte</a></p>\n";
								}
								else if(strcmp($fechaTransformada,$fechaTransformadaAnterior)===0){
									//echo "2: $fechaTransformada - $fechaTransformadaAnterior";
									echo "<p> Hora: $horaTransformada</p>";
									echo "<p><a class='btn btn-primary' href='./".$group."/".$array[$i]."'>Ver Reporte</a></p>\n";

								}
								else if(strcmp($fechaTransformada,$fechaTransformadaAnterior)!==0){
									//echo "3 $fechaTransformada - $fechaTransformadaAnterior";
									//Se actualiza la nueva fecha anterior
									$fechaTransformadaAnterior= $fechaTransformada;
									echo "</div>";
									echo "<div class='col-xs-4'>";
									echo "<p> <b> Dia: $fechaTransformada</b></p>";
									echo "<p> Hora: $horaTransformada</p>";
									echo "<p><a class='btn btn-primary' href='./".$group."/".$array[$i]."'>Ver Reporte</a></p>\n";
						
								}

								

								
							} //Fin del for de impresion normal
							
						



							//Tras juntar los reportes de un mismo día, si se realizó cierro esta cadena de divs. En caso contrario no	
							if(!empty($fechaTransformadaAnterior)){
								$fechaTransformadaAnterior="";
								echo "</div>"; //Cierra el ultimo div de los reportes de un mismo dia
							}
							echo "</div>"; //cierra el div de row


							echo "</div>"; //Cierra el div de cada grupo

							$cntGroup++;

					}//End foreach group

					echo "</section>"; //Cierra la seccion
					echo "</div>"; //cierra el div que recoge la seccion
					echo "</div>\n"; //cierra el div que recoge el boss
					$cntBoss ++;

				}
			 ?>
		</div>
	</body>

</html>