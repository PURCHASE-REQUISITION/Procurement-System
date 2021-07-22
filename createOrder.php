<?php
session_start();

if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{
	if(($_SESSION['sbelevelx'] == 'Manager') || ($_SESSION['sbelevelx'] == 'General Manager')){
		echo "<script> alert('You are not authorize this page'); window.location = 'home.php';</script>";
		//header("Location: home.php");
	}
}
?>
<style type="text/css">
/*	.textbox-text{
      margin: 0px;
    padding-top: 0px;
    padding-bottom: 0px;
    height: 29.0208px;
    line-height: 29.0208px;
    width: 394.021px;
    font-size: 20px;
    color: black;
    font-weight: bold;
}*/
</style>
<div class="page-header">
	<h1>
		Create Order
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Purchase Requisition
		</small>
	</h1>
</div><!-- /.page-header -->

<div class="row" style="background-color: #1596ff">
	<div class="col-xs-12">
		<div class="row">
			<div class="easyui-panel" title="Form Entry" style="width:100%;max-width:100%;height:'auto';padding:10px">
			<form id="fm" method="post" novalidate enctype="multipart/form-data" 
			form-data="style=background: #1791ff;color:white;">
			<table width="80%" style="margin: : 10px">
					<thead>						
						<th>Header Text</th>
						<th>Warehouse</th>
						<th>Document Date</th>
						<th>Required Date</th>
					</thead>
					<tbody>
						<td><input id="project" name="project" style="width:500px;color: black;font-size: 15px;" placeholder="Optional" data-options="prompt:'Optional'">
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
				<div>
					<table id="dg" title="PR Items" class="easyui-datagrid" style="width:100%;height:325px"
					        toolbar="#toolbar" fitColumns="false" singleSelect="true">
					    <thead>
					        <tr>
					        	<!-- <th field="item" width="20">Item</th> -->
					            <th field="itemcode" width="150">Item Code</th>
					            <th field="itmname" width="300">Item Name</th>
					            <th field="qty" width="120">Quantity</th>
					            <th field="unit" width="80">Unit</th>
					            <th field="price" width="120">Price</th>
					            <th field="curr" width="80">Currency</th>
					            <th field="subtot" width="120">Sub Total</th>
					            <th field="moq" width="50">MOQ</th>
					            <th field="spq" width="50">SPQ</th>
					            <th field="remark" width="350">Remark</th> 
					        </tr>
					    </thead>
					</table>
						<div id="toolbar">
						    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="NewItem('new')">Add New Item</a>
						    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="NewItem('edit')">Change PR Item</a>
						    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleterow()">Delete PR Item</a>
						</div>
					</div>
					
				</form><br>
				<div style="margin-bottom: 10px">							          
						<a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-ok'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="generateJSON()">Save</a>

					</div>
			</div>
			<div id="dd" class="ydialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" 
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
<!-- Form Add Item -->
			<div id="addItem" class="zdialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" 
			closable="true">
			<br><br>
				<table cellspacing="2" cellpadding="20px">
			
			<tr>
				<td style="width: 200px;"><h5 style="margin-left: 30px;">Item Code</td><td style="width: 20px">:</td>
				<td><input id="itemcode" name="itemcode" class="easyui-textbox" style="width:200px;" readonly required="true">
					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:100px; background: #2ecac4" onclick="cari()">Search</a></td>
				</tr>
				<tr>
					<td><h5 style="margin-left: 30px;">Item Name </td><td style="width: 20px">:</td>
					<td><input id="itmname" name="itmname" style="width:500px" class="easyui-textbox" required="true" readonly/></td>

				</tr>
				<tr>
					<td style="width: 100px"><h5 style="margin-left: 30px;">Required Qty </td><td>:</td>
					<td>
						
						<input id="qty" name="qty" style="width:200px" class="easyui-numberbox" required="true" data-options="min:0,precision:4,decimalSeparator:'.',groupSeparator:','"/>
					</td>
					<td><h5>Total </td><td style="width: 20px">:</td>
					<td><input id="total" name="total" style="width:200px" class="easyui-numberbox" value="0" readonly="true" data-options="min:0,precision:4,decimalSeparator:'.',groupSeparator:','"/></td>
				</tr>

				<tr>
					<td><h5 style="margin-left: 30px;">Unit</td><td>:</td>
					<td><input id="uom" name="uom" style="width:100px" class="easyui-textbox" placeholder="unit" ></td>
					<td style="width: 90px"><h5>MOQ</td><td>:</td>
					<td>
						<input id="moq" name="moq" style="width:200px" class="easyui-textbox" readonly="true">
					</td>
				</tr>
				<tr>
					<td><h5 style="margin-left: 30px;">Price </td><td>:</td>
					<td><input id="price" name="price" style="width:200px" class="easyui-numberbox" value="0" data-options="min:0,precision:4,decimalSeparator:'.',groupSeparator:','"></td>
					<td><h5>SPQ </td><td>:</td>
					<td>
						<input id="spq" name="spq" style="width:200px" class="easyui-textbox" readonly="true">
					</td>
				</tr>
				<tr>													
					<td><h5 style="margin-left: 30px;">Currency </td><td>:</td>
					<td >
						<select id="curr" class="easyui-dropdown" style="width: 200px" >
						</select>
					</td>	
				</tr>

			</table>

			<h5 style="margin-left: 30px;">Remark</h5>
			<div style="margin-bottom:20px; margin-left: 30px;">
				<textarea  type="text" id="remark" name="message" style="width:90%;height:100px;"></textarea>
			</div>
			<div style="margin-bottom: 10px;margin-left: 30px;">							            	
				<a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-add'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="addItem()">Add</a>
			</div>
			</div>
		<div id="smsg" class="xdialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" 
		closable="true" toolbar="#dlg-toolbar" buttons="#dlg-buttons">
	</div>

	<div id = "dlgMsg" class = "easyui-dialog" style = "width: 300px; height: 120px; padding: 10px 20px"
			closed = "true" buttons = "#dlgMsg-buttons" closable= "false">
			<form id = "fm" method = "post">
				
				<div class = "fitem">
					<label id="txtMsg" style="width: 150px"> </label>
				</div>
			</form>
			</div>
			<div id = "dlgMsg-buttons">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="closeMsgWindow()"> Ok </a>
			</div>
</div><!-- /.row -->
</div><!-- /.col -->
</div><!-- /.row -->


<script type="text/javascript">		


	var zcarnam;
	var zcarcode;
	var action;
	var rIndex;

	function clearForm(){
		$('#itemcode, #itmname, #uom, #dtu').textbox({
			value:''
		})
		$('#qty, #price, #total, #moq, #spq').numberbox({
			value:''
		})
		$('#remark').val("");
		$('#curr').val("");
	}

	function deleterow(){
		var row = $('#dg').datagrid('getSelected');					
		var rowIndex = $("#dg").datagrid("getRowIndex", row);

		var index = rowIndex+1;
		$.messager.confirm('Confirm','Are you sure to delete PR item '+ index +' ?',function(r){
			if (r){
				$('#dg').datagrid('deleteRow', rowIndex);
			}
		});
	}

	function generateJSON(){
		var prNumb;
		var djson = {};
		var jsonTemp = {};
		var dataH = [];
		var data = [];
		var rows = $('#dg').datagrid('getRows');
		
		$.ajax({
			type:'POST',
			url:'action/getNextNR.php',
			dataType: "json",
			data:'',
			cache:false,
			success:function(results){
				prNumb = results[0].prNumb;
				djson.prNumb = prNumb
				djson.project = $("#project").attr("value") 
				djson.wrhs = $("#wrhs").attr("value")
				djson.dcdate = $("#dcdate").attr("value")
				djson.rqdate = $("#rqdate").attr("value") 
				dataH.push(djson);
				$.ajax({
					type:'POST',
					url:'action/inserPRHeader.php',
					dataType: "json",
					data:djson,
					cache:false,
					success:function(results){

					}
				});

				for(var i=0; i<rows.length; i++){
					jsonTemp.prNumb = prNumb
					jsonTemp.prItem = i + 1
					jsonTemp.ItemCode = rows[i].itemcode
					jsonTemp.ItemName = rows[i].itmname
					jsonTemp.qty = rows[i].qty
					jsonTemp.uom = rows[i].unit 
					jsonTemp.price = rows[i].price 
					jsonTemp.curr = rows[i].curr
					jsonTemp.total = rows[i].subtot
					jsonTemp.spq = rows[i].spq
					jsonTemp.moq = rows[i].moq
					jsonTemp.remark = rows[i].remark
					data.push(jsonTemp);
					// alert(JSON.stringify(data))
					$.ajax({
						type:'POST',
						url:'action/insertPR.php',
						dataType: "json",
						data:jsonTemp,
						cache:false,
						success:function(results){
						}
					}); 
				}

				document.getElementById("smsg").innerHTML = "<center><br><h3>Order " + prNumb + " Created</h3></center>";
				$('#smsg').dialog({
					title: 'Information',
					width: 400,
					height: 200,
					closed: false,
					cache: false,
					modal: true,
					buttons:[{
						text:'Ok',
						iconCls:'icon-ok',
						width:'60px',
						handler:function(){
							$('#smsg').dialog('close');
							window.location = "home.php?modul=create";
						}

					}]
				});
			}
		}); 	
		
	}

	$('#qty, #price').numberbox({
		"onChange":function(){  
			var a = $("#qty").attr("value");
			var b = $("#price").attr("value");
			var c = a * b;
			// alert(c);
			$('#total').numberbox({
				value:c
			});
		}  
	});

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
						{field:'ItmsGrpNam',title:'Item Group',width:150},
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
					{field:'ItmsGrpNam',title:'Item Group',width:150},
					{field:'itemcode',title:'Item ID',width:150},
					{field:'ItemName',title:'namaitem',width:470,editor:'text'},
					{field:'BaseUnit',title:'satuan',width:80,editor:'text'},					
					]],
				});
			});
		}
	});

	function NewItem(param){

		if(param == "new"){
			action = '';
			clearForm();
			$('#addItem').dialog({
				title: 'Add PR Item',
				width: '80%',
				height: 500,
				padding:'20px',
				closed: false,
				cache: false,
				modal: true
			});
		}else{
			var row = $('#dg').datagrid('getSelected');	

			rIndex = $("#dg").datagrid("getRowIndex", row);
			if(rIndex == "-1"){
				alert('Pilih PR Item');
			}else{
				// alert(rowIndex);	
				action = 'X';
				clearForm();
				console.log(row.itemcode);
				$('#itemcode').textbox({
						iconAlign:'left',
						value:row.itemcode
					})

					$('#itmname').textbox({
						iconAlign:'left',
						value:row.itmname
					})

				$('#qty').numberbox({
						iconAlign:'left',
						value:row.qty
					})

					$('#uom').textbox({
						iconAlign:'left',
						value:row.unit
					})
					$('#price').numberbox({
						iconAlign:'left',
						value:row.price
					})

					$('#total').numberbox({
						iconAlign:'left',
						value:row.subtot
					})

					$('#moq').numberbox({
						iconAlign:'left',
						value:row.moq
					})

					$('#spq').numberbox({
						iconAlign:'left',
						value:row.spq
					})

					$('#remark').val(row.remark);
					$('#curr').val(row.curr);

				$('#addItem').dialog({
					title: 'Edit PR Item',
					width: '80%',
					height: 500,
					padding:'20px',
					closed: false,
					cache: false,
					modal: true
				});
			}
		}		
	}

	function doeditRow(rowIndex) {

		$('#dg').datagrid('updateRow', {
			index: rowIndex,
			row: {
				itemcode        : $("#itemcode").attr("value"), 
				itmname         : $("#itmname").attr("value"),
				qty 			   : $("#qty").attr("value"),
				unit : $("#uom").attr("value"),
				price : $("#price").attr("value"),
				curr : $("#curr").attr("value"), 
				subtot : $("#total").attr("value"),
				moq : $("#moq").attr("value"),
				spq : $("#spq").attr("value"),
				// dtunit :$("#dtu").attr("value"),
				remark : $("#remark").attr("value"),
				prNumb	: ''
			}
		});
	}

	function test(){
		var src = [
           {"year" : 2015, "month" : "JAN", "value" : 0, "desc" : "tess1"},
           {"year" : 2015, "month" : "FEB", "value" : 0, "desc" : "tess2"},
           {"year" : 2015, "month" : "MAR", "value" : 0, "desc" : "tess3"},
           {"year" : 2014, "month" : "JAN", "value" : 0, "desc" : "tess4"},
           {"year" : 2014, "month" : "FEB", "value" : 0, "desc" : "tess5"},
           {"year" : 2014, "month" : "MAR", "value" : 0, "desc" : "tess6"}
         ];
         	console.log(src);
			var newRecord = {
			"year": 2015,
			"month": "FEB",
			"value": 2.33,
			"desc": "bejo"
			};

			function updateJSON(src, newRecord) {
			return src.map(function(item) {
			  return (item.year === newRecord.year && item.month === newRecord.month) ? newRecord : item;
			});
			}
			src = updateJSON(src, newRecord);
			console.log(src);
	}

	function windowMessage(msg){
		// $("#txtMsg").val('PR Approved');
		$("#txtMsg").html(msg);
		$('#dlgMsg').dialog('open').dialog('setTitle','Warning...!!!');
	}

	function closeMsgWindow(){
		$('#dlgMsg').dialog('close');
		// window.location = "home.php?modul=openPR";
	}

	function addItem(){
		var valdQty = $("#qty").attr("value");
		var itemcode        = $("#itemcode").attr("value");
		// alert(valdQty);
		if(itemcode == ""){
			windowMessage("Input ItemCode")
		}else if(valdQty == ""){
			windowMessage("Input Quantity")
		}else{
			if (action =="X"){

				doeditRow(rIndex);
			}else{
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
					// dtunit :$("#dtu").attr("value"),
					remark : $("#remark").attr("value")
				});
			}

			$('#dg').datagrid('reload'); 
			$('#addItem').dialog('close');
		}
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
				width:'95%',
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
					$('#price').textbox({
									value:''
								})
					var row = $("#igr").datagrid("getSelected");

					vitemcode = row.itemcode;
					vitemname = row.ItemName;

					getCurrency(vitemcode);

					vuom = row.BaseUnit;
					$('#itemcode').textbox({
						iconAlign:'left',
						value:vitemcode
					})

					if(vitemname == "." || vitemname == "-"){
						$('#itmname').textbox({
						iconAlign:'left',
						readonly:false,
						value:vitemname
					})
					}else{
						$('#itmname').textbox({
						iconAlign:'left',
						readonly:true,
						value:vitemname
					})
					}

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


	$(document).ready(function () {	
		$('#dcdate').datebox({
			readonly:true,
			formatter: function(date) {
				var y = date.getFullYear();
				var m = date.getMonth() + 1;
				var d = date.getDate();

				var r = y + '-' + m + '-' + d;
				return r;
			},

			parser: function(s) {
				if (!s) {
					return new Date();
				}
				var ss = (s.split('-'));
				var y = parseInt(ss[0], 10);
				var m = parseInt(ss[1], 10);
				var d = parseInt(ss[2], 10);

				if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
					return new Date(y, m - 1, d);
				} else {
					return new Date();
				}
			}
		});
		var opts = $('#dcdate').datebox('options');
		$('#dcdate').datebox('setValue', opts.formatter(new Date()));
	});	

	$(document).ready(function () {	
		$('#rqdate').datebox({
			formatter: function(date) {
				var y = date.getFullYear();
				var m = date.getMonth() + 1;
				var d = date.getDate();

				var r = y + '-' + m + '-' + d;
				return r;
			},

			parser: function(s) {
				if (!s) {
					return new Date();
				}
				var ss = (s.split('-'));
				var y = parseInt(ss[0], 10);
				var m = parseInt(ss[1], 10);
				var d = parseInt(ss[2], 10);

				if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
					return new Date(y, m - 1, d);
				} else {
					return new Date();
				}
			}
		});
		var opts = $('#rqdate').datebox('options');
		$('#rqdate').datebox('setValue', opts.formatter(new Date()));
	});	

	var jsonData = {};
	$(document).ready(function(e){
		var suid = ("<?php echo $_SESSION['sbeuidx']?>");
		$.ajax({
			type:'POST',
			url:'action/getWarehouse.php',
			dataType: "json",
			data:{user_id:suid},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					var listItems;
					for (var i = 0; i < count; i++) {
						listItems += "<option value='" + results[i].whs_code + "'>" + results[i].WhsName + "</option>";
					};
					$("#wrhs").html(listItems);
				});
			}
		});
	});

	$(document).ready(function(e){
		$.ajax({
			type:'POST',
			url:'action/maxID.php',
			dataType: "json",
			data:{action:'getid'},
			cache:false,
			success:function(results){
				var count = results.length;
				$('#nomor').textbox({
					iconAlign:'left',
					value:results[0].docNum
				})
			}
		});
	});

	$('#remark').css('font-size', '14px');

	var xind;

	function getCurrency(param){
		$(document).ready(function(e){
		
		$.ajax({
			type:'POST',
			url:'action/getCurrency.php',
			dataType: "json",
			data:{ItemCode:param},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					var listItems;
					for (var i = 0; i < count; i++) {
						listItems += "<option value='" + results[i].Currency + "'>" + results[i].Currency + "</option>";
					};
					$("#curr").html(listItems);
				});
			}
		});
	});
	}

	function insert(){

		if(xind == "1"){
			$('#smsg').dialog('close');
			window.location = "createOrder.php";
		}else{
			$('#fm').form('submit',{

				onSubmit: function(){
					return $(this).form('validate');
				}
			});

			if($("#qty").attr("value") < $("#moq").attr("value")){
				$.messager.show({    
					title: 'Error',
					msg: 'Qty Order must >= Mininum Qty Order'
				});
			}else{
				$(document).ready(function(e){
					

					var insert_data = {
						
						project : $("#project").attr("value"),
						itemcode : $("#itemcode").attr("value"),
						itmname : $("#itmname").attr("value"),
						uom : $("#uom").attr("value"), 
						wrhs : $("#wrhs").attr("value"), 
						dcdate : $("#dcdate").attr("value"), 
						rqdate : $("#rqdate").attr("value"), 
						qty : $("#qty").attr("value"), 
						price : $("#price").attr("value"), 
						curr : $("#curr").attr("value"), 
						total : $("#total").attr("value"),
						moq : $("#moq").attr("value"), 
						spq : $("#spq").attr("value"),
						remark : $("#remark").attr("value"),
					};

					$.ajax({
						type:'POST',
						url:'action/insert.php',
						dataType: "json",
						data:insert_data,
						cache:false,
						success:function(results){
									// alert(results[0].docNum);
									if (results[0].docNum !== "") {
										xind = "1";
										document.getElementById("smsg").innerHTML = "<center><br><h3>Order " + results[0].docNum + " Created</h3></center>";
										$('#smsg').dialog({
											title: 'Information',
											width: 400,
											height: 200,
											closed: false,
											cache: false,
											modal: true,
											buttons:[{
												text:'Ok',
												iconCls:'icon-ok',
												width:'60px',
												handler:function(){
													$('#smsg').dialog('close');
													window.location = "home.php?modul=create";
												}

											}]
										});
									}else{
										alert(results)
									}
								}
							}); 
				});

			}
		}
	};



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
