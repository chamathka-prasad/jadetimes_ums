<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_admin"])) {

	$admin = $_SESSION["jd_admin"];

	$attendanceId = $_GET["aId"];

	$resultProfile = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`fname`,`user`.`lname`,`user`.`sname`,`user`.`mname`,`user`.`mobile`,`user`.`jid`,`user`.`nic`,`user`.`dob`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `img`,`attendance`.`date_time`,`attendance`.`description` FROM `user` INNER JOIN `attendance` ON `attendance`.`user_id`=`user`.`id` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN  `user_status` ON `user`.`user_status_id`=`user_status`.`id`
INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id`  WHERE `attendance`.`id`='" . $attendanceId . "';", "s");


	$Profile;

	if ($resultProfile->num_rows == 1) {
		$Profile = $resultProfile->fetch_assoc();
	} else {
?>
		<script>
			window.location = "manageAttendence.php";
		</script>
	<?php
	}
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - view user attendance details</title>

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
								<a href="adminPanel.php">Home</a>
							</li>
							<li class="breadcrumb-item"><a href="manageAttendence.php">Manage Aattendance</a></li>
							<li class="breadcrumb-item" aria-current="page">View Attendance</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->

						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">

						<div class="row">
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="card mb-4 rounded-5">
									<div class="card-body">
										<div class="d-flex align-items-center flex-column">
											<div class="mb-3">

												<img src="<?php if (empty($Profile["img"])) {
															?>assets/img/defaultProfileImage.png<?php
																							} else {
																								echo "resources/profileImg/" . $Profile["img"];
																							}  ?>" class="img-6x rounded-circle" alt="" />

											</div>
											<h5 class="mb-3"><?php echo $Profile["fname"] . " " . $Profile["lname"] ?></h5>
											<p><?php echo $Profile["email"] ?></p>
											<div class="mb-3">
												<span class="badge bg-danger"><?php echo $Profile["department"] ?></span>
												<span class="badge bg-info"><?php echo $Profile["position"] ?></span>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-8 col-sm-6 col-12">
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-12 mb-3">
												<div class="alert alert-danger d-none" id="infoMessage" role="alert">
												</div>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="card">
											<div class="card-body">


												<div class="alert alert-success" role="alert">
													<div class="mb-3">
														<i class="bi bi-check-circle fs-1 me-2 lh-1"></i>
													</div>
													<h4 class="alert-heading">Task have Completed</h4>
													<p>
														Attendance Date -> <?php echo $Profile["date_time"] ?>
													</p>
													<hr />
													<p>
														<?php echo $Profile["description"] ?>
													</p>
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

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>
		<script src="assets/js/admin.js"></script>
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