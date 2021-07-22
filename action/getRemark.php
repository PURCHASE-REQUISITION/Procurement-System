<?php

include "../config/conn.php";
	$itemid = $_GET['docNum'];
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	// echo json_encode($id);
	/* TSQL Query */
	$tsql = "Select additional_remark From tblOrderDetail where DocNum = '$itemid'";
	$stmt = sqlsrv_query( $conn, $tsql);
	
	if( $stmt === false ) {
		echo "Error in executing query.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
?>
	<div><td><h5><b>Remark : </b></h5></td><td><h5>
<?php	
	
	do {
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			echo $row['additional_remark'];
		}
	} while ( sqlsrv_next_result($stmt) );

	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

?>
	</h5></td></div>