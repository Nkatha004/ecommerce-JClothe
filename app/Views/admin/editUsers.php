<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>
<style>
    .error{
    	color:  red;
    	display: block;
    }
</style>
<?php
	use App\Models\UserModel;
	use App\Models\RolesModel;
	
	$email = $_GET['id'] ?? null;
	$sql_select = "SELECT * FROM tbl_users WHERE email = '$email'";
	$model = new UserModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){
		$sql_select_role = "SELECT * FROM tbl_roles";
		$model_role = new RolesModel();
		$query_role = $model_role->query($sql_select_role);

		if($results_role = $query_role->getResult()){
			foreach ($results as $row) {
				$email = $row->email;
				$firstName = $row->first_name;
				$lastName = $row->last_name;
				$gender = $row->gender;
			}?>
			<form id = "registration_form" style = "color: #000000"class = "register reg" method = "post">
				<h3>Edit User Information</h3>
				<fieldset>
					<p id = 'feedback' class = 'alert-danger'></p>
					<p id = 'success' class = 'alert-success'></p>
					<label>First Name: </label><br><br>
					<input id = 'fname' type="text" name="fname" autocomplete="off" value = <?php echo $firstName?>>
					<br><br>

					<label>Last Name: </label><br><br>
					<input id = 'lname' type="text" name="lname" autocomplete="off" value = <?php echo $lastName?>><br><br>
	
					<label>Email: </label><br><br>
					<input id = 'email' type="email" name="email" autocomplete="off" value = <?php echo $email?>><br><br>
					<label>Password: </label><br><br>
					<input id = 'password' type="password" name="password" autocomplete="off" ><br><br>

					<label>Role: </label><br><br>
					<select name="role">
					<?php foreach($results_role as $row_role){?>
						<option value = <?php echo $row_role->role_id?>><?php echo $row_role->role_name;?></option>
					<?php }?>
					</select><br><br>

					<label>Gender: </label><br>

					<input type="radio" name="gender" value = "male">
					<label>Male</label><br>

					<input type="radio" name="gender" value = "female">
					<label>Female</label><br>

					<button style = "width: 30%"id = 'save' name = 'save'>Save Changes</button>
								
				</fieldset>
			</form>	
			<script type="text/javascript">
				$(document).ready(function(){
					$(document).on('click','#save', function(form){
						form.preventDefault();
						var msg = '';
						
						$.ajax({
							
							url: "/clothes/save_user_edits",
							type: "POST",
							data: $('#registration_form').serialize(),
							
							success:function(data){
								if(data == 1){
									msg = "Successful";
									$("#success").html(msg);
									document.getElementById('registration_form').reset();
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
			<?php
		}		
	}
?>
		

