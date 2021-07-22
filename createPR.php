<!DOCTYPE html>
<html>
<head>
	<title>Create PR</title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
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
	</style>
</head>
<body>
	<div class="easyui-panel" title="Form Entry" style="width:100%;max-width:100%;height:'auto';padding:10px">
		<form id="fm" method="post" novalidate enctype="multipart/form-data" 
		form-data="style=background: #1791ff;color:white;">
		<table width="80%" style="margin: : 10px">
			<thead>
				
				<th>Project</th>
				<th>Warehouse</th>
				<th>Document Date</th>
				<th>Required Date</th>
			</thead>
			<tbody>
				

				<td><input class="easyui-textbox" id="project" name="project" style="width:400px;" data-options="prompt:'Optional'">
				</td>
				<td >
					<select id="wrhs" class="easyui-dropdown" style="width: 200px" >
					</select>
				</td>
				<td><input id="dcdate" name="dcdate" style="width:150px" class="easyui-datebox">
				</td>
				<td><input id="rqdate" name="rqdate" style="width:150px" class="easyui-datebox">
				</td>

			</tbody>
		</table>
		<div class="hr hr10 hr-dotted"></div>

		<table cellspacing="2" cellpadding="5px">
			
			<tr>
				<td><h5>Item Code</td><td style="width: 20px">:</td>
				<td><input id="itemcode" name="itemcode" class="easyui-textbox" style="width:200px;" readonly required="true">
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:100px; background: #2ecac4" onclick="cari()">Search</a></td>
				</tr>
				<tr>
					<td><h5>Item Name </td><td style="width: 20px">:</td>
					<td><input id="itmname" name="itmname" style="width:500px" class="easyui-textbox" required="true" readonly></td>

				</tr>
				<tr>
					<td style="width: 100px"><h5>Required Qty </td><td>:</td>
					<td><input id="qty" name="qty" style="width:100px" class="easyui-numberbox" required="true" data-options="min:0,precision:0"></td>
					<td><h5>Total </td><td style="width: 20px">:</td>
					<td><input id="total" name="total" style="width:100px" class="easyui-numberbox" value="0" readonly="true" data-options="min:0,precision:3,decimalSeparator:'.',groupSeparator:','"></td>
				</tr>

				<tr>
					<td><h5>Unit</td><td>:</td>
					<td><input id="uom" name="uom" style="width:100px" class="easyui-textbox" placeholder="unit" readonly="true"></td>
					<td style="width: 90px"><h5>MOQ</td><td>:</td>
					<td>
						<input id="moq" name="moq" style="width:200px" class="easyui-textbox" readonly="true">
					</td>
				</tr>
				<tr>
					<td><h5>Price </td><td>:</td>
					<td><input id="price" name="price" style="width:100px" class="easyui-numberbox" value="0" data-options="min:0,precision:3,decimalSeparator:'.',groupSeparator:','"></td>
					<td><h5>SPQ </td><td>:</td>
					<td>
						<input id="spq" name="spq" style="width:200px" class="easyui-textbox" readonly="true">
					</td>
				</tr>
				<tr>													
					<td><h5>Currency </td><td>:</td>
					<td >
						<select id="curr" class="easyui-dropdown" style="width: 200px" >
							<option value="IDR">IDR</option>
							<option value="IDR">USD</option>
							<option value="IDR">EUR</option>
						</select>
					</td>
					<td><h5>Detail Unit </td><td>:</td>
					<td>
						<input id="dtu" name="dtu" style="width:300px" class="easyui-textbox" readonly="true">
					</td>	
				</tr>

			</table>

			<h5>Remark</h5>
			<div style="margin-bottom:20px">
				<textarea  type="text" id="remark" name="message" style="width:80%;height:65px;"></textarea>
			</div>
			<div style="margin-bottom: 10px">							            	
				<a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-add'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="addRow()">Add</a>
				<a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-ok'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="generateJSON()">Save</a>
			</div>
			<div>
				<table id="dg" title="My Users" class="easyui-datagrid" style="width:98%;height:200px"
				        toolbar="#toolbar" fitColumns="true" singleSelect="true">
				    <thead>
				        <tr>
				        	<th field="item" width="20">Item</th>
				            <th field="itemcode" width="50">Item Code</th>
				            <th field="itmname" width="100">Item Name</th>
				            <th field="qty" width="50">Quantity</th>
				            <th field="unit" width="50">Unit</th>
				            <th field="price" width="50">Price</th>
				            <th field="curr" width="50">Currency</th>
				            <th field="subtot" width="50">Sub Total</th>
				            <th field="moq" width="50">MOQ</th>
				            <th field="spq" width="50">SPQ</th>
				            <th field="dtunit" width="50">Detail Unit</th>
				            <th field="remark" width="50">Remark</th> 
				        </tr>
				    </thead>
				</table>
				<div id="toolbar">
				    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Change PR Item</a>
				    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleterow()">Delete PR Item</a>
				</div>
			</div>
		</form>

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
	</div>

<script type="text/javascript">
	var rIndex;
	$('#qty, #price').numberbox({
			"onChange":function(){  
				var a = $("#qty").attr("value");
				var b = $("#price").attr("value");
				var c = a * b;
				$('#total').numberbox({
					value:c
				});
  			}  
		});

	function deleterow(){
		 
			$.messager.confirm('Confirm','Are you sure?',function(r){
				if (r){
					var row = $('#dg').datagrid('getSelected');
					 var rowIndex = $("#dg").datagrid("getRowIndex", row);
					 $('#dg').datagrid('deleteRow', rowIndex);
				}
			});
		}

	function addRow(){
		var count = $('#dg').datagrid('getRows');

		 $('#dg').datagrid('appendRow',{
		   item            : count.length + 1,
		   itemcode        : $("#itemcode").attr("value"), 
		   itmname         : $("#itmname").attr("value"),
		   qty 			   : $("#qty").attr("value"),
		   unit : $("#uom").attr("value"),
		   price : $("#price").attr("value"),
		   curr : $("#curr").attr("value"), 
		   subtot : $("#total").attr("value"),
		   moq : $("#moq").attr("value"),
		   spq : $("#spq").attr("value"),
		   dtunit :$("#dtu").attr("value"),
		   remark : $("#remark").attr("value")
		});
	}

	function generateJSON(){
		var djson = new Array();
		var rows = $('#dg').datagrid('getRows');
		for(var i=0; i<rows.length; i++){
			djson.push(rows[i]);
		  // console.log(rows[i]['itemcode']);
		}
		alert(JSON.stringify(djson));
	}

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
						$('#itemcode').textbox({
							iconAlign:'left',
							value:vitemcode
						})

						$('#itmname').textbox({
							iconAlign:'left',
							value:vitemname
						})

						$('#uom').textbox({
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
</script>
</body>
</html>