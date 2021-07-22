<div id = "dlg" class = "easyui-dialog" style = "width: 600px; height: 200px; padding: 10px 20px"
closed = "true" buttons = "#dlg-buttons">
<form id = "fm" method = "post">
	
	<div class = "fitem">
		<label style="width: 150px"> New Password: </label>
		<input id = "newpass" name = "newpass" type="password" required = "true" style="width: 200px">
	</div>
</form>
</div>
<div id = "dlg-buttons">
	<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="savePass()"> Save </a>
	<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"> Cancel </a>
</div>