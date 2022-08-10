<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RolesModel;
use App\Models\CategoriesModel;
use App\Models\SubcategoriesModel;
use App\Models\ProductsModel;
use App\Models\ProductImagesModel;
use App\Models\PaymentModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;
use App\Models\WalletModel;

use CodeIgniter\Controller;

class Filter extends Controller
{
	
	public function filter(){
		$model_sub = new SubcategoriesModel();
		$model_prod = new ProductsModel();

		$category = $_POST['category'] ?? null;
		$subcategory =$_POST['subcategory'] ?? null;
		$min_price = $_POST['min_price'] ?? null;
		$max_price = $_POST['max_price'] ?? null;
		$text = $_POST['text'] ?? null;
		$date_added = $_POST['date_added'] ??null;

		for($i = 0; $i < count($category); $i++){
			$sql = "SELECT subcategory_id FROM tbl_subcategories WHERE category = '$category[$i]'";
			
			$query_sub = $model_sub->query($sql);
			
			if($result_sub = $query_sub->getResult()){
				foreach($result_sub as $res_sub){

					if($min_price == '' || $max_price == '')
					{
						$sqlprod = "SELECT * FROM tbl_product WHERE subcategory_id = '$res_sub->subcategory_id'";
					}
					else
					{
						$sqlprod = "SELECT * FROM tbl_product WHERE subcategory_id = '$res_sub->subcategory_id' AND unit_price BETWEEN '$min_price' AND '$max_price'";
					}
					$query_prod= $model_prod->query($sqlprod);
					
					if($result_prod = $query_prod->getResult()){

						foreach($result_prod as $res_prod){
							
							$imagepathname = $res_prod->product_image;
							$name = $res_prod->product_name;
							$productPrice = $res_prod->unit_price;

							$rows[] = array("name" => $name, "imagepathname"=>$imagepathname, "price"=>$productPrice);
										
						}
					}
				}
			}
		}
		echo json_encode($rows);

	}
	public function analyticsProduct()
	{
		$model = new ProductsModel();
		$model_cat = new CategoriesModel();
		$model_subcat = new SubcategoriesModel();
		$order_mod = new OrdersModel();
		$order_det = new OrderDetailsModel();

		$category = $_POST['category'] ?? null;
		$subcategory =$_POST['subcategory'] ?? null;
		$product = $_POST['product'] ?? null;
		$gender = $_POST['gender'] ?? null;

		for($i = 0; $i < count($product); $i++){
			$sql_details = "SELECT * FROM tbl_orderdetails WHERE product_id = '$product[$i]'";	

			$re = $model->where('product_id', $product[$i])
						->first();

			$query_det = $order_det->query($sql_details);
			if($results_det = $query_det->getResult()){

				foreach($results_det as $result_det){

					$order_id = $result_det->order_id;
					$id = $result_det->product_id;
					$name = $re['product_name'];
					$quantity = $result_det->order_quantity;
					$total = $result_det->orderdetails_total;

					$rows[] = array("order_id"=>$order_id, "id"=>$id,"name" => $name, "quantity"=>$quantity, "total"=>$total);
				}
			}		
		}
		
		echo json_encode($rows);
	}
	public function analyticsSubcategory()
	{
		$model = new ProductsModel();
		$model_cat = new CategoriesModel();
		$model_subcat = new SubcategoriesModel();
		$order_mod = new OrdersModel();
		$order_det = new OrderDetailsModel();

		$subcategory = $_POST['subcategory'] ?? null;
		$length = count($subcategory);
		
		for($i = 0; $i < $length; $i++){
			$subc = $model_subcat->where('subcategory_name', $subcategory[$i])
								->findAll();
			for($j = 0; $j < count($subc);$j++){
				$subname = $subc[$j]['subcategory_name'];
				$re = $model->where('subcategory_id', $subc[$j]['subcategory_id'])
							->findAll();
				
				for($k = 0; $k < count($re);$k++){
					$details = $order_det->where('product_id', $re[$k]['product_id'])
										->findAll();
					
					$rep = $model->where('product_id', $re[$k]['product_id'])
								->findAll();
					for($l = 0; $l < count($rep);$l++){
						$prod_name = $rep[$l]['product_name'];
						for($x = 0; $x < count($details); $x++){
							$order_id = $details[$x]['order_id'];
							$product_id = $details[$x]['product_id'];
							$quantity = $details[$x]['order_quantity'];
							$total = $details[$x]['orderdetails_total'];

							$rows[] = array("order_id"=>$order_id, "product_id"=>$product_id,"name" => $prod_name, "subname" => $subname,"quantity"=>$quantity, "total"=>$total);
						}	
					}		
				}			
			}
		}
		echo json_encode($rows);
	}
	public function analyticsCategory()
	{
		$model = new ProductsModel();
		$model_cat = new CategoriesModel();
		$model_subcat = new SubcategoriesModel();
		$order_mod = new OrdersModel();
		$order_det = new OrderDetailsModel();

		$category = $_POST['category'] ?? null;

		for($i = 0; $i < count($category); $i++){
			$cat = $model_cat->where('category_id', $category[$i])
							->findAll();
			for($p = 0; $p < count($cat); $p++){
				$catname = $cat[$p]['category_name'];
			}				
			$subc = $model_subcat->where('category', $category[$i])
								->findAll();
			for($j = 0; $j < count($subc); $j++){
				$re = $model->where('subcategory_id', $subc[$j]['subcategory_id'])
							->findAll();
				for($k = 0; $k < count($re);$k++){
					$details = $order_det->where('product_id', $re[$k]['product_id'])
											->findAll();
					$rep = $model->where('product_id', $re[$k]['product_id'])
								->findAll();
					for($l = 0; $l < count($rep);$l++){
						$prod_name = $rep[$l]['product_name'];				
					}
					for($x = 0; $x < count($details); $x++){
						$order_id = $details[$x]['order_id'];
						$product_id = $details[$x]['product_id'];
						$quantity = $details[$x]['order_quantity'];
						$total = $details[$x]['orderdetails_total'];

						$rows[] = array("order_id"=>$order_id, "product_id"=>$product_id,"name" => $prod_name, "catname" => $catname,"quantity"=>$quantity, "total"=>$total);
					}	
				}
			}
		}
		echo json_encode($rows);
	}
}