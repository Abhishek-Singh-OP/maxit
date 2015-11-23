
<?php
	echo "idÇidentitynoÇcard_nameÇissuing_organizationÇiss_org_logoÇiss_org_urlÇcard_typeÇcard_categoryÇaffiliationÇaffiliation_categoryÇreward_points_value_on_spendingÇcountryÇcountry_codeÇcontact_noÇcreated_date".PHP_EOL;
	foreach($user_details as $abc){
		$array = get_object_vars($abc);
		$comma_separated = '"'.implode('"Ç"',$array).'"';
		echo $comma_separated.PHP_EOL;
	}
?>