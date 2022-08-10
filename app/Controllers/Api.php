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
use App\Models\ApiUsersModel;

use CodeIgniter\Controller;

class Api extends Controller
{
	public function api_user(){
		$username = $_POST['username'];
		$key = $_POST['key'];

		$model_apiuser = new ApiUsersModel();
		$model_apiuser->save([
			'username'=> $username,
			'key'=> $key,
			'added_by'=>1
		]);
		
		$response['status'] = true;
		$response['message'] = "Successful";

		echo json_encode($response);
	}
	public function users(){
		$model = new UserModel();
		$users = $model->findAll();

		echo json_encode($users);
	}
	public function one_user(){
		$model = new UserModel();
		$user_id = $_GET['user_id'];
		$users = $model->find($user_id);

		echo json_encode($users);
	}
	public function male(){
		$model = new UserModel();
		$users = $model->where('gender', 'male')
						->findAll();
		for($i = 0; $i < count($users); $i++){
			$rows[] = array('firstname'=>$users[$i]['first_name'], 'gender'=>$users[$i]['gender']);

		}				
		
		echo json_encode($rows);
	}
	public function female(){
		$model = new UserModel();
		$users = $model->where('gender', 'female')
						->findAll();
		for($i = 0; $i < count($users); $i++){
			$rows[] = array('firstname'=>$users[$i]['first_name'], 'gender'=>$users[$i]['gender']);

		}				
		
		echo json_encode($rows);
	}
	public function product(){
		$model = new ProductsModel();
		$prod = $model->findAll();
		echo json_encode($prod);
	}
	public function one_product(){
		$model = new ProductsModel();
		$prod_id = $_GET['product_id'];
		$prod = $model->where('product_id', $prod_id)
						->first();
		echo json_encode($prod);
	}
	
	public function transactions(){
		$model = new OrdersModel();
		$order = $model->where('order_status', 'paid')
						->findAll();

		for($i = 0; $i < count($order); $i++)
		{
			$rows[] = array("order_id"=>$order[$i]['order_id'], "order_amount"=>$order[$i]['order_amount'],"order_status"=>$order[$i]['order_status']);
		}
		echo json_encode($rows);
	}
	public function product_subcat(){
		$id = $_GET['subcategory_id'];

		$model = new ProductsModel();
		$prod = $model->where('subcategory_id', $id)
					->findAll();
		echo json_encode($prod);
	}


}