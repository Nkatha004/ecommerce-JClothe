<?php
use App\Models\SubcategoriesModel;
use App\Models\CategoriesModel;

$sql = "SELECT DISTINCT subcategory_name FROM tbl_subcategories";
$model = new SubcategoriesModel();
$query = $model->query($sql);

$sql_c = "SELECT DISTINCT category_name FROM tbl_categories";

$model_c = new CategoriesModel();
$query_cat = $model_c->query($sql_c);

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
<form class = 'register reg' id = "add_product" method = 'post' enctype="multipart/form-data">
    <h3>Add New Product</h3>
	<fieldset>
        <p class = 'alert-success' id = "success"></p>
        <p class = 'alert-danger' id = "message"></p>

        <label>Product Name: </label><br><br>
        <input type="text" id = "product_name" name="product_name" autofocus autocomplete="off"><br><br>

        <label>Unit Price: </label><br><br>
        <input type="number" min = 0 id = "price" name="price" autocomplete = 'off'><br><br>

        <label>Category: </label><br><br>
        <select id = 'category' name = 'category'><?php
        if($result = $query_cat->getResult()){
            foreach ($result as $rows) {
                ?><option value = '<?php echo $rows->category_name;?>'><?php echo $rows->category_name;
            }
        }
        ?></option></select><br><br>

        <label>Subcategory: </label><br><br>
        <select id = 'subcategory' name = 'subcategory'><?php
        if($results = $query->getResult()){
            foreach ($results as $row) {
                ?><option value = '<?php echo $row->subcategory_name;?>'><?php echo $row->subcategory_name;
            }
        }
        ?></option></select><br><br>

        <label>Available quantity: </label><br><br>
        <input type="number" id = "quantity" name="quantity" autocomplete = 'off' min = 0><br><br>

        <label>Product Description: </label><br><br>
        <textarea columns = "70" rows = "4" id = "description" name="description"  autocomplete="off"></textarea><br><br>

        <label>Upload Product Image: </label><br><br>
        <input type="file" id = "image" name="image" accept="image/*"><br><br>

        <button id = "btn_product"style = "width: 30%">Add Product</button>
</fieldset>
</form>
<script>
	$(document).ready(function(){
		$("#btn_product").click(function(form){
			form.preventDefault();
            if($('#image').val() == ''){
                alert("Please enter a valid value");
            }
			var msg = "";

            var form = document.getElementById('add_product');
            var formData = new FormData(form);
            formData.append('image', $('input[type=file]')[0].files[0]);

			$.ajax({
				url:'/clothes/add_product',
				type:'post',
				data: formData,
                contentType: false, 
                processData: false,

				success:function(data, textStatus, req){
                    if(data == 1){
						msg = "Successful";
						$("#success").html(msg);
						document.getElementById("add_product").reset();
                        
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