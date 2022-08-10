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

use App\Models\SubcategoriesModel;

$sql_select = "SELECT category_name FROM tbl_categories";
$model = new SubcategoriesModel();
$query = $model->query($sql_select);

if($results = $query->getResult()){
	?>
	<form id = "add_subcategory" method = 'post'>
		<p id = 'message' class = 'alert-danger'><p>
		<p id = 'success' class = 'alert-success'><p>

		<label>Subcategory Name: </label><br><br>
		<input type="text" id = 'subcat_name'name="subcategory_name" autofocus autocomplete="off"><br><br>
		<span class = 'error' id = 'name_error'></span>

		<label>Category Name: </label><br><br>
		<select id = 'cat_name'name="category_name">
		<?php foreach ($results as $row) {
			?><option><?php echo $row->category_name;?> </option><?php
		}
		?>
		</select>
		
		<br><br><button id = 'btn_sub'style = "width: 15%">Add Subcategory</button>
	</form>
	<script>
		$(document).ready(function(){
			$("#btn_sub").click(function(form){
				form.preventDefault();
				var subcat_name = $("#subcat_name").val();
				var cat_name = $("#cat_name").val();
				
				var msg = "";

				$.ajax({
					url:'/clothes/add_subcategory',
					type:'post',
					data:{subcat_name: subcat_name,cat_name: cat_name},

					success:function(data, textStatus, req){
					
						if(data == 1){
							msg = "Successful";
							$("#success").html(msg);
							document.getElementById("add_subcategory").reset();
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
<?php
}?>

