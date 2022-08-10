<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<style>
	.error{
		color:  red;
		display: block;
	}
</style>
<main style = "color: #000000">
	<div class="login">
		<form id = 'login_form'>
				<h3 class="centered">API User Registration</h3>
				<fieldset>
					<h4 class = 'alert-danger' id = 'feedback'></h4>
					<h4 class = 'alert-success' id = 'success'></h4>
					
					<label>Username</label><br>
					<input style = "font-size: medium" id = 'username' type="username" name="username" autocomplete="off" autofocus><br><br>

					<label>Key</label><br>
					<input style = "font-size: medium" id ="key" type="key" name="key" autocomplete="off" readonly value = <?php echo bin2hex(random_bytes(5))?>><br><br>

					<button id = 'register' name = 'register'>Register</button></a>
					
				</fieldset>
			</form>
			
		</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click','#register', function(form){
				form.preventDefault();
				var msg = '';
				
				$.ajax({
					
					url: "/api/api_user",
					type: "POST",
					data: $('#login_form').serialize(),
					
					success:function(data){
						msg = "Successful";
						document.getElementById("login_form").reset();
						$("#success").html(msg);
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
