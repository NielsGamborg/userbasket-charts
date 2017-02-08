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
$apiUrl = "http://devel06:8381/spot/services/moedelokale/kalenderidag";

if (isset($_GET["apiUrl"])) {
		$apiUrl = ($_GET["apiUrl"]);
	}


$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept:application/json\r\n" 
  )
);

$context = stream_context_create($opts);
// Open the file using the HTTP headers set above		

$result = @file_get_contents($apiUrl,false, $context);

$json = json_decode($result,true);
			
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>API tester</title>
	
	<link type="text/css" href="charts.css" rel="stylesheet">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>
<div id="wrapper">
	<h1>API tester</h1>
	<div>
		<form method="get" action="<?=$_SERVER['PHP_SELF'];?>" name="chooseUrl">
			Url til API: <input name="apiUrl" value="<?=$apiUrl;?>" onblur="document.chooseUrl.submit()" style="width: 75%" />	
		</form>
	</div>
	<?php
				echo "<div>var_dump: </div>";
				
				if($result !=''){
					var_dump(json_decode($result, true));
				}
				
	?>
	<script type="text/javascript">
		var result=<?=json_encode($result) ?>;
		console.log("Result: " + result);
	</script>
</div>
</body>
</html>	
