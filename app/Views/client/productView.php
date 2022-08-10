<?php

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Models\SubcategoriesModel;

if(!isset($_SESSION)) { 
	session_start(); 
}
$sql_select = "SELECT * FROM tbl_product";
$model = new ProductsModel();
$model_cat = new CategoriesModel();
$model_subcat = new SubcategoriesModel();

$query = $model->query($sql_select);
$cat = $model_cat->findColumn('category_name');
$catid =$model_cat->findColumn('category_id');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JClothe</title>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href= "../assets/styles.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

</head>
<body class = "landing">
<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:21%; padding-left:10px">
		<form class="d-flex">
			<input id = "search_text"class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          	<button id = 'search_button'class="btn btn-outline-success" type="submit">Filter</button>
        </form>
        <button id = "remove_filter" style = "width: 60%"class="btn btn-primary" type="submit">Remove filter</button>
    <h1>Price</h1>
	    <label><b>From: </b></label><input style = "width: 30%"type="number" id = "min_price" name="min_price" autocomplete="off">
		<label><b>To: </b></label><input style = "width: 30%"type="number" id = "max_price" name="max_price" autocomplete="off">
	
	<h1>Categories</h1>
		<?php 
		$length = count($cat);
		for($i = 0; $i < $length; $i++){
			?><label><input type="checkbox" name = "category" value = <?php echo $catid[$i];?>><?php echo $cat[$i];?></label><br><?php
		}
		?>
	<h1>Subcategories</h1>

		<?php 
			$sql_subcat = "SELECT DISTINCT subcategory_name FROM tbl_subcategories";
			$query_sub = $model_subcat->query($sql_subcat);
			if($res_sub = $query_sub->getResult()){
				foreach($res_sub as $sub_row){ 

					?><label><input type="checkbox" name ="subcategory" value = <?php echo $sub_row->subcategory_name;?>><?php echo $sub_row->subcategory_name;?></label><br><?php
				}
			}
		?>
	 <div class="row filter_data"></div>

	<h1>Date Added</h1>
	
		<input type="checkbox" name = "date_added"class = "common_selector" value = "latest"><label>Latest Added</label><br>
		<input type="checkbox" name = "date_added"class = "common_selector"value = "earliest"><label>Earliest Added</label><br>

</div>
<div style="margin-left:20%">
<header class = "landing">
		<a href = "/clothes/userprofile"><div style = "text-align: right; padding-right: 20px; padding-top: 10px;">
			<p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">

	 			<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
	  			<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
	  					
			</svg>
			
			<?php 
					$fname = $_SESSION['firstName']??null;
					$lname = $_SESSION['lastName']??null;
					echo $fname." ".$lname ?? null;
			?> </p></div></a>

		<nav class = "navbar-nav mr-auto">
			<ul>
				<li class="nav-item"><a href = "index">HOME</a></li>
				<li class="nav-item"><a href = "">CONTACT US</a></li>
				<li class="nav-item"><a href = "login">SHOP</a></li>
				<a href = "/clothes/registration"><button class = "right">Register</button></a>
				<a href = "/clothes/login"><button class = "right">Login</button></a>
			</ul>
		</nav>
</header>
<main>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<style type="text/css">
			.cont
			{
				display: grid;
				grid-template-columns: repeat(3, 1fr);
				text-align: center;
				margin-bottom:30px;
				/* padding-left: 200px;  */
			}
			.item
			{
				border: 2px solid;
				border-collapse: collapse;
				height: 250px;
				width: 300px;
				background-color: mintcream;
				padding-bottom: 350px;	
			}

		</style>
		<div>
			<a href = "/clothes/cart" style = "padding-left:50px">My Cart<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
				<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
				</svg>
			</a>
			
			<div class = 'cont' id = 'container'>

					<?php
					if($rows = $query->getResult())
					{
						foreach ($rows as $row=>$value)
						{
							$imagepathname = $rows[$row]->product_image;
							$name = $rows[$row]->product_name;
							$productPrice = $rows[$row]->unit_price;
							

							?><form style = "background-color: transparent" method = 'post'action = "/clothes/cart?action=add&productName=<?php echo $name; ?>"><div id = 'proddisplay' class = "item">
								<img src = "../<?php echo $imagepathname?>" height = 200px width = 200px float = left><strong><i><p>
									<?php echo $name;?></p><p><?php echo $productPrice.' Kshs/=';?></p></i></strong>
									<input type="number" name="quantity" min = 1 placeholder = "Quantity" style = "width: 30%" autocomplete="off"><input style = "background-color: black; color: white"type="submit" name = "cart" value = "Add to Cart">
							</div></form><?php
						}
					}
					?>
				</div>
			</div>	
		</div>
</main>

<script type="text/javascript">
	$(document).ready(function(){
		$("#remove_filter").click(function(){
			window.location.href = "/clothes/productView";
		});
        $("#search_button").click(function(form){
            form.preventDefault();
            var category = new Array();
            var subcategory = new Array();

            var text = $('#search_text').val();
            var min_price = $('#min_price').val();
            var max_price = $('#max_price').val();

            $('input[name="category"]:checked').each(function(){
            	category.push($(this).val());
            });

            $('input[name="subcategory"]:checked').each(function(){
            	subcategory.push($(this).val());
            });
            var msg = '';var i = '';
            var date_added = $('input[name="date_added"]:checked').serialize();
           
            $.ajax({
            	url: '/filter/filter',
            	type:'post',
            	data: {text: text, min_price:min_price,max_price:max_price,subcategory:subcategory,date_added:date_added, category:category},
            	success: function(data){
            	
            		if(data != ''){
            			
               			for(i = 0; i < data.length; i++){
            				msg += '<form style = "background-color: transparent" method = "post" action = "/clothes/cart?action=add&productName='+data[i]["name"]+'"><div id = "proddisplay" class = "item"><img src = "../'+data[i]['imagepathname']+'" height = 200px width = 200px float = left><strong><i><p>'+data[i]['name']+'</p><p>'+data[i]['price']+'Kshs/=</p></i></strong><input type="number" name="quantity" min = 1 placeholder = "Quantity" style = "width: 30%" autocomplete="off"><input style = "background-color: black; color: white"type="submit" name = "cart" value = "Add to Cart"></div></form>';

            				$('#container').html(msg);
            			}
            		}
            		else{
            			msg = "No products found!";
            			$('#container').html(msg)
            		}
            	},
            	error: function(xhr ,textStatus, errorThrown){
            		alert("Error" + textStatus + errorThrown);
            	},
            	dataType: "json"
            }); 
    	});
    });
</script>
	<footer>
        <div class = "footer centered">
            <h1>More about us</h1>
            <p><a href = "index">Home Page</a></p>
            <p><a href = "#">Contact us</a></p>
			<p><a href = "#">About us</a></p>

            <hr>
            <p id = "copyright" class = "left">&copy; Copyright 2022. By Joy Nkatha Muriungi</p>
        </div>
    </footer>
	</body>
</html>
