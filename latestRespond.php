<?php 

require "DBConnect.php";
	$callid = $_POST['call'];
	$rescue = $_POST['rescue'];
	$utility = $_POST['utility'];
	$brush = $_POST['brush'];
	$latter = $_POST['latter'];
	$tanker = $_POST['tanker'];

	if(!empty($rescue)) {
		foreach ($rescue as $value) {
				$temp = (int) $value;
				$sql = "INSERT INTO responded (`callid`, `ffid`, `type`) VALUES ('".$callid."','".$temp."', 'rescue')";
				$retval = mysql_query( $sql);
		            
		            if(! $retval ) {
		               die('Could not update data: ' . mysql_error());
		            }
 	}

	}

	if(!empty($utility)) {
	foreach ($utility as $value) {
			$temp = (int) $value;
			$sql2 = "INSERT INTO responded (`callid`, `ffid`, `type`) VALUES ('".$callid."','".$temp."', 'utility')";
			$retval = mysql_query( $sql2);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }

	}
}

	if(!empty($brush)) {
	foreach ($brush as $value) {
			$temp = (int) $value;
			$sql3 = "INSERT INTO responded (`callid`, `ffid`, `type`) VALUES ('".$callid."','".$temp."', 'brush')";
			$retval = mysql_query( $sql3);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }

	}
}
	if(!empty($latter)) {
	foreach ($latter as $value) {
			$temp = (int) $value;
			$sql4 = "INSERT INTO responded (`callid`, `ffid`, `type`) VALUES ('".$callid."','".$temp."', 'latter')";
			$retval = mysql_query( $sql4);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }

	}
}
	if(!empty($tanker)) {
	foreach ($tanker as $value) {
			$temp = (int) $value;
			$sql5 = "INSERT INTO responded (`callid`, `ffid`, `type`) VALUES ('".$callid."','".$temp."', 'tanker')";
			$retval = mysql_query( $sql5);
	            
	            if(! $retval ) {
	               die('Could not update data: ' . mysql_error());
	            }

	}
}

	echo "call successfully entered"



?>