<?php
	
	$id = "";
	
	if(isset($_POST['id'])){
		$id = str_replace(' ', '%20',$_POST['id']);
	}
	
	/*if(isset($_GET['id'])){		
		//$id=str_replace(' ', '%20',$_GET['id']);
		$id=$_GET['id'];
	}*/
	
	$shortRecordURL = "http://devel06:9220/searchservice-ws/items/" . $id . "/shortRecord"; 
	//$shortRecordURL = urlencode("http://devel06:9220/searchservice-ws/items/sb_dbc_artikelbase_2 649 308 0/shortRecord"); 

	$fileContens = @file_get_contents($shortRecordURL);

	$json = json_decode($fileContens);
	
	if($json){
		$fileContens = @file_get_contents($shortRecordURL);
		$title = ($json->title);
	}else{
		$title = $id;
	}


	echo $title;
	
?>
