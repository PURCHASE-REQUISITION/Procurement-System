<?php
include "../config/conn.php";
session_start();
if(!empty($_POST['username'])){
	$data = array();
	$username = $_POST['username'];
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	/* TSQL Query */
	$tsql = "Select * from TblUser where name = '$username'";
	$stmt = sqlsrv_query( $conn, $tsql);
	$rows = sqlsrv_num_rows($stmt);
	echo $rows;
	if( $stmt === false ) {
		echo "Error in executing query.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
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
	}
	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}else{
	echo json_encode('e');
	
}    

?>