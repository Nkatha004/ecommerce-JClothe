<?php
use App\Models\UserModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;
use App\Models\PaymentModel;
use App\Models\ProductsModel;

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<?php

if(!isset($_SESSION)) { 
    session_start(); 
}
$model = new UserModel();
$email = $_SESSION['email'];
$total_price = 0;

$sql_select = "SELECT * FROM tbl_users WHERE email = '$email'";
$query = $model->query($sql_select);
if($result = $query->getResult())
{
    foreach($result as $row)
    {
        $user_id = $row->user_id;
        $fname = $row->first_name;
    }
}
if(!empty($_SESSION["cart_item"])) {

    foreach($_SESSION["cart_item"] as $key){
        $item_price = $key["quantity"] * $key["price"];
        $total_price += ($key["price"]*$key["quantity"]);
    }
}
$model_order = new OrdersModel();
$model_order->save([
    'customer_id'=>$user_id,
    'order_amount'=>$total_price
]);

$sql_select_orderNo = "SELECT order_id FROM tbl_order WHERE customer_id = $user_id";
$query = $model_order->query($sql_select_orderNo);
if($rows = $query->getResult())
{
    foreach($rows as $row)
    {
        $order_id = $row->order_id;
    }
}

if(!empty($_SESSION["cart_item"])) {
    ?><form class = 'register reg'id = "orderConfirmation" method = "post"><h2>Order Confirmation</h2>
    <fieldset>
        <h5 class = "alert-success" id = 'success'></h5>
		<h5 class = "alert-danger" id = 'feedback'></h5>

        <p>Hello <?php echo $fname;?>. Welcome!</p><p> Please confirm your order and select a payment method. Thank you!</p>
    <b><label>ORDER ID: </label></b><input id = "order_id" disabled name = "order_id" value = <?php echo $order_id;?>>
<?php

    foreach($_SESSION["cart_item"] as $key){
        
        $name = ($key['product_name']);
        $quantity = $key['quantity'];
        $product_id = $key['product_id'];
        $unit_price = $key['price'];

        $item_price = $key["quantity"] * $key["price"];
        ?>
       
        <p><b><?php echo"<br>". $name;?></b></p>
        <p><?php echo "Unit Price: ".$unit_price;?></p>
        <p><?php echo $unit_price." x ".$quantity." = ".$item_price;?></p>
        <p><?php echo "Total Item Price: ".$item_price;?></p>
        <?php
        $order_details = new OrderDetailsModel();
        $prod_model = new ProductsModel();

        $product_search = $prod_model->where('product_id',$product_id)
                    ->first();
        $new_quantity = $product_search['available_quantity'] - $quantity;
        $dataa = [
            'available_quantity'=> $new_quantity
        ];
        $prod_model->update($product_id, $dataa);

        $insert = $order_details->save([
            'order_id'=>$order_id,
            'product_id'=>$product_id,
            'product_price'=>$unit_price,
            'order_quantity'=>$quantity,
            'orderdetails_total'=>$item_price
        ]);
        if($insert){
            unset($_SESSION["cart_item"]);
        }
    }
    ?>
    <br><label>Total Price: </label><input disabled value = <?php echo $total_price;?>><br><br>
    <label>Payment Method: </label>
    <select id = 'paymenttype'>
    <?php 
    $model_pay = new PaymentModel();
    $sql_pay = "SELECT * FROM tbl_paymenttypes";
    $query_pay = $model_pay->query($sql_pay);
    if($result_pay = $query_pay->getResult())
    {
        foreach($result_pay as $row_pay)
        {
            $paymenttype_id = $row_pay->paymenttype_id;
            $paymenttype_name = $row_pay->paymenttype_name;
            ?><option value = <?php echo $paymenttype_id;?>><?php echo $paymenttype_name;?></option>
            <?php
        }
    }

    ?>
    </select><br><br>
    <button style = 'width:30%' id = "save_payment">Confirm Order</button>
    <button style = 'width:30%' id = "cancel_order">Cancel Order</button>

</fieldset></form>

<?php
}else{
    echo "Empty";
}
?>
<script>
	$(document).ready(function(){
		$("#save_payment").click(function(form){
			form.preventDefault();
			var paymenttype = $("#paymenttype").val();
            var id = $("#order_id").val();
           
			var msg = "";
			$.ajax({
				url:'/clothes/save_select_payment',
				type:'post',
				data:{paymenttype: paymenttype, order_id:id},

				success:function(data, textStatus, req){
					if(data == 1){
						window.location.href = "/clothes/purchaseHistory";
                        exit();
    				}
                    else if(data == 2){
                        window.location.href = "/clothes/wallet?order_id="+id;
                        exit();
                    }
                    else{
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
        $("#cancel_order").click(function(form){
			form.preventDefault();
            var id = $("#order_id").val();
			
			var msg = "";
			$.ajax({
				url:'/clothes/cancel_order',
				type:'post',
				data:{order_id:id},

				success:function(data, textStatus, req){
					if(data == 1){
						msg = "Successfully cancelled";
						$("#success").html(msg);
					}else{
						msg = "Order not cancelled!";
						$("#message").html(msg);
					}
				},
				error:function(req, textStatus, errorThrown){
					msg = "Order not cancelled";
					$("#message").html(msg);
				}
			});
		});
        
	});
</script>