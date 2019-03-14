<?php
	
//OBTENEMOS EL Votos de la encuesta
$votos=$_REQUEST['votos'];


//ABRIMOS FICHERO EN MODO ACTUALIZACION (a)Y AÑADIMOS EL VOTO 
$fichero=fopen('datosEncuesta.txt','a');

//DEBEMOS ADEMAS, INCLUIR EL NOMBRE DEL GRUPO \r\n  (retorno de carro y salto de linea )PARA QUE SALTE A LA SIGUIENTE LINEA
	if(fputs($fichero,"\r\n".$votos)){
		 	echo'<H1> SE HA AÑADIDO EL VOTO DE LA ENCUESTA AL FICHERO</H1>';
			echo '<h2>GRUPO SANGUINEO ENCUESTADO: '.$votos.'</h2>';
		}else{
			echo'NO SE HA AÑADIDO NINGUN VOTO';
	}
	
	//cerramos el fichero
	fclose($fichero);


	//INICIALIZAMOS EL ARRAY ASOCIATIVO QUE CONTENDRA EL RESULTADO DE LAS VOTACIONES DE LA ENCUESTA
	$todosvotos=array('desconocido'=>0,'grupo A+'=>0, 'grupo A-' =>0, 'grupo B+'=>0,'grupo B-' =>0, 'grupo AB+'=>0, 'grupo AB-'=>0, 'grupo O+'=>0, 'grupo O-'=>0, 'otros'=>0);
	
	//abrimos el fichero en ,modo lectura
	$fichero=fopen('datosEncuesta.txt','r');
	
	//recorremos el fichero introduciendo la informacion	
	while(!feof($fichero)){
		//leo la linea que contiene el grupo, le pongo trim para que me elimine los espacios delante y detras 
		$grupo=trim(fgets($fichero));
		//contabilizamosn los votos de la encuesta
		$todosvotos[$grupo]++;
		}
		
		//cerramos el fichero
		fclose($fichero);
		
	
?>
<html>
<meta charset="utf-8">
<head>
<style type="text/css">.ladoEncuesta{float:left;}</style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	//aqui se imprimira en la pagina 
	//una imagen dinamica, de la encuesta, en forma de disco , con los porcentajes de los votos
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
		  //esta sera nuestra leyenda del rosco
        var data = google.visualization.arrayToDataTable([
          ['Grupos', 'Num. Votos'],
    	  ['desconocido',  <?php echo $todosvotos['desconocido']; ?>],
		  ['grupo A+', <?php echo $todosvotos['grupo A+']; ?>],
          ['grupo A-', <?php echo $todosvotos['grupo A-']; ?>],
		  ['grupo B+', <?php echo $todosvotos['grupo B+']; ?>],
		  ['grupo B-', <?php echo $todosvotos['grupo B-']; ?>],
		  ['grupo AB+', <?php echo $todosvotos['grupo AB+']; ?>],
		  ['grupo AB-', <?php echo $todosvotos['grupo AB-']; ?>],
		  ['grupo O+',  <?php echo $todosvotos['grupo O+']; ?>],
		  ['grupo O-',  <?php echo $todosvotos['grupo O-']; ?>],
		  ['otros',     <?php echo $todosvotos['otros']; ?>]
		  ]);

        var options = {   
          title: 'ENCUESTA GRUPOS SANGUINEOS',
          is3D: true,
		 colors: ['#28b463','#a64dff','#ff8000','#0000e6','#ff0066','#7FFF00','#A52A2A','#00FFFF','#FFD700','#FF0000']
        };
		
		
        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
	  
	  
    </script>
	</head>
      <body>
	  
	  <div  class="ladoEncuesta" id="piechart_3d" style="width: 700px; height: 500px;"></div>
	  <div class="ladoEncuesta">
	  <?php 
	  echo '<p><b>NUMERO DE VOTOS TOTALES: </b></p>';
		echo'<table border=1><tr><th>GRUPOS</th><th>Num Total</th><tr>';
		foreach($todosvotos as $indice=>$valor){
			echo '<tr><td align="center">'.$indice.' </td><td align="center">  '.$valor.'</td></tr>';
						}
		echo '</table>';
		?>
		<div>
		
  </body>
</html>