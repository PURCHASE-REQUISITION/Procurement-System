<style type="text/css">
.zdialog { display: none; }
a {
	color: blue;
	font-size: '14px';
}
a:hover {
	color: red;
}

element.style {
	background-image: linear-gradient(to bottom,#00BEFF,#2577FF);
}
</style>
<style>
    .datagrid-header-check input{
        display: none;
    }
</style>

<div class="page-header">
	<h1>
		List Orders
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			orders status
		</small>
	</h1>
</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<table id="tt"></table>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</div>
<div id = "dlgMsg" class = "easyui-dialog" style = "width: 360px; height: 150px; padding: 10px 20px"
			closed = "true" buttons = "#dlgMsg-buttons" closable= "false">
			<form id = "fm" method = "post">
				
				<div class = "fitem">
					<label id="txtMsg" style="width: 350px"> </label>
				</div>
			</form>
			</div>
			<div id = "dlgMsg-buttons">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="closeMsgWindow()"> Ok </a>
			</div>

<script>
	
	var sesseion = ("<?php echo $_SESSION['sbelevelx']?>");
	var suname = ("<?php echo $_SESSION['sbeusernamex']?>");
	var suid = ("<?php echo $_SESSION['sbeuidx']?>");

	function filterJson(rows) {
	    return rows.ind == "X";
	}

	function generateJSON(){
		var item = $('#tt').datagrid('getRows');
		var url;
		var djson = [];
		
		for(i=0;i<item.length;i++){			
			if(item[i].ind == "X"){
				
				if(sesseion == "Manager"){
					 djson = {
						prnum : item[i].docNum,
						item : item[i].docItem,
						act : '2'
					}
				}else{
					 djson = {
						prnum : item[i].docNum,
						item : item[i].docItem,
						act : '3'
					}
				}
				
				
				$.ajax({
					type:'GET',
					url:'action/approve.php',
					dataType: "json",
					data:djson,
					cache:false,
					success:function(results){

						windowMessage('Purchase Requisition Approved','');
					}
				});
			}
		}		
		if(djson.length == 0){
			windowMessage('Please select Purchase Requisition item','');
		}
	}

	function rejectAllSelected(){
		var item = $('#tt').datagrid('getRows');
		var djson = [];
		for(i=0;i<item.length;i++){			
			if(item[i].ind == "X"){
				if(sesseion == "Manager"){
					 djson = {
						prnum : item[i].docNum,
						item : item[i].docItem,
						act : '8'
					}
				}else{
					 djson = {
						prnum : item[i].docNum,
						item : item[i].docItem,
						act : '8'
					}
				}
				$.ajax({
					type:'GET',
					url:'action/approve.php',
					dataType: "json",
					data:djson,
					cache:false,
					success:function(results){
						windowMessage('Purchase Requisition Rejected','');
					}
				});
			}
		}
		if(djson.length == 0){
			windowMessage('Please select Purchase Requisition item','');
		}			
	}
	
		function onCheck(index,row){
			$('#tt').datagrid('updateRow', {
			index: index,
			row: {
					ind        : 'X'
				}
			});
		}
		function onUncheck(index,row){
			$('#tt').datagrid('updateRow', {
			index: index,
			row: {
					ind        : ''
				}
			});
		}

	if (sesseion == "Manager" || sesseion == "General Manager"){
		
		var url = 'action/listOrders.php?created_by='+sesseion+'&uid='+suid+'&all=Y';
		$(function(){
			$('#tt').datagrid({	
				title:'List Open Purchase Requisition',
				width:'100%',
				height:600,
				singleSelect:false,
				resizable:true,
				fitColumns:false,
				striped: true,
				pagination:true,
				pageList:[50,100,150,200],
				checkOnSelect:false,
				selectOnCheck:false,
				onCheck:onCheck,
				onUncheck:onUncheck,
				idField:['docItem','docNum'],
				url:url,
				toolbar: [
				'-  -',{
					text:'Select All',
					iconCls: 'icon-selectAll',
					handler: function(){
						$('#tt').datagrid('checkAll');
						var data = {}; 
						data = $('#tt').datagrid('getRows');
						for(i=0;i<=data.length;i++){
							onCheck(i,data);
						}
					}
				},'-',{
					text : 'UnSelect All',
					iconCls: 'icon-remove',
					handler: function(){ 
						$('#tt').datagrid('uncheckAll');
						var data = {}; 
						data = $('#tt').datagrid('getRows');
						for(i=0;i<=data.length;i++){
							onUncheck(i,data);
						}
						// window.location = "home.php?modul=openPR";
					}
				},'-',{
					text:'Approve',
					iconCls: 'icon-ok',
					handler: function(){generateJSON();}
				},'-',{
					text : 'Reject',
					iconCls: 'icon-cancel',
					handler: function(){rejectAllSelected();}
				}
				],
				columns:[[
				{field:'ck', checkbox:true},
				{field:'docStatus',title:'Status',width:130,align:'center',editor:'text',
					styler: function(value,row,index){
						if (row.status == "0" || row.status == "9") {
							return 'background-color:#ffee00;color:black;font-weight: bold;';
						}else if (row.status == "1") {
							return 'background-color:#3ea5ef;color:black;font-weight: bold;';
						}else if (row.status == "2") {
							return 'background-color:#87a9dc;color:white;font-weight: bold;';
						}else if (row.status == "3") {
							return 'background-color:#c57530;color:white;font-weight: bold;';
						}else if (row.status == "4") {
							return 'background-color:green;color:white;font-weight: bold;';
						}else if (row.status == "8" || row.status == "5") {
							return 'background-color:red;color:white;font-weight: bold;';
						}
					}
				},
				{field:'ind',title:'ind',width:80, hidden:true},
				{field:'docNum',title:'PR Number',width:80},
				{field:'docItem',title:'Item',width:80},
				{field:'project_name',title:'Project',width:100,editor:'text',nowrap:false},
				{field:'ItemCode',title:'Item Code',width:130,editor:'text',nowrap:false},
				{field:'ItemName',title:'Item Name',width:300,editor:'text',nowrap:false},
				{field:'created_by',title:'Created By',width:80,editor:'text'},
				{field:'created_date',title:'Created Date',width:80,editor:'text'},
				{field:'required_date',title:'Required Date',width:100,editor:'text'},
				{field:'Qty',title:'Required Qty',width:120,editor:'text'},
				{field:'Unit',title:'Unit',width:60,editor:'text'},
				{field:'Price',title:'Price',width:100,editor:'text'},
				{field:'Currency',title:'Currency',width:60,editor:'text'},
				{field:'Total',title:'Total',width:100,editor:'text'},
				{field:'remark',title:'remark',width:400,editor:'text'}

			]],				
		});
		});

	}

	function getRowIndex(target){
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		console.log('index' + v);
		console.log(v);
		return parseInt(tr.attr('datagrid-row-index'));

	}

	function windowMessage(param, msg){
		// $("#txtMsg").val('PR Approved');
		$("#txtMsg").html(param + " " + msg);
		$('#dlgMsg').dialog('open').dialog('setTitle','Information');
	}

	function closeMsgWindow(){
		$('#dlgMsg').dialog('close');
		window.location = "home.php?modul=openPR";
	}
	function approve(target){
		
		var session = ("<?php echo $_SESSION['sbelevelx']?>");
		var zact;
		if(session == "Manager" || session == "Administrator"){
			zact = '2';
		}else{
			zact = '3';
		}
		// alert(zact);
		var suid = ("<?php echo $_SESSION['sbeuidx']?>");
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		var item=$('#tt').datagrid('getRows')[x].docItem;
		var orserStatus=$('#tt').datagrid('getRows')[x].docStatus;
		if(orserStatus == "Open" && session == "Manager"){
			$.messager.confirm('Confirm','Are you sure you want to approve order '+ v +' ?',function(r){
				if (r){
					$.post('action/approveHeader.php',{id:v,act:zact,approveBy:suid},function(result){
						// alert(result);
						console.log('Result' + result);
						if (result === "success"){
							windowMessage('Purchase Requisition '+v, ' Approved');
							
							// $('#tt').datagrid('reload');    
							// $.messager.show({    
							// 	title: 'Success',
							// 	msg: 'Order '+ v +' Approved'
							// });
						} else {
							$.messager.show({    
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'JSON');
				}
			});
		}else if(orserStatus == "Open" || orserStatus == "Approved Manager" && session == "General Manager"){
			// alert(v);
			$.messager.confirm('Confirm','Are you sure you want to approve order '+ v +' ?',function(r){
				if (r){
					$.post('action/approveHeader.php',{id:v,act:zact,approveBy:suid},function(result){
						console.log('Result' + result);
						if (result === "success"){
							windowMessage('Purchase Requisition '+v, ' Approved');
							// window.location = "home.php?modul=openPR";
							// $('#tt').datagrid('reload');    
							// $.messager.show({    
							// 	title: 'Success',
							// 	msg: 'Order '+ v +' Approved'
							// });
						} else {
							$.messager.show({    
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'JSON');
				}
			});
		}
		else{
			$.messager.show({   
				title: 'Error',
				msg: 'Cannot approve order, order '+ v +' was ' + orserStatus
			});
		}
	}

	function reject(target){
		var session = ("<?php echo $_SESSION['sbelevelx']?>");

		var suid = ("<?php echo $_SESSION['sbeuidx']?>");
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		var orserStatus=$('#tt').datagrid('getRows')[x].docStatus;
		if(orserStatus == "Open" || orserStatus == "Approved Manager" && session == "Manager"){
			$.messager.confirm('Confirm','Are you sure you want to reject order '+ v +' ?',function(r){
				if (r){
					$.post('action/approveHeader.php',{id:v,act:'8',approveBy:suid},function(result){
						console.log('Result' + result);
						if (result === "success"){
							windowMessage('Purchase Requisition '+v, ' Rejected');
							// $('#tt').datagrid('reload');    
							// $.messager.show({    
							// 	title: 'Success',
							// 	msg: 'Order '+ v +' Rejected'
							// });
						} else {
							windowMessage('Purchase Requisition '+v, result);
							// $.messager.show({    
							// 	title: 'Error',
							// 	msg: result.errorMsg
							// });
						}
					},'JSON');
				}
			});
		}else if(orserStatus == "Open" || orserStatus == "Approved Manager" && session == "General Manager"){
			$.messager.confirm('Confirm','Are you sure you want to reject order '+ v +' ?',function(r){
				if (r){
					$.post('action/approveHeader.php',{id:v,act:'4',approveBy:suid},function(result){
						console.log('Result' + result);
						if (result === "success"){
							windowMessage('Purchase Requisition '+v, ' Rejected');
						} else {
							windowMessage(v, result);
						}
					},'JSON');
				}
			});
		}
		else{
			$.messager.show({   
				title: 'Error',
				msg: 'Cannot reject order, order '+ v +' was ' + orserStatus
			});
		}
	}


	$(function(){
		var dg = $('#tt').datagrid({

		});
		dg.datagrid('enableFilter', [{
			field:'docStatus',
			type:'combobox',
			options:{
				panelHeight:'auto',
				data:[{value:'',text:'All'},{value:'Open',text:'Open'},{value:'Approved Manager',text:'Approved Manager'},
				{value:'Approved GM',text:'Approved GM'},{value:'Rejected',text:'Rejected'},{value:'Closed',text:'Closed'}
				],
				onChange:function(value){
					if (value == ''){
						dg.datagrid('removeFilterRule', 'docStatus');
					} else {
						dg.datagrid('addFilterRule', {
							field: 'docStatus',
							op: 'equal',
							value: value
						});
					}
					dg.datagrid('doFilter');
				}
			}
		}]);
	});

	function changePass(){
		$("#newpass").val('');
		$('#dlg').dialog('open').dialog('setTitle','Change Password');
	}

	function savePass(){
		var usrid = ("<?php echo $_SESSION['sbeuidx']?>");
		var reset_data = {
			id : usrid,
			Password : $("#newpass").attr("value"),
		};
		$.ajax({
			type:'POST',
			url:'action/resetPass.php',
			dataType: "json",
			data:reset_data,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dlg').dialog('close').dialog();
					$.messager.show({   
						title: 'Success',
						msg: 'Password reseted'
					});
				}else{
					alert(results)
				}
			}
		}); 
	}
</script>