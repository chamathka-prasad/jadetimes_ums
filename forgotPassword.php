<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Jade Times user forgot password / recover your password</title>

	<!-- Meta -->
	<meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
	<meta name="author" content="Bootstrap Gallery" />
	<link rel="canonical" href="https://www.bootstrap.gallery/">
	<meta property="og:url" content="https://www.bootstrap.gallery">
	<meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
	<meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
	<meta property="og:type" content="Website">
	<meta property="og:site_name" content="Bootstrap Gallery">
	<link rel="shortcut icon" href="assets/img/iconImg.jpg" />

	<!-- *************
			************ CSS Files *************
		************* -->
	<link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="assets/css/user.css"/>

</head>

<body class="bg-white">
	<!-- Container start -->
	<div class="container ">
	    
		<div class="row justify-content-center align-content-center vh-100">
			<div class="col-xl-4 col-lg-5 col-sm-12 col-12">

				<div class="border border-light p-4 mt-5 removeCorner">
					<div class="login-form">

						<div class="row">
							<div class="alert alert-danger d-none" id="infoMessage" role="alert">
							</div>
							<div class="col-12 " id="reqbox">
							    <div class="row">
							        <a href="userLogin.php" class="mb-4  text-center">
									<img src="assets/img/logoDark.jpg" style="height: 80px;width: auto;" class="img-fluid login-logo" alt="" />
								</a>
							    </div>
								
								<h6 class="fw-light mb-4 lh-2">
									In order to access your account, please enter the email id you
									provided during the registration process.
								</h6>
								<div class="mb-3">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-12">
													<label class="form-label">Your Email</label>
												</div>
												<div class="col-9 ps-4 pe-3">
<div class="row">
    <input type="text" id="forgotEmail" class="form-control removeCorner" placeholder="Enter your email" />
</div>
    	

												
												</div>
												<div class="col-3">
												    <div class="row pe-2">
												        	<button onclick="getVerificationCode()" class="btn smallText btn-lg   btn-dark backgroundColorChange removeCorner">
														Request
													</button>
												    </div>
												
												</div>
											</div>


										</div>



									</div>



								</div>

							</div>

							<div class="col-12 d-none" id="refbox">
								<div class="row">
									<div class="col-12">
										<label class="form-label">Reference code</label>
										<input type="text" id="frefcode" class="form-control removeCorner" placeholder="reference code" />

										<hr>
									</div>
									<div class="col-12">
										<label class="form-label">New Password</label>
										<input type="text" id="fnewPassword" class="form-control removeCorner" placeholder="Enter the Password" />
									</div>
									<div class="col-12">
										<label class="form-label">Repeat the Password</label>
										<input type="text" id="frepPassword" class="form-control removeCorner" placeholder="Repeat the Password" />
									</div>
									<div class="col-12 mt-3 ">
									    
										<button class="btn w-100 smallText btn-lg  btn-dark backgroundColorChange removeCorner" onclick="recoverAndChangeThePassword()">
											Recover
										</button>
									</div>
								</div>

							</div>
							<div class="col-12">
								<div class="row">

									<div class="col-6">
										<a href="userLogin.php" class="text-decoration-underline">Go to User LogIn</a>
									</div>
									<div class="col-6 text-end ">
										<a href="adminLogin.php" class="text-decoration-underline">Go to Admin Login</a>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	
	</div>
	<script src="assets/js/changePassword.js"></script>
	<!-- Container end -->
</body>

</html>