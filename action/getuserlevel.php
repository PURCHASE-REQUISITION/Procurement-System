<?php
include "../config/conn.php";

if(!empty($_GET['user_id'])){
	$data = array();
	$username = $_GET['user_id'];

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	/* TSQL Query */


	$tsql = "select * from vUsers where name = '$username'";
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
	unset($_SESSION['sbeusername'],$_SESSION['sbelevel'],$_SESSION['sbeuid']);
	session_destroy();
}    

?>