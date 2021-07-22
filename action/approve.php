<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	echo json_encode('You are not Authentication');
}else{
	// $id = intval($_REQUEST['id']);
	// $act = intval($_REQUEST['act']);
	// $approveBy = intval($_REQUEST['approveBy']);
//$id = $_GET['id'];
//echo $id;
	$act = $_GET['act'];
	$prnum = $_GET['prnum'];
	$item = $_GET['item'];
	$approveBy = ($_SESSION['sbeuidx']);
	include "../config/conn.php";
	
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	

	$tsql = "Exec sp_approvePR_V2 @docnum = '$prnum', @item = '$item', @action = '$act', @appBy = '$approveBy'";
//$result = sqlsrv_prepare($conn, $tsql, $procedure_params);
	$result = sqlsrv_query( $conn, $tsql);

//$proc = mssql_init('some_proc', $conn);
//$proc_result = mssql_execute($proc);
	
	if ($result){

		echo json_encode("sukses");
		// header('location:../home.php?modul=openPR');
		// echo json_encode('success');
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}

?>