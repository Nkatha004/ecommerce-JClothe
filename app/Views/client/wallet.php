<?php
use App\Models\UserModel;
use App\Models\WalletModel;
use App\Models\OrdersModel;

if(!isset($_SESSION)) { 
    session_start(); 
}
$model = new UserModel();
$wallet = new WalletModel();
$orderModel = new OrdersModel();

$email = $_SESSION['email'];
$order = $_GET['order_id'];

$sql_select = "SELECT * FROM tbl_users WHERE email = '$email'";
$query = $model->query($sql_select);
if($result = $query->getResult())
{
    foreach($result as $row)
    {
        $user_id = $row->user_id;
    }
}

$sql_wall = "SELECT * FROM tbl_wallet WHERE customer_id = '$user_id'";
$query_w = $wallet->query($sql_wall);
if($result_w = $query_w->getResult())
{
    foreach($result_w as $roww)
    {
        $amount_available = $roww->amount_available;
        $wallet_id = $roww->wallet_id;
    }
}
else{
    echo "Your wallet records not found. Contact admin for further help!";
}

$sql_order = "SELECT * FROM tbl_order WHERE order_id = '$order'";
$query_order = $orderModel->query($sql_order);
if($result_order = $query_order->getResult())
{
    foreach($result_order as $roworder)
    {
        $total = $roworder->order_amount;
    }
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<div id = "adminDiv" style = "color:black;padding: 30px;">
    <h4>Amount Available in wallet: <?php echo $amount_available;?></h4>
    <h4>Order Total: <?php echo $total;?></h4>
    <?php
        if($amount_available < $total){

            ?><p style="color:red">You have insufficient balance in your wallet to make this purchase!</p>
            
            <a href = "/clothes/load_wallet?id=<?php echo $order;?>"><button style = "width: 20%">Add money to wallet</button></a>
            <a id = "cancel" href="/clothes/wallet_cancel_order?id=<?php echo $order;?>"><button style = "width: 20%">Cancel Order</button></a>
            <?php
        }
        else{
            $rem = $amount_available-$total;
            $data = [
                'amount_available'=>$rem
            ];

            $wallet->update($wallet_id,$data);

            $data_order = [
                'order_status'=>'paid'
            ];

            $orderModel->update($order,$data_order)

            ?>
            <p style = "color:green">Purchase successful!!Thank you for shopping with us.</p><h6>New wallet balance is: <?php echo $rem;?></h6>

            <a href = "/clothes/purchaseHistory" title = "View my purchase history"><button style = "width: 20%">Purchase History</button></a>
            <a id = "cancel" title = "Back to product View" href="/clothes/productView"><button>Exit</button></a>
            <?php
        }
    ?>
    
</div>
