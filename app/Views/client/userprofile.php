<?php 
use App\Models\UserModel;
use App\Models\RolesModel;

$model = new UserModel();
$rolesModel = new RolesModel();
if(!isset($_SESSION)){
    session_start();
}

if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $sql_select = "SELECT * FROM tbl_users WHERE email = '$email'";
    $query = $model->query($sql_select);

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
    <style>
        table,th,td
        {
          border:2px solid grey;
        }
        table
        {
          border-collapse:collapse;
          width:60%;
      }
        td,th
        {
          height:40px;
        }
      </style>";

    if($result = $query->getResult())
    {
        foreach($result as $row)
        {
            $role = $rolesModel->find($row->role);
            echo'<tr>
                <td><b>User ID</b></td>
                <td>'.$row->user_id.'</td>
              </tr>
              <tr>
                <td><b>First Name</b></td>
                <td>'.$row->first_name.'</td>
              </tr>
              <tr>
                <td><b>Last Name</b></td>
                <td>'.$row->last_name.'</td>
              </tr>
              <tr>
                <td><b>Email</b></td>
                <td>'.$row->email.'</td>
              </tr>
              <tr>
                <td><b>Gender</b></td>
                <td>'.$row->gender.'</td>
              </tr>
              <tr>
                <td><b>Role</b></td>
                <td>'.$role['role_name'].'</td>
              </tr>';
        }
    }

    echo '</table>';

}
else{
    echo "<p>Please <a href = '/clothes/login'>login </a>to view your profile. <a href = '/clothes/login'>Log in?</a>";
}?>
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





