<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_POST['id'])){
	$data = array();

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		$id = 	($_POST['id']);
		$mngid = 	($_POST['mngid']);  
		$gmid = 	($_POST['gmid']);
		// $dept =	($_POST['dept']);
		// $level = 	($_POST['level']);

		/* TSQL Query */
		$tsql = "Insert Into TblUserMap values('$id','$mngid','$gmid',getdate(),getdate())";
		// $tsql = "Exec sp_assigmentUser @uid = '$id', @mngid = '$mngid', @gmid = '$gmid', @deptid = '$dept', @userlvl = '$level'";
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