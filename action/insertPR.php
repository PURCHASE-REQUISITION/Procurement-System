<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_POST['ItemCode'])){
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

		$prNumb = 	($_POST['prNumb']);  
		$prItem = 	($_POST['prItem']);  
		$itemcode = 	($_POST['ItemCode']);
		$itmname = 	($_POST['ItemName']);
		$uom =	($_POST['uom']);
		$qty = 	($_POST['qty']);
		$price = 	($_POST['price']);
		$curr =	($_POST['curr']);
		$total =	($_POST['total']);
		$remark =	($_POST['remark']); 
		$idusr =	($_SESSION['sbeuidx']);
		$lvlusr =	($_SESSION['sbeulvlx']); 
		$crBy =	($_SESSION['sbeusernamex']);

		/* TSQL Query */
		$tsql = "sp_insertDetail @nomor = '$prNumb', 
				@prItem = '$prItem', 
				@itemcode = '" . mssql_escape($itemcode) . "', 
				@itmname = '" . mssql_escape($itmname) . "', 
				@uom = '$uom', 
				@qty = '$qty', 
				@price = '$price', 
				@curr = '$curr', 
				@total = '$total', 
				@remark = '" . mssql_escape($remark) . "', 
				@idusr = '$idusr', 
				@crBy = '$crBy'";
		$stmt = sqlsrv_query($conn, $tsql);
		 
		if( $stmt === false ) {
			echo "Error in executing query detail.</br>";
			echo $tsql;
			die( print_r( sqlsrv_errors(), true));

			echo json_encode(print_r( sqlsrv_errors(), true));
		}else{
			$json = array();
		
			do {
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$json[] = $row;
				}
			} while ( sqlsrv_next_result($stmt) );
			
			echo json_encode($json);
			// echo json_encode('sukses');
		}
	}
	/* Free statement and connection resources. */


}else{
	echo json_encode('gagal');
}    

?>