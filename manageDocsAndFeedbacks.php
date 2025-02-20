<!-- <?php
		session_start();
		require "connection.php";
		// if (isset($_SESSION["jd_user"]) && $_SESSION["jd_user"]["user_type"] == "admin" || isset($_SESSION["jd_user"]) && $_SESSION["jd_user"]["user_type"] == "director") {

		// 	$admin = $_SESSION["jd_user"];


		// 	$resultProfile = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`fname`,`user`.`lname`,`user`.`sname`,`user`.`mname`,`user`.`mobile`,`user`.`jid`,`user`.`nic`,`user`.`dob`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `img`,`user`.`user_status_id` AS `stat` FROM `user`  INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN  `user_status` ON `user`.`user_status_id`=`user_status`.`id`
		// INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`  WHERE `department`.`name`='" . $_SESSION["jd_user"]["department"] . "' ORDER BY `user`.`user_status_id` ASC", "s");

		?> -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Jade Times - Manage Documents And Feedbacks </title>

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
	<link rel="stylesheet" href="assets/css/admin.css" />
</head>

<body class="backgroundColorChange">

	<!-- Page wrapper start -->
	<div class="page-wrapper">

		<!-- Main container start -->
		<div class="main-container">

			<!-- Sidebar wrapper start -->
			<?php require "adminSideBar.php" ?>
			<!-- Sidebar wrapper end -->

			<!-- App container starts -->
			<div class="app-container">

				<!-- App header starts -->
				<?php require "adminAppHeader.php" ?>
				<!-- App header ends -->

				<!-- App hero header starts -->
				<div class="app-hero-header d-flex align-items-start">

					<!-- Breadcrumb start -->
					<ol class="breadcrumb d-none d-lg-flex align-items-center">
						<li class="breadcrumb-item">
							<i class="bi bi-house text-dark"></i>
							<a href="userDashBoard.php">Home</a>
						</li>

						<li class="breadcrumb-item" aria-current="page">Employees</li>
					</ol>
					<!-- Breadcrumb end -->

					<!-- Sales stats start -->

					<!-- Sales stats end -->

				</div>
				<!-- App Hero header ends -->

				<!-- App body starts -->
				<div class="app-body">

					<div class="row">
						<div class="col-sm-4 col-12">
							<div class="card shadow mb-4">
								<div class="card-img">
									<img src="assets/img/LogInBack.jpg" class="card-img-top img-fluid" alt="Google Admin" />
								</div>
								<div class="card-header">
									<h5 class="card-title m-0">Normal Documents</h5>
								</div>
								<div class="card-body">
									<p class="mb-4">
										Send Feedbacks To Employees <br>
										View Feedbacks <br>
										Upload Documents
									</p>
									<a href="documentSection.php" class="btn btn-primary backgroundColorChange rounded-0">View</a>
								</div>
							</div>
						</div>

						<div class="col-sm-4 col-12">
							<div class="card shadow mb-4">
								<div class="card-img">
									<img src="assets/img/LogInBack.jpg" class="card-img-top img-fluid" alt="Google Admin" />
								</div>
								<div class="card-header">
									<h5 class="card-title m-0">Certificates and Service letters </h5>
								</div>
								<div class="card-body">
									<p class="mb-4">
										Send Feedbacks To Employees <br>
										View Feedbacks <br>
										Upload Documents
									</p>
									<a href="cetiandServiceLetterFeedbacks.php" class="btn btn-primary backgroundColorChange rounded-0">View</a>
								</div>
							</div>
						</div>

						<div class="col-sm-4 col-12">
							<div class="card shadow mb-4">
								<div class="card-img">
									<img src="assets/img/LogInBack.jpg" class="card-img-top img-fluid" alt="Google Admin" />
								</div>
								<div class="card-header">
									<h5 class="card-title m-0">Manage User Feedbacks</h5>
								</div>
								<div class="card-body">
									<p class="mb-4">
										Feedbacks After 2025/02/15 <br>
										Monthly Feedbacks <br>
										Users And Admins
									</p>
									<a href="#" class="btn btn-primary backgroundColorChange rounded-0">View</a>
								</div>
							</div>
						</div>

						<div class="col-sm-4 col-12">
							<div class="card shadow mb-4">
								<div class="card-img">
									<img src="assets/img/LogInBack.jpg" class="card-img-top img-fluid" alt="Google Admin" />
								</div>
								<div class="card-header">
									<h5 class="card-title m-0">Past Feedbacks </h5>
								</div>
								<div class="card-body">
									<p class="mb-4">
										Feedbacks Before 2025/02/15
									</p>
									<a href="#" class="btn btn-primary backgroundColorChange rounded-0">View</a>
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

	<!-- Custom JS files -->
	<script src="assets/js/custom.js"></script>
	<script src="assets/js/admin.js"></script>
</body>

</html>

<?php

// } else {
?>
<!-- <script>
		window.location = "userLogin.php";
	</script> -->
<?php
// }
?>