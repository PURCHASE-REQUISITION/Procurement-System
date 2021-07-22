<?php

include "../config/conn.php";
if(!empty($_POST['usrnm']) && !empty($_POST['passw'])){
	if( $conn === false ) {
		echo "Unable to connect.</br>";
		die( print_r( sqlsrv_errors(), true));
	}else{
		$email = 	($_POST['email']);  
		$username = 	($_POST['usrnm']);
		$password =	($_POST['passw']);

		// $tsql = "Insert Into TblUser (username,name,password,email) values ('$email','$username', '". SHA1($password). "', '$email')";
		$tsql = "Exec sp_RegisterUser @name = '$username', @email = '$email', @password = '". SHA1($password). "'";
		$stmt = sqlsrv_query( $conn, $tsql);

		if( $stmt === false ) {
			echo json_encode("Username or password already registered");
		}else{
			
			$json = array();
			$output = '';
		 	$a = 0;
			do {
			     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					$json[] = $row;
					$output = $row['Ada'];
					$a = $a + 1;
			     }
			} while ( sqlsrv_next_result($stmt) );

			
			if ($a == 0){
				echo json_encode("sukses");
			}else{
				if($output == "username sudah terdaftar"){
					echo json_encode("username sudah terdaftar");
				}else if($output == "email sudah terdaftar"){
					echo json_encode('email sudah terdaftar');
				}
				
			}

		}
	}
	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);	

}else{
	echo "error";
}

?>