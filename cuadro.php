<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<title>Side-by-Side Stacked Bar</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="Demos/styles.css" rel="stylesheet" />
		<script src="Demos/js/jquery-1.9.1.min.js"></script>
		<script src="Demos/js/knockout-2.2.1.js"></script>
		<script src="Demos/js/globalize.min.js"></script>
		<script src="Demos/js/dx.chartjs.js"></script>
                                      
	</head>
	<body>
		<script type="text/javascript">
			$(function ()  
				{
   var dataSource = [
    { state: "Mar", maleyoung: 3956, malemiddle: 1354, maleolder: 14472, femaleyoung: 5000 },
    { state: "Abr", maleyoung: 2607, malemiddle: 5793, maleolder: 3727, femaleyoung: 5000 },
    { state: "May", maleyoung: 3493, malemiddle: 8983, maleolder: 5802, femaleyoung: 5000 },
    { state: "Jun", maleyoung: 1575, malemiddle: 3363, maleolder: 9024, femaleyoung: 5000 },
    { state: "Jul", maleyoung: 3306, malemiddle: 1223, maleolder: 1927, femaleyoung: 5000 },
    { state: "Ago", maleyoung: 5679, malemiddle: 3638, maleolder: 5133, femaleyoung: 5000 },
    { state: "Sep", maleyoung: 2816, malemiddle: 1622, maleolder: 3864, femaleyoung: 5000 }
];

$("#chartContainer").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "state",
        type: "stackedBar"
    },
    series: [
        { valueField: "maleyoung", name: "SMS de Compras", stack: "male" },
        { valueField: "malemiddle", name: "SMS de Promo", stack: "male" },
       { valueField: "femaleyoung", name: "Credito Agregado", stack: "female" },
     
    ],
    legend: {
        horizontalAlignment: "right",
        position: "inside",
        border: { visible: true }
    },
    valueAxis: {
        title: {
            text: "Populations, millions"
        }
    },
	 label:{
                visible: true,
                connector:{
                    visible:true,           
                    width: 1
                }},
    title: "Mensajes Enviados  / Creditos Cargados",
    tooltip: {
        enabled: true
    }
});
}

			);
		</script>
		
	 
 
				<div id="chartContainer" style="width: 100%; height: 300px;"></div>
	 
		 
	</body>
</html>