<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_admin"])) {

	$admin = $_SESSION["jd_admin"];


	$resultProfile = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`fname`,`user`.`lname`,`user`.`sname`,`user`.`mname`,`user`.`mobile`,`user`.`jid`,`user`.`nic`,`user`.`dob`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`profile_image`.`name` AS `img`,`user`.`user_status_id` AS `stat`,`pending_attendance`.`id` AS `pendingId`,`pending_attendance`.`date_time`,`pending_attendance`.`task`  FROM `user`  INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN  `user_status` ON `user`.`user_status_id`=`user_status`.`id`
INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id` INNER JOIN `pending_attendance` ON `pending_attendance`.`user_id`=`user`.`id`  WHERE  `pending_attendance`.`status`='1'  ORDER BY `user`.`user_status_id` ASC", "s");

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - Pending Attendance </title>

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

							<li class="breadcrumb-item" aria-current="page">Pending Attendance</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->

						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">
						<div class="row">
							<div class="col-12 alert alert-danger d-none" id="infoMessage" role="alert">
							</div>
						</div>

						<div class="row">
							<?php

							if ($resultProfile->num_rows != 0) {


								while ($Profile = $resultProfile->fetch_assoc()) {

							?>
									<div class="col-xl-6 col-md-12 col-12">
										<div class="card mb-4 rounded-5">
											<div class="card-body">
												<div class="row text-center bg-info my-2">
													<span class="text-white">Attendance For : <?php
																								echo $Profile["date_time"]
																								?></span>
												</div>
												<div class="row">
													<div class="col-xl-4 col-md-4">
														<div class="d-flex align-items-center flex-column">
															<div class="mb-3">

																<img src="<?php if (empty($Profile["img"])) {
																			?>assets/img/defaultProfileImage.png<?php
																											} else {
																												echo "resources/profileImg/" . $Profile["img"];
																											}  ?>" class="img-6x rounded-circle" alt="" />

															</div>
															<h5 class="mb-3"><?php echo $Profile["fname"] . " " . $Profile["lname"] ?></h5>

														</div>
													</div>
													<div class="col-xl-8 col-md-8">
														<div class="d-flex align-items-start flex-column">
															<div class="mb-3">

																<span class="fw-bold">Articles</span>
															</div>

															<?php
															$pendingArticleResult = Database::operation("SELECT * FROM `pending_articles` WHERE `pid`='" . $Profile["pendingId"] . "'", "s");
															if ($pendingArticleResult->num_rows > 0) {
																$aNum = 1;
																while ($row = $pendingArticleResult->fetch_assoc()) {
															?>
																	<p><i class="bi bi-journal-text"></i>&nbsp;&nbsp;<?php echo $aNum ?> &nbsp;<?php echo $row["title"] ?></p>
															<?php
																	$aNum++;
																}
															}

															?>

														</div>
													</div>

												</div>
												<div class="row">

													<div class="d-flex align-items-center flex-column">
														<div class="mb-3">
															<span class="fw-bold">
																<?php
																echo $Profile["task"]
																?>
															</span>
														</div>
													</div>
												</div>
												<div class="row">

													<div class="d-flex align-items-center flex-column">
														<div class="mb-3">

															<button class="btn btn-success" onclick="approveAttendance(<?php echo $Profile['pendingId'] ?>)">Approve</button>
															<span class="fw-bold"></span>
														</div>
													</div>
												</div>


											</div>
										</div>
									</div>
								<?php
								}
								?>

							<?php


							} else {
							?>
								<p class="text-center">No Pending Attendance</p>
							<?php
							}

							?>

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
	<script>
		function approveAttendance(id) {
			var msg = document.getElementById("infoMessage");
			if (id.length != 0) {
				fetch("attendanceapproveProcess.php?pid=" + id, {
						method: "GET",
					})
					.then(function(resp) {

						try {
							let response = resp.json();
							return response;
						} catch (error) {
							msg.classList = "alert alert-danger";
							msg.innerHTML = "Something wrong please try again";

						}

					})
					.then(function(value) {

						if (value.type == "error") {
							msg.classList = "alert alert-danger";
							msg.innerHTML = value.message;

						} else if (value.type == "success") {
							msg.classList = "alert alert-success";
							msg.innerHTML = value.message;

							setTimeout(() => {
								window.location = "adminPendingAttendanceView.php";
							}, 1000);
						} else {
							msg.classList = "alert alert-danger";
							msg.innerHTML = "Something wrong please try again";

						}

					})
					.catch(function(error) {
						console.log(error);
					});
			}
		}
	</script>

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