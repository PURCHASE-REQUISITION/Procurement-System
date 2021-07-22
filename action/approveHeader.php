<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	echo json_encode('You are not Authentication');
}else{
	$id = $_POST['id'];
	$act = $_POST['act'];
	$approveBy = $_POST['approveBy'];
//$id = $_GET['id'];
//echo $id;
	
	include "../config/conn.php";
	
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}
	//echo $id;
	/* TSQL Query */
//$result = sqlsrv_query($conn, "update tblOrder set docStatus = 2 where docNum = '$id'");
	$procedure_params = array(
		array(&$myparams['docnum'], SQLSRV_PARAM_OUT));

	$tsql = "Exec sp_approvePR_HeaderLvl_V2 @docnum = $id, @action = '$act', @appBy = $approveBy";
//$result = sqlsrv_prepare($conn, $tsql, $procedure_params);
	$result = sqlsrv_query( $conn, $tsql);

//$proc = mssql_init('some_proc', $conn);
//$proc_result = mssql_execute($proc);
	
	if ($result){
		echo json_encode('success');
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}

?>