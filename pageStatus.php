
<?php
session_start();

if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{

}
?>
<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>SBE - Purchase Requisition</title>

	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link href='assets/images/LOGO3.png' rel='shortcut icon'>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
	<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
	<script src="assets/js/ace-extra.min.js"></script> 

	<link rel="stylesheet" type="text/css" href="assets/easyui/resource/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="assets/easyui/resource/themes/icon.css">
	<script type="text/javascript" src="assets/js/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="assets/easyui/datagrid-detailview.js"></script>
	<script type="text/javascript" src="assets/js/datagrid-filter.js"></script>
	
	<style type="text/css">
	.zdialog { display: none; }
	.xdialog { display: none; }
	.ydialog { display: none; }

</style>
</head>

<body class="no-skin">
	<div id="navbar" class="navbar navbar-default          ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="#" class="navbar-brand">
				</small>
				<center>System Inactive</center>
			</small>
		</a>
	</div>			
</div>
</div>

<div class="main-container ace-save-state" id="main-container">
	<script type="text/javascript">
		try{ace.settings.loadState('main-container')}catch(e){}
	</script>

	<div class="main-content">
		<div class="main-content-inner">
			<div class="page-content">
				<div class="row">
					<br><br><br><br><br><br><br><br><br><br>
					<center><h1>Opps...! <br> System can't be use, please contact your administrator</h1></center>
				</div>
			</div>
		</div>
	</div>
	<?php
	include "footer.php";
	?>
</div>
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="assets/js/jquery.easypiechart.min.js"></script>
<script src="assets/js/jquery.sparkline.index.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>

<script type="text/javascript">
	
	function cekAppStat(){
		
		$.ajax({
			type:'POST',
			url:'action/getAppStatus.php',
			dataType: "json",
			data:'',
			cache:false,
			success:function(results){
				if (results[0].status == "Active") {
					
					var lvlusr = ("<?php echo $_SESSION['sbelevelx']?>");
					if (lvlusr == "Staff"){
						window.location = "home.php?modul=create";
					}else if(lvlusr == "Administrator"){
						window.location = "Admin.php";
					}else{
						window.location = "home.php?modul=openPR";
					}
				}else{
				}
			}
		}); 
	}

	this.cekAppStat();
</script>
</body>
</html>
