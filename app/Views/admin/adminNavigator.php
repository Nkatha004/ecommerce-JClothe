
<nav class="navbar">
	<div class="container-fluid">
		<a class="navbar-brand" href="#"></a>
		<button style= "width: 20%;background-color: #149ddd;color: #000000"class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">Admin Navigator
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<form class="d-flex">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form>
				<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
					
					<li class="nav-item">
						<a class="nav-link" href="users">Users</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="addNewAdmin">Add New Admin</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/clothes/analytics">Analytics</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/clothes/api_user">API</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Roles
						</a>
						<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
							<li>
								<a class="dropdown-item" href="/clothes/role">View Roles</a>
							</li>
							<li>
								<a class="dropdown-item" href="/clothes/addRole">Add Role</a>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Payment Type
						</a>
						<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
							<li>
								<a class="dropdown-item" href="/clothes/paymenttype">View</a>
							</li>
							<li>
								<a class="dropdown-item" href="/clothes/addPaymenttype">Add </a>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Category
						</a>
						<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
							<li>
								<a class="dropdown-item" href="/clothes/category">View Categories</a>
							</li>
							<li>
								<a class="dropdown-item" href="/clothes/addcategory">Add category</a>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Sub category
						</a>
						<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
							<li>
								<a class="dropdown-item" href="/clothes/subcategory">View</a>
							</li>
							<li>
								<a class="dropdown-item" href="/clothes/addSubcategory">Add </a>
							</li>
						</ul>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Clothing
						</a>
						<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
		
							<li>
								<a class="dropdown-item" href="/clothes/product">View table</a>
							</li>
							<li><a class="dropdown-item" href="/clothes/productView">View images</a></li>
							<li>
								<a class="dropdown-item" href="/clothes/addProduct">Add clothing</a>
							</li>
							
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</div>
</nav>
