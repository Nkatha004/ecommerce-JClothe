<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<style>
	.error{
		color:  red;
		display: block;
	}
</style>
<main>
	
	<form id = "registration_form" style = "color: #000000"class = "register reg" method = "post">
		<h3>Register New Admin</h3>
		
		<fieldset>
			<h5 id = 'success' class ='alert-success'></h5>
			<h5 id = 'feedback' class ='alert-danger'></h5>
			<label>First Name: </label><br><br>
			<input id = 'fname' type="text" name="fname" autocomplete="off" autofocus ><span class = 'error' id = 'fname_error'></span><br>

			<label>Last Name: </label><br><br>
			<input id = 'lname' type="text" name="lname" autocomplete="off" >
			<span class = 'error' id = 'lname_error'></span><br>

			<label>Email: </label><br><br>
			<input id = 'email' type="email" name="email" autocomplete="off" >
			<span class = 'error' id = 'email_error'></span><br>

			<label>Password: </label><br><br>
			<input id = 'password' type="password" name="password" autocomplete="off" >
			<span class = 'error' id = 'password_error'></span><br>

			<label>Gender: </label><br>

			<input type="radio" name="gender" value = "male">
			<label>Male</label><br>

			<input type="radio" name="gender" value = "female">
			<label>Female</label><br><br>
			<span class = 'error' id = 'gender_error'></span>


			<?php 
			use App\Models\RolesModel;
			$sql = "SELECT role_id FROM tbl_roles WHERE role_name = 'Admin'";
			$model = new RolesModel();
			$query = $model->query($sql);
			if($result = $query->getResult())
			{
				foreach($result as $row)
				{
					$id = $row->role_id;
				}
			}
			?>
			<label>Role</label>
			<select name = 'role'>
				<option value = <?php echo $id;?>>Admin</option>
			</select><br><br>
		
			<button style="width: 20%" id = 'admin' name = 'admin'>Add Admin</button>
			
		</fieldset>
	</form>	
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click','#admin', function(form){
				form.preventDefault();
				var msg = '';
				$.ajax({
					
					url: "/clothes/process_newAdmin",
					type: "POST",
					data: $('#registration_form').serialize(),
					
					success:function(data){
						if(data == 1){
							msg = "Successful";
							$("#success").html(msg);
							document.getElementById("registration_form").reset();
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
</main>
