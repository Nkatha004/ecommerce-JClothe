<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<style>
    .error{
    	color:  red;
    	display: block;
		font-size:medium;
    }
</style>

<main style = "color: #000000">
		<div class="login">
			<form id = 'login_form'>
				<h3 class="centered">Login</h3>
				<h6 class = "centered">Welcome! Please login to proceed.</h6>
				<fieldset>
					<h4 class = 'alert-danger' id = 'message'><h4>
					
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
	  				<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					</svg>

					<input style = "font-size: medium" id = 'email' type="email" name="email" placeholder="email address" autocomplete="off" autofocus><span class = 'error' id = 'login_email_error'></span><br><br>

					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
	  				<path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
					</svg>

					<input style = "font-size: medium" id ="password" type="password" name="password" placeholder="password" autocomplete="off"><span class = 'error' id = 'login_password_error'></span>
					<br>

					<button id = 'login' name = 'login'>Login</button></a>
					
				</fieldset>
			</form>
			
		</div>
	<script>
		$(document).ready(function(){
			$("#login").click(function(form){
				form.preventDefault();
				var username = $("#email").val().trim();
				var password = $("#password").val().trim();
				var msg = "";

				$.ajax({
					url: "/clothes/process_login",
					type:'post',
					data:{email:username,password:password},
				
					success:function(data){
						if(data == 1){
							window.location.href = "/clothes/productView";
							exit();
						}
						else if(data == 2){
							window.location.href = "/clothes/users";
							exit();
						}
						else{
							msg = "Not successful";
							$("#message").html(msg);
						}
					},
					error:function(req, textStatus, errorThrown){
						
						msg = "Not successful";
						$("#message").html(msg);
					}
				});
			});
		});
	</script>
		
	</main>

