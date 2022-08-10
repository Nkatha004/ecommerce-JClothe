<?php
	use App\Models\PaymentModel;

	$id = $_GET['id'];
	$sql_select = "SELECT * FROM tbl_paymenttypes WHERE paymenttype_id = $id";
	$model = new PaymentModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){
		foreach ($results as $row) {
			$paymenttype_id = $row->paymenttype_id;
			$paymenttype_name = $row->paymenttype_name;
            $description = $row->description;
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

<form id = "edit_paymenttype" style = "color: #000000"class = "register reg" method = "post">
	<h3>Edit Payment Type Information</h3>
	<fieldset>
		<p id = 'success' class = 'alert-success'></p>
		<p id = 'feedback' class = 'alert-danger'></p>
		<label>Payment Type ID: </label><br><br>
		<input id = 'paymenttype_id' type="text" name="paymenttype_id" autocomplete="off" value = <?php echo $paymenttype_id?>>
		<br><br>

		<label>Payment Type Name: </label><br><br>
		<input id = 'paymenttype_name' type="text" name="paymenttype_name" autocomplete="off" value = <?php echo $paymenttype_name?>><br><br>
        
        <label>Payment Type Description: </label><br><br>
        <textarea name="description" id="description" cols="50" rows="5"><?php echo $description?></textarea><br><br>
		<button style = "width: 30%"id = 'save' name = 'save'>Save Changes</button>
				
	</fieldset>
</form>	
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#save', function(form){
			form.preventDefault();
			var msg = '';
			var name = $('#paymenttype_name').val();
			var id = $('#paymenttype_id').val();
            var description = $('#description').val();
			
			$.ajax({
				
				url: "/clothes/save_paymenttype_edits",
				type: "POST",
				data: {paymenttype_name: name, paymenttype_id:id, description:description},
				
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