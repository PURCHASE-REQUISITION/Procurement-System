<?php
include "../config/conn.php";
session_start();
if(!empty($_POST['username']) && !empty($_POST['password'])){
	$data = array();
	$username = $_POST['username'];
	$password = SHA1($_POST['password']);
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	
	/* TSQL Query */
	$tsql = "Select * from TblUser where name = '$username' and password = '$password' and user_level is not null and dept_id is not null";
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
				$_SESSION['sbeusernamex'] = $_POST['username'];
				$_SESSION['sbelevelx'] = $_POST['level'];
				$_SESSION['sbeuidx'] = $_POST['uid'];
				$_SESSION['sbeulvlx'] = $_POST['ulvl'];
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
	unset($_SESSION['sbeusernamex'],$_SESSION['sbelevelx'],$_SESSION['sbeuidx']);
	// session_destroy();
}    

?>