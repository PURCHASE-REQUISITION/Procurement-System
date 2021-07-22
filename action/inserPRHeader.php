<?php
session_start();
if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<?php
include "../config/conn.php";

if(!empty($_POST['prNumb'])){
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
		$project = 	($_POST['project']);
		$wrhs =	($_POST['wrhs']);
		$dcdate = 	($_POST['dcdate']);
		$rqdate =	($_POST['rqdate']);
		$idusr =	($_SESSION['sbeuidx']);
		$lvlusr =	($_SESSION['sbeulvlx']); 
		$crBy =	($_SESSION['sbeusernamex']);

		/* TSQL Query */
		$tsql = "sp_inserHeader @nomor = '$prNumb', @project = '" . mssql_escape($project) . "',
			@wrhs = '$wrhs', @dcdate = '$dcdate', @rqdate = '$rqdate', @idusr = '$idusr', @lvlusr = '$lvlusr', @crBy = '$crBy' ";
		$stmt = sqlsrv_query( $conn, $tsql);
		 
		if( $stmt === false ) {
			echo "Error in executing query (Header).</br>";
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
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

}else{
	echo json_encode('gagal');
}    

?>