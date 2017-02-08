<?php
	
	$department = "Projektkontor";
	$departmentCount1 = 0;
	$departmentCount2 = 0;
	$departmentCount3 = 0;
	$departmentCountInde = 0;
	$departmentCountFerie = 0;
	$departmentCountSygdom = 0;
	$departmentCountHjemmearbejde = 0;
	$departmentCountTjenstligtFra = 0;
	
	if(isset($_POST['department'])){
		$department = str_replace(' ', '%20',$_POST['department']);
	}
	
	
	$searchSpotURL = "http://devel06:8381/spot/services/medarbejder/search/departments:" . $department; 
	$searchSpotInURL = "http://devel06:8381/spot/services/medarbejder/inde/search/" . $department;
	$searchDepartmentURL = "http://devel06:8381/spot/services/afdeling/" . $department;

	$fileContens1 = @file_get_contents($searchSpotURL);
	$fileContens2 = @file_get_contents($searchSpotInURL);
	$fileContens3 = @file_get_contents($searchDepartmentURL);

	$json1 = json_decode($fileContens1);
	$json2 = json_decode($fileContens2);
	$json3 = json_decode($fileContens3);
	
	if($json1){
		$departmentCount1 = ($json1->numberOfResults);
	}else{
		$departmentCount1 = "0";
	}
	
	if($json2){
		$departmentCount2 = ($json2->numberOfResults);
	}else{
		$departmentCount2 = "0";
	}
	
	if($json3->medarbejdere){
		$departmentCount3 = (count($json3->medarbejdere));
		foreach ($json3->medarbejdere as $key => $value) {
           if($value->wintidStempKodeTekst == "Inde"){
			   $departmentCountInde = $departmentCountInde + 1;
		   }
		   if($value->wintidStempKodeTekst == "Ferie"){
			   $departmentCountFerie = $departmentCountFerie + 1;
		   }
		   if($value->wintidStempKodeTekst == "Sygdom"){
			   $departmentCountSygdom = $departmentCountSygdom + 1;
		   }
		   if($value->wintidStempKodeTekst == "Hjemmearbejde"){
			   $departmentCountHjemmearbejde = $departmentCountHjemmearbejde + 1;
		   }
		   if($value->wintidStempKodeTekst == "Tjenstligt fravær"){
			   $departmentCountTjenstligtFra = $departmentCountTjenstligtFra + 1;
		   }
		   //echo $value->wintidStempKodeTekst;
		}
	}else{
		$departmentCount3 = "0";
	}


	echo /*$departmentCount1 . "," . $departmentCount2 . "," . */$departmentCount3 . "," . $departmentCountInde . "," . $departmentCountHjemmearbejde . "," . $departmentCountTjenstligtFra . "," . $departmentCountFerie . "," . $departmentCountSygdom;
	//echo "test";
	
	//echo var_dump($json3->medarbejdere);
	
?>
