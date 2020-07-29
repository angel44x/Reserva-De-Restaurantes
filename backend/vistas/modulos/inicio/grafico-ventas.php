<?php

error_reporting(0);
$ventas = ControladorVentas::ctrMostrarVentas();
$totalVentas = ControladorVentas::ctrMostrarTotalVentas();

$arrayFechas = array();
$arrayFechaPago = array();
$totalPaypal = 0;

foreach ($ventas as $key => $value) {

	/*=============================================
  	PORCENTAJES MÉTODOS DE PAGO PAYPAL
  	=============================================*/
  	if($value["metodo"] == "paypal"){

  		 $totalPaypal += $value["pago"];

  		 $porcentajePaypal = $totalPaypal * 100 / $totalVentas["total"];
  	}

  	/*=============================================
  	PORCENTAJES MÉTODOS DE PAGO PAYU
  	=============================================*/
  	if($value["metodo"] == "payu"){

  		 $totalPayu += $value["pago"];

  		 $porcentajePayu = $totalPayu * 100 / $totalVentas["total"];
  	}

	/*=============================================
  	GRÁFICA EN LÍNEA
  	=============================================*/
	
	if($value["metodo"] != "gratis"){

		#Capturamos sólo el año y el mes
		$fecha = substr($value["fecha"],0,7);

		#Capturamos las fechas en un array
		array_push($arrayFechas, $fecha);

		#Capturamos las fechas y los pagos en un mismo array
		$arrayFechaPago = array($fecha => $value["pago"]);

		#Sumamos los pagos que ocurrieron el mismo mes
		foreach ($arrayFechaPago as $key => $value) {
			
			$sumaPagosMes[$key] += $value;
		}

	}



}

#Evitamos repetir fecha
$noRepetirFechas = array_unique($arrayFechas);

?>


<!--=====================================
GRÁFICO DE VENTAS
======================================-->
<!-- solid sales graph -->

<!-- solid sales graph -->

<script>
	
var line = new Morris.Line({
    element          : 'line-chart',
    resize           : true,
    data             : [

    <?php

    	foreach ($noRepetirFechas as $value) {
    	
    	echo "{ y: '".$value."', ventas: ".$sumaPagosMes[$value]." },";
    		
    	}

      echo "{ y: '".$value."', ventas: ".$sumaPagosMes[$value]." }";

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['Ventas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits		 : '$',
    gridTextSize     : 10
  });
	
</script>