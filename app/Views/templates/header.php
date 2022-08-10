<?php 
if(!isset($_SESSION))
{
	session_start();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JClothe</title>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href= "../assets/styles.css">

</head>
<body class = "landing">
	<header class = "landing">
		<a href = "/clothes/userprofile"><div style = "text-align: right; padding-right: 20px; padding-top: 10px;">
			<p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">

	 			<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
	  			<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
	  					
			</svg>
			
			<?php
				$fname = $_SESSION['firstName']??null;
				$lname = $_SESSION['lastName']??null;
				echo $fname." ".$lname ?? null;?></p></div></a>

		<nav class = "navbar-nav mr-auto">
			<ul>
				<li class="nav-item"><a href = "/clothes/index">HOME</a></li>
				<li class="nav-item"><a href = "">CONTACT US</a></li>
				<li class="nav-item"><a href = "/clothes/productView">SHOP</a></li>
				<a href = "/clothes/registration"><button class = "right">Register</button></a>
				<a href = "/clothes/login"><button class = "right">Login</button></a>
			</ul>
		</nav>

	</header>