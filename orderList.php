<?php
session_start();

if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{

}
?>

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

.zdialog { display: none; }
.xdialog { display: none; }
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
		</div><!-- /.col -->
		<div id = "dgreset" class = "easyui-dialog" style = "width: 800px; height: 500px; padding: 10px 20px"
		closed = "true" buttons = "#dlg-btreset">
		<form id = "fm1" method = "post">
			<table padding="10px">
				<tr>
					<td style="width: 100px"><label> Order Num </label></td><td style="width: 50px">:</td>
					<td><input id = "oeNum" name = "oeNum" class = "easyui-textbox" required = "true" readonly="true"></td>
				</tr>
				<tr>
					<td style="width: 100px"><label> Project Name </label></td><td style="width: 50px">:</td>
					<td><input id = "prjNm" name = "prjNm" class = "easyui-textbox" style="width: 500px"></td>
				</tr>
				<tr>
					<td><label> Item Code </label></td><td>:</td>
					<td><input id = "oeItemCode" name = "rUname" class = "easyui-textbox" required = "true">
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:100px; background: #2ecac4" onclick="cari()">Search</a></td>
					</tr>
					<tr>
						<td><label> Description </label></td><td>:</td>
						<td><input id = "desc" name = "npass" class = "easyui-textbox" style="width: 500px"></td>
					</tr>
					<tr>
						<td><label> Qty </label></td><td>:</td>
						<td><input id = "eQty" name = "rUname" class = "easyui-textbox" required = "true"></td>
					</tr>
					<tr>
						<td><label> Unit </label></td><td>:</td>
						<td><input id = "eUnit" name = "rUname" class = "easyui-textbox" required = "true"></td>
					</tr>
					<tr>
						<td><label> Price </label></td><td>:</td>
						<td><input id = "ePrice" name = "rUname" class = "easyui-numberbox" required = "true" data-options="min:0,precision:3,decimalSeparator:'.',groupSeparator:','"></td>
					</tr>
					<tr>
						<td><label> Total </label></td><td>:</td>
						<td><input id = "eTotal" name = "rUname" class = "easyui-numberbox" required = "true" data-options="min:0,precision:3,decimalSeparator:'.',groupSeparator:','"></td>
					</tr>
					<tr>
						<td><label> Currency </label></td><td>:</td>
						<td><input id = "eCurr" name = "rUname" class = "easyui-textbox" required = "true"></td>
					</tr>
					<tr>
						<td><label> Remark </label></td><td>:</td>
						<td><textarea  type="text" id="eRemark" name="message" style="width:600px;height:80px;"></textarea></td>
					</tr>
				</table>
			</form>
		</div>
		<div id = "dlg-btreset">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" style="width:200px" onclick="updateOrder()"> Save </a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dgreset').dialog('close')"> Cancel </a>
		</div>	

		<div id="dd" class="zdialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" 
		closable="true" >
		<br>
		<div>
			<tr>													
				<td>
					<input type="text" name="carcode" id="carcode" class="form-control" placeholder="Cari berdasarka ItemCode"/>
				</td>	
				<td>
					<input type="text" name="carnam" id="carnam" class="form-control" placeholder="Cari berdasarka ItemName"/>
				</td>													
			</tr>
		</div><br>
		<table id="igr"></table>
	</div>

	<div id = "dlgMsg" class = "easyui-dialog" style = "width: 500px; height: 180px; padding: 10px 20px"
			closed = "true" buttons = "#dlgMsg-buttons" closable= "false">
			<form id = "fm2" method = "post">
				
				<div class = "fitem">
					<label id="txtMsg" style="width: 500px"> </label>
				</div>
			</form>
			</div>
			<div id = "dlgMsg-buttons">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="closeMsgWindow()"> Ok </a>
			</div>
</div>
</div>

<script>
	var sesseion = ("<?php echo $_SESSION['sbelevelx']?>");
	var suname = ("<?php echo $_SESSION['sbeusernamex']?>");
	var suid = ("<?php echo $_SESSION['sbeuidx']?>");

	function windowMessage(msg){
		// $("#txtMsg").val('PR Approved');
		$("#txtMsg").html(msg);
		$('#dlgMsg').dialog('open').dialog('setTitle','Warning...!!!');
	}

	function closeMsgWindow(){
		$('#dlgMsg').dialog('close');
		// window.location = "home.php?modul=openPR";
	}

	$(function(){
		var url = 'action/listOrders.php?created_by='+sesseion+'&uid='+suid+'&all=Y';	
		$('#tt').datagrid({
			view: detailview,
			detailFormatter:function(index,row){
				return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
			},
			onExpandRow: function(index,row){
				$('#ddv-'+index).panel({
					border:true,
					cache:false,
					href:'action/getItem.php?docNum='+row.docNum+'&ind=Y',

					onLoad:function(){
						$('#tt').datagrid('fixDetailRowHeight',index);
					}
				});
				$('#tt').datagrid('fixDetailRowHeight',index);
			},
			title:'List Purchase Requisition',
			width:'100%',
			height:500,
			singleSelect:true,
			resizable:true,
			fitColumns:true,
			pagination:true,
			pageList:[20,50,100,150,200],
			idField:'docNum',
			url:url,
			columns:[[
			{field:'docNum',title:'Order Num',width:90},
			{field:'project_name',title:'Project',width:150,editor:'text',nowrap:true},
			{field:'created_by',title:'Created By',width:80,editor:'text'},
			{field:'created_date',title:'Created Date',width:80,editor:'text'},
			{field:'required_date',title:'Required Date',width:100,editor:'text'},
			{field:'Action1',title:'',width:60,align:'center',
				formatter:function(value,row,index){
					var a = '<a href="javascript:void(0)" onclick="confirm(this)">Confirm</a>';
					return a;
				},
				styler: function(value,row,index){
					return 'background-color:white;color:blue;';
				}
			},
			{field:'Action2',title:'',width:60,align:'center',
				formatter:function(value,row,index){
					var a = '<a href="javascript:void(0)" onclick="edit(this)">Edit</a>';
					return a;
				},
				styler: function(value,row,index){
					return 'background-color:white;color:blue;';
				}
			}
			]],				
});
	});

	$('#eQty, #ePrice').numberbox({
		"onChange":function(){  
			var a = $("#eQty").attr("value");
			var b = $("#ePrice").attr("value");
			var c = a * b;
			$('#eTotal').numberbox({
				value:c
			});
		}  
	});

	function edit(target){
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;

		$.ajax({
			type:'GET',
			url:'action/getHeaderData.php',
			dataType: "json",
			data:{DocNum:v},
			cache:false,
			success:function(results){
				$.ajax({
					type:'POST',
					url:'action/getEditData.php',
					dataType: "json",
					data:{DocNum:v},
					cache:false,
					success:function(data){
						if (data[0].docStatus == "0" || data[0].docStatus == "9"){
			window.location = "home.php?modul=editPR&Order="+v+"&project="+results[0].project_name+"&rqdata="+results[0].required_date+"&dcdate="+results[0].created_date;
						}else{
							windowMessage("cannot change order, this order already confirm")

						}

					}
				});	
			}
		});
	}


	$('#carcode').keyup(function(e){
		if(e.keyCode == 13)
		{
			zcarcode = ($('#carcode').val());
			var url = 'action/getDataFilter_3.php?carcode='+zcarcode;

			$(function(){
				$('#igr').datagrid({	
					title:'',
					width:'90%',
					height:450,
					singleSelect:true,
					rownumbers:true,
					pagination:false,
					idField:'itemcode',
					url:url,
					columns:[[
					{field:'itemcode',title:'Item ID',width:150},
					{field:'ItemName',title:'namaitem',width:470,editor:'text'},
					{field:'BaseUnit',title:'satuan',width:80,editor:'text'},					
					]],
				});
			});
		}
	});

	$('#carnam').keyup(function(e){
		if(e.keyCode == 13)
		{	
			zcarnam = ($('#carnam').val());
			var url = 'action/getDataFilter_2.php?carnam='+zcarnam;

			$(function(){
				$('#igr').datagrid({	
					title:'',
					width:'90%',
					height:450,
					singleSelect:true,
					rownumbers:true,
					pagination:false,
					idField:'itemcode',
					url:url,
					columns:[[
					{field:'itemcode',title:'Item ID',width:150},
					{field:'ItemName',title:'namaitem',width:470,editor:'text'},
					{field:'BaseUnit',title:'satuan',width:80,editor:'text'},					
					]],
				});
			});
		}
	});

	function cari(){
		$('#carcode').val('');
		$('#carnam').val('');
		$('#dd').dialog({
			title: 'List Item',
			width: '65%',
			height: 600,
			closed: false,
			cache: false,
			modal: true
		});

		$(function(){
			$('#igr').datagrid({	
				title:'',
				width:'90%',
				height:450,
				singleSelect:true,
				rownumbers:true,
				pagination:false,
				idField:'itemcode',
				url:'action/getDataFilter.php',
				columns:[[
				{field:'ItmsGrpNam',title:'Item Group',width:150},
				{field:'itemcode',title:'Item ID',width:150},
				{field:'ItemName',title:'namaitem',width:470,editor:'text'},
				{field:'BaseUnit',title:'satuan',width:80,editor:'text'},					
				]],
			});
		});

		var vitemcode = '';
		var vitemname = '';
		$(function(){
			var dg = $('#igr').datagrid({
				onDblClickRow:function(){

					var row = $("#igr").datagrid("getSelected");
					vitemcode = row.itemcode;
					vitemname = row.ItemName;
					vuom = row.BaseUnit;
					$('#oeItemCode').textbox({
						iconAlign:'left',
						value:vitemcode
					})

					$('#desc').textbox({
						iconAlign:'left',
						value:vitemname
					})

					$('#eUnit').textbox({
						iconAlign:'left',
						value:vuom
					})

					$.ajax({
						type:'POST',
						url:'action/getMOQSPQ.php',
						dataType: "json",
						data:{itemcode:vitemcode},
						cache:false,
						success:function(results){
							var djson = JSON.stringify(results);
							$('#moq').textbox({
								iconAlign:'left',
								value:results[0].MinOrdrQty
							})

							$('#spq').textbox({
								iconAlign:'left',
								value:results[0].OrdrMulti
							})

							if(results[0].InvntItem == "Y"){
								$('#price').textbox({
									iconAlign:'left',
									readonly:true,
									value:results[0].price
								})
							}else{
								$('#price').textbox({
									iconAlign:'left',
									readonly:false,
								})
							}

						}
					});
					$('#dd').dialog('close');
				}
			});
		});
	}

	function updateOrder(){
		var updateData = {
			nomor : $("#oeNum").attr("value"),
			project : $("#prjNm").attr("value"),
			itemcode : $("#oeItemCode").attr("value"),
			itmname : $("#desc").attr("value"),
			qty : $("#eQty").attr("value"), 
			uom : $("#eUnit").attr("value"), 
			price : $("#ePrice").attr("value"), 
			total : $("#eTotal").attr("value"), 
			curr : $("#eCurr").attr("value"),
			remark : $("#eRemark").attr("value"),
		};
		$.ajax({
			type:'POST',
			url:'action/updateOrder.php',
			dataType: "json",
			data:updateData,
			cache:false,
			success:function(results){
				if (results == "sukses") {
					$('#dgreset').dialog('close').dialog();
					$('#dgreset').dialog('close').dialog();
					$.messager.show({    
						title: 'Information',
						msg: 'Order ' + $("#oeNum").attr("value") + ' updated'
					});
					$('#tt').datagrid('reload'); 
				}else{
					alert(results)
				}
			}
		}); 
	}

	function destroy(target){
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		var updateData = {
			nomor : v,
			action : 'delete',
		};
		$.messager.confirm('Delete','Are you sure you want to delete order '+ v +' ?',function(r){
			if (r){
				$.ajax({
					type:'POST',
					url:'action/getEditData.php',
					dataType: "json",
					data:{DocNum:v},
					cache:false,
					success:function(data){
						if (data[0].docStatus == "1" || data[0].docStatus == "2" || data[0].docStatus == "3" || data[0].docStatus == "4"){
								alert('You cannot delete order, this order already confirm or approved');
									
								}else{
									$.ajax({
										type:'GET',
										url:'action/confirmOrder.php',
										dataType: "json",
										data:updateData,
										cache:false,
										success:function(results){
											if (results == "sukses") {
												$('#dgreset').dialog('close').dialog();
												window.location = "home.php?modul=listOrder";
											}else{
												alert(results)
											}
										}
									}); 
								}

							}
						});
			}
		})								
	}

	function confirm(target){
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		var updateData = {
			nomor : v,
			action : 'confirm',
		};
		$.messager.confirm('Confirm','Are you sure you want to confirm order '+ v +' ?',function(r){
			if (r){
				$.ajax({
					type:'POST',
					url:'action/getEditData.php',
					dataType: "json",
					data:{DocNum:v},
					cache:false,
					success:function(data){

						if (data[0].docStatus == "0" || data[0].docStatus == "9"){
							$.ajax({
								type:'GET',
								url:'action/confirmOrder.php',
								dataType: "json",
								data:updateData,
								cache:false,
								success:function(results){
									if (results == "sukses") {
										$('#dgreset').dialog('close').dialog();
										// sendEmail(v);
										window.location = "home.php?modul=listOrder";
									}else{
										alert(results)
									}
								}
							}); 

						}else{
							windowMessage("cannot confirm order, this order already confirm")
							
						}
						
					}
				});
			}
		})
	}

	function sendEmail(param){
		var emailApp = {
			docnum : param
		}
		$.ajax({
			type:'POST',
			url:'action/sendMail.php',
			dataType: "json",
			data:emailApp,
			cache:false,
			success:function(results){

			}
		});
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


</script>
