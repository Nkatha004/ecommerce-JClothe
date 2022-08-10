<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>
<style>
    .error{
    	color:  red;
    	display: block;
    }
</style>
<form id = "add_paymenttype" method = "post">
	<p id = 'success' class = 'alert-success'></p>
	<p id = 'message' class = 'alert-danger'></p>
	<label>Payment Name: </label><br><br>
	<input type="text" id = "paymenttype" name="paymenttype" autofocus autocomplete="off"><br><br>

    <label>Payment Description: </label><br><br>
    <textarea rows = 5 columns = 50 id = "description" name="description" autocomplete="off"></textarea><br><br>


	<button id = 'btn_paymenttype' style = "width: 20%">Add Payment Type</button>
</form>
<script>
	$(document).ready(function(){
		$("#btn_paymenttype").click(function(form){
			form.preventDefault();
			var paymenttype = $("#paymenttype").val();
            var description = $("#description").val();
			
			var msg = "";

			$.ajax({
				url:'/clothes/add_paymenttype',
				type:'post',
				data:{paymenttype: paymenttype, description: description},

				success:function(data, textStatus, req){
					
					if(data == 1){
						msg = "Successful";
						$("#success").html(msg);
						document.getElementById("add_paymenttype").reset();
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