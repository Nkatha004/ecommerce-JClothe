<main>
<div id = "adminDiv" class = "centered">

	<h1>Users</h1>
	<?php
	use App\Models\UserModel;
	use App\Models\RolesModel;

	$sql_select = "SELECT * FROM tbl_users";
	
	$model = new UserModel();
	$query = $model->query($sql_select);

	echo '<table class = "about centered">

			<thead>
				<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Gender</th>
					<th>Role</th>
					<th>Role Name</th>
				</tr>
			</thead>';

			if($results = $query->getResult()){
				foreach ($results as $row) {
					$id = $row->user_id;
					$email = $row->email;
					$role = $row->role;

					$select_role = "SELECT role_name FROM tbl_roles WHERE role_id = '$role'";
					$model_roles = new RolesModel();
					$query_role = $model_roles->query($select_role);

					if($result = $query_role->getResult()){
						foreach ($result as $role_row) {
						echo '<tr>
							<td>'.$row->user_id.'</td>
							<td>'.$row->first_name.'</td>
							<td>'.$row->last_name.'</td>
							<td>'.$row->email.'</td>
							<td>'.$row->gender.'</td>
							<td>'.$row->role.'</td>
							<td>'.$role_row->role_name.'</td>
										
							<td><a href = "/clothes/edit_users?id='.$email.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
								<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
								</svg></a>

								<a href = "/clothes/delete_users?id='.$id.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
								<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
								</svg></a>
							</td></tr>';
						}
					}
				}
			}
			echo "</table>";
		?>
</div></main>