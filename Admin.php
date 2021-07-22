<?php
session_start();

if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Admin - Manage Department</title>

	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
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
	<script type="text/javascript" src="assets/easyui/resource/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="assets/easyui//datagrid-detailview.js"></script>
	<script type="text/javascript" src="assets/js/datagrid-filter.js"></script>
	
	<style type="text/css">
	.zdialog { display: none; }
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
				<a href="index.php" class="navbar-brand">
					<small>
						Sinar Baja Electric
					</small>
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							
							<span class="user-info">
								<small>Welcome,</small>
								<?php echo $_SESSION['sbeusernamex'];?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.navbar-container -->
	</div>

	<div class="main-container ace-save-state" id="main-container" style="background-image: linear-gradient(to bottom,#00BEFF,#2577FF);">
		<script type="text/javascript">
			try{ace.settings.loadState('main-container')}catch(e){}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try{ace.settings.loadState('sidebar')}catch(e){}
			</script>
			<?php
			include "menu.php";
			?>

			<div class="hr hr10 hr-dotted"></div>
		</div>

		<div class="main-content" >
			<div class="main-content-inner">
				<div class="page-content">				

					<div class="page-header">
						<h1>
							Manage Department
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Maintain department
							</small>
						</h1>
					</div><!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<!-- <table id="tt"></table> -->
								<table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:500px"
								url="action/getDepartment.php" toolbar="#toolbar" pagination="true" fitColumns="true" singleSelect="true">
								<thead>
									<tr>
										<th field="dept_id" width="50">Dept Id</th>
										<th field="dept_name" width="50">Department Name</th>
										<th field="whs_code" width="100">Warehouse</th>
									</tr>
								</thead>
							</table>
							<div id="toolbar">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newDept()">Add Deparment</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove Department</a>
							</div>
							<div id = "dlg" class = "easyui-dialog" style = "width: 600px; height: 400px; padding: 10px 20px"
							closed = "true" buttons = "#dlg-buttons">
							<div class = "ftitle"> Deparment </div>
							<form id = "fm" method = "post">
								<div class = "fitem">
									<label style="width: 150px"> Deparment Name: </label>
									<input id = "name" name = "name" class = "easyui-textbox" required = "true" style="width: 250px">
								</div>
								<div class = "fitem">
									<label style="width: 150px"> Warehouse: </label>
									<select id="wscode" class="easyui-listbox" style="width: 200px" >
									</select>
								</div>

							</form>
						</div>
						<div id = "dlg-buttons">
							<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveDept()"> Save </a>
							<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"> Cancel </a>
						</div>							
					</div><!-- /.col -->						
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->
</div><!-- /.main-container -->

<?php
include "footer.php";
?>

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script type="text/javascript">
	var url;
	$('#dg').datagrid({
		pageList:[20,50,100,150,200],
	})

	function newDept(){
		$('#dlg').dialog('open').dialog('center').dialog('setTitle','New Deparment');
		$('#fm').form('clear');
		url = 'save_user.php';
	}

	function saveDept(){
		// alert(url);
		var row = $('#dg').datagrid('getSelected');
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			}
		});

		var update_data = {
			deptnm : $("#name").attr("value"),
			wscode : $("#wscode").attr("value"),
		};
		// alert(JSON.stringify(update_data));
		$.ajax({
			type:'POST',
			url:'action/saveDept.php',
			dataType: "json",
			data:update_data,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dlg').dialog('close');
					$('#dg').datagrid('reload'); 
					$.messager.show({    // show error message
						title: 'Success',
						msg: 'Deparment Added'
					});
				}else{
					alert(results)
				}
			}
		}); 
	}
	function destroyUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to destroy this Deparment?',function(r){
				if (r){
					$.post('action/destroyDept.php',{id:row.dept_id},function(result){
						if (result == "sukses") {
							$('#dg').datagrid('reload');
							$.messager.show({	
								title: 'Sukses',
								msg: 'Deparment deleted'
							});	
						} else {
							$.messager.show({	
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		}
	}

	$(document).ready(function(e){
		$.ajax({
			type:'POST',
			url:'action/getWarehouse.php',
			dataType: "json",
			data:{user_id:'bejo'},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					var listItems = '';
					for (var i = 0; i < count; i++) {
						listItems += "<option value='" + results[i].WhsCode + "'>" + results[i].WhsName + "</option>";
					};
					$("#wscode").html(listItems);
				});
			}
		});
	});

	
</script>

<style type="text/css">
#fm{
	margin:0;
	padding:10px 30px;
}
.ftitle{
	font-size:14px;
	font-weight:bold;
	padding:5px 0;
	margin-bottom:10px;
	border-bottom:1px solid #ccc;
}
.fitem{
	margin-bottom:5px;
}
.fitem label{
	display:inline-block;
	width:80px;
}
.fitem input{
	width:160px;
}
</style>

<script>
	$(function(){
		var dg = $('#dg').datagrid({

		});
		dg.datagrid('enableFilter', [{}]);
	});
</script> 

<script language=JavaScript>
	var message="Function Disabled!";
	function clickIE4(){
		if (event.button==2){
			alert(message);
			return false;
		}
	}

	function clickNS4(e){
		if (document.layers||document.getElementById&&!document.all){
			if (e.which==2||e.which==3){
				alert(message);
				return false;
			}
		}
	}

	if (document.layers){
		document.captureEvents(Event.MOUSEDOWN);
		document.onmousedown=clickNS4;
	}
	else if (document.all&&!document.getElementById){
		document.onmousedown=clickIE4;
	}

	document.oncontextmenu=new Function("return false")
</script>
</body>
</html>
