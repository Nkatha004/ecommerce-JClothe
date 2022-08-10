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
$order = $_GET['id'];

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

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<form id = "load_wallet">
    <input id = "order_no" hidden value = <?php echo $order;?>>
    <input id = "amount_available" hidden value = <?php echo $amount_available;?>>
    <input id = "wallet_id" hidden value = <?php echo $wallet_id;?>>
    <p style = "color:green"id = 'smessage'></p>
    <p style = "color:red"id = 'umessage'></p>

    <label>Amount: </label><br>
    <input type = "number" min = 0 id = "wallet_amount"><br><br>

    <button id = "load"style="width:10%">Load Amount</button>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        $("#load").click(function(form){
            form.preventDefault();
            var amount = $("#amount_available").val();
            var wallet_id = $("#wallet_id").val();
            var wallet_amount = $("#wallet_amount").val();
            var order = $('#order_no').val();

            var msg = "";
            $.ajax({
                url:'/clothes/process_wallet_loading',
                type:'post',
                data:{amount: amount, wallet_id:wallet_id, wallet_amount:wallet_amount},

                success:function(data, textStatus, req){
                    if(data == 1){
                        msg = "Amount loaded successfully";
                        $("#smessage").html(msg);
                        document.getElementById("load_wallet").reset();
                        window.location.href = "/clothes/wallet?order_id="+order;
                    }
                    else{
                        msg = "Unsuccessful!Amount not loaded";
                        $("#umessage").html(msg);
                    }
                },
                error:function(req, textStatus, errorThrown){
                    msg = "Unsuccessful!Amount not loaded";
                    $("#umessage").html(msg);
                }
            });
        });
    });

</script>

