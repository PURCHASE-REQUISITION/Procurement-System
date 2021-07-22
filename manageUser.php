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
	<title>Admin - Manage User</title>

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
							Manage Users
							<small>
								<i class="ace-icon fa fa-angle-double-right"></i>
								Maintain user and user role
							</small>
						</h1>
					</div><!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">
							<div class="row">
								<!-- <table id="tt"></table> -->
								<table id="dg" title="My Users" class="easyui-datagrid" style="width:'100%';height:500px"
								url="action/listUsers.php" toolbar="#toolbar" pagination="true" fitColumns="false" singleSelect="true">
								<thead>
									<tr>
										<th field="id" width="100">User Id</th>
										<th field="name" width="200">User Name</th>
										<th field="username" width="200">Email</th>
										<th field="deskripsi" width="150">Level</th>
										<th field="department" width="150">Departmen</th>
										<th field="Manager" width="150">Manager</th>
										<th field="GM" width="150">General Manager</th>
										<th field="status" width="200">User Status</th>
									</tr>
								</thead>
							</table>
							<div id="toolbar">
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-new" plain="true" onclick="newUser()">Create New User</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="editUser()">Add User Level & Department</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="editUser2()">Add User Manager & General Manager</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="formReset()">Reset Password</a>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
							</div>
							<div id = "dlg" class = "easyui-dialog" style = "width: 600px; height: 400px; padding: 10px 20px"
							closed = "true" buttons = "#dlg-buttons">
							<div class = "ftitle"> User Information </div>
								<form id = "fm" method = "post">
									<div class = "fitem">
										<label style="width: 150px"> Username: </label>
										<input id = "name" name = "name" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Email: </label>
										<input id = "username" name = "username" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Level: </label>
										<select id="level" class="easyui-dropdown" style="width: 200px" >
											<option>--Select Level--</option>
											<option value="10">Administrator</option>
											<option value="3">General Manager</option>
											<option value="2">Manager</option>
											<option value="1">Staff</option>
										</select>
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Departmen: </label>
										<select id="dept" class="easyui-dropdown" style="width: 200px" >
										</select>
									</div>
								</form>
							</div>
							<div id = "dlg-buttons">
								<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()"> Save </a>
								<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"> Cancel </a>
							</div>

							<div id = "dlgmnguser" class = "easyui-dialog" style = "width: 600px; height: 400px; padding: 10px 20px"
							closed = "true" buttons = "#dlgmng-buttons">
							<div class = "ftitle"> User Information </div>
								<form id = "fmmng" method = "post">
									<div class = "fitem">
										<label style="width: 150px"> Username: </label>
										<input id = "mngName" name = "name" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Email: </label>
										<input id = "mngEmail" name = "username" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Level: </label>
										<input id = "mngLevel" name = "username" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Department: </label>
										<input id = "mngDept" name = "username" class = "easyui-textbox" required = "true" readonly="true">
									</div>
									<div class = "fitem">
										<label style="width: 150px"> Manager: </label>
										<select id="mngMgr" class="easyui-dropdown" style="width: 200px" >
										</select>
									</div>
									<div class = "fitem">
										<label style="width: 150px"> General Manager: </label>
										<select id="mngGM" class="easyui-dropdown" style="width: 200px" >
										</select>
									</div>
								</form>
							</div>
							<div id = "dlgmng-buttons">
								<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="editAtasan()"> Save </a>
								<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgmnguser').dialog('close')"> Cancel </a>
							</div>							
						</div><!-- /.col -->

						<div id = "dgreset" class = "easyui-dialog" style = "width: 600px; height: 400px; padding: 10px 20px"
							closed = "true" buttons = "#dlg-btreset">
							<div class = "ftitle"> Reset User Password </div>
								<form id = "fmr" method = "post">
									<table padding="10px">
										<tr>
											<td><label> User ID </label></td><td>:</td>
											<td><input id = "rUid" name = "rUid" class = "easyui-validatebox" required = "true" readonly="true"></td>
										</tr>
										<tr>
											<td><label> Username </label></td><td>:</td>
											<td><input id = "rUname" name = "rUname" class = "easyui-validatebox" required = "true" readonly="true"></td>
										</tr>
										<tr>
											<td><label> New Password </label></td><td>:</td>
											<td><input id = "npass" name = "npass" class = "easyui-validatebox" required = "true"></td>
										</tr>
									</table>
								</form>
							</div>
							<div id = "dlg-btreset">
								<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="resetUser()"> Reset </a>
								<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dgreset').dialog('close')"> Cancel </a>
							</div>					
							<div id="newUserdlg" class="ydialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" closable="true">
								<br><br>
								<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="email" id="email" name="email" class="form-control" placeholder="Email" />
														<i class="ace-icon fa fa-envelope"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" id="usrnm" name="username" class="form-control" placeholder="Username" required/>
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" id="password" name="password" class="form-control" placeholder="Password" required maxlength="20" minlength="6"/>
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>

												<div class="space-24"></div>
											</fieldset>
							</div>		
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
	function newUser(){
		$('#email, #usrnm, #password').val('');
		$('#newUserdlg').dialog({
			title: 'Create New User',
			width: 500,
			height: 270,
			closed: false,
			cache: false,
			modal: true,
			buttons:[{
				text:'Create',
				iconCls:'icon-save',
				width:'100px',
				handler:function(){
					if($('#email').attr("value") == ""){
						$.messager.show({    
							title: 'Warning',
							msg: 'Please input email'
						});
					}else if($('#usrnm').attr("value") == ""){
						$.messager.show({    
							title: 'Warning',
							msg: 'Please input username'
						});
					}else if($('#password').attr("value") == ""){
						$.messager.show({    
							title: 'Warning',
							msg: 'Please input password'
						});
					}else{
						
						var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

						if (reg.test($('#email').attr("value")) == false) 
						{
							$.messager.show({    
								title: 'Error',
								msg: 'Invalid email format'
							});
							return false;
						}else{
							var usrData = {
								email : $('#email').attr("value"),
								usrnm : $('#usrnm').attr("value"),
								passw : $('#password').attr("value")
							}					

							$.ajax({
								type:'POST',
								url:'action/register.php',
								dataType: "json",
								data:usrData,
								cache:false,
								success:function(results){
									if(results == "sukses"){
										$('#newUserdlg').dialog('close');
										$.messager.show({    
											title: 'Sukses',
											msg: results
										});
										$('#dg').datagrid('reload');
									}else{
										$.messager.show({
											title: 'Warning',
											msg: results
										});
									}

								}
							});
						}
					}
				}
			},
			{
				text:'Cancel',
				iconCls:'icon-cancel',
				width:'100px',
				handler:function(){
					$('#newUserdlg').dialog('close');
				}
			}
			]
		});
	}

	function validateEmail(emailField){
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

		if (reg.test(emailField.value) == false) 
		{
			alert('Invalid Email Address');
			return false;
		}

		return true;

	}
	var url;
	$('#dg').datagrid({
		pageList:[20,50,100,150,200],
	})

	function editUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Add User Level & Department');
			$('#fm').form('load',row);
			url = 'action/update_user.php?id='+row.id;
		}
	}

	function editUser2(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlgmnguser').dialog('open').dialog('setTitle','Add User Manager & General Manager');
			$('#mngName').textbox({
				iconAlign:'left',
				value:row.name
			})

			$('#mngEmail').textbox({
				iconAlign:'left',
				value:row.username
			})

			$('#mngLevel').textbox({
				iconAlign:'left',
				value:row.deskripsi
			})

			$('#mngDept').textbox({
				iconAlign:'left',
				value:row.department
			})

			url = 'action/update_user.php?id='+row.id;
		}
	}

	function formReset(){
		var row = $('#dg').datagrid('getSelected');
		//alert(row.id);
		if (row){
			$('#dgreset').dialog('open').dialog('setTitle','Reset User Password');
			// $("#rUid").attr("value") = row.id; 
			$('#rUid').textbox({
				iconAlign:'left',
				value:row.id
			})

			$('#rUname').textbox({
				iconAlign:'left',
				value:row.username
			})
			// $('#fmr').form('load',row);
			url = 'action/resetPass.php?id='+row.id;
		}
	}

	function resetUser(){
		var row = $('#dg').datagrid('getSelected');
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			}
		});

		var reset_data = {
			id : row.id,
			Password : $("#npass").attr("value"),
		};
		//alert(update_data);
		$.ajax({
			type:'POST',
			url:'action/resetPass.php',
			dataType: "json",
			data:reset_data,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dgreset').dialog('close');
					// $('#dg').datagrid('reload'); 
					$.messager.show({    // show error message
						title: 'Success',
						msg: 'Password reseted'
					});
				}else{
					alert(results)
				}
			}
		}); 
	}

	function saveUser(){
		var row = $('#dg').datagrid('getSelected');
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			}
		});


		var update_data = {
			id : row.id,
			dept : $("#dept").attr("value"),
			level : $("#level").attr("value"),
		};
		
		$.ajax({
			type:'POST',
			url:'action/update_user.php',
			dataType: "json",
			data:update_data,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dlg').dialog('close');
					// $('#dg').datagrid('reload'); 
					// $.messager.show({    // show error message
					// 	title: 'Success',
					// 	msg: 'User updated'
					// });
					window.location = "manageUser.php";
				}else{
					alert(results)
				}
			}
		}); 
	}

	function editAtasan(){

		var row = $('#dg').datagrid('getSelected');
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			}
		});


		var update_data = {
			id : row.id,
			mngid : $("#mngMgr").attr("value"),
			gmid : $("#mngGM").attr("value"),
		};

		$.ajax({
			type:'POST',
			url:'action/updateAtasan.php',
			dataType: "json",
			data:update_data,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dlg').dialog('close');
					// $('#dg').datagrid('reload'); 
					// $.messager.show({    // show error message
					// 	title: 'Success',
					// 	msg: 'User updated'
					// });
					window.location = "manageUser.php";
				}else{
					alert(results)
				}
			}
		}); 
	}

	function destroyUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
				if (r){
					$.post('action/destroyUser.php',{id:row.id},function(result){
						if (result == "sukses") {
							$('#dg').datagrid('reload');
							$.messager.show({	
								title: 'Sukses',
								msg: 'User deleted'
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

	var deptitems;
	$(document).ready(function(e){
		$.ajax({
			type:'POST',
			url:'action/getDepartment.php',
			dataType: "json",
			data:{user_id:'bejo'},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					deptitems = '<option value="0">--Select Departmen--</option>';
					for (var i = 0; i < count; i++) {
						deptitems += "<option value='" + results[i].dept_id + "'>" + results[i].dept_name + "</option>";
					};
					$("#dept").html(deptitems);
				});
			}
		});
	});

	var mngitems;

	$(document).ready(function(e){
		$.ajax({
			type:'POST',
			url:'action/getManager.php',
			dataType: "json",
			data:{user_id:'bejo'},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					mngitems = '<option value="0">--Select Manager--</option>';
					for (var i = 0; i < count; i++) {
						mngitems += "<option value='" + results[i].id + "'>" + results[i].name + "</option>";
					};
					$("#mngMgr").html(mngitems);
				});
			}
		});
	});

	var gmitems;
	$(document).ready(function(e){
		$.ajax({
			type:'POST',
			url:'action/getGM.php',
			dataType: "json",
			data:{user_id:'gm'},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					gmitems = '<option value="0">--Select General Manager--</option>';
					for (var i = 0; i < count; i++) {
						gmitems += "<option value='" + results[i].id + "'>" + results[i].name + "</option>";
					};
					$("#mngGM").html(gmitems);
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

<!-- <script language=JavaScript>
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
</script> -->
</body>
</html>
