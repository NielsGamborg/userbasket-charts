<?php
//header('Accept:application/json;Content-Type:application/json;Authorization:Basic(bmlnQHN0YXRzYmlibGlvdGVrZXQuZGs6a2FyaW5hUzEwMA==)');
	
	/*Chart ressources:
	* 16 JavaScript Libraries for Creating Beautiful Charts: http://www.sitepoint.com/15-best-javascript-charting-libraries/
	* Google charts: https://developers.google.com/chart/interactive/docs/quick_start 
	*
	*
	*	Offentlige data: https://data.digitaliser.dk/alle 
	*   Spotdata: http://devel06:8381/spot/
	*   Userbasket API: http://dione:9220/userbasket/
	   
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


// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept:application/json\r\n" .
	"Content-Type:application/json\r\n" .
	"Authorization:Basic (bmlnQHN0YXRzYmlibGlvdGVrZXQuZGs6a2FyaW5hUzEwMA==)\r\n"
  )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above


		
$url = "https://statsbiblioteket.harvestapp.com/daily/?slim=1"; 


//pass: bmlnQHN0YXRzYmlibGlvdGVrZXQuZGs6a2FyaW5hUzEwMA==



$result = @file_get_contents($url,false, $context);



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HarvestCharts</title>
	
	<link type="text/css" href="spotCharts.css" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
		
		$( document ).ready(function() {
			var result = '<?php echo $result ?>';

			//console.log(result);			
						
			//var myObj =  JSON.parse(result);			
			/*var myVar = myObj[3];
			var myArray = [];
			var myTempArray = [];
			console.log(myVar);			
			var myData1  = myObj[1].dayName;
			var myData2  = myObj[1].hours;
			console.log(myData1 + ": " + myData2);*/
			//console.log(myData2);*/

			
			/*jQuery.each(myObj, function(i, val) {
			  console.log("i: " + i + " Data: " + val.dayName + " den " + val.dayPresentation + ": " + val.hours);
			  myTempArray = [val.dayPresentation,val.hours]
			  myArray.push(myTempArray)
			});	
			
			console.log(myArray);*/
			
			console.log(result);
		});

		
		/*	Iterations over arrays and objects	
		var arr = [ "one", "two", "three", "four", "five" ];
		var obj = { one:1, two:2, three:3, four:4, five:5 };
		
		jQuery.each(arr, function() {
		  $("#" + this).text("My id is " + this + ".");
		  return (this != "four"); // will stop running to skip "five"
		});

		jQuery.each(obj, function(i, val) {
		  $("#" + i).append(document.createTextNode(" - " + val));
		});
		*/
		
		
	</script>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
	


	  
	  
    </script>

	
</head>
<body>
	<div id="wrapper">
		<h1>Harvest</h1>
		
		<form method="get" action="<?=$_SERVER['PHP_SELF'];?>" name="choosePerson">
			Medarbejderinitialer: <input name="initials" value="" onblur="document.choosePerson.submit()" />	 URL: 	<?php echo $url ?>
		</form>
		
				
		<div onclick="$('#table_div').toggle();return false"><a href="">Table</a><br/><br/></div>	
		<div id="table_div" style="display: none;"></div>
		
		<div onclick="$('#chart_div').toggle();return false"><a href="">Chart</a><br/><br/></div>	
		<div id="chart_div" style="display: block;"></div>
		
		
		<div onclick="$('#rawVarDump').toggle();return false"><a href="">Full var_dump</a><br/><br/></div>	
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