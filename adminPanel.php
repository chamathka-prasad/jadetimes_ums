<?php
session_start();
if (isset($_SESSION["jd_admin"])) {
	require "connection.php";
	$admin = $_SESSION["jd_admin"];
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times Admin Panel - Manage Your News Platform Efficiently</title>

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
		<style>
			.btn-outline-custom {
				color: #181414;
				border-color: #181414;
			}

			.btn-outline-custom:hover {
				background-color: #181414;
				color: #fff;
			}

			.btn-check:checked+.btn-outline-custom {
				background-color: #181414;
				color: #fff;
				border-color: #181414;
			}
		</style>
	</head>

	<body class="backgroundColorChange" onload="loadUserAttendanceTODashBoard(0)">

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">
				<?php require "adminSideBar.php" ?>


				<!-- App container starts -->
				<div class="app-container">


					<?php require "adminAppHeader.php" ?>

					<!-- App hero header starts -->
					<div class="app-hero-header d-flex align-items-start">

						<!-- Breadcrumb start -->
						<ol class="breadcrumb d-none d-lg-flex align-items-center">
							<li class="breadcrumb-item">
								<i class="bi bi-house text-dark"></i>
								<a href="adminPanel.php">Home</a>
							</li>
							<li class="breadcrumb-item" aria-current="page">Dashboard</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->
						<div class="ms-auto d-flex flex-row">

							<div class="d-flex flex-column text-end">
								<p class="m-0 text-secondary">Welcome</p>
								<h3 class="m-0"><?php echo $admin["fname"] . " " . $admin["lname"] ?></h3>
							</div>
						</div>
						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">

						<!-- Row starts -->
						<div class="row">
							<div class="col-xl-8">
								<div class="row">
									<div class="col-xxl-6 col-sm-6 col-12">
										<div class="card mb-4">
											<div class="card-body d-flex align-items-center p-0">
												<div class="p-4">
													<i class="bi bi-pie-chart fs-1 lh-1 text-dark"></i>
												</div>
												<div class="py-4">
													<h5 class="text-secondary fw-light m-0">Head Count</h5>
													<?php
													$headCount = 0;
													$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` WHERE `user`.`user_status_id`='1'", "s");
													if ($userResultCount->num_rows == 1) {
														$count = $userResultCount->fetch_assoc();
														$headCount = $count["total_rows"];
													?>
														<h1 class="m-0 number" id="count1"><?php echo $count["total_rows"] ?></h1>
													<?php
													}

													$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `user` WHERE `user`.`user_status_id`='1' AND `user`.`type_id`='3'", "s");
													if ($userResultCount->num_rows == 1) {
														$count = $userResultCount->fetch_assoc();

														$headCount = $headCount - $count["total_rows"];
													?>

													<?php
													}
													?>

												</div>
												<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">Active</span>
											</div>
										</div>
									</div>
									<div class="col-xxl-6 col-sm-6 col-12">
										<div class="card mb-4">
											<div class="card-body d-flex align-items-center p-0">
												<div class="p-4">
													<i class="bi bi-sticky fs-1 lh-1 text-dark"></i>
												</div>
												<div class="py-4">
													<h5 class="text-secondary fw-light m-0">Pending Leaves</h5>

													<?php
													$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `leave` WHERE `leave`.`leave_status_id`='1'", "s");
													if ($userResultCount->num_rows == 1) {
														$count = $userResultCount->fetch_assoc();
													?>
														<h1 class="m-0 " id="count4"><?php echo $count["total_rows"] ?></h1>
													<?php
													}


													?>




												</div>
												<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">leaves</span>
											</div>
										</div>
									</div>

									<div class="col-xxl-6 col-sm-6 col-12">
										<div class="card mb-4">
											<div class="card-body d-flex align-items-center p-0">
												<div class="p-4">
													<i class="bi bi-star fs-1 lh-1 textredChange"></i>
												</div>
												<div class="py-4">
													<h5 class="text-secondary fw-light m-0">Attendance</h5>
													<?php
													$d = new DateTime();
													$tz = new DateTimeZone("Asia/Colombo");
													$d->setTimezone($tz);
													$today = $d->format("Y-m-d");
													$attendanceMarkedCount = 0;
													$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` INNER JOIN `user` ON `user`.`id`=`attendance`.`user_id` WHERE `user`.`user_status_id`='1' AND `attendance`.`date_time`LIKE '" . $today . "%'", "s");
													if ($userResultCount->num_rows == 1) {

														$count = $userResultCount->fetch_assoc();
														$attendanceMarkedCount = $count["total_rows"];
													?>
														<h1 class="m-0 text-success "> <span class="number" id="count2"><?php
																														if ($headCount != 0) {

																															echo number_format(($count["total_rows"] / $headCount) * 100, 2);
																														}



																														?></span> %</h1>
													<?php
													}
													?>
												</div>
												<span class="badge backGroundRed position-absolute top-0 end-0 m-3">Today</span>
											</div>
										</div>
									</div>

									<div class="col-xxl-6 col-sm-6 col-12">
										<div class="row">
											<div class="col-6">
												<div class="card mb-4 bg-success">
													<div class="card-body d-flex align-items-center py-4 ">
														<table class="w-100  text-center">
															<tr>
																<td class="">
																	<span class="m-0 text-white smallText">Marked</span>
																</td>
															</tr>
															<tr>
																<td class="">
																	<h2 class="m-0 text-white number" id="count5"><?php echo $attendanceMarkedCount; ?></h2>
																</td>
															</tr>
														</table>
													</div>

												</div>

											</div>
											<div class="col-6">
												<div class="card mb-4 backGroundRed">
													<div class="card-body d-flex align-items-center py-4 ">
														<table class="w-100  text-center">

															<tr>
																<td class="">
																	<span class="m-0 text-white smallText">Not Marked</span>
																</td>
															</tr>
															<tr>
																<td class="">
																	<h2 class="m-0 text-black number" id="count6"><?php echo $headCount - $attendanceMarkedCount ?></h2>
																</td>
															</tr>


														</table>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-xl-4  text-sm-center text-lg-center text-xl-end text-md-center text-center">

								<?php
								$imagePath = "";
								$profileImgResult = Database::operation("SELECT * FROM `id_image` WHERE `user_id`='" .  $admin["id"] . "'", "s");
								if ($profileImgResult->num_rows == 1) {
									$image = $profileImgResult->fetch_assoc();
									$imagePath = "resources/idImg/" . $image["name"];
								} else {
									$imagePath = "assets/img/card_icon.png";
								}
								?>
								<img src="<?php echo $imagePath ?>" class="img-fluid  imageSize" style="height: 400px;" />
							</div>

						</div>


						<?php

						if ($admin["user_type"] == "admin") {
						?>
							<div class="col-12">
								<hr>
							</div>

							<div class="col-xl-12 col-sm-12 col-12">
								<div class="row">
									<div class="col-12 col-xl-4">
										<div class="card mb-4">
											<?php
											$d = new DateTime();
											$tz = new DateTimeZone("Asia/Colombo");
											$d->setTimezone($tz);
											$thisMonth = $d->format("Y-m");
											$today = $d->format("Y-m-d");

											$userResultCount = Database::operation("SELECT * FROM `attendance` WHERE `attendance`.`user_id`='" . $admin["id"] . "' AND  `attendance`.`date_time`LIKE '" . $today . "%'", "s");
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
													<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 "><?php echo $today ?></span>
												</div>

											<?php
											} else {
											?>
												<div class="card-body d-flex align-items-center  p-0">
													<div class="p-4">
														<i class="bi bi-star fs-1 lh-1 textredChange"></i>
													</div>
													<div class="py-4">
														<h5 class="text-secondary fw-light m-0">Today Attendance</h5>


														<h1 class="m-0 text-light">NOT SUBMITTED</h1>

													</div>
													<span class="badge backGroundRed position-absolute top-0 end-0 m-3 "><?php echo $today ?></span>
												</div>
											<?php
											}
											?>
										</div>
									</div>

									<div class="col-12 col-xl-4">
										<div class="card mb-4">
											<div class="card-body d-flex align-items-center p-0">
												<div class="p-4">
													<i class="bi bi-pie-chart fs-1 lh-1 text-dark"></i>
												</div>
												<div class="py-4">
													<h5 class="text-secondary fw-light m-0">Attendance</h5>
													<?php

													$prev = 0;

													$prevAttendance = Database::operation("SELECT user.prev_attendance  FROM `user` WHERE `user`.`id`='" . $admin["id"] . "'", "s");
													if ($prevAttendance->num_rows == 1) {
														$prevCount = $prevAttendance->fetch_assoc();
														if (!empty($prevCount["prev_attendance"])) {
															$prev = $prevCount["prev_attendance"];
														}
													}


													$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` WHERE `attendance`.`user_id`='" . $admin["id"] . "'", "s");
													if ($userResultCount->num_rows == 1) {
														$count = $userResultCount->fetch_assoc();

													?>
														<h1 class="m-0 "><span class="number" id="count3"><?php echo ($count["total_rows"] + $prev)  ?></span> days</h1>
													<?php
													}
													?>

												</div>
												<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">Total</span>
											</div>
										</div>
									</div>

									<div class="col-12 col-xl-4">
										<div class="col-12">
											<div class="card mb-4 backgroundColorChange">

												<div class="card-body text-center">
													<?php
													$userTaskDataResult = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $admin["id"] . "'", "s");
													$userTask = "";
													if ($userTaskDataResult->num_rows == 1) {
														$userTaskData = $userTaskDataResult->fetch_assoc();
														$userTask = $userTaskData["user_task"];
													}

													?>

													<h5 class="mb-3 fw-bold text-light"><?php echo $admin["position"] ?>'s Task</h5>
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


						<!-- Row ends -->

						<div class="row">
							<hr>
						</div>

						<div class="row">
							<div class="col-xl-4 col-sm-6 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Leave Requests</h5>
									</div>
									<div class="card-body">
										<div class="scroll350">

											<?php

											$leaveResultset = Database::operation("SELECT leave.id,leave.reason,leave.leave_date,user.fname,user.lname,profile_image.name FROM `leave` INNER JOIN `user` ON `user`.`id`=`leave`.`user_id` LEFT JOIN `profile_image` ON `user`.`id`=`profile_image`.`user_id` WHERE `leave`.`leave_date`>='" . $today . "' AND `leave`.`leave_status_id`='1' ORDER BY `leave`.`leave_date` DESC LIMIT 20 OFFSET 0", "s");
											for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
												$pendingLeave = $leaveResultset->fetch_assoc();
											?>
												<div class="d-flex align-items-center mb-4">
													<img src="<?php if (empty($pendingLeave["name"])) {
																?>assets/img/defaultProfileImage.png<?php
																								} else {
																									echo "resources/profileImg/" . $pendingLeave["name"];
																								}  ?>" class="img-5x me-3 rounded-4" alt="Admin Dashboard" />
													<div class="m-0">
														<h6 class="fw-bold"><?php echo $pendingLeave["fname"] . " " . $pendingLeave["lname"] ?></h6>
														<p class="mb-2">

															<?php echo substr($pendingLeave["reason"], 0, 20) ?>

														</p>
														<p class="small mb-2 text-secondary"><?php echo $pendingLeave["leave_date"] ?></p>
													</div>
													<span class="badge backgroundColorChange ms-auto">pending</span>
												</div>
											<?php

											}

											?>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-sm-6 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Today Leaves</h5>
									</div>
									<div class="card-body">
										<div class="scroll350">

											<?php
											$d = new DateTime();
											$tz = new DateTimeZone("Asia/Colombo");
											$d->setTimezone($tz);
											$today = $d->format("Y-m-d");
											$leaveResultset = Database::operation("SELECT leave.id,leave.reason,leave.leave_date,user.fname,user.lname,profile_image.name FROM `leave` INNER JOIN `user` ON `user`.`id`=`leave`.`user_id` LEFT JOIN `profile_image` ON `user`.`id`=`profile_image`.`user_id` WHERE `leave`.`leave_date`='" . $today . "' AND `leave`.`leave_status_id`='2' ORDER BY `leave`.`leave_date` DESC LIMIT 20 OFFSET 0", "s");
											for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
												$pendingLeave = $leaveResultset->fetch_assoc();
											?>
												<div class="d-flex align-items-center mb-4">
													<img src="<?php if (empty($pendingLeave["name"])) {
																?>assets/img/defaultProfileImage.png<?php
																								} else {
																									echo "resources/profileImg/" . $pendingLeave["name"];
																								}  ?>" class="img-5x me-3 rounded-4" alt="Admin Dashboard" />
													<div class="m-0">
														<h6 class="fw-bold"><?php echo $pendingLeave["fname"] . " " . $pendingLeave["lname"] ?></h6>
														<p class="mb-2">

															<?php echo substr($pendingLeave["reason"], 0, 20) ?>

														</p>
														<p class="small mb-2 text-secondary"><?php echo $pendingLeave["leave_date"] ?></p>
													</div>
													<span class="badge bg-success ms-auto">Approved</span>
												</div>
											<?php

											}

											?>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-sm-6 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Absent Employees</h5>
									</div>
									<div class="card-body">
										<div class="scroll350">

											<?php
											$d = new DateTime();
											$tz = new DateTimeZone("Asia/Colombo");
											$d->setTimezone($tz);

											$newDate =  date('Y-m-d', strtotime($d->format('Y-m-d') . ' - 4 days'));


											$userResultSearch = Database::operation("SELECT user.id,user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,profile_image.name FROM `user` LEFT JOIN `profile_image` ON `profile_image`.`user_id`=`user`.`id` WHERE `user`.`user_status_id`='1' AND `user`.`type_id`IN('1','2','4')", "s");

											$userResultsForCheckAttendance = [];
											$lastSearchForUserDatas = [];

											if ($userResultSearch->num_rows != 0) {


												$attandance_markedByID = [];



												$userIdsFromSearch = array();

												while ($rowSearch = $userResultSearch->fetch_assoc()) {

													$userIdsFromSearch[] = $rowSearch["id"];
													$userResultsForCheckAttendance[] = $rowSearch;
													$lastSearchForUserDatas[] = $rowSearch;
												}


												$ids_string = "'" . implode("','", $userIdsFromSearch) . "'";

												$userResult = Database::operation("SELECT user.fname,user.lname,user.email,user.mobile,user.jid,user.reg_date,attendance.date_time,attendance.description,attendance.id,user.id AS `uid` FROM `user` 
										   INNER JOIN  `attendance`  ON `user`.`id`=`attendance`.`user_id` WHERE user.id IN($ids_string) AND `attendance`.`date_time` >= '" . $newDate . "'", "s");


												while ($row = $userResult->fetch_assoc()) {
													$attandance_markedByID[] = $row["uid"];
												}




												$data = [];
												$absendUserIds = [];
												if (sizeof($userResultsForCheckAttendance) != 0) {



													for ($check = 0; $check < sizeof($userResultsForCheckAttendance); $check++) {
														$all = $userResultsForCheckAttendance[$check];
														$status = in_array($all["id"], $attandance_markedByID) ? 1 : 0;
														if ($status == 0) {
															$data[] = array_values($all);
															$absendUserIds[] = $all["id"];
														}
													}
												}



												$finalData = [];
												$abs_string = "'" . implode("','", $absendUserIds) . "'";
												$leaveResultset = Database::operation("SELECT leave.reason,leave.leave_date,leave.user_id FROM `leave` WHERE `leave`.`leave_date`>'" . $newDate . "' AND `leave`.`leave_status_id`='2' AND `leave`.`user_id` IN (" . $abs_string . ")", "s");


												$leaveUserIds = [];
												if ($leaveResultset->num_rows != 0) {



													for ($ab = 0; $ab < $leaveResultset->num_rows; $ab++) {
														$all = $leaveResultset->fetch_assoc();
														$status = in_array($all["user_id"], $absendUserIds) ? 1 : 0;
														if ($status == 1) {

															$leaveUserIds[] = $all["user_id"];
														}
													}
												}

												$finalArrayData = [];
												if (sizeof($leaveUserIds) == 0) {
													$finalArrayData = $data;
												} else {
													for ($ab = 0; $ab < sizeof($absendUserIds); $ab++) {
														$all = $absendUserIds[$ab];
														$status = in_array($all, $leaveUserIds) ? 1 : 0;
														if ($status == 0) {

															$finalData[] = $all;
														}
													}

													for ($check = 0; $check < sizeof($data); $check++) {
														$all = $data[$check];
														$status = in_array($all[0], $finalData) ? 1 : 0;
														if ($status == 1) {
															$finalArrayData[] = array_values($all);
														}
													}
												}

												for ($i = 0; $i < sizeof($finalArrayData); $i++) {
													$absentUser = $finalArrayData[$i];

											?>
													<div class="d-flex align-items-center mb-4">
														<img src="<?php if ($absentUser[7] == null || empty($absentUser[7])) {
																	?>assets/img/defaultProfileImage.png<?php
																									} else {
																										echo "resources/profileImg/" . $absentUser[7];
																									}  ?>" class="img-5x me-3 rounded-4" alt="Admin Dashboard" />

														<div class="m-0">
															<h6 class="fw-bold"><?php echo $absentUser[1] . " " . $absentUser[2] ?></h6>
															<p class="mb-2">

															</p>
															<p class="small mb-2 text-secondary"></p>
														</div>
														<!-- <span class="badge bg-success ms-auto">Approved</span> -->
													</div>
											<?php

												}
											}

											?>
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
		<!-- Modal Structure -->
		<div class="modal fade" id="autoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Hello Admin !!</h5>
					</div>
					<div class="modal-body">
						<p id="feedbackMessage">You have been working with us for over three months. We would love to hear your feedback about any issues, complaints,
							or what you've learned from your experience with Jadeimes.</p>

						<div class="col-12">
							<div class="row">
								<div class="container mt-1">
									<div class="card shadow-sm">
										<div class="card-header backgroundColorChange removeCorner text-white">
											<h5 class="mb-0">Rate Your Experience</h5>
											<span id="feedbackId" class="d-none"></span>
										</div>
										<div class="card-body">
											<form id="feedbackForm">
												<!-- Rating Section -->
												<div class="mb-4">
													<label for="rating" class="form-label">Rate Us (1 to 5):</label>
													<div id="rating" class="d-flex gap-2">
														<input type="radio" class="btn-check" name="rating" id="rate1" value="1" required>
														<label class="btn btn-outline-custom  removeCorner" for="rate1">1</label>

														<input type="radio" class="btn-check" name="rating" id="rate2" value="2">
														<label class="btn btn-outline-custom  removeCorner" for="rate2">2</label>

														<input type="radio" class="btn-check" name="rating" id="rate3" value="3">
														<label class="btn btn-outline-custom  removeCorner" for="rate3">3</label>

														<input type="radio" class="btn-check" name="rating" id="rate4" value="4">
														<label class="btn btn-outline-custom  removeCorner" for="rate4">4</label>

														<input type="radio" class="btn-check" name="rating" id="rate5" value="5">
														<label class="btn btn-outline-custom  removeCorner" for="rate5">5</label>
													</div>
												</div>

												<!-- Feedback Text Area -->
												<div class="mb-4">
													<label for="feedback" class="form-label">Your Feedback:</label>
													<textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Share your thoughts..." required></textarea>
												</div>

												<!-- Submit Button -->
												<div class="text-end">
													<button type="submit" class="btn btn-dark backgroundColorChange removeCorner">Submit</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
		<script src="assets/js/admin.js"></script>


		<?php

		if ($admin["user_type"] == "admin") {
		?>
			<script>
				userFeedBackRequest();
			</script>
		<?php
		}
		?> <script>
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
				const countUp1 = new CountUp("count1", 1, 150);
				const countUp2 = new CountUp("count2", 2.14, 150);
				const countUp5 = new CountUp("count5", 1, 200);
				const countUp6 = new CountUp("count6", 1, 150);



				const countUp4 = new CountUp("count4", 1, 300);

				// Start counting
				countUp1.start();
				countUp2.start();
				countUp4.start();
				if (document.getElementById("count3")) {
					const countUp3 = new CountUp("count3", 2, 50);
					countUp3.start();

				}
				countUp5.start();
				countUp6.start();

			});
		</script>

	</body>

	</html>
<?php

} else {
?>
	<script>
		window.location = "adminLogin.php"
	</script>
<?php
}
?>