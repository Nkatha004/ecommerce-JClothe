<?php
	use App\Models\RolesModel;

	$id = $_GET['id'];
	$sql_select = "SELECT * FROM tbl_roles WHERE role_id = $id";
	$model = new RolesModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){
		foreach ($results as $row) {
			$role_id = $row->role_id;
			$role_name = $row->role_name;
		}
	}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>
<style>
    .error{
    	color:  red;
    	display: block;
    }
</style>

<form id = "edit_role" style = "color: #000000"class = "register reg" method = "post">
	<h3>Edit Role Information</h3>
	<fieldset>
		<p id = 'success' class = 'alert-success'></p>
		<p id = 'feedback' class = 'alert-danger'></p>
		<label>Role ID: </label><br><br>
		<input id = 'role_id' type="text" name="role_id" autocomplete="off" value = <?php echo $role_id?>>
		<br><br>

		<label>Role Name: </label><br><br>
		<input id = 'role_name' type="text" name="role_name" autocomplete="off" value = <?php echo $role_name?>><br><br>

		<button style = "width: 30%"id = 'save' name = 'save'>Save Changes</button>
				
	</fieldset>
</form>	
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#save', function(form){
			form.preventDefault();
			var msg = '';
			var name = $('#role_name').val();
			var id = $('#role_id').val();
			
			$.ajax({
				
				url: "/clothes/save_role_edits",
				type: "POST",
				data: {role_name: name, role_id:id},
				
				success:function(response){
					
					if(response == 1){
						msg = "Successful";
						$("#success").html(msg);
						
					}else{
						msg = "Not successful";
						$("#feedback").html(msg);
					}
				
				},
				error:function(req, textStatus, errorThrown){
					msg = "Not successful";
					$("#feedback").html(msg);
				}
			
			});
			
		});
	});
	
</script>