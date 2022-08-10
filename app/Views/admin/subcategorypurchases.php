<?php

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Models\SubcategoriesModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;

if(!isset($_SESSION)) { 
	session_start(); 
}
$sql_select = "SELECT * FROM tbl_product";

$model = new ProductsModel();
$model_cat = new CategoriesModel();
$model_subcat = new SubcategoriesModel();
$order_mod = new OrdersModel();
$order_det = new OrderDetailsModel();

$orderdetails = $order_det->findAll();

$query = $model->query($sql_select);
$cat = $model_cat->findColumn('category_name');
$catid =$model_cat->findColumn('category_id');

$prod = $model->findColumn('product_name');
$prodid =$model->findColumn('product_id');
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
	<div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h5 class="text-white h4">Analytics</h5>
            <p><a href = "/clothes/analytics">Products purchases</a></p>
            <p><a href = "/clothes/purchases_per_category">Category purchases</a></p>
            <p><a href = "/clothes/purchases_per_subcategory">Subcategory purchases</a></p>
            <p><a href = '/clothes/users'>Admin Navigator</a></p>
     
        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">ANALYTICS - Subcategory Purchases
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
  </nav>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<table class = 'about centered w3-light-grey w3-bar-block'>
  		<style>
  			th{
  				background-color: #dff9fb;
  			}
	        table,th,td
	        {
	          border:2px solid grey;
	        }
	        table
	        {
	          border-collapse:collapse;
	        }
	        td,th
	        {
	          height:40px;
	        }
      	</style>;
  		<thead>
  			<tr>
  				<th>Order ID</th>
  				<th>Product ID</th>
  				<th>Product Name</th>
  				<th>Subcategory Name</th>
  				<th>Quantity</th>
  				<th>Total</th>
  			</tr>
  		</thead>
  		<tbody id = 'table'>
	  			<?php 
	  			for($i = 0; $i < count($orderdetails); $i++){

					$re = $model->where('product_id', $orderdetails[$i]['product_id'])
									->first();
					$res = $model_subcat->where('subcategory_id',$re['subcategory_id'])
										->first();
							
	  				echo'<tr><td>'.$orderdetails[$i]['order_id'].'</td>';
					echo'<td>'.$orderdetails[$i]['product_id'].'</td>';
					echo'<td>'.$re['product_name'].'</td>';
					echo'<td>'.$res['subcategory_name'].'</td>';
					echo'<td>'.$orderdetails[$i]['order_quantity'].'</td>';
					echo'<td>'.$orderdetails[$i]['orderdetails_total'].'</td></tr>';
				}?>

  		</tbody>
  </table>
		
</main>

<script type="text/javascript">
	$(document).ready(function(){
		$("#remove_filter").click(function(){
			window.location.href = "/clothes/purchases_per_subcategory";
		});
        $("#search_button").click(function(form){
            form.preventDefault();
            var category = new Array();
            var subcategory = new Array();
            var product = new Array();
            var gender = new Array();
            var i = 0;
            var msg = '';

            $('input[name="category"]:checked').each(function(){
            	category.push($(this).val());
            });

            $('input[name="subcategory"]:checked').each(function(){
            	subcategory.push($(this).val());
            });

            $('input[name="product"]:checked').each(function(){
            	product.push($(this).val());
            });

            $('input[name="gender"]:checked').each(function(){
            	gender.push($(this).val());
            });
           
            $.ajax({
            	url: '/filter/analyticsSubcategory',
            	type:'post',
            	data: {gender: gender, product:product,subcategory:subcategory,category:category},
            	success: function(data){
            		
            		if(data != ''){
            			
               			for(i = 0; i < data.length; i++){
           
            				msg += '<tr><td>'+data[i]["order_id"]+'</td><td>'+data[i]["product_id"]+'</td><td>'+data[i]['name']+'</td><td>'+data[i]["subname"]+'</td><td>'+data[i]['quantity']+'</td><td>'+data[i]['total']+'</td></tr>';

            				$('#table').html(msg);
            			}
            		}
            		else{
            			$('#table').html("No products found");
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
