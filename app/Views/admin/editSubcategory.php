<?php
	use App\Models\CategoriesModel;
    use App\Models\SubcategoriesModel;

	$id = $_GET['id'];
	$sql_select = "SELECT * FROM tbl_subcategories WHERE subcategory_id = $id";
	$model = new SubcategoriesModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){
		foreach ($results as $row) {
			$cat_id = $row->category;
            $subcat_id = $row->subcategory_id;
			$subcat_name = $row->subcategory_name;
		}
	}
    
    $sql = "SELECT category_name FROM tbl_categories WHERE category_id = $cat_id";
    $model_cat = new CategoriesModel();
	$query_cat = $model_cat->query($sql);

	if($results_cat = $query_cat->getResult()){
		foreach ($results_cat as $rows) {
			$cat_name = $rows->category_name;
		}
	}
    $sql_select_cat = "SELECT * FROM tbl_categories";
    $query_cat1 = $model_cat->query($sql_select_cat);
    

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
	<h3>Edit Subcategory Information</h3>
	<fieldset>
		<p id = 'success' class = 'alert-success'></p>
		<p id = 'feedback' class = 'alert-danger'></p>
		<label>Subcategory ID: </label><br><br>
		<input id = 'subcat_id' disabled type="text" name="subcat_id" autocomplete="off" value = <?php echo $subcat_id?>>
		<br><br>

		<label>Subcategory Name: </label><br><br>
		<input id = 'subcat_name' type="text" name="cat_name" autocomplete="off" value = <?php echo $subcat_name?>><br><br>

        <label>Category Name: </label><br><br>
        <select name = 'avail_cats' id = 'avail_cats'>
        <?php 
        if($results_cat1 = $query_cat1->getResult()){
		    foreach ($results_cat1 as $rows1) {
                ?><option value = <?php echo $rows1->category_id;?>><?php echo $rows1->category_name;?></option><?php
               
		    }
	    }?></select><br><br>
		<button style = "width: 30%"id = 'save' name = 'save'>Save Changes</button>
				
	</fieldset>
</form>	
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','#save', function(form){
			form.preventDefault();
			var msg = '';

			var subcat_id = $('#subcat_id').val();
            var cat_id = $('#avail_cats').val();
            var subcat_name= $('#subcat_name').val();
        
			$.ajax({
				
				url: "/clothes/save_subcategory_edits",
				type: "POST",
				data: {cat_id: cat_id,subcat_id: subcat_id,subcat_name: subcat_name},
				
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