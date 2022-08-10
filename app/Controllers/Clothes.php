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
use App\Models\UserLoginModel;

use CodeIgniter\Controller;

class Clothes extends Controller
{
	public function index(){
		//echo view('templates/header');
		echo view('clothes/index');
		echo view('templates/footer');
	}
	public function login(){
		echo view('templates/header');
		echo view('clothes/login');
		echo view('templates/footer');
	}

	public function registration(){
		echo view('templates/header');
		echo view('clothes/registration');
		echo view('templates/footer');
	}
	public function process_registration(){
		$model = new UserModel();
		$wallet_model = new WalletModel();

		if(isset($_POST))
		{
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$pass= $_POST['password'];
			$gender = $_POST['gender'];

			$password = password_hash($pass, PASSWORD_DEFAULT);
			$insert = $model->save([
				'first_name' => $fname,
				'last_name'  => $lname,
				'email'  => $email,
				'gender' => $gender,
				'password'=> $password
			]);
			if($insert){
				$sql = "SELECT user_id FROM tbl_users WHERE email = '$email'";
				$query = $model->query($sql);

				if($results = $query->getResult()){
					foreach ($results as $row) {
			    		$user_id= $row->user_id;
			    	}
			    }
				$wallet_model->save([
					'customer_id'=>$user_id
				]);
				
				echo 1;
			}else{
				echo 0;
			}
		}	
	}
	public function process_login(){
		session_start();
		
		$username = $_POST['email'];
		$password = $_POST['password'];
		$sql_select = "SELECT * FROM tbl_users WHERE email = '$username'";

		$model = new UserModel();
		$model_login = new UserLoginModel();

		$query = $model->query($sql_select);
		if($results = $query->getResult()){

			foreach ($results as $row) {
				$user_id = $row->user_id;
			    $dbpassword = $row->password;
			    $role = $row->role;
			    $_SESSION['firstName'] = $row->first_name;
			    $_SESSION['lastName'] = $row->last_name;
				$_SESSION['email'] = $row->email;
			}

			$model_login->save([
				'user_ip'=>$_SERVER['REMOTE_ADDR'],
				'user_id'=>$user_id
			]);
		
			
			if(password_verify($password, $dbpassword)){
				
				if($role == 2){
					echo 2;
				}
				else{
					echo 1;
				}
			}
			else{
				echo 0;
			}
		}
		else{
			echo 0;
		}
	}

	public function users(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/users');
		echo view('templates/footer');
	}
	public function process_newAdmin(){
		$model = new UserModel();
		if(isset($_POST))
		{
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$pass= $_POST['password'];
			$gender = $_POST['gender'];
			$role = $_POST['role'];

			$password = password_hash($pass, PASSWORD_DEFAULT);
			$insert = $model->save([
				'first_name' => $fname,
				'last_name'  => $lname,
				'email'  => $email,
				'gender' => $gender,
				'password'=> $password,
				'role' => $role
			]);
			if($insert){
				echo 1;
			}else{
				echo 0;
			}
		}		
	}
	public function addNewAdmin(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/addNewAdmin');
		echo view("admin/editUsers");
		echo view('templates/footer');
	}

	public function edit_users(){
		
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/editUsers");
		echo view('templates/footer');
	}
	public function save_user_edits(){
		$model = new UserModel();
		
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$role = $_POST['role'];
		$gender = $_POST['gender'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$sql = "SELECT user_id FROM tbl_users WHERE email = '$email'";
		$query = $model->query($sql);
		if($result = $query->getResult()){
			foreach($result as $row)
			{
				$id = $row->user_id;
			}
		}
		$data = [
			'email' => $email,
			'first_name' => $fname,
			'last_name' => $lname,
			'role' => $role,
			'gender' => $gender,
			'password' => $password
		];
		$model->update($id, $data);
		echo 1;
		
	}
	public function delete_users(){
		$model = new UserModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_users WHERE user_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['user_id' =>$id]))
			{
				$this->admin();
			}else{
				$this->admin();
			}
		}
	}

	public function role(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/roles');
		echo view('templates/footer');		
	}
	public function addRole(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/addRole");
		echo view('templates/footer');
	}
	
	public function add_role(){
		$model = new RolesModel();
		if(isset($_POST)){
			$role = $_POST['role'];
			$insert = $model->save([
				'role_name'=>$role
			]);
		
			if($insert){
				echo 1;
			}else{
				echo 0;
			}	
		}
			
	}
	public function edit_roles(){
		$id = $_GET['id'];
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/editRole");
		echo view('templates/footer');
	}
	public function save_role_edits(){	
		$model = new RolesModel();

		$role_name = $_POST['role_name'];
		$role_id = $_POST['role_id'];

		$model->set('role_name', $role_name);
		$model->where('role_id',$role_id);
		$model->update();
		echo 1;	
	}
	public function delete_role(){
		$model = new RolesModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_roles WHERE role_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['role_id' =>$id]))
			{
				$this->role();
			}else{
				$this->role();
			}
		}
	}
	
	public function category(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/category');
		echo view('templates/footer');
	}
	public function addCategory(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/addCategory");
		echo view('templates/footer');
	}
	public function add_category(){
			
		$model = new CategoriesModel();
		if(isset($_POST)){
			$category_name = $_POST['category_name'];

			$insert = $model->save([
				'category_name'=>$category_name
			]);
		
			if($insert){
				echo 1;
			}else{
				echo 0;
			}	
		}
	}

	public function edit_category(){
		$id = $_GET['id'];
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/editCategory");
		echo view('templates/footer');
	}
	public function save_category_edits(){	
		$model = new CategoriesModel();
		$cat_name = $_POST['cat_name'];
		$cat_id = $_POST['cat_id'];

		$model->set('category_name', $cat_name);
		$model->where('category_id',$cat_id);
		$model->update();
		echo 1;	
	}
	
	public function delete_category(){
		$model = new CategoriesModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_categories WHERE category_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['category_id' =>$id]))
			{
				$this->category();
			}else{
				$this->category();
			}
		}
	}
	public function subcategory(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/subcategory');
		echo view('templates/footer');
	}
	public function addSubcategory(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/addSubcategory');
		echo view('templates/footer');
	}
	public function add_subcategory(){
		$model_cat = new CategoriesModel();
		$model = new SubcategoriesModel();

		$subcat_name = $_POST['subcat_name'];
		$cat_name = $_POST['cat_name'];

		$sql_select = "SELECT category_id FROM tbl_categories WHERE category_name = '$cat_name'";
		$query = $model_cat->query($sql_select);
		if($results = $query->getResult()){
			foreach($results as $row)
			{
				$cat_id = $row->category_id;
			}
		}
		$insert = $model->save([
			'category'=> $cat_id,
			'subcategory_name'=> $subcat_name
		]);
		if($insert){
			echo 1;
		}
		else{
			echo 0;
		}
	}
	public function edit_subcategory(){
		$id = $_GET['id'];
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view("admin/editSubcategory");
		echo view('templates/footer');
	}
	public function save_subcategory_edits(){	
		$model = new SubcategoriesModel();

		$subcat_id = $_POST['subcat_id'];
		$subcat_name = $_POST['subcat_name'];
		$cat_id = $_POST['cat_id'];
		$data = [
			'subcategory_name' => $subcat_name,
			'category'    => $cat_id
		];
		
		$model->update($subcat_id, $data);
		echo 1;	
	}
	public function delete_subcategory(){
		$model = new SubcategoriesModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_subcategories WHERE subcategory_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['subcategory_id' =>$id]))
			{
				$this->subcategory();
			}else{
				$this->subcategory();
			}
		}
	}

	public function product(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/product');
		echo view('templates/footer');
	}
	public function addProduct(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/addProduct');
		echo view('templates/footer');
	}
	public function add_product(){

		$model = new ProductsModel();
		$model_image = new ProductImagesModel();
		session_start();
		$fname = $_SESSION['firstName'];
		$lname = $_SESSION['lastName'];

		$usermodel = new UserModel();
		$sql_select_user = "SELECT user_id FROM tbl_users WHERE first_name = '$fname' AND last_name = '$lname'";
		$query_user = $usermodel->query($sql_select_user);
		if($results = $query_user->getResult())
		{
			foreach($results as $rows){
				$user_id = $rows->user_id;
			}
		}
	
		$product_name = $_POST['product_name'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$desc = $_POST['description'];
		$subcat = $_POST['subcategory'];
		$cat = $_POST['category'];

		$model_cat = new CategoriesModel();
		$sql_c = "SELECT * FROM tbl_categories WHERE category_name = '$cat'";
		$query_c = $model_cat->query($sql_c);
		if($result_c = $query_c->getResult())
		{
			foreach($result_c as $row){
				$cat_id = $row->category_id;
			}
		}
		$model_sub = new SubcategoriesModel();
		$sql = "SELECT * FROM tbl_subcategories WHERE subcategory_name = '$subcat' AND category = '$cat_id'";
		$query = $model_sub->query($sql);
		if($result = $query->getResult())
		{
			foreach($result as $row){
				$sub_id = $row->subcategory_id;
			}
		}

		$file = $this->request->getFile('image');
		$name = $file->getName();
		$path = "assets/images/".$name;
		
		$file->move('./assets/images');
		
		
		$insert = $model->save([
			'product_name'=>$product_name,
			'product_description'=>$desc,
			'unit_price'=>$price,
			'available_quantity'=>$quantity,
			'subcategory_id'=> $sub_id,
			'added_by'=>$user_id,
			'product_image'=>$path
		]);

		if($insert)
		{	
			$sql = "SELECT * FROM tbl_product WHERE product_image = '$path'";
			$query = $model_image->query($sql);
			if($result = $query->getResult())
			{
				foreach($result as $row){
					$prod_id = $row->product_id;
				}
			}
			$insert1 = $model_image->save([
				'product_image'=>$path,
				'product_id'=>$prod_id,
				'added_by'=>$user_id
			]);
			echo 1;
		}else{
			echo 0;
		}
	}
	public function edit_product(){
		$model = new ProductsModel();
		$model_image = new ProductImagesModel();

		session_start();
		$fname = $_SESSION['firstName'];
		$lname = $_SESSION['lastName'];

		$usermodel = new UserModel();
		$sql_select_user = "SELECT user_id FROM tbl_users WHERE first_name = '$fname' AND last_name = '$lname'";
		$query_user = $usermodel->query($sql_select_user);
		if($results = $query_user->getResult())
		{
			foreach($results as $rows){
				$user_id = $rows->user_id;
			}
		}
	
		$product_name = $_POST['product_name'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$desc = $_POST['description'];
		$subcat = $_POST['subcategory'];
		$cat = $_POST['category'];
		$id = $_POST['product_id'];

		$model_cat = new CategoriesModel();
		$sql_c = "SELECT * FROM tbl_categories WHERE category_name = '$cat'";
		$query_c = $model_cat->query($sql_c);
		if($result_c = $query_c->getResult())
		{
			foreach($result_c as $row){
				$cat_id = $row->category_id;
			}
		}
		
		$model_sub = new SubcategoriesModel();
		$sql = "SELECT * FROM tbl_subcategories WHERE subcategory_name = '$subcat' AND category = '$cat_id'";
		$query = $model_sub->query($sql);
		if($result = $query->getResult())
		{
			foreach($result as $row){
				$sub_id = $row->subcategory_id;
			}
		}

		$file = $this->request->getFile('image');
		$name = $file->getName();
		$path = "assets/images/".$name;
		
		$file->move('./assets/images');
		
		date_default_timezone_set('Africa/Nairobi');
		$date = date('Y-m-d h:i:s');

		$data = [
			'product_name'=>$product_name,
			'product_description'=>$desc,
			'unit_price'=>$price,
			'available_quantity'=>$quantity,
			'subcategory_id'=> $sub_id,
			'added_by'=>$user_id,
			'product_image'=>$path,
			'updated_at'=> $date
		];
		
		$select_product = "SELECT * FROM tbl_product WHERE product_name = '$product_name'";
		$query = $model->query($select_product);
		if($result = $query->getResult())
		{
			foreach($result as $row){
				$prod_id = $row->product_id;
			}
		}
		$model->update($id, $data);


		$data1 = [
			'product_image'=>$path,
			'product_id'=>$id,
			'added_by'=>$user_id,
			'updated_at'=>$date
		];
		$model_image->update($id, $data1);

		echo 1;
	}
		
	public function editProduct(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/editProduct');
		echo view('templates/footer');
	}
	public function delete_product(){
		$model = new ProductsModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_product WHERE product_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['product_id' =>$id]))
			{
				$this->product();
			}else{
				$this->product();
			}
		}
	}
	
	public function productView(){
		echo view('client/productView');
	}
	public function filter(){
		$min_price = $_POST['minimum_price'];
	}

	public function cart(){
		echo view('templates/header');
		echo view('client/cart');
		echo view('templates/footer');
	}
	public function clearCart(){
		if(!isset($_SESSION)) { 
			session_start(); 
		}
		
		unset($_SESSION["cart_item"]);
		$this->cart();
	}

	public function confirmOrder(){
		echo view('templates/header');
		echo view('client/confirmOrder');
		echo view('templates/footer');
	}

	public function paymenttype(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/paymenttype');
		echo view('templates/footer');
	}
	public function addPaymenttype(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/addPaymenttype');
		echo view('templates/footer');
	}
	public function delete_paymenttype(){
		$model = new PaymentModel();
		$id = $_GET['id'];

		$sql_select = "SELECT * FROM tbl_paymenttypes WHERE paymenttype_id = '$id'";
		$query = $model->query($sql_select);
		if($results = $query->getResult())
		{
			if($model->delete(['paymenttype_id' =>$id]))
			{
				$this->paymenttype();
			}else{
				$this->paymenttype();
			}
		}
	}
	public function edit_paymenttype(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/editPaymenttype');
		echo view('templates/footer');
	}
	public function add_paymenttype(){
		$model = new PaymentModel();
		
		$paymenttype = $_POST['paymenttype'];
		$description = $_POST['description'];
		$insert = $model->save([
			'paymenttype_name'=>$paymenttype,
			'description'=>$description
		]);
	
		if($insert){
			echo 1;
		}else{
			echo 0;
		}
	
	}
	public function save_paymenttype_edits(){
		$model = new PaymentModel();

		$paymenttype_name = $_POST['paymenttype_name'];
		$paymenttype_id = $_POST['paymenttype_id'];
		$description = $_POST['description'];

		$data = [
			'paymenttype_name'=>$paymenttype_name,
			'description'=>$description
		];
		$model->update($paymenttype_id, $data);
		echo 1;	
	}
	public function selectPaymenttype(){
		echo view('templates/header');
		echo view('client/selectPaymenttype');
		echo view('templates/footer');
	}
	public function save_select_payment(){	

		$model_order = new OrdersModel();

		$paymenttype = $_POST['paymenttype'];
		$order_id = $_POST['order_id'];

		date_default_timezone_set('Africa/Nairobi');
		$date = date('Y-m-d H:i:s');
		
		if($paymenttype == 2){
			$data = [
				'payment_type'=>$paymenttype,
				'updated_at'=>$date,
				'order_status'=>'paid'
			];
			$model_order->update($order_id, $data);
			echo 1;
		}
		else if($paymenttype == 1){
			$data = [
				'payment_type'=>$paymenttype,
				'updated_at'=>$date,
				'order_status'=>'pending payment'
			];
			$model_order->update($order_id, $data);
			echo 2;
		}
		
	}
	public function cancel_order(){
		$order_id = $_POST['order_id'];
		
		$model_details = new OrderDetailsModel();

		$sql = "SELECT orderdetails_id FROM tbl_orderdetails WHERE order_id = $order_id";
		$query = $model_details->query($sql);
		if($results = $query->getResult())
		{
			
			foreach ($results as $row) {
				$model_details->delete($row->orderdetails_id);
			}
		}
		
		$model = new OrdersModel();
		$model->delete($order_id);
		echo 1;
	}
	public function wallet_cancel_order(){
		$order_id = $_GET['id'];
		
		$model_details = new OrderDetailsModel();

		$sql = "SELECT orderdetails_id FROM tbl_orderdetails WHERE order_id = $order_id";
		$query = $model_details->query($sql);
		if($results = $query->getResult())
		{
			foreach ($results as $row) {
				$model_details->delete($row->orderdetails_id);
			}
		}
		
		$model = new OrdersModel();
		$model->delete($order_id);
		$this->productView();
	}
	public function wallet(){
		echo view('templates/header');
		echo view('client/wallet');
		echo view('templates/footer');
	}
	public function load_wallet(){
		echo view('templates/header');
		echo view('client/loadWallet');
		echo view('templates/footer');
	}

	public function process_wallet_loading(){
		$amount = $_POST['amount'];
		$wallet_amount = $_POST['wallet_amount'];
		$wallet_id = $_POST['wallet_id'];

		$new_amount = $amount+$wallet_amount;
		$model = new WalletModel();
		$data = [
			'amount_available'=>$new_amount
		];

		$model->update($wallet_id, $data);
		echo 1;

	}
	public function userprofile(){
		echo view('templates/header');
		echo view('client/userprofile');
		echo view('templates/footer');
	}
	public function ewallet(){
		echo view('templates/header');
		echo view('client/ewalletLoading');
		echo view('templates/footer');
	}
	public function checkBalance(){
		echo view('templates/header');
		echo view('client/checkBalance');
		echo view('templates/footer');
	}

	public function purchaseHistory(){
		echo view('templates/header');
		echo view('client/purchaseHistory');
		echo view('templates/footer');
	}
	public function analytics()
	{
		echo view('admin/analytics');
	}
	public function purchases_per_category()
	{
		echo view('admin/categorypurchases');
	}
	public function purchases_per_subcategory()
	{
		echo view('admin/subcategorypurchases');
	}
	public function api_user(){
		echo view('templates/header');
		echo view('admin/adminNavigator');
		echo view('admin/apiuser');
		echo view('templates/footer');
	}
	public function log_out(){
		session_start();
		$email = $_SESSION['email'];

		$sql_select = "SELECT * FROM tbl_users WHERE email = '$email'";

		$model = new UserModel();
		$model_login = new UserLoginModel();

		$query = $model->query($sql_select);
		if($results = $query->getResult()){
			foreach ($results as $row) {
				$user_id = $row->user_id;
			}
		}
		$sql_select_s = "SELECT * FROM tbl_userlogins WHERE user_id = '$user_id'";
		$query_s = $model_login->query($sql_select_s);

		if($result = $query_s->getResult()){
			foreach ($result as $rows) {
				$userlogin_id = $rows->userlogin_id;
			}
		}

		date_default_timezone_set('Africa/Nairobi');
		$date = date('Y-m-d h:i:s');

		$data = [
			'logout_time'=>$date
		];
		$model_login->update($userlogin_id, $data);


		session_destroy();
		echo 1;
	}

}
?>