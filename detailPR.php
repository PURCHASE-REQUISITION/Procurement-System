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

<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<table id="tt"></table>
		</div><!-- /.col -->
	</div>
</div>

<script>

	var docNum = ("<?php echo $_GET['docNum']?>");
	// alert(docNum);

	$(function(){
		var url = 'action/getItem.php?docNum='+docNum;	
		$('#tt').datagrid({			
			width:'90%',
			height:200,
			singleSelect:true,
			resizable:true,
			fitColumns:true,
			// pagination:true,
			pageList:[20,50,100,150,200],
			idField:'docNum',
			url:url,
			columns:[[
			{field:'z',title:'',width:5},
			{field:'docNum',title:'Order Num',width:60},
			{field:'docItem',title:'Item',width:60},
			{field:'ItemCode',title:'Item Code',width:100,editor:'text',nowrap:false},
			{field:'ItemName',title:'Item Name',width:200,editor:'text',nowrap:true},
			// {field:'created_by',title:'Created By',width:80,editor:'text'},
			// {field:'create_date',title:'Created Date',width:80,editor:'text'},
			// {field:'required_date',title:'Required Date',width:100,editor:'text'},					
			// {field:'Qty',title:'Required Qty',width:70,editor:'text'},
			// {field:'Unit',title:'Unit',width:50,editor:'text'},
			// {field:'price',title:'Price',width:70,editor:'text'},
			// {field:'Currency',title:'Currency',width:50,editor:'text'},
			// {field:'Total',title:'Total',width:50,editor:'text'},
			// {field:'docStatus',title:'Status',width:80,align:'center',editor:'text',
			// 	styler: function(value,row,index){
			// 		if (row.status == "0" || row.status == "9") {
			// 			return 'background-color:#ffee00;color:black;font-weight: bold;';
			// 		}else if (row.status == "1") {
			// 			return 'background-color:#3ea5ef;color:black;font-weight: bold;';
			// 		}else if (row.status == "2") {
			// 			return 'background-color:#87a9dc;color:white;font-weight: bold;';
			// 		}else if (row.status == "3") {
			// 			return 'background-color:#c57530;color:white;font-weight: bold;';
			// 		}else if (row.status == "4") {
			// 			return 'background-color:green;color:white;font-weight: bold;';
			// 		}else if (row.status == "8") {
			// 			return 'background-color:red;color:white;font-weight: bold;';
			// 		}
			// 	}
			// },
			// {field:'Action1',title:'',width:60,align:'center',
			// 	formatter:function(value,row,index){
			// 	var a = '<a href="javascript:void(0)" onclick="edit(this)">Edit</a>';
			// 	return a;
			// 	}
			// 	,
			// 	styler: function(value,row,index){
			// 		return 'background-color:white;color:black;';
			// 	}
			// },
			// {field:'Action2',title:'',width:60,align:'center',
			// 	formatter:function(value,row,index){
			// 		var a = '<a href="javascript:void(0)" onclick="destroy(this)">Delete</a>';
			// 		return a;
			// 	},
			// 	styler: function(value,row,index){
			// 		return 'background-color:white;color:blue;';
			// 	}
			// },
			// {field:'Action3',title:'',width:60,align:'center',
			// 	formatter:function(value,row,index){
			// 		var a = '<a href="javascript:void(0)" onclick="confirm(this)">Confirm</a>';
			// 		return a;
			// 	},
			// 	styler: function(value,row,index){
			// 		return 'background-color:white;color:blue;';
			// 	}
			// }
			]],				
		});
	});

	
	function edit(target){
		var tr = $(target).closest('tr.datagrid-row');
		var x = (tr.attr('datagrid-row-index'));
		var v=$('#tt').datagrid('getRows')[x].docNum;
		$('#oeNum').textbox({
			iconAlign:'left',
			readonly:true,
			value:v
		})
		$.ajax({
			type:'POST',
			url:'action/getEditData.php',
			dataType: "json",
			data:{DocNum:v},
			cache:false,
			success:function(data){
				if (data[0].docStatus == "0" || data[0].docStatus == "9"){
					$('#oeItemCode').textbox({
						iconAlign:'left',
						readonly:true,
						value:data[0].ItemCode
					})

					$('#prjNm').textbox({
						iconAlign:'left',
						readonly:false,
						value:data[0].project_name
					})	

					$('#desc').textbox({
						iconAlign:'left',
						readonly:true,
						value:data[0].ItemName
					})	

					$('#eQty').textbox({
						iconAlign:'left',
						readonly:false,
						value:data[0].Qty

					})

					$('#eUnit').textbox({
						iconAlign:'left',
						readonly:true,
						value:data[0].Unit
					})

					$('#ePrice').numberbox({
						iconAlign:'left',
						readonly:false,
						value:data[0].Price
					})

					$('#eTotal').numberbox({
						iconAlign:'left',
						readonly:true,
						value:data[0].Total
					})

					$('#eCurr').textbox({
						iconAlign:'left',
						readonly:false,
						value:data[0].Currency
					})

					$('#eRemark').val(data[0].remark);

					$('#dgreset').dialog('open').dialog('setTitle','Edit Order');

				}else{
					$.messager.show({    
						title: 'Warning',
						msg: 'You cannot change order, this order already confirm or approved'
					});
				}

			}
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
		$.messager.confirm('Confirm','Are you sure you want to delete order'+ v +' ?',function(r){
			if (r){
				$.ajax({
					type:'POST',
					url:'action/getEditData.php',
					dataType: "json",
					data:{DocNum:v},
					cache:false,
					success:function(data){
						if (data[0].docStatus == "1" || data[0].docStatus == "2" || data[0].docStatus == "3" || data[0].docStatus == "4"){
									$.messager.show({    // show error message
										title: 'Warning',
										msg: 'You cannot delete order, this order already confirm or approved'
									});
									
								}else{
									$.ajax({
										type:'POST',
										url:'action/confirmOrder.php',
										dataType: "json",
										data:updateData,
										cache:false,
										success:function(results){
											if (results == "sukses") {
												$('#dgreset').dialog('close').dialog();
												$.messager.show({    // show error message
													title: 'Information',
													msg: 'Order '+ v +' deleted'
												});
												$('#tt').datagrid('reload'); 
												//window.location = "orderList.php";
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
		$.messager.confirm('Confirm','Are you sure you want to confirm order'+ v +' ?',function(r){
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
								type:'POST',
								url:'action/confirmOrder.php',
								dataType: "json",
								data:updateData,
								cache:false,
								success:function(results){
									if (results == "sukses") {
										$('#dgreset').dialog('close').dialog();
										$.messager.show({    // show error message
											title: 'Information',
											msg: 'Order '+ v +' confirmed'
										});
										$('#tt').datagrid('reload'); 
										sendEmail(v);
									}else{
										alert(results)
									}
								}
							}); 

						}else{
							$.messager.show({   
								title: 'Warning',
								msg: 'You cannot confirm order, this order already confirm or approved'
							});
							
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

</script>
