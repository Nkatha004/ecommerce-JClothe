<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>
<style>
    .error{
    	color:  red;
    	display: block;
    }
</style>
<form id = "add_role" method = "post">
	<p id = 'success' class = 'alert-success'></p>
	<p id = 'message' class = 'alert-danger'></p>
	<label>Role Name: </label><br><br>
	<input type="text" id = "role" name="role" autofocus autocomplete="off"><br><br>

	<button id = 'btn_role' style = "width: 15%">Add Role</button>
</form>
<script>
	$(document).ready(function(){
		$("#btn_role").click(function(form){
			form.preventDefault();
			var role = $("#role").val();
			
			var msg = "";

			$.ajax({
				url:'/clothes/add_role',
				type:'post',
				data:{role: role},

				success:function(data, textStatus, req){
					
					if(data == 1){
						msg = "Successful";
						$("#success").html(msg);
						document.getElementById("add_role").reset();
					}else{
						msg = "Unsuccessful!";
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