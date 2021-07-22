

<html>
<head>
</head>
<body >
<?php
include "../config/conn.php";

$docNum = $_GET['docNum'];
$action = $_GET['act'];
$approveBy = $_GET['appBy'];
			// $carname = $_POST['carname'];

$data = array();

if( $conn === false ) {
	echo "Unable to connect.</br>";
	die( print_r( sqlsrv_errors(), true));
}

/* TSQL Query */
$tsql = "Exec sp_approvePR @docnum = '$docNum', @action = '$action', @appBy = '$approveBy'";
$stmt = sqlsrv_query( $conn, $tsql);

if( $stmt === false ) {
	echo "Error in executing query.</br>";
	die( print_r( sqlsrv_errors(), true));
}else{

	 $json = array();
	 $message = '';
	 $cek = 'X';
	 do {
	 	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	 		$json[] = $row;
			$message = $row[''];
			$cek = 'Y';
	 	}
	 } while ( sqlsrv_next_result($stmt) );
	
	if($cek == "Y"){
		 $message; //json_encode($json);
	}else{
		if($action=="8"){
			$message = 'Purchase Requisition : ' . $docNum . ' Rejected';
			// echo json_encode('Purchase Requisition : ' . $docNum . ' Rejected');
		}else{
			$message = 'Purchase Requisition : ' . $docNum . ' Approved';
			// echo json_encode('Purchase Requisition : ' . $docNum . ' Approved');
		}
	}
	
	
	
}

/* Kososngkan $stmt dan tutup koneksi database.  getEditData.php */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>	
<center><br>
<h3> <?php echo $message; ?> </h3><br>
<input type="button" name="Quit" id="Quit" value="Close" onclick="return quitBox('quit');" style="width: 200px;height: 50px;background: 'red';background: #e4a718;color: white;font-size: xx-large;">

</center>
<script type="text/javascript">
	function quitBox(cmd)
	{   
    if (cmd=='quit')
    {
     	window.open(location, '_self', '');
		window.close();   
    }   
    return false;   
}
</script>
</body>
</html>