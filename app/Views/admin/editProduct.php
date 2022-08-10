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
	use App\Models\ProductsModel;
	use App\Models\SubcategoriesModel;
    use App\Models\CategoriesModel;

    $sql_c = "SELECT DISTINCT category_name FROM tbl_categories";
    $model_c = new CategoriesModel();
    $query_cat = $model_c->query($sql_c);

    $sql = "SELECT DISTINCT subcategory_name FROM tbl_subcategories";
    $model_sub = new SubcategoriesModel();
    $query_s = $model_sub->query($sql);
	
	$id = $_GET['id'] ?? null;
	$sql_select = "SELECT * FROM tbl_product WHERE product_id = '$id'";
	$model = new ProductsModel();
	$query = $model->query($sql_select);

	if($results = $query->getResult()){

        foreach ($results as $row=>$value) {
            $quantity = $results[$row]->available_quantity;
            $name = $results[$row]->product_name;
            $price = $results[$row]->unit_price;
            $description = $results[$row]->product_description;
            $prod_id = $results[$row]->product_id;
        }?>
        <form class = 'register reg' id = "add_product" method = 'post' enctype="multipart/form-data">
            <h3>Edit Product</h3>
            <fieldset>
                <p class = 'alert-success' id = "success"></p>
                <p class = 'alert-danger' id = "message"></p>

                 <label>Product ID: </label><br><br>
                <input type="text" readonly id = "product_id" name="product_id"  value = <?php echo $prod_id;?> autofocus autocomplete="off"><br><br>

                <label>Product Name: </label><br><br>
                <input type="text" id = "product_name" name="product_name"  value = <?php echo $name?> autofocus autocomplete="off"><br><br>

                <label>Unit Price: </label><br><br>
                <input type="number" min = 0 id = "price"  value = "<?php echo $price?>" name="price" autocomplete = 'off'><br><br>

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
                if($results_s = $query_s->getResult()){
                    foreach ($results_s as $row_s=>$val) {
                        ?><option value = '<?php echo $results_s[$row_s]->subcategory_name;?>'><?php echo $results_s[$row_s]->subcategory_name;
                    }
                }
                ?></option></select><br><br>

                <label>Available quantity: </label><br><br>
                <input type="number" id = "quantity" name="quantity"  value = "<?php echo $quantity;?>"autocomplete = "off" min = 0><br><br>

                <label>Product Description: </label><br><br>
                <textarea columns = "70" rows = "4" id = "description" name="description"  autocomplete="off"><?php echo $description?></textarea><br><br>

                <label>Upload Product Image: </label><br><br>
                <input type="file" id = "image" name="image" accept="image/*"><br><br>

                <button id = "btn_product"style = "width: 30%">Save Changes</button>
            </fieldset>
        </form>
        <script>
            $(document).ready(function(){
                $("#btn_product").click(function(form){
                    form.preventDefault();
                    if($('#image').val() == ''){
                        alert("Please enter a valid image");
                    }
                    var msg = "";

                    var form = document.getElementById('add_product'); // You need to use standard javascript object here
                    var formData = new FormData(form);
                    formData.append('image', $('input[type=file]')[0].files[0]);

                    $.ajax({
                        url:'/clothes/edit_product',
                        type:'post',
                        data: formData,
                        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                        processData: false,

                        success:function(data, textStatus, req){
                            
                            if(data == 1){
                                msg = "Successful";
                                $("#success").html(msg);
                              
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
	}		
?>
		

