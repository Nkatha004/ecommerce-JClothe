<?php

use App\Models\ProductsModel;

if(!empty($_POST["quantity"])) {
    $model = new ProductsModel();
    $prod = $_GET["productName"];

    $sql_select_product = "SELECT * FROM tbl_product WHERE product_name = '".$prod."'";
    $query = $model->query($sql_select_product);
    $product = $query->getResult();

    $productArray = array($product[0]->product_name =>
                            array(
                                'product_name'=>$product[0]->product_name,
                                'product_id'=>$product[0]->product_id, 
                                'quantity'=>$_POST["quantity"], 
                                'price'=>$product[0]->unit_price, 
                                'imagepathname'=>$product[0]->product_image
                            )
                    );

    if(!empty($_SESSION["cart_item"])) {

        if(in_array($product[0]->product_name,array_keys($_SESSION["cart_item"]))) {

            foreach($_SESSION["cart_item"] as $key  => $value) {
        
                    if($product[0]->product_name == $key){
                        if(empty($_SESSION["cart_item"][$key]["quantity"])) 
                        {
                            $_SESSION["cart_item"][$key]["quantity"] = 0;
                        }
                        $_SESSION["cart_item"][$key]["quantity"] += $_POST["quantity"];
                    }
            }
        } else {
            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$productArray);
        }
    } 
    else {
        $_SESSION["cart_item"] = $productArray;
    }
}
?>

<h1>Shopping Cart</h1>

<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
    ?>	
    <table class="about" style = "border:solid" cellpadding="10" cellspacing="1">
    <style>
        table,th,td
        {
            border:2px solid grey;
        }
        table
        {
            border-collapse:collapse;
            width:80%;
            background-color: #dff9fb;
        }
        td,th
        {
            height:40px;
        }	
        th
        {
            background-color:yellow;
            color:black;
        }
    </style>
    <tbody>
        <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Price</th>
        <th>Remove</th>
        </tr>	
    <?php		
    foreach ($_SESSION["cart_item"] as $item)
    {
        $item_price = $item["quantity"] * $item["price"];?>
        <tr>
            <td><img style = "height: 50px; width:50px "src="../<?php echo $item["imagepathname"]; ?>" class="cart-item-image" /><?php //echo $item["product_name"]; ?></td>
            <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
            <td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
            <td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
            <td style="text-align:center;"><a href = "#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <a href="#?action=remove&productName=<?php //echo $item["product_name"]; ?>">
                    <?php echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                </a></td>
        </tr>';?>
        <?php
        $total_quantity += $item["quantity"];
        $total_price += ($item["price"]*$item["quantity"]);
    }

    echo "<tr>
        <td align = 'right'>Total:</td>
        <td align='right'>".$total_quantity."</td>
        <td align='right' colspan='2'><strong>";echo "$ ".number_format($total_price, 2); echo "</strong></td>
    </tr>
    </tbody>
    </table><br><br>
    <a href='/clothes/productView'><button style = 'width:10%'>Add Items</button>
    <a href='/clothes/confirmOrder'><button style = 'width: 15%'>Checkout</button></a>
    <a href='/clothes/clearCart'><button style = 'width: 10%'>Empty Cart</button></a>";

} else {

    echo "<form>Your Cart is Empty</form><br><br>
    <a href='/clothes/productView'><button style = 'width:10%';>Add Items</button>";
}
echo "</div>";?>
