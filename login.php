<?php
session_start();

if (!isset($_SESSION['sbeusernamex'])){

}else{
	header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>ABC - Login Page</title>

	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<!-- <link href='assets/images/LOGO3.png' rel='shortcut icon'> -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
	<link rel="stylesheet" href="assets/css/ace.min.css" />
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

	<style type="text/css">
	.blur-login {
		background: url(images/meteorshower2.jpg) #e1e5ea;
		background-image: linear-gradient(to bottom,#00BEFF,#2577FF);
	}
	.login-box .toolbar {
		background: #70747b;
		border-top: 2px solid #f0f1f7;
	}
</style>
</head>

<body class="login-layout">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<div class="center">
							<br>
							<!-- <img src="assets/images/LOGO3.png" style="width:350px;height:100px;margin:auto"> -->
							<h1><span class="white" id="id-text1"><b>Purchase Requisition</b></span></h1>
						</div><br>

						<div class="space-6"></div>

						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h5 class="header blue lighter bigger">
											<i class="ace-icon fa fa-coffee green"></i>
											Enter Username and Password
										</h5>

										<div class="space-6">sfasf</div>

										<form id="fmlogin" method="post">
											<fieldset>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" name="username" id="username" class="form-control" placeholder="Username" onChange="getuser()" required  >
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>


												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" name="password" id="password" class="form-control" placeholder="Password" required="true"/>
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>

												<label class="block clearfix">
													<center><label for="usrlvl">User Level</label></center>
													<span class="block input-icon input-icon-right">
														<input type="text" align="center" name="lvlusr" id="lvlusr" class="form-control" readonly="true" />
													</span>
													<input type="hidden" name="usrid" id="usrid">
													<input type="hidden" name="ulvl" id="ulvl">
												</label>

												<div class="space"></div>

												<div class="clearfix">

													<button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="login()">
														<i class="ace-icon fa fa-key"></i>
														<span class="bigger-110">Login</span>
													</button>
												</div>

												<div class="space-4"></div>

											</fieldset>
										</form>
									</div><!-- /.widget-main -->

									<div class="toolbar clearfix">
										<div>

										</div>

										<div>
										</div>
									</div>
								</div><!-- /.widget-body -->
							</div><!-- /.login-box -->

							<div id="signup-box" class="signup-box widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header green lighter bigger">
											<i class="ace-icon fa fa-users blue"></i>
											New User Registration
										</h4>

										<div class="space-6"></div>
										<p> Enter your details to begin: </p>

										<form action="action/register.php" method="post">
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="email" name="email" class="form-control" placeholder="Email" required />
														<i class="ace-icon fa fa-envelope"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="text" name="username" class="form-control" placeholder="Username" required/>
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input type="password" name="password" class="form-control" placeholder="Password" required maxlength="20" minlength="6"/>
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>

												<div class="space-24"></div>

												<div class="clearfix">
													<button type="reset" class="width-30 pull-left btn btn-sm">
														<i class="ace-icon fa fa-refresh"></i>
														<span class="bigger-110">Reset</span>
													</button>

													<button type="submit" class="width-65 pull-right btn btn-sm btn-success">
														<span class="bigger-110">Register</span>

														<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
													</button>
												</div>
											</fieldset>
										</form>
									</div>

									<div class="toolbar center">
										<a href="#" data-target="#login-box" class="back-to-login-link">
											<i class="ace-icon fa fa-arrow-left"></i>
											Back to login
										</a>
									</div>
								</div><!-- /.widget-body -->
							</div><!-- /.signup-box -->
						</div><!-- /.position-relative -->
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.main-content -->
	</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		jQuery(function($) {
			$(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			});
		});

		function getuser(){
			var user_id = $('#username').val();
			$.ajax({
				type:'GET',
				url:'action/getuserlevel.php',
				dataType: "json",
				data:{user_id:user_id},
				cache:false,
				success:function(data){
					if(data.length == '1'){
						$('#lvlusr').val(data[0].deskripsi);
						$('#usrid').val(data[0].id);
						$('#ulvl').val(data[0].user_level);


					}else{
						$('#lvlusr').val('');
						$('#usrid').val('');
						$('#ulvl').val('');
					} 
				}
			});
		};

		$('#password').keyup(function(e){
			if(e.keyCode == 13)
			{
				login();
			}
		});

		function beforeShowForm(e) {
			var form = $(e[0]);
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_edit_form(form);
		};

		function login(){

			if ($('#username').val() == ''){
				alert('Fill username');
			}else if($('#password').val() == ''){
				alert('Fill password');
			}else{

				$.ajax({
					type:'POST',
					url:'action/cekUserStatus.php',
					dataType: "json",
					data:{username:$('#username').val()},
					cache:false,
					success:function(data){

						if(data.length == '1'){
							if(data[0].dept_id == null){
								alert('You are not activated, please contact your administrator');
								window.location = "login.php";
							}else{
								var form_data = {
									username: $('#username').val(),
									password: $('#password').val(),
									level: $('#lvlusr').val(),
									uid: $('#usrid').val(),
									ulvl: $('#ulvl').val(), 
								};

								$.ajax({
									type: "POST",
									url: "action/userLogin.php",
									dataType: "json",
									data : form_data,
									cache:false,
									success: 
									function(data){
										console.log("return login" + data);
										console.log(Object.keys(data).length);
										var sukses = Object.keys(data).length;

										if(sukses === 1 )
										{	
											var lvlusr = $('#lvlusr').val();

											if (lvlusr == "Staff"){
												window.location = "home.php?modul=create";
											}else if(lvlusr == "Administrator"){
												window.location = "Admin.php";
											}else{
												window.location = "home.php?modul=openPR";
											}

										}else{
											alert(' incorrect username or password ' );
										}

									}

								});
								return false; 
							}
						}else{

						} 
					}
				});

			}		  
		}
		jQuery(function($) {
			$('body').attr('class', 'login-layout blur-login');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'light-blue');

		});
	</script>
</body>
</html>
