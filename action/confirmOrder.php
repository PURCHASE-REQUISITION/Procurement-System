<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_GET['nomor'])){
	$data = array();

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		$nomor  = 	$_GET['nomor'];
		$action = 	$_GET['action'];

		/* TSQL Query */
		$tsql = "Exec sp_ConfirmOrderV2 @docNum = $nomor, @action = '$action'";
		$stmt = sqlsrv_query( $conn, $tsql);
		
		if( $stmt === false ) {
			echo "Error in executing query.</br>";
			die( print_r( sqlsrv_errors(), true));

			echo json_encode(print_r( sqlsrv_errors(), true));
		}else{
			echo json_encode('sukses');
		}
	}
	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}else{
	echo json_encode('gagal');
}    

?>