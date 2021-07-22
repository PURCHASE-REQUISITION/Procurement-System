<?php
	$serverName="DESKTOP-EA2V86B";
	$uid = "sa";
	$pwd = "Admin12345";
	$connectionInfo = array( "UID"=>$uid,
	                         "PWD"=>$pwd,
	                         "Database"=>"SBE2_LIVE_4",
	                         "CharacterSet"=>"UTF-8");
	 
	/* Connect using SQL Server Authentication. */
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

?>