<?php
session_start();

if (!isset($_SESSION['sbeusernamex']) && !isset($_SESSION['sbelevelx'])){
	header("Location: index.php");
}else{

}
?>
<script type="text/javascript" src="https://raw.githubusercontent.com/openexchangerates/accounting.js/master/accounting.js"></script>
<script type="text/javascript" src="https://raw.githubusercontent.com/openexchangerates/accounting.js/master/accounting.min.js"></script>
<div class="page-header">
	<h1>
		History Orders
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			display
		</small>
	</h1>
</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<td>
				<input id="strdate" name="strdate" style="width:150px" class="easyui-datebox">
			</td>
			<td>
				<input id="enddate" name="enddate" style="width:150px" class="easyui-datebox">
			</td>
			<td>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:200px; background: #2ecac4" onclick="readData()">Display Data</a>
			</td><br>
			<table id="tt"></table>
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
<script>

	$(document).ready(function () {	
		$('#strdate').datebox({
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
		var opts = $('#strdate').datebox('options');
		$('#strdate').datebox('setValue', opts.formatter(new Date()));
	});	

	$(document).ready(function () {	
		$('#enddate').datebox({
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
		var opts = $('#enddate').datebox('options');
		$('#enddate').datebox('setValue', opts.formatter(new Date()));
	});	

	var sesseion = ("<?php echo $_SESSION['sbelevelx']?>");
	var suname = ("<?php echo $_SESSION['sbeusernamex']?>");
	var suid = ("<?php echo $_SESSION['sbeuidx']?>");		


	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
    	dd = '0'+dd
	} 

	if(mm<10) {
	    mm = '0'+mm
	} 

	today = yyyy + '-' + mm + '-' + dd;
	// alert(today);
	
	function readData(){
		// $('#tt').datagrid('reload');
		// $('#tt').datagrid('reload');  
		var strdate; 
		var enddate;
		if($("#strdate").attr("value") === ""){
			strdate = today; 
		}else{
			strdate = $("#strdate").attr("value"); 	
		}
		
		if($("#enddate").attr("value") === ""){
			enddate = today;
		}else{
			enddate = $("#enddate").attr("value");
		}
		
		var z = new Date(strdate);
		var y = new Date(enddate);
		// alert(enddate + ' ' + strdate);
		if(z > y){
			alert('Enddate must be grather than stardate');
			setStrDate();
		}else{
			if (sesseion == "Manager" || sesseion == "General Manager"){
				$(function(){
					var date = new Date();
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var suname = ("<?php echo $_SESSION['sbelevelx']?>");
					var r = y + '-' + m + '-' + d;
					var url = 'action/listOrders_2.php?created_by='+sesseion+'&uid='+suid+'&all=X&strdate='+strdate+'&enddate='+enddate;
					
					$('#tt').datagrid({
						title:'History Purchase Requisition',
						width:'100%',
						height:500,
						singleSelect:true,
						resizable:true,
						fitColumns:false,
						pagination:true,
						striped:true, 

						pageList:[50,100,150,200],
						idField:'docNum',
						url:url,
						columns:[[
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
				{field:'docNum',title:'PR Number',width:80},
				{field:'docItem',title:'Item',width:80},
				{field:'project_name',title:'Project',width:150,editor:'text',nowrap:false},
				{field:'ItemCode',title:'Item Code',width:140,editor:'text',nowrap:false},
				{field:'ItemName',title:'Item Name',width:300,editor:'text',nowrap:false},
				{field:'created_by',title:'Created By',width:80,editor:'text'},
				{field:'created_date',title:'Created Date',width:80,editor:'text'},
				{field:'required_date',title:'Required Date',width:100,editor:'text'},
				{field:'Qty',title:'Required Qty',width:120,editor:'numberbox'},
				{field:'Unit',title:'Unit',width:60,editor:'text'},
				{field:'Price',title:'Price',width:120,editor:'numberbox'},
				{field:'Currency',title:'Currency',width:60,editor:'text'},
				{field:'Total',title:'Total',width:120,editor:'text'},
				{field:'remark',title:'remark',width:400,editor:'text'}
						]],				
					});

					$(function(){
						var dg = $('#tt').datagrid({

						});
						dg.datagrid('enableFilter', [{
							field:'docStatus',
							type:'combobox',
							options:{
								panelHeight:'auto',
								data:[{value:'',text:'All'},{value:'Open',text:'Open'},{value:'Approved Manager',text:'Approved Manager'},
								{value:'Approved GM',text:'Approved GM'},{value:'Rejected',text:'Rejected'},{value:'Void',text:'Void'},{value:'Closed',text:'Closed'}
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
				});
			}else{
				$(function(){
					var date = new Date();
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var suname = ("<?php echo $_SESSION['sbelevelx']?>");
					var r = y + '-' + m + '-' + d;
					var url = 'action/listOrders_2.php?created_by='+sesseion+'&uid='+suid+'&all=X&strdate='+strdate+'&enddate='+enddate;

					$('#tt').datagrid({

						view: detailview,
						detailFormatter:function(index,row){
							return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
						},
						onExpandRow: function(index,row){
							$('#ddv-'+index).panel({
								border:true,
								cache:false,
								href:'action/getItem.php?docNum='+row.docNum+'&ind=X',

								onLoad:function(){
									$('#tt').datagrid('fixDetailRowHeight',index);
								}
							});
							$('#tt').datagrid('fixDetailRowHeight',index);
						},
						title:'History Purchase Requisition',
						width:'100%',
						height:500,
						singleSelect:true,
						resizable:true,
						fitColumns:true,
						pagination:true,
						striped:true, 

						pageList:[50,100,150,200],
						idField:'docNum',
						url:url,
						columns:[[
						{field:'docNum',title:'Order Num',width:90},
						{field:'project_name',title:'Project',width:150,editor:'text',nowrap:true},
						{field:'created_by',title:'Created By',width:80,editor:'text'},
						{field:'created_date',title:'Created Date',width:80,editor:'text'},
						{field:'required_date',title:'Required Date',width:100,editor:'text'},
						]],				
					});

					$(function(){
						var dg = $('#tt').datagrid({

						});
						dg.datagrid('enableFilter', [{
							field:'docStatus',
							type:'combobox',
							options:{
								panelHeight:'auto',
								data:[{value:'',text:'All'},{value:'Open',text:'Open'},{value:'Approved Manager',text:'Approved Manager'},
								{value:'Approved GM',text:'Approved GM'},{value:'Rejected',text:'Rejected'},{value:'Void',text:'Void'},{value:'Closed',text:'Closed'}
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
				});
			}
		}
	};

	function readData2(){
		// $('#tt').datagrid('reload');
		// $('#tt').datagrid('reload');  
		var strdate; 
		var enddate;
		if($("#strdate").attr("value") === ""){
			strdate = today; 
		}else{
			strdate = $("#strdate").attr("value"); 	
		}
		
		if($("#enddate").attr("value") === ""){
			enddate = today;
		}else{
			enddate = $("#enddate").attr("value");
		}
		
		var z = new Date(strdate);
		var y = new Date(enddate);
		// alert(enddate + ' ' + strdate);
		if(z > y){
			alert('Enddate must be grather than stardate');
			setStrDate();
		}else{
			$(function(){
				var date = new Date();
				var y = date.getFullYear();
				var m = date.getMonth() + 1;
				var d = date.getDate();
				var suname = ("<?php echo $_SESSION['sbelevelx']?>");
				var r = y + '-' + m + '-' + d;
				var url = 'action/listOrders_2.php?created_by='+sesseion+'&uid='+suid+'&all=X&strdate='+strdate+'&enddate='+enddate;
				// alert(url);
				$('#tt').datagrid({

					view: detailview,
					detailFormatter:function(index,row){
						return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
					},
					onExpandRow: function(index,row){
						$('#ddv-'+index).panel({
							border:true,
							cache:false,
							href:'action/getItem.php?docNum='+row.docNum+'&ind=X',

							onLoad:function(){
								$('#tt').datagrid('fixDetailRowHeight',index);
							}
						});
						$('#tt').datagrid('fixDetailRowHeight',index);
					},
					title:'History Purchase Requisition',
					width:'100%',
					height:430,
					singleSelect:true,
					resizable:true,
					fitColumns:true,
					pagination:true,
					striped:true, 

					pageList:[20,50,100,150,200],
					idField:'docNum',
					url:url,
					columns:[[
						{field:'docNum',title:'Order Num',width:90},
						{field:'project_name',title:'Project',width:150,editor:'text',nowrap:true},
						{field:'created_by',title:'Created By',width:80,editor:'text'},
						{field:'created_date',title:'Created Date',width:80,editor:'text'},
						{field:'required_date',title:'Required Date',width:100,editor:'text'},
					]],				
				});

				$(function(){
					var dg = $('#tt').datagrid({

					});
					// dg.datagrid('doFilter');
					dg.datagrid('enableFilter', [{
						field:'docStatus',
						type:'combobox',
						options:{
							panelHeight:'auto',
							data:[{value:'',text:'All'},{value:'Open',text:'Open'},{value:'Approved Manager',text:'Approved Manager'},
							{value:'Approved GM',text:'Approved GM'},{value:'Rejected',text:'Rejected'},{value:'Void',text:'Void'},{value:'Closed',text:'Closed'}
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
			});
		}
	};

	function setStrDate(){
		$(document).ready(function () {	
			$('#enddate').datebox({
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
			var opts = $('#enddate').datebox('options');
			$('#enddate').datebox('setValue', opts.formatter(new Date()));
		});	
	}

	
	this.readData();

</script>


