<?php

include "../config/conn.php";
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	echo json_encode('You are not Authentication');
}else{
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	// $id = intval($_REQUEST['created_by']);
	$uname  = ($_GET['created_by']);
	$uid    = ($_GET['uid']);
	$all    = ($_GET['all']);
	$strdate = ($_GET['strdate']);
	$enddate = ($_GET['enddate']);
	
	//echo $strdate;
	//echo $enddate;
	// echo json_encode($id);
	/* TSQL Query */
	$tsql = "Exec sp_ListOrders_02_V2 @uname = '$uname', @uid = '$uid', @all = 'X', @strDate = '$strdate', @endDate = '$enddate'";
	// $tsql = "Exec sp_ListOrders @uname = '$uname', @uid = '$uid', @all = '$all'";
	// $tsql = "Exec sp_Select @strDate = '$strdate', @endDate = '$enddate'";
	//echo $tsql;
	// echo $tsql;
	$stmt = sqlsrv_query($conn, $tsql);
	
	if( $stmt === false ) {
		//echo "Error in executing query.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	/* Process results */
	$json = array();
	
	do {
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$json[] = $row;
		}
	} while ( sqlsrv_next_result($stmt) );
	
	/* Run the tabular results through json_encode() */
	/* And ensure numbers don't get cast to trings */
	echo json_encode($json);


	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}
?>