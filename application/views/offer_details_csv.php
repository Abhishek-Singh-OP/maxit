			
<?php
	echo "idÇoffer_idÇcard_nameÇofferÇoffer_categoryÇoffer_subcategoryÇestablishment_idÇoffer_typeÇamountÇvalid_tillÇoffer_urlÇtncÇimp_tncÇoffer_contentÇlatitudeÇlongtitudeÇspecific_location_existsÇapplicable_across_categoryÇweek_daysÇ	cityÇscrapper_log_urlÇmanually_updatedÇcreated_date".PHP_EOL;  
	foreach($user_details as $abc){
		$array = get_object_vars($abc);
		$comma_separated = '"'.implode('"Ç"',$array).'"';
		echo $comma_separated.PHP_EOL;
	}
?>