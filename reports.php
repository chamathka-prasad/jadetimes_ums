<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_user"]) || isset($_SESSION["jd_admin"])) {

	$page = 0;
	$userSession = "";
	if (isset($_SESSION["jd_user"])) {
		$userSession = $_SESSION["jd_user"];
	} else {
		$userSession = $_SESSION["jd_admin"];
	}

	if (isset($_GET["page"])) {
		$page = $_GET["page"];
		try {
			$page = (int)$page;
		} catch (Throwable $th) {

			$page = 0;
		}
	}


?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - Articles </title>

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

		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

		<!-- Calendar CSS -->
		<link rel="stylesheet" href="assets/vendor/calendar/css/main.min.css" />
		<link rel="stylesheet" href="assets/vendor/calendar/css/custom.css" />
		<link rel="stylesheet" href="assets/css/user.css" />
	</head>

	<body class="backgroundColorChange">

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">

				<!-- Sidebar wrapper start -->
				<?php
				
				if (isset($_SESSION["jd_user"])) {
					require "userSideBar.php";
				} else {
					require "adminSideBar.php";
				}
				 ?>
				<!-- Sidebar wrapper end -->

				<!-- App container starts -->
				<div class="app-container">

					<!-- App header starts -->
					<?php
					if (isset($_SESSION["jd_user"])) {
						require "userAppHeader.php";
					} else {
						require "adminAppHeader.php";
					}
					
					?>
					<!-- App header ends -->

					<!-- App hero header starts -->
					<div class="app-hero-header d-flex align-items-start">

						<!-- Breadcrumb start -->
						<ol class="breadcrumb d-none d-lg-flex align-items-center">
							<li class="breadcrumb-item">
								<i class="bi bi-house text-dark"></i>
								<a href="userDashBoard.php">Home</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">Report</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->

						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">


						<div class="row">
							<div class="col-xxl-12">
								<div class="card mb-4">
									<div class="card-body">
										<div class="row">
											<div class="col-xxl-12">
												<div class="card mb-4">
													<div class="card-header">
														<h5 class="card-title">Report</h5>
													</div>
													<div class="card-body">

														<!-- Row start -->
														<div class="row" aria-disabled="">
															<div class="col-12 alert alert-danger d-none" id="infoMessage" role="alert">
															</div>
															<div class="col-sm-6 col-12">
																<div class="mb-3">
																	<label class="form-label"></label>
																	<textarea class="form-control removeCorner" id="title" placeholder="describe the condition" rows="5"></textarea>
																</div>
																<div class="d-flex gap-2 justify-content-center">
																	<button type="button" onclick="addNewReport()" class="btn btn-dark backgroundColorChange removeCorner">
																		Report
																	</button>
																</div>
															</div>
														</div>
														<!-- Row end -->
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>











					</div>
					<!-- App body ends -->

					<!-- App footer start -->
					<div class="app-footer">
						<span>© 2024 Jadetimes Media LLC. All rights reserved.</span>
					</div>
					<!-- App footer end -->

				</div>
				<!-- App container ends -->

			</div>
			<!-- Main container end -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->

		<!-- Overlay Scroll JS -->
		<script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
		<script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

		<!-- Calendar JS -->
		<script src="assets/vendor/calendar/js/main.min.js"></script>
		<!-- <script src="assets/vendor/calendar/custom/daygrid-calendar.js"></script> -->

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>
		<script src="assets/js/user.js"></script>
		<script>
			document.getElementById('title').addEventListener('paste', function(event) {
				event.preventDefault();
				let paste = (event.clipboardData || window.clipboardData).getData('text');
				paste = paste.replace(/[\x00-\x1F\x7F-\x9F]/g, ''); // Remove control characters
				document.getElementById('title').value = paste.trim(); // Clean and trim the pasted input
			});

			function addNewReport() {
				var msg = document.getElementById("infoMessage");
				var title = document.getElementById("title");

				if (!title.value) {

					msg.innerHTML = "Describe the Condition";
					msg.classList = "alert alert-danger";

				} else {

					var formData = new FormData();
					formData.append("title", title.value);
					fetch(baseUrl + "reportSubmittProcess.php", {
							method: "POST",
							body: formData,

						})
						.then(function(resp) {

							try {
								let response = resp.json();
								return response;
							} catch (error) {
								msg.classList = "alert alert-danger";
								msg.innerHTML = "Something wrong please try again";
								emailField.classList = "form-control";
								passwordField.classList = "form-control";
							}

						})
						.then(function(value) {

							if (value.type == "error") {
								msg.classList = "alert alert-danger";
								msg.innerHTML = value.message;

							} else if (value.type == "success") {
								msg.classList = "alert alert-success";
								msg.innerHTML = value.message;
								title.value = "";

								setTimeout(function() {
									msg.classList = "d-none";

								}, 2000);

							} else {
								msg.classList = "alert alert-danger";
								msg.innerHTML = "Something wrong please try again";
								emailField.classList = "form-control";
								passwordField.classList = "form-control";
							}

						})
						.catch(function(error) {
							console.log(error);
						});


				}
			}
		</script>
	</body>

	</html>
<?php

} else {
?>
	<script>
		window.location = "userLogin.php";
	</script>
<?php
}
?>