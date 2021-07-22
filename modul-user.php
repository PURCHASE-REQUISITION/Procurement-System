<?php

	if($_GET['modul']=='create')
	{
		include "createOrder.php";
	}if($_GET['modul']=='openPR')
	{
		include "openPR.php";
	}if($_GET['modul']=='History')
	{
		include "historyOrder.php";
	}if($_GET['modul']=='Manageuser')
	{
		include "manageUser.php";
	}if($_GET['modul']=='Managedept')
	{
		include "Department.php";
	}if($_GET['modul']=='listOrder')
	{
		include "orderList.php";
	}if($_GET['modul']=='editPR')
	{
		include "editPR.php";
	}

?>
