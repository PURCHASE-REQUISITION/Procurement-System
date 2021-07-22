<?php
	session_start();
	
	if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
		echo json_encode('You are not Authentication');
	}else{
		/* Set Connection Credentials */
		include "../config/conn.php";
		/* Connect using SQL Server Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		 
		if( $conn === false ) {
		     echo "Unable to connect.</br>";
		     die( print_r( sqlsrv_errors(), true));
		}
		
		function mssql_escape($str)
		{
		   if(get_magic_quotes_gpc())
		   {
		    $str= stripslashes($str);
		   }
		   return str_replace("'", "''", $str);
		}

		$ItemCode = $_POST['ItemCode']; 
		/* TSQL Query */
		$tsql = "Exec sp_GetCurrency @ItemCode = '" . mssql_escape($ItemCode) . "'";
		$stmt = sqlsrv_query( $conn, $tsql);

		 
		if( $stmt === false ) {
		     echo "Error in executing query.</br>";
		     die( print_r( sqlsrv_errors(), true));
		}
		 
		$json = array();
		 
		do {
		     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$json[] = $row;
		     }
		} while ( sqlsrv_next_result($stmt) );

		echo json_encode($json);
		/* Free statement and connection resources. */
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn);
	}

 
?>