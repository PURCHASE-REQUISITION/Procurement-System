<?php
	include "../config/conn.php";
	session_start();
	if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
		echo json_encode('You are not Authentication');
	}else{
			// $carcode = $_POST['carcode'];
			// $carname = $_POST['carname'];

		    $data = array();

		    if( $conn === false ) {
		     echo "Unable to connect.</br>";
		     die( print_r( sqlsrv_errors(), true));
			}
			 
			/* TSQL Query */
			$tsql = "select top(200) b.ItmsGrpNam, a.itemcode, a.ItemName, a.InvntryUom as BaseUnit 
					 from OITM as a inner join oitb as b on a.ItmsGrpCod = b.ItmsGrpCod where a.U_FLAGPR = 'Y'";
			$stmt = sqlsrv_query( $conn, $tsql);
			 
			if( $stmt === false ) {
			     echo "Error in executing query.</br>";
			     die( print_r( sqlsrv_errors(), true));
			}else{
				
				$json = array();
				 
				do {
				     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$json[] = $row;
				     }
				} while ( sqlsrv_next_result($stmt) );
				 
				echo json_encode($json);
			}

			/* Kososngkan $stmt dan tutup koneksi database. */
			sqlsrv_free_stmt( $stmt);
			sqlsrv_close( $conn);
		}
?>