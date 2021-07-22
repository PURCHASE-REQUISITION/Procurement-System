<?php
session_start();
$ind = $_GET['ind'];
?>
<table class="table table-bordered table-hover" Width='800'>  
<tr>
    <!-- <th> Order No. </th> -->
    <th> Item </th>
    <th> Item Code </th>
    <th> Item Name </th>
    <th> Quantity </th>
    <th> Unit </th>
    <th> Price </th>
    <th> Currency </th>
    <th> Total </th>    
    <th> Remark </th>
    <th style='width: 100px'> <center>Status</center> </th>
    <?php
    	if($ind=="X"){

    	}else{
    		if($_SESSION['sbelevelx'] == "Manager" || $_SESSION['sbelevelx'] == "General Manager"){
    		echo "<th style='width: 150px'> <center>action</center> </th>";
    	}else{
    		// echo "<th style='width: 100px'> <center>action</center> </th>";
    	}
    	}
    	
    ?>
    
</tr>

<?php  
function mssql_escape($str)
		{
		   if(get_magic_quotes_gpc())
		   {
		    $str= stripslashes($str);
		   }
		   return str_replace("'", "''", $str);
		}
include "../config/conn.php";
	$itemid = $_GET['docNum'];
	$level = $_SESSION['sbelevelx'];
	// $ind = $_GET['ind'];
// Perintah untuk menampilkan data
$tsql = "Exec sp_ListDetailV2 @docNum = '$itemid', @level = '$level', @ind = '$ind'";	
// $tsql = "Select * From tblOrderDetail where DocNum = '$itemid' order by DocNum,docItem asc";
$stmt = sqlsrv_query( $conn, $tsql);

// perintah untuk membaca dan mengambil data dalam bentuk array <td>".$row['DocNum']."</td>
		do {
		     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				 echo "    
			        <tr>
			        
			        <td>".$row['docItem']."</td>
			        <td>".mssql_escape($row['ItemCode'])."</td>
			        <td>".mssql_escape($row['ItemName'])."</td>
			        <td>".$row['Qty']."</td>
			        <td>".$row['Unit']."</td>
			        <td>".$row['Price']."</td>
			        <td>".$row['Currency']."</td>	
			        <td>".$row['Total']."</td>			        
			        <td>".$row['additional_remark']."</td>
			        ";
			        if($row['RowStatus'] == "Open"){
			        	echo "<td style='background-color:#ffee00;color:black;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }elseif($row['RowStatus'] == "Confirmed"){
			        	echo "<td style='background-color:#3ea5ef;color:white;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }elseif($row['RowStatus'] == "Rejected"){
			        	echo "<td style='background-color:red;color:white;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }elseif($row['RowStatus'] == "Approved Manager"){
			        	echo "<td style='background-color:#87a9dc;color:white;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }elseif($row['RowStatus'] == "Approved GM"){
			        	echo "<td style='background-color:#c57530;color:white;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }elseif($row['RowStatus'] == "Approved GM"){
			        	echo "<td style='background-color:green;color:white;font-weight: bold;'>".$row['RowStatus']."</td>";
			        }
			        
			      if($ind=="X"){}else{
			      	if($_SESSION['sbelevelx'] == "Manager"){
			     	echo "   <td>
			        	<a href='action/approve.php?prnum=".$row['DocNum']."&item=".$row['docItem']."&act=2' class='btn btn-xs btn-success' style='background-color:green'>Approve</a>
			        	<a href='action/approve.php?prnum=".$row['DocNum']."&item=".$row['docItem']."&act=8' class='btn btn-xs btn-danger' style='background-color:red'>Reject</a>
			        </td>	        
			        </tr> 
			        ";
			     }elseif ($_SESSION['sbelevelx'] == "General Manager") {
			     	echo "<td><a href='action/approve.php?prnum=".$row['DocNum']."&item=".$row['docItem']."&act=3' class='btn btn-xs btn-success' style='background-color:green'>Approve</a>
			     	<a href='action/approve.php?prnum=".$row['DocNum']."&item=".$row['docItem']."&act=8' class='btn btn-xs btn-danger' style='background-color:red'>Reject</a></td>";
			     }
			     else{
			     	// echo "   
			      //   	<a href='action/confirmOrder.php?nomor=".$row['DocNum']."&item=".$row['docItem']."&action=a' class='btn btn-xs btn-success' style='background-color:green'>Confirm</a>";
			     }
			      }
			     
			     
		     }
		} while ( sqlsrv_next_result($stmt) );

?>
</table>