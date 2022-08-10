<?php
	use App\Models\CategoriesModel;

	$id = $_GET['id'];
	$sql_select = "SELECT * FROM tbl_categories WHERE category_id = '$id'";
	$model = new CategoriesModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){
		foreach ($results as $row) {
			$cat_id = $row->category_id;
			$cat_name = $row->category_name;
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

<form id = "edit_cat" style = "color: #000000"class = "register reg" method = "post">
	<h3>Edit Category Information</h3>
	<fieldset>
		<p id = 'success' class = 'alert-success'></p>
		<p id = 'feedback' class = 'alert-danger'></p>
		<label>Category ID: </label><br><br>
		<input id = 'cat_id' type="text" name="cat_id" autocomplete="off" value = <?php echo $cat_id?>>
		<br><br>

		<label>Category Name: </label><br><br>
		<input id = 'cat_name' type="text" name="cat_name" autocomplete="off" value = <?php echo $cat_name?>><br><br>

		<button style = "width: 30%"id = 'save' name = 'save'>Save Changes</button>
				
	</fieldset>
</form>	
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#save', function(form){
			form.preventDefault();
			var msg = '';
			var name = $('#cat_name').val();
			var id = $('#cat_id').val();
			
			$.ajax({
				
				url: "/clothes/save_category_edits",
				type: "POST",
				data: {cat_name: name, cat_id:id},
				
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