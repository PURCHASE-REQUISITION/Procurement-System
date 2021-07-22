<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_POST['deptnm'])){
	$data = array();

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		$deptnm = 	($_POST['deptnm']);
		$wscode = 	($_POST['wscode']);  

		/* TSQL Query */
		// $tsql = "Update TblUser set dept_id = '$dept', user_level = '$level' where id = '$id'";
		$tsql = "Insert Into TblDept (dept_name,whs_code) values('$deptnm','$wscode')";
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