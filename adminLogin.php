<?php

$rememberEmail = "";
if (isset($_COOKIE["email"])) {
	$rememberEmail = $_COOKIE["email"];
}
$rememberPassword = "";
if (isset($_COOKIE["password"])) {
	$rememberPassword = $_COOKIE["password"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Jadetimes - User Management System(UMS)</title>

	<!-- Meta -->
	<meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
	<meta name="author" content="Bootstrap Gallery" />
	<link rel="canonical" href="https://www.bootstrap.gallery/">
	<meta property="og:url" content="https://www.bootstrap.gallery">
	<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
	<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
	<meta property="og:type" content="Website">
	<meta property="og:site_name" content="Bootstrap Gallery">
<link rel="icon" href="assets/img/iconImg.jpg" />

	<!-- *************
			************ CSS Files *************
		************* -->
	<link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="assets/css/admin.css" />
</head>

<body class="setBackImg">
	<!-- Container start -->
	<div class="container ">
		<div class="row">

		</div>

		<div class="row justify-content-center align-content-center vh-100">


			<div class="col-xl-4 col-lg-5 col-12 align-content-center ">

				<div class="border border-light  p-4 mt-5 bg-white removeCorner">
					<div class="login-form">

						<a href="index.php" class="mb-4 d-flex d-block justify-content-center">

							<img src="assets/img/logoDark.jpg" style="height: 70px;width: auto;" class="img-fluid login-logo" alt="Jade Times Admin" />
						</a>
						<h4 class="fw-semibold mb-4 text-center">Admin Login</h4>
						<div class="alert alert-danger d-none" id="infoMessage" role="alert">
						</div>
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="text" class="form-control removeCorner" id="email" placeholder="Enter your email" value="<?php echo $rememberEmail?>" />
						</div>
						<div class="mb-3">
							<label class="form-label">Password</label>
							<div class="input-group">
								<input type="password" class="form-control removeCorner" id="password" placeholder="Enter password" value="<?php echo $rememberPassword?>" />
								<a href="#" class="input-group-text removeCorner" onclick="togglePasswordVisibility()">
									<i class="bi bi-eye"></i>
								</a>
							</div>
						</div>
						<div class="d-flex align-items-center justify-content-between">
							<div class="form-check m-0">
								<input class="form-check-input" type="checkbox" id="rememberPassword" />
								<label class="form-check-label" for="rememberPassword">Remember</label>
							</div>
							<a href="forgotPassword.php" class="text-blue text-decoration-underline">Lost password?</a>
						</div>
						<div class="d-grid py-3 mt-2">
							<button class="btn btn-lg btn-dark backgroundColorChange removeCorner" onclick="adminSignin()">
								Login
							</button>
						</div>



					</div>
				</div>

			</div>
		</div>
	</div>
	<script src="assets/js/adminLogin.js"></script>
	<!-- Container end -->
</body>

</html>