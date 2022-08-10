<?php 
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;
use App\Models\UserModel;
use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use App\Models\SubcategoriesModel;

$userModel = new UserModel();
$orderModel = new OrdersModel();
$orderDetails = new OrderDetailsModel();
$productModel = new ProductsModel();
$subcatModel = new SubcategoriesModel();
$catModel = new CategoriesModel();

$email = $_SESSION['email'];
?>
<div class="collapse" id="navbarToggleExternalContent">
  <div class="bg-dark p-4">
    <h5 class="text-white h4">About me</h5>
    <p><a href = "/clothes/userprofile">My Profile</a></p>
    <p><a href = "/clothes/purchaseHistory">My Purchase History</a></p>
    <p><a href = "/clothes/ewallet">Load my Wallet</a></p>
    <p><a href = "/clothes/checkBalance">Check Wallet Balance</a></p>
    <p><a id = "log_out" href = ''>Log out?</a></p>
   
  </div>
</div>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">MY PROFILE
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>
<?php
echo "<table class = 'about centered'>
    <h2>Purchase History</h2>
    <tr>
        <th>Date</th>
        <th>Order ID</th>
        <th>Category name</th>
        <th>Product Name</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
    <style>
        table,th,td
        {
            border:2px solid grey;
        }
        table
        {
            border-collapse:collapse;
            width:90%;
        }
        th{
            background-color: yellow;
        }
        td,th
        {
            height:40px;
        }
    </style><tr>";
    $users = $userModel->where('email', $email)
                   ->findAll();
    foreach($users as $row){
        $user_id = $row['user_id'];
        $fname = $row['first_name'];
        $lname = $row['last_name'];
    }
    $orders = $orderModel->where('customer_id', $user_id)
                        ->findAll();
    foreach($orders as $row){
        $order_id = $row['order_id'];
        $date = $row['updated_at'];
        $details = $orderDetails->where('order_id', $order_id)
                        ->findAll();
                   
        foreach($details as $row){
           
            $product_id = $row['product_id'];
            $products = $productModel->where('product_id', $product_id)
                                    ->findAll();
            foreach($products as $prod){
                $product_name = $prod['product_name'];
                $subcat = $prod['subcategory_id'];
                $subcategory = $subcatModel->where('subcategory_id', $subcat)
                                    ->findAll();
                foreach($subcategory as $sub){
                    $cat = $sub['category'];
                }
                $category = $catModel->where('category_id', $cat)
                                    ->findAll();
                foreach($category as $category){
                    $cat_name = $category['category_name'];
                }
            }

            echo "<td>".$date."</td>";
            echo "<td>".$order_id."</td>";
            echo "<td>".$cat_name."</td>";
            echo "<td>".$product_name."</td>";
            echo "<td>".$row['product_price']."</td>";
            echo "<td>".$row['order_quantity']."</td>";
            echo "<td>".$row['orderdetails_total']."</td>";
           echo "<tr>"; 
        }
    }

	echo "</table>";
    ?><script>alert("Thank you for shopping with us");</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#log_out").click(function(form){
            form.preventDefault();
          
            $.ajax({
                url: '/clothes/log_out',
                type:'post',
                
                success: function(data){
                    if(data == 1){
                        window.location.href = "/clothes/index";
                        
                    }
                },
                error: function(xhr ,textStatus, errorThrown){
                    alert("Error" + textStatus + errorThrown);
                }
            }); 
        });
    });
</script>
<?php
?>
