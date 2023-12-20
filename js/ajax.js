$(document).ready(function(){	
	var empRecords = $('#empList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"process.php",
			type:"POST",
			data:{action:'listEmp'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 6, 7],
				"orderable":false,
			},
		],
		"pageLength": 10
	});		
	$('#addEmp').click(function(){
		$('#empModal').modal('show');
		$('#empForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Employee");
		$('#action').val('addEmp');
		$('#save').val('Add');
	});		
	$("#empList").on('click', '.update', function(){
		var empId = $(this).attr("id");
		var action = 'getEmp';
		$.ajax({
			url:'process.php',
			method:"POST",
			data:{empId:empId, action:action},
			dataType:"json",
			success:function(data){
				$('#empModal').modal('show');
				$('#empId').val(data.id);
				$('#empName').val(data.name);
				$('#empAge').val(data.age);
				$('#empSkills').val(data.skills);				
				$('#address').val(data.address);
				$('#designation').val(data.designation);	
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Employee");
				$('#action').val('updateEmp');
				$('#save').val('Save');
			}
		})
	});
	$("#empModal").on('submit','#empForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"process.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#empForm')[0].reset();
				$('#empModal').modal('hide');				
				$('#save').attr('disabled', false);
				empRecords.ajax.reload();
			}
		})
	});		
	$("#empList").on('click', '.delete', function(){
		var empId = $(this).attr("id");		
		var action = "deleteEmp";
		if(confirm("Are you sure you want to delete this employee?")) {
			$.ajax({
				url:"process.php",
				method:"POST",
				data:{empId:empId, action:action},
				success:function(data) {					
					empRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
});