<main>
	<div id = 'adminDiv'>
	<h1>Products</h1>

	<a href = "/clothes/addProduct"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-plus-fill" viewBox="0 0 16 16">
		  	<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z"/>
	</svg></a><label style = "color: #000000">Add Products</label>

	<?php
	use App\Models\ProductsModel;
    use App\Models\SubcategoriesModel;
    use App\Models\UserModel;

	$sql_select = "SELECT * FROM tbl_product";
	$model = new ProductsModel();
	$query = $model->query($sql_select);

	echo '<table class = "about centered">
			<thead>
				<tr>
					<th>Product ID</th>
					<th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Available Quantity</th>
                    <th>Product Description</th>
                    <th>Subcategory</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Added by</th>
				</tr>
			</thead>';

			if($results = $query->getResult()){
				foreach ($results as $row) {
					$id = $row->product_id;
                    $user = $row->added_by;
                    $subcat_id = $row->subcategory_id;

                    $sql_select_user = "SELECT * FROM tbl_users WHERE user_id = $user";
                    $model_user = new UserModel();
                    $query_user = $model_user->query($sql_select_user);
                    if($results_user = $query_user->getResult()){
                        foreach ($results_user as $row_user) {
                            $username = $row_user->first_name;
                        }
                    }
                    $sql_select_subcat = "SELECT * FROM tbl_subcategories WHERE subcategory_id = '$subcat_id'";
                    $model_subcat = new SubcategoriesModel();
                    $query_subcat = $model_subcat->query($sql_select_subcat);
                    if($results_subcat = $query_subcat->getResult()){
                        foreach ($results_subcat as $row_subcat) {
                            $subcat_name = $row_subcat->subcategory_name;
                        }
                    }

					echo '<tr>
						<td>'.$row->product_id.'</td>
						<td>'.$row->product_name.'</td>
                        <td>'.$row->unit_price.'</td>
                        <td>'.$row->available_quantity.'</td>
                        <td>'.$row->product_description.'</td>
                        <td>'.$subcat_name.'</td>
                        <td>'.$row->created_at.'</td>
                        <td>'.$row->updated_at.'</td>
                        <td>'.$username.'</td>
									
						<td style = "width: 7%"><a href = "/clothes/editProduct?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
							<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
							</svg></a>

							<a href = "/Clothes/delete_product?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
							<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
							</svg></a>
						</td></tr>';
				}
			}
			echo "</table>";
		?>
</div></main>