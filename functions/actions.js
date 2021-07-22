<script type="text/javascript">		


	function cari(){

		$('#dd').dialog({
			title: 'List Item',
			width: 900,
			height: 500,
			closed: false,
			cache: false,
			modal: true
		});
	}

	$(function(){
		$('#igr').datagrid({	
			title:'',
			width:'85%',
			height:495,
			singleSelect:true,
			pagination:false,
			idField:'itemcode',
			url:'action/getDataFilter.php',
			columns:[[
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

				$('#dd').dialog('close');
			}
		});
		dg.datagrid('enableFilter', [{

		}]);
	});		

	$(document).ready(function () {	
		$('#dcdate').datebox({
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
		$.ajax({
			type:'POST',
			url:'action/getWarehouse.php',
			dataType: "json",
			data:{user_id:'bejo'},
			cache:false,
			success:function(results){
				var count = results.length;

				var djson = JSON.stringify(results);

				$(document).ready(function () {
					var listItems = '<option selected="selected" value="0">------ Select Warehouse ------</option>';
					for (var i = 0; i < count; i++) {
						listItems += "<option value='" + results[i].whs_code + "'>" + results[i].whs_code + "</option>";
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

	function insert(){
		$('#fm').form('submit',{

			onSubmit: function(){
				return $(this).form('validate');
			}
		});

		var insert_data = {
			nomor : $("#nomor").attr("value"),
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
			total : '', 
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
				if (results == "sukses") {
					document.getElementById("smsg").innerHTML = "<center><br><h3>Order " + $("#nomor").attr("value") + " Created</h3></center>";
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
								window.location = "createOrder.php";
							}

						}]
					});
				}else{
					alert(results)
				}
			}
		});    

	};

</script>