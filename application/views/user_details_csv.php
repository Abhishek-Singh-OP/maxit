
<?php
	echo "idÇestablishmentÇaddressÇurlÇpincodeÇstatusÇclassÇlocationÇspecific_location_existsÇcategoryÇoffer_subcategoryÇlatitudeÇlongtitudeÇestablishment_logoÇultimate_cardÇbest_cardÇcreated_date".PHP_EOL; 
	foreach($user_details as $abc){
		$array = get_object_vars($abc);
		$comma_separated = '"'.implode('"Ç"',$array).'"';
		echo $comma_separated.PHP_EOL;
	}
?>