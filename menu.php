
<ul class="nav nav-list">
	<li class="active">
		<a href="#">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Main Menu </span>
		</a>

		<b class="arrow"></b>
	</li>						

	<?php
	if ($_SESSION['sbelevelx'] == 'Administrator'){
		?>
	</li> 

	<li class="">
		<a href="Admin.php">
			<i class="menu-icon fa fa-pencil-square-o"></i>
			<span class="menu-text"> List Department </span>
		</a>
	</li>

	<li class="">
		<a href="manageUser.php">
			<i class="menu-icon fa fa-user"></i>
			<span class="menu-text"> Manage User </span>
		</a>
	</li>
	<?php
}elseif (($_SESSION['sbelevelx'] == 'Manager') || ($_SESSION['sbelevelx'] == 'General Manager')) {
	?>
	<li class="">
		<a href="home.php?modul=openPR">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text"> List Orders </span>
		</a>
	</li>

	<li class="">
		<a href="home.php?modul=History">
			<i class="menu-icon fa fa-user-secret"></i>
			<span class="menu-text"> History Orders </span>
		</a>
	</li>

	<li class="">
		<a href="javascript:void(0)" onclick="changePass()">
			<i class="menu-icon fa fa-cog"></i>
			<span class="menu-text"> Change Password </span>
		</a>
	</li>
	<?php
}
else{
	?>
	<li class="">
		<a href="home.php?modul=create">
			<i class="menu-icon fa fa-pencil-square-o"></i>
			<span class="menu-text"> Create Order </span>
		</a>
	</li>

	<li class="">
		<a href="home.php?modul=listOrder">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text"> List Orders </span>
		</a>
	</li>

	<li class="">
		<a href="home.php?modul=History">
			<i class="menu-icon fa fa-user-secret"></i>
			<span class="menu-text"> History Orders </span>
		</a>
	</li>

	<li class="">
		<a href="javascript:void(0)" onclick="changePass()">
			<i class="menu-icon fa fa-cog"></i>
			<span class="menu-text"> Change Password </span>
		</a>
	</li>

	<?php		
}
?>

<li class="">
	<a href="action/logout.php">
		<i class="menu-icon fa fa-power-off"></i>
		<span class="menu-text"> Logout </span>
	</a>
</li>
</ul>