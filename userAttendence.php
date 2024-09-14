<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_user"])) {

	$userSession = $_SESSION["jd_user"];
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - user attendance </title>

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

	<body class="backgroundColorChange" onload="loadUserAttendance()">

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">

				<!-- Sidebar wrapper start -->
				<?php require "userSideBar.php"; ?>
				<!-- Sidebar wrapper end -->

				<!-- App container starts -->
				<div class="app-container">

					<!-- App header starts -->
					<?php require "userAppHeader.php" ?>
					<!-- App header ends -->

					<!-- App hero header starts -->
					<div class="app-hero-header d-flex align-items-start">

						<!-- Breadcrumb start -->
						<ol class="breadcrumb d-none d-lg-flex align-items-center">
							<li class="breadcrumb-item">
								<i class="bi bi-house text-dark"></i>
								<a href="userDashBoard.php">Home</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">Attendence</li>
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
										<div class="custom-tabs-container">
											<ul class="nav nav-tabs" id="customTab2" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab" aria-controls="oneA" aria-selected="true"><i class="bi bi-building-check text-dark"></i></a>
												</li>
												<li class="nav-item" role="presentation">
													<a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab" aria-controls="twoA" aria-selected="false"><i class="bi bi-building-add text-dark"></i></a>
												</li>

											</ul>
											<div class="tab-content">
												<div class="tab-pane fade show active" id="oneA" role="tabpanel">

													<!-- Row start -->
													<div class="row">
														<div class="col-xxl-12">
															<!-- Card start -->
															<div class="card">
																<div class="card-body">
																	<div id="dayGrid"></div>
																</div>
															</div>
															<!-- Card end -->
														</div>
													</div>

												</div>
												<div class="tab-pane fade" id="twoA" role="tabpanel">

													<div class="row">
														<div class="col-xxl-12">
															<div class="card mb-4">
																<div class="card-header">
																	<h5 class="card-title">Mark Attendence</h5>
																</div>
																<div class="card-body">
																	<?php
																	$d = new DateTime();
																	$tz = new DateTimeZone("Asia/Colombo");
																	$d->setTimezone($tz);


																	$today = $d->format("Y-m-d");

																	$results = Database::operation("SELECT * FROM `attendance` WHERE `user_id`='" . $userSession["id"] . "' AND `date_time` LIKE '" . $today . "%' ", "s");
																	$leaveAvailable = false;
																	if ($results->num_rows == 1) {
																	?>
																		<div class="col-12 alert alert-success " id="infoMessage" role="alert">
																			Attendance Already Marked
																		</div>

																		<?php
																	} else {

																		$resultsLeave = Database::operation("SELECT * FROM `leave` WHERE `user_id`='" . $userSession["id"] . "' AND `leave_date`='" . $today . "' AND `leave_status_id` IN('2','4')", "s");
																		if ($resultsLeave->num_rows == 1) {
																			$leaveAvailable = true;
																		?>
																			<div class="col-12 alert alert-danger " id="infoMessage" role="alert">
																				You are on a leave you cannot mark Attendance
																			</div>

																	<?php
																		}
																	}


																	?>

																	<!-- Row start -->
																	<div class="row" aria-disabled="">
																		<div class="col-12 alert alert-danger d-none" id="infoMessage" role="alert">
																		</div>


																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Date</label>
																				<input type="text" class="form-control removeCorner" id="date" disabled placeholder="Enter Date" value="<?php echo $today ?>" />
																			</div>
																		</div>


																		<div class="col-sm-6 col-12">
																			<div class="mb-3">
																				<label class="form-label">Tasks have Completed <small>(max characters: 1000)</small></label>
																				<textarea class="form-control removeCorner" id="task" placeholder="Tasks have Completed" rows="10"></textarea>
																			</div>
																		</div>
																	</div>
																	<!-- Row end -->
																</div>
																<div class="card-footer">
																	<div class="d-flex gap-2 justify-content-center">
																		<button type="button" class="btn btn-dark backgroundColorChange removeCorner" <?php
																																						if ($results->num_rows == 1) {
																																						?> disabled <?php
																																								} else if ($leaveAvailable) {
																																									?>
																			disabled
																			<?php
																																								}
																			?> onclick="markAttendence()">
																			Mark Attendence
																		</button>
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