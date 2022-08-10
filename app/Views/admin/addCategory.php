<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>
<style>
    .error{
    	color:  red;
    	display: block;
    }
</style>
<form id = "add_cat" method = 'post'>
	<p class = 'alert-success' id = "success"></p>
	<p class = 'alert-danger' id = "message"></p>
	<label>Category Name: </label><br><br>
	<input type="text" id = "category_name" name="category_name" autofocus autocomplete="off"><br><br>

	<button id = "btn_cat"style = "width: 15%">Add Category</button>
</form>
<script>
	$(document).ready(function(){
		$("#btn_cat").click(function(form){
			var cat_name = $("#category_name").val().trim();
			form.preventDefault();
			var msg = "";

			$.ajax({
				url:'/clothes/add_category',
				type:'post',
				data:{category_name: cat_name},
				success:function(response){
					
					if(response == 1){
						msg = "Successful";
						$("#success").html(msg);
						document.getElementById("add_cat").reset();
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