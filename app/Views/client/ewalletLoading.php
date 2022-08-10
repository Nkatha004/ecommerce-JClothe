<?php
use App\Models\UserModel;
use App\Models\WalletModel;
use App\Models\OrdersModel;

if(!isset($_SESSION)) { 
    session_start(); 
}
$model = new UserModel();
$wallet = new WalletModel();
$email = $_SESSION['email'];

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src = "../assets/validate.js"></script>

<form id = "load_wallet">
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
                        window.location.href = "/clothes/userprofile";
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

