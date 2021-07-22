<?php
include "../config/conn.php";

if(!empty($_POST['itemcode'])){
	$data = array();
	$itemcode = $_POST['itemcode'];

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	/* TSQL Query */


	$tsql = "Exec sp_GetMOQ @itemcode = '$itemcode'";
	$stmt = sqlsrv_query( $conn, $tsql);
	
	if( $stmt === false ) {
		echo "Error in executing query.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		
		$json = array();
		
		do {
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$json[] = $row;
			}
		} while ( sqlsrv_next_result($stmt) );
		
		echo json_encode($json);
	}

	/* Kososngkan $stmt dan tutup koneksi database. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}else{
	echo json_encode('gagal');
}    

?>