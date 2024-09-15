<?php
session_start();
if (isset($_SESSION["jd_user"])) {
	require "connection.php";
	$user = $_SESSION["jd_user"];
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times User Dashboard - Personalized News Experience /mark Attendance/leaves</title>

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
		<link rel="stylesheet" href="assets/css/user.css" />
	</head>

	<body class="backgroundColorChange">

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">
				<?php require "userSideBar.php" ?>


				<!-- App container starts -->
				<div class="app-container">


					<?php require "userAppHeader.php" ?>

					<!-- App hero header starts -->
					<div class="app-hero-header d-flex align-items-start">

						<!-- Breadcrumb start -->
						<ol class="breadcrumb d-none d-lg-flex align-items-center">
							<li class="breadcrumb-item">
								<i class="bi bi-house text-black"></i>
								<a href="userDashBoard.php">Home</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">Dashboard</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->
						<div class="ms-auto d-flex flex-row">

							<div class="d-flex flex-column text-end">
								<p class="m-0 text-secondary">welcome</p>
								<h3 class="m-0"><?php echo $user["fname"] . " " . $user["lname"] ?></h3>
							</div>
						</div>
						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">
						<div class="row">

							<?php
							if ($user["user_type"] != "contributor") {
							?>

								<div class="col-12 col-xl-4 col-sm-6 col-12">
									<div class="row">
										<div class="col-12">
											<div class="row">
												<div class="col-12">
													<div class="card mb-4">
														<?php
														$d = new DateTime();
														$tz = new DateTimeZone("Asia/Colombo");
														$d->setTimezone($tz);
														$thisMonth = $d->format("Y-m");
														$today = $d->format("Y-m-d");

														$userResultCount = Database::operation("SELECT * FROM `attendance` WHERE `attendance`.`user_id`='" . $user["id"] . "' AND  `attendance`.`date_time`LIKE '" . $today . "%'", "s");
														if ($userResultCount->num_rows == 1) {


														?>
															<div class="card-body d-flex align-items-center backGroundRed p-0">
																<div class="p-4">
																	<i class="fs-1 lh-1 bi bi-check2-circle text-light"></i>
																</div>
																<div class="py-4">
																	<h5 class="text-light m-0">Today Attendance</h5>


																	<h1 class="m-0 text-light">SUBMITTED</h1>

																</div>
																<span class="badge backgroundColorChange text-light position-absolute top-0 end-0 m-3 "><?php echo $today ?></span>
															</div>

														<?php
														} else {
														?>
															<div class="card-body d-flex align-items-center  p-0">
																<div class="p-4">
																	<i class="bi bi-star fs-1 lh-1  textredChange"></i>
																</div>
																<div class="py-4">
																	<h5 class="text-secondary fw-light m-0">Today Attendance</h5>


																	<h1 class="m-0 text-light">NOT SUBMITTED</h1>

																</div>
																<span class="badge  backGroundRed position-absolute top-0 end-0 m-3 "><?php echo $today ?></span>
															</div>
														<?php
														}
														?>
													</div>
												</div>

												<div class="col-12">
													<div class="card mb-4">
														<div class="card-body d-flex align-items-center p-0">
															<div class="p-4">
																<i class="bi bi-pie-chart fs-1 lh-1 text-dark "></i>
															</div>
															<div class="py-4">
																<h5 class="text-secondary fw-light m-0">Attendance</h5>
																<?php
																$prev = 0;

																$prevAttendance = Database::operation("SELECT user.prev_attendance  FROM `user` WHERE `user`.`id`='" . $user["id"] . "'", "s");
																if ($prevAttendance->num_rows == 1) {
																	$prevCount = $prevAttendance->fetch_assoc();
																	if (!empty($prevCount["prev_attendance"])) {
																		$prev = $prevCount["prev_attendance"];
																	}
																}
																$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` WHERE `attendance`.`user_id`='" . $user["id"] . "'", "s");
																if ($userResultCount->num_rows == 1) {
																	$count = $userResultCount->fetch_assoc();

																?>
																	<h1 class="m-0"><span id="count1" class="number"><?php


																														echo ($count["total_rows"] + $prev);



																														?></span> days</h1>
																<?php
																}
																?>

															</div>
															<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">Total</span>
														</div>
													</div>
												</div>



											</div>
										</div>
										<div class="col-12">
											<div class="col-12">
												<div class="card mb-4 backgroundColorChange">

													<div class="card-body text-center">
														<?php
														$userTaskDataResult = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $user["id"] . "'", "s");
														$userTask = "";
														if ($userTaskDataResult->num_rows == 1) {
															$userTaskData = $userTaskDataResult->fetch_assoc();
															$userTask = $userTaskData["user_task"];
														}

														?>

														<h5 class="mb-3 fw-bold text-light"><?php echo $user["position"] ?>'s Task</h5>
														<p class="lh-base mb-4 text-light"><?php echo $userTask ?></p>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Row ends -->




								<div class="col-xl-4 col-sm-6 col-12">
									<div class="card mb-4">
										<div class="card-header">
											<h5 class="card-title">Leave Requests</h5>
										</div>
										<div class="card-body">
											<div class="scroll350">

												<?php

												$leaveResultset = Database::operation("SELECT leave.leave_status_id,leave.reason,leave.leave_date,user.fname,user.lname FROM `leave` INNER JOIN `user` ON `user`.`id`=`leave`.`user_id` WHERE `leave`.`leave_date`>='" . $today . "' AND `leave`.`user_id`='" . $user["id"] . "' ORDER BY `leave`.`leave_date` DESC LIMIT 20 OFFSET 0", "s");
												for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
													$pendingLeave = $leaveResultset->fetch_assoc();
												?>
													<div class="d-flex align-items-center mb-4">

														<div class="m-0">
															<h6 class="fw-bold"><?php echo $pendingLeave["fname"] . " " . $pendingLeave["lname"] ?></h6>
															<p class="mb-2">

																<?php echo substr($pendingLeave["reason"], 0, 20) ?>

															</p>
															<p class="small mb-2 text-secondary"><?php echo $pendingLeave["leave_date"] ?></p>
														</div>
														<?php if ($pendingLeave["leave_status_id"] == 1) {
														?>
															<span class="badge bg-info ms-auto">
															<?php
															echo "Pending";
														} else if ($pendingLeave["leave_status_id"] == 2) {
															?>
																<span class="badge bg-success ms-auto">
																<?php
																echo "Approved";
															} else {
																?>
																	<span class="badge bg-danger ms-auto">
																	<?php
																	echo "Rejected";
																} ?></span>
													</div>
												<?php

												}

												?>
											</div>
										</div>
									</div>
								</div>



								<div class="col-xl-4 col-sm-12 col-12">
									<div class="card mb-4">
										<div class="card-header">
											<h5 class="card-title">Recent Attendance</h5>
										</div>
										<div class="card-body">
											<div class="scroll350">
												<div class="d-grid  mt-4">

													<?php
													$d = new DateTime();
													$tz = new DateTimeZone("Asia/Colombo");
													$d->setTimezone($tz);
													$today = $d->format("Y-m-d");
													$leaveResultset = Database::operation("SELECT attendance.date_time,user.fname,user.lname,profile_image.name FROM `attendance` INNER JOIN `user` ON `user`.`id`=`attendance`.`user_id` LEFT JOIN `profile_image` ON `user`.`id`=`profile_image`.`user_id` WHERE `user`.`id`='" . $user["id"] . "' ORDER BY `attendance`.`date_time` DESC LIMIT 20 OFFSET 0", "s");
													for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
														$pendingLeave = $leaveResultset->fetch_assoc();

														$dateSplit = explode(" ", $pendingLeave["date_time"]);
													?>
														<div class="d-flex align-items-center bg-success-subtle">

															<div class="d-flex flex-column">
																<p class="ms-1 m-auto"><b><?php echo $dateSplit[0] ?></b></p>

															</div>
															<p class=" ms-auto text-dark me-1"><?php echo $dateSplit[1] ?></p>


														</div>
														<br>
													<?php

													}

													?>


												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
							} else {
							?>
								<div class="col-12">
									<div class="row">
										<div class="col-12 col-lg-4">
											<div class="row">


												<div class="col-12">
													<div class="card mb-4">
														<div class="card-body d-flex align-items-center p-0">
															<div class="p-4">
																<i class="bi bi-currency-dollar fs-1 lh-1 text-dark"></i>
															</div>
															<div class="py-4">
																<h5 class="text-secondary fw-light m-0">Commercial</h5>
																<?php
														
																$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `article` WHERE `article`.`user_id`='" . $user["id"] . "' AND `article`.`type`='1'", "s");
																if ($userResultCount->num_rows == 1) {
																	$count = $userResultCount->fetch_assoc();

																?>
																	<h1 class="m-0"><span id="count1" class="number"><?php


																														echo ($count["total_rows"]);



																														?></span> Articles</h1>
																<?php
																}
																?>

															</div>

														</div>
													</div>
												</div>



											</div>
										</div>
										<div class="col-12 col-lg-4">
											<div class="row">


												<div class="col-12">
													<div class="card mb-4">
														<div class="card-body d-flex align-items-center p-0">
															<div class="p-4">
																<i class="bi bi-gift-fill fs-1 lh-1 text-dark"></i>
															</div>
															<div class="py-4">
																<h5 class="text-secondary fw-light m-0">Non Commercial</h5>
																<?php
													
																$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `article` WHERE `article`.`user_id`='" . $user["id"] . "' AND `article`.`type`='2'", "s");
																if ($userResultCount->num_rows == 1) {
																	$count = $userResultCount->fetch_assoc();

																?>
																	<h1 class="m-0"><span id="count2" class="number"><?php


																														echo ($count["total_rows"]);



																														?></span> Articls</h1>
																<?php
																}
																?>

															</div>

														</div>
													</div>
												</div>



											</div>
										</div>
										<div class="col-12 col-lg-6">
											<div class="col-12">
												<div class="card mb-4 backgroundColorChange">

													<div class="card-body text-center">
														<?php
														$userTaskDataResult = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $user["id"] . "'", "s");
														$userTask = "";
														if ($userTaskDataResult->num_rows == 1) {
															$userTaskData = $userTaskDataResult->fetch_assoc();
															$userTask = $userTaskData["user_task"];
														}

														?>

														<h5 class="mb-3 fw-bold text-light"><?php echo $user["position"] ?>'s Task</h5>
														<p class="lh-base mb-4 text-light"><?php echo $userTask ?></p>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
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

		<!-- Apex Charts -->
		<script src="assets/vendor/apex/apexcharts.min.js"></script>
		<script src="assets/vendor/apex/custom/dash1/activity-report.js"></script>
		<script src="assets/vendor/apex/custom/dash1/deals.js"></script>
		<script src="assets/vendor/apex/custom/dash1/sparkline.js"></script>
		<script src="assets/vendor/apex/custom/dash1/sparkline2.js"></script>

		<!-- Rating -->
		<script src="assets/vendor/rating/raty.js"></script>
		<script src="assets/vendor/rating/raty-custom.js"></script>

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				function CountUp(elementId, increment, interval = 1000) {
					this.element = document.getElementById(elementId);

					// Check if the element exists
					if (!this.element) {
						console.error(`Element with ID "${elementId}" not found.`);
						return; // Exit if the element is not found
					}

					this.targetNumber = parseFloat(this.element.innerText);
					this.currentNumber = 0;
					this.increment = increment || 1;
					this.intervalTime = interval; // Set the interval time

					// Set initial content to 0
					this.element.innerText = '0';

					this.updateNumber = () => {
						if (this.currentNumber < this.targetNumber) {


							setTimeout(() => {
								this.currentNumber = Math.min(this.currentNumber + this.increment, this.targetNumber);
								this.element.textContent = this.currentNumber % 1 === 0 ? this.currentNumber : this.currentNumber.toFixed(2);
								this.element.style.opacity = '1';
							}, 500);
						} else {
							clearInterval(this.intervalId);
						}
					};

					this.start = () => {
						this.intervalId = setInterval(this.updateNumber, this.intervalTime);
					};
				}
				// Create multiple CountUp instances
				const countUp1 = new CountUp("count1", 1, 20);
				countUp1.start();
				<?php
				if ($user["user_type"] == "contributor") {
				?>
					const countUp2 = new CountUp("count2", 1, 20);
					countUp2.start();
				<?php
				}
				?>
			});
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