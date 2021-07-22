<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_POST['nomor']) && !empty($_POST['itemcode'])){
	$data = array();

	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{

		function mssql_escape($str)
		{
		   if(get_magic_quotes_gpc())
		   {
		    $str= stripslashes($str);
		   }
		   return str_replace("'", "''", $str);
		}

		$nomor = 	($_POST['nomor']); 
		$project = ($_POST['project']);
		$itemcode = 	($_POST['itemcode']);
		$itmname = 	($_POST['itmname']);
		$qty = 	($_POST['qty']);
		$uom =	($_POST['uom']);		
		$price = 	($_POST['price']);
		$curr =	($_POST['curr']);
		$total =	($_POST['total']);
		$remark =	($_POST['remark']); 

		/* TSQL Query */
		$tsql = "sp_UpdateOrder @docNum = '$nomor', @prjNm = '$project', @itemCode = '$itemcode', @itemName = '" . mssql_escape($itmname) . "', @qty = $qty, @unit = '$uom',
		 @price = $price, @total = $total, @currency = '$curr', @remark = '" . mssql_escape($remark) . "'";
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