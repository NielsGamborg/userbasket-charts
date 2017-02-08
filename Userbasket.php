<?php	
	/*Chart ressources:
	* 16 JavaScript Libraries for Creating Beautiful Charts: http://www.sitepoint.com/15-best-javascript-charting-libraries/
	* Google charts: https://developers.google.com/chart/interactive/docs/quick_start 
	*
	*
	*	Offentlige data: https://data.digitaliser.dk/alle 
	*   Spotdata: http://devel06:8381/spot/
	*   Userbasket API: http://dione:9220/userbasket/
	*/

// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept:application/json\r\n" 
  )
);

$context = stream_context_create($opts);
// Open the file using the HTTP headers set above		
$url = "http://dione:9220/userbasket/services/system/monitoring"; 
$result = @file_get_contents($url,false, $context);

$json = json_decode($result,true);
			
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Userbasket</title>
	
	<link type="text/css" href="charts.css" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">	
	
	var result = '<?=$result ?>';
	var myObj =  JSON.parse(result);	
	
	var myArray1 = [];
	var myArray1b = [];
	var myArray2 = [];
	var myArray3 = [];	
	var myArray4 = [];
	var myArray5 = [];
	var myArray6 = [];
	
	var itemsInBases = 0;
	
	
    // Load the Visualization API and the corechart + table package.
    google.charts.load('current', {'packages':['corechart','table']});
	
/* NUMBER OF MATERIALS IN BASKET BY SOURCE */
	
	/*sorting object by value */
	myObj.itemsInBases.sort(function(a,b) {
		return a.value - b.value;
	});
			
	jQuery.each(myObj.itemsInBases, function(i, val) {		
		var myTempArray1 = [val.key,parseInt(val.value)];
		myArray1.push(myTempArray1);
		itemsInBases = itemsInBases + parseInt(val.value);
	});
	//console.log("itemsInBases: "+itemsInBases);	
	
	jQuery.each(myObj.itemsInBases, function(i, val) {
		//console.log(myArray1b);
		if(parseInt(val.value)/itemsInBases * 100 > 1){
			var myTempArray1b = [val.key,parseInt(val.value)];
			myArray1b.push(myTempArray1b);
			//console.log(myTempArray1b);
		}/*else{
			var otherCount = otherCount + parseInt(val.value)
			//if(typeof  myArray1b["other"] === 'undefined') {
			if(!("other" in myArray1b)) {
			//if (!(myArray1b.hasOwnProperty("other"))){
				// does not exist
				console.log("does not exist");
				myTempArray1b = ["other",parseInt(val.value)];
				myArray1b.push(myTempArray1b)
				//console.log("myTempArray1b: " + myTempArray1b);
				//console.log("myArray1b: " + myArray1b);
				//console.log("typeof myArray1b: " + typeof myArray1b);
				//console.log("myArray1b['other']: " + myArray1b['other']);
			} else {
				// does exist
				console.log("EXISTS");
			}		
			
		}*/
		
		//myArray1b["other"].Value = otherCount; 
		//console.log("myArray1b[1]: " + myArray1b[1]);
		//console.log(myArray1b);
		//console.log("myArray1b.hasOwnProperty('other'): " + myArray1b.hasOwnProperty("other"));
	});
	
	myArray1.reverse(); 
	myArray1b.reverse(); 
	//console.log("myArray1b[0]: " + myArray1b[0][0]);
	//console.log("myArray1b: " + myArray1b);
	//console.log("typeof myArray1b: " + typeof myArray1b);
      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart1);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart1() {
		  
		var data = new google.visualization.DataTable();		
		data.addColumn('string', 'Datakilde');
		data.addColumn('number', 'Antal');
		
		data.addRows(myArray1); 
		
        // Set chart options
        var options = {'title':'Fordeling af materialer i kurven efter datakilde',
						"tooltip.isHtml": true,
						backgroundColor:'#fafafa',
						hAxis: {
						  title: 'Target'
						},
						 vAxis: {
						  title: 'Antal materialer',
						  scaleType: 'log'/*,
						  ticks: [0, 5, 50, 500, 5000]*/
						},
						legend: "none",/*,
						width:800,*/
						height:700};

        // Instantiate and draw our chart, passing in some options.
		var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart1.draw(data, options);
      }
	  

      //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable1);

      function drawTable1() {
 
        var data = new google.visualization.DataTable();
		data.addColumn('string', 'Datakilde');
		data.addColumn('number', 'Antal');
		
		data.addRows(myArray1);

        var table1 = new google.visualization.Table(document.getElementById('table_div1'));

        table1.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }

	/* Pie style */
	
      google.charts.setOnLoadCallback(drawChart1b);
      function drawChart1b() {
		
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Datakilde');
		data.addColumn('number', 'Antal');
		
		data.addRows(myArray1b);

        var options = {
          title: 'Fordeling af materialer i kurven efter datakilde med større andel end 1%',
		  backgroundColor:'#fafafa',
		  tooltip: "Fordeling af materialer",
		  height:700
        };

        var chart1b = new google.visualization.PieChart(document.getElementById('chart_div1b'));

        chart1b.draw(data, options);
      }

	
	
/* LIST STATS */
	
	myObj.listCountUserCount.sort(function(a,b) {
		return a.value - b.value;
	});
	
	jQuery.each(myObj.listCountUserCount, function(i, val) {		
			  var myTempArray2 = [parseInt(val.key), parseInt(val.value)];
			  myArray2.push(myTempArray2);
			});	
	
	
	//myArray.sort(function(a, b){return b-a});


      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart2);

      // Callback that creates and populates a data table,
      function drawChart2() {
		  
		var data = new google.visualization.DataTable();			
		data.addColumn('number', 'Antal');		
		data.addColumn('number', 'Lister');	
		
		data.addRows(myArray2); 
		
        // Set chart options
        var options = {'title':'Antal lister pr. bruger',
						"tooltip.isHtml": true,
						backgroundColor:'#fafafa',
						columns: {
							style: 'width: 200px;'
						},
						legend: "none",
						colors:["#cc0000"],
						hAxis: {
						  title: 'Antal lister',
						  titleTextStyle:{
							  color: "black",
							  bold: true,
							  italic: false
						  },
						  scaleType: 'log',
						},
						 vAxis: {
						  title: 'Brugere',
						  scaleType: 'mirrorLog',
						  minValue: 0
						  //ticks: [0, 5, 50, 500],
						  //scaleType: 'log'
						},
						chartArea:{
							backgroundColor: {
								fill:"#fafafa"
								},	
							left:'5%',
							top:'5%',
							width:'90%',
							height:'90%'
							},
						animation: {
							duration: 0,
							easing: "out",
							startup: true
						},
						height:700};

        // Instantiate and draw our chart, passing in some options.
		var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart2.draw(data, options);
      }
	  

      //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable2);
	   
	function drawTable2() {	  
        var data = new google.visualization.DataTable();		
		data.addColumn('number', 'Antal');		
		data.addColumn('number', 'Lister');			
		data.addRows(myArray2);
		var table2 = new google.visualization.Table(document.getElementById('table_div2'));

        table2.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
	  
	  
/* NAVNE PÅ SIDST OPRETTEDE LISTER */

	jQuery.each(myObj.lastCreatedLists, function(i, val) {
			var myDate1 = val.value.split(" CEST"); //removing timezone to get valid dateformat
			var myDate2 = val.value.substring(0, 10); 
			var myTempArray3 = [new Date(myDate2 + myDate1[1]), val.key];
			myArray3.push(myTempArray3);
	});
			
			
	  //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable3);

      function drawTable3() {
		  
        var data = new google.visualization.DataTable();
		data.addColumn('date', 'Dato');
		data.addColumn('string', 'Navn');
		
		data.addRows(myArray3);

        var table3 = new google.visualization.Table(document.getElementById('table_div3'));

        table3.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }


	  
/* MEST POPULÆRE TITLER */
		/*
		myObj.mostPopularItems.sort(function(a,b) {
			return b.value - a.value;
		});
		*/

		jQuery.each(myObj.mostPopularItems, function(i, val) {
			$.ajax({
			 method: "POST",
			 url: "titleHelper.php",
			 data: { id: val.key }
			})
			 .done(function( msg ) {
				var title = msg;
				var myTempArray4 = [title, parseInt(val.value)];
				myArray4.push(myTempArray4);
			  });			
		});
	
	

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart4);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart4() {		
		var data = new google.visualization.DataTable();		
		data.addColumn('string', 'Titel');			
		data.addColumn('number', 'Antal');
		
		myArray4.sort(function(a, b){return b[1] - a[1] }); /* sorting in reverse order */
		data.addRows((myArray4)); 
		
        // Set chart options
        var options = {'title':'Mest populære titler',
						"tooltip.isHtml": true,
						backgroundColor:'#fafafa',
						columns: {
							style: 'width: 200px;'
						},
						colors:["#009900"],						
						legend: "none",
						hAxis: {
						  title: 'Antal',
						  },
						scaleType: 'log',
						vAxis: {
						  title: 'materialer'
						},
						height:1200};

        // Instantiate and draw our chart, passing in some options.
		var chart4 = new google.visualization.ColumnChart(document.getElementById('chart_div4'));
        chart4.draw(data, options);
      }


	
	  //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable4);

      function drawTable4() {
		  
        var data = new google.visualization.DataTable();
		data.addColumn('string', 'Titel');
		data.addColumn('number', 'Antal');
		
		data.addRows(myArray4);

        var table = new google.visualization.Table(document.getElementById('table_div4'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
	  
	  
	  
/* LAST ADDED ITEMS */


		jQuery.each(myObj.lastAddedItems , function(i, val) {
			$.ajax({
			 method: "POST",
			 url: "titleHelper.php",
			 data: { id: encodeURIComponent(val.key) }
			})
			 .done(function( msg ) {
				var title = msg;
				var myDate1 = val.value.split(" CEST"); //removing timezone to get valid dateformat
				var myTempArray5 = [title, new Date(myDate1[0] + myDate1[1])];
				myArray5.push(myTempArray5);
			  });			
		});
	
	//google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable5);

      function drawTable5() {
		  
        var data = new google.visualization.DataTable();
		data.addColumn('string', 'Titel');
		data.addColumn('datetime', 'Dato');
		
		data.addRows(myArray5);

        var table = new google.visualization.Table(document.getElementById('table_div5'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
	  
/* OPRETTEDE LISTER OVER TID */

	jQuery.each(myObj.itemsAddedByWeeksAgo, function(i, val) {		
			  var myTempArray6 = [parseInt(val.key * -1), parseInt(val.value)];
			  myArray6.push(myTempArray6);
			});	


      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart6);

      // Callback that creates and populates a data table,
      function drawChart6() {
		  
		var data = new google.visualization.DataTable();			
		data.addColumn('number', 'Antal');		
		data.addColumn('number', 'Nye lister pr. uge');	
		
		data.addRows(myArray6); 
		
        // Set chart options
        var options = {'title':'Nye huskelister tilføjet pr. uge det sidste år',
						"tooltip.isHtml": true,
						backgroundColor:'#fafafa',
						colors:["#ff9900"],
						legend: "none",
						hAxis: {
							ticks: [0,-10,-20,-30,-40,-50],
							title: 'Uger siden'
						},
						 vAxis: {
							title: 'Antal lister pr. uge'
						},
						height:700};

        // Instantiate and draw our chart, passing in some options.
		var chart6 = new google.visualization.ColumnChart(document.getElementById('chart_div6'));
        chart6.draw(data, options);
      }
	  
	  //google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart6b);

      function drawChart6b() {
        
		var data = new google.visualization.DataTable();			
		data.addColumn('number', 'Antal');		
		data.addColumn('number', 'Nye lister pr. uge');

		data.addRows(myArray6); 		

        var options = {'title':'Nye huskelister tilføjet pr. uge det sidste år',
						"tooltip.isHtml": true,
						backgroundColor:'#fafafa',
						curveType: 'function', /*smooth the lines in chart*/
						colors:["#ff9900"],
						pointSize: 8,
						legend: {position: 'none'},
						hAxis: {
							ticks: [0,-10,-20,-30,-40,-50],
							title: 'Uger siden'
						},
						 vAxis: {
							title: 'Antal lister pr. uge'
						},
						height:700};

        var chart = new google.visualization.LineChart(document.getElementById('chart_div6b'));

        chart.draw(data, options);
      }

	  

      //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable6);
	  
	  function drawTable6() {
		  
        var data = new google.visualization.DataTable();			
		data.addColumn('number', 'Antal');		
		data.addColumn('number', 'Nye lister pr. uge');	
		
		data.addRows(myArray6);

        var table = new google.visualization.Table(document.getElementById('table_div6'));

        table.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }

	  
	  
	  
</script>

	
</head>
<body>
	<div id="wrapper">
		<h1>Userbasket</h1>
		<div id="dokumentation">
			<p>
			Lavet med <a class="dokuLink" href="https://developers.google.com/chart/">Google Charts</a>
			</p>
			<p>
			Data fra Thomas's userbasket webservice: <a class="dokuLink" href="http://dione:9220/userbasket/">http://dione:9220/userbasket/</a>
			</p>		
			<p>
			Materialetitler hentet med shortRecord service: <a class="dokuLink" href="http://devel06:9220/searchservice-ws/items/sb_123/shortRecord">http://devel06:9220/searchservice-ws/items/sb_123/shortRecord</a>
			</p>
		</div>
				
		
		<h2>Datakilder</h2>		
		<div onclick="$('#chart_div1').toggle();return false"><a href="">Column chart</a></div>	
		<div id="chart_div1" class="chartContainer chart" style="display: block;"></div>
		
		<div onclick="$('#chart_div1b').toggle();return false"><a href="">Pie chart</a></div>	
		<div id="chart_div1b" class="chartContainer chart" style="display: block;"></div>
		
		<div onclick="$('#table_div1').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div1" class="chartContainer" style="display: none;"></div>
		
		
		<h2>Nyoprettede lister over tid</h2>		
		<div onclick="$('#chart_div6').toggle();return false"><a href="">Chart1</a></div>	
		<div id="chart_div6" class="chartContainer chart" style="display: block;"></div>
		
		<div onclick="$('#chart_div6b').toggle();return false"><a href="">Chart2</a></div>	
		<div id="chart_div6b" class="chartContainer chart" style="display: block;"></div>
		
		<div onclick="$('#table_div6').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div6" class="chartContainer" style="display: none;"></div>
		
		
		<h2>Mest populære titler på huskelister</h2>		
		<div onclick="$('#chart_div4').toggle();return false"><a href="">Chart</a></div>	
		<div id="chart_div4" class="chartContainer chart" style="display: block;"></div>
		
		<div onclick="$('#table_div4').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div4" class="chartContainer" style="display: block;"></div>
		
		
		<h2>Senest tilføjede titler</h2>		
		<div onclick="$('#table_div5').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div5" class="chartContainer" style="display: block;"></div>
		
						
		<h2>Navne på nyeste huskeliste</h2>
		<div onclick="$('#table_div3').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div3" class="chartContainer" style="display: block;"></div>
		
			
		<h2>Huskelister pr bruger</h2>
		<div onclick="$('#chart_div2').toggle();return false"><a href="">Chart</a></div>	
		<div id="chart_div2" class="chartContainer chart" style="display: block;"></div>
						
		<div onclick="$('#table_div2').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div2" class="chartContainer" style="display: none;"></div>
		
		
		
		<div onclick="$('#rawVarDump').toggle();return false"><a href="">Full var_dump</a></div>	
		<div id="rawVarDump"  style="display: none;">
		<?php
			echo "<div>var_dump: </div>";
			
			if($result !=''){
				var_dump(json_decode($result, true));
			}
			
		?>	
			
	
	</div>
</body>
</html>	