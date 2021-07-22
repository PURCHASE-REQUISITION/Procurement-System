<?php
session_start();


include "../config/conn.php";

$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false ) {
	echo "Unable to connect.</br>";
	die( print_r( sqlsrv_errors(), true));
}


$tsql = "SELECT * FROM SYSV";
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

sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);



?>