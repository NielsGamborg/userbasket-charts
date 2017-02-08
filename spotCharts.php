<?php
	/*Chart ressources:
	* 16 JavaScript Libraries for Creating Beautiful Charts: http://www.sitepoint.com/15-best-javascript-charting-libraries/
	* Google charts: https://developers.google.com/chart/interactive/docs/quick_start 
	*
	*
	*	Offentlige data: https://data.digitaliser.dk/alle 
	*   Spotdata: http://devel06:8381/spot/
	   
		Userbasket object:
		private String initDate=null;
		private String lastDatabaseBackupDate = null;
		private long extractTimeInMillis=0;
		private int totalNumberOfBasketItems=0;
		private int totalNumberOfUsersWithItemsInBasket=0;    
		private int numberOfGetAllItemsForUserSinceStartup = 0; 
		private int numberOfDeleteItemForUserSinceStartup = 0;
		private int numberOfDatabaseBackupsSinceStartup = 0;
		
		private ArrayList<DataPair> usersWithMostItems = new ArrayList<DataPair>();
		private ArrayList<DataPair> itemsInBases = new ArrayList<DataPair>();
		private ArrayList<DataPair> mostPopularItems = new ArrayList<DataPair>();
		private ArrayList<DataPair> mostPopularLists = new ArrayList<DataPair>();
		private ArrayList<DataPair> lastAddedItems = new ArrayList<DataPair>();
		private ArrayList<DataPair> lastCreatedLists = new ArrayList<DataPair>();
		private ArrayList<DataPair> itemsAddedByWeeksAgo = new ArrayList<DataPair>();
		private ArrayList<DataPair> itemCountUserCount = new ArrayList<DataPair>();
		private ArrayList<DataPair> listCountUserCount = new ArrayList<DataPair>();

	*/
		
	$url1 = "http://devel06:8381/spot/services/medarbejder/workhours/nig"; 
	$initials = "nig";

	if (isset($_GET["initials"])) {
		$initials = ($_GET["initials"]);
	}

	$url1 = "http://devel06:8381/spot/services/medarbejder/workhours/" . $initials;
	$result1 = @file_get_contents($url1);
	
	$url2 = "http://devel06:8381/spot/services/afdeling/";
	$result2 = @file_get_contents($url2);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>spotCharts</title>
	
	<link type="text/css" href="charts.css" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
	
	var result1 = '<?=$result1 ?>';
	var myObj1 =  JSON.parse(result1);			
	var myArray1 = [];
	
	var result2 = '<?=$result2 ?>';
	var myObj2 =  JSON.parse(result2);			
	var myArray2 = [];
	var myArray2table = [];
			
	jQuery.each(myObj1, function(i, val) {
			  var myTempArray = [new Date(val.date),val.hours]
			  myArray1.push(myTempArray)
			});
	
	myArray1.reverse(); 

      // Load the Visualization API and the corechart + table package.
      google.charts.load('current', {'packages':['corechart','table']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart1);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart1() {
		  
		var data = new google.visualization.DataTable();		
		data.addColumn('datetime', 'Dato');
		data.addColumn('number', 'Timer');
		
		data.addRows(myArray1); 
		
        // Set chart options
        var options = {'title':'Arbejdstimer',
						'backgroundColor':'#fafafa',
						'legend':'left',/*,
						'width':800,*/
						'height':500};

        // Instantiate and draw our chart, passing in some options.
		var chart1 = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart1.draw(data, options);
      }
	  
      //google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable1);

      function drawTable1() {		  
        var data = new google.visualization.DataTable();
		data.addColumn('datetime', 'Dato');
		data.addColumn('number', 'Timer');
		
		data.addRows(myArray1);

        var table1 = new google.visualization.Table(document.getElementById('table_div1'));
        table1.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }


/* AFDELINGER */

		jQuery.each(myObj2, function(i, val) {
			$.ajax({
				 method: "POST",
				 url: "departmentHelper.php",
				 data: { department: encodeURIComponent(val) }
				})
			.done(function( msg ) {
				var employeeCount = msg;
				var emplCountArray = employeeCount.split(",");
				var myTempArrayChart = [val,parseInt(emplCountArray[0]),parseInt(emplCountArray[1]),parseInt(emplCountArray[2]) + parseInt(emplCountArray[3]) + parseInt(emplCountArray[4]) + parseInt(emplCountArray[5])];
				var myTempArrayTable = [val,parseInt(emplCountArray[0]),parseInt(emplCountArray[1]),parseInt(emplCountArray[2]),parseInt(emplCountArray[3]),parseInt(emplCountArray[4]),parseInt(emplCountArray[5])];
				myArray2.push(myTempArrayChart);
				myArray2table.push(myTempArrayTable);
			  });
			  //var myTempArray = [new Date(val.date),val.hours]
			  //myArray2.push(myTempArray)
			});	

	
	
	google.charts.setOnLoadCallback(drawChart2);

	function drawChart2() {
		  
		var data = new google.visualization.DataTable();		
		data.addColumn('string', 'Afdeling');
		data.addColumn('number', 'Ansatte i alt');
		data.addColumn('number', 'Inde');
		data.addColumn('number', 'Hjemmearbejde,Tjenstligt fravær, Ferie, Sygdom');

		myArray2.sort(function(a, b){return b[1] - a[1] }); /* sorting in reverse order */
		data.addRows(myArray2); 
		
        // Set chart options
        var options = {title:'Ansatte i afdelinger',
						backgroundColor:'#fafafa',
						colors:["#00cc00","#009900","#006600"],	
						ticks:[20,40,60,80],
						//isStacked: true,
						height:700};

        // Instantiate and draw our chart, passing in some options.
		var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart2.draw(data, options);
      }
	  
	  google.charts.setOnLoadCallback(drawTable2);
	  
	  function drawTable2() {		  
        var data = new google.visualization.DataTable();
		data.addColumn('string', 'Afdeling');
		data.addColumn('number', 'Ansatte');
		data.addColumn('number', 'Inde');
		data.addColumn('number', 'Hjemmearb.');
		data.addColumn('number', 'Tjenst. frav.');		
		data.addColumn('number', 'Ferie');
		data.addColumn('number', 'Sygdom');
		
		myArray2table.sort(function(a, b){return b[1] - a[1] }); /* sorting in reverse order */
		data.addRows(myArray2table);

        var table2 = new google.visualization.Table(document.getElementById('table_div2'));
        table2.draw(data, {showRowNumber: false, width: '100%', height: '100%'});
      }
	  			
	  
    </script>

	
</head>
<body>
	<div id="wrapper">
		<h1>Spot</h1>
		
		<div id="dokumentation">
			<p>
			Lavet med <a class="dokuLink" href="https://developers.google.com/chart/">Google Charts</a>
			</p>
			<p>
			Data fra Thomas's spot webservice: <a class="dokuLink" href="http://devel06:8381/spot/">http://devel06:8381/spot/</a>
			</p>		
		</div>
		
		<h2>Arbejdstimer de sidste 4 uger</h2>
		
		<form method="get" action="<?=$_SERVER['PHP_SELF'];?>" name="choosePerson">
			Medarbejderinitialer: <input name="initials" value="<?=$initials;?>" onblur="document.choosePerson.submit()" />
		</form>
			
		
		<div onclick="$('#chart_div1').toggle();return false"><a href="">Chart</a></div>	
		<div id="chart_div1" class="chartContainer" style="display: block;"></div>
				
		<div onclick="$('#table_div1').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div1" class="chartContainer" style="display: none;"></div>
		
		
		<div onclick="$('#rawVarDump').toggle();return false"><a href="">Full var_dump</a></div>	
		<div id="rawVarDump"  style="display: none;">
		<?php
			echo "<div>var_dump: </div>";
			
			if($result1 !=''){
				var_dump(json_decode($result1, true));
			}			
		?>
		</div>
		
		<h2>Ansatte i afdelinger</h2>

		<div onclick="$('#chart_div2').toggle();return false"><a href="">Chart</a></div>	
		<div id="chart_div2" class="chartContainer" style="display: block;"></div>
				
		<div onclick="$('#table_div2').toggle();return false"><a href="">Table</a></div>	
		<div id="table_div2" class="chartContainer" style="display: block;"></div>
		
		
		<div onclick="$('#rawVarDump2').toggle();return false"><a href="">Full var_dump</a></div>	
		<div id="rawVarDump2"  style="display: none;">
		<?php
			echo "<div>var_dump: </div>";
			
			if($result2 !=''){
				var_dump(json_decode($result2, true));
			}			
		?>			
		</div>
		

		
	</div>	
</body>
</html>	