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
		<title>Jade Times - view user leave / request leave </title>

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

	<body class="backgroundColorChange" onload="">

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
							<li class="breadcrumb-item" aria-current="page">Leaves</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->

						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body" id="mainRow">


						<div class="row">
							<div class="col-xxl-12">
								<div class="card mb-4">
									<div class="card-body">
										<div class="custom-tabs-container">
											<ul class="nav nav-tabs" id="customTab2" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab" aria-controls="oneA" aria-selected="true"><i class="bi bi-list-nested text-dark"></i></a>
												</li>
												<li class="nav-item" role="presentation">
													<a class="nav-link" id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab" aria-controls="twoA" aria-selected="false"><i class="bi bi-send-plus-fill text-dark"></i></a>
												</li>

											</ul>
											<div class="tab-content">
												<div class="tab-pane fade show active" id="oneA" role="tabpanel">

													<div class="row">

														<div class="col-xxl-12">
															<div class="card mb-4">
																<div class="card-body">
																	<div class="card-header">
																		<h5 class="card-title">Leaves</h5>
																	</div>
																	<div class="table-responsive mt-5">
																		<table class="table table-bordered m-0">
																			<thead>
																				<tr>
																					<th>#</th>
																					<th>Status</th>
																					<th>Date</th>

																				</tr>
																			</thead>
																			<tbody>

																				<?php
																				$leaveResultset = Database::operation("SELECT * FROM `leave` WHERE `leave`.`user_id`='" . $userSession["id"] . "' ORDER BY `leave`.`leave_date` DESC LIMIT 20 OFFSET 0", "s");
																				if ($leaveResultset->num_rows > 0) {


																					for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
																						$leave = $leaveResultset->fetch_assoc();
																						$statId = $leave["leave_status_id"];
																				?>
																						<tr>
																							<td><?php echo $i + 1 ?></td>
																							<td>
																								<span class="badge 
																							<?php
																							if ($statId == 1) {
																								echo "backgroundColorChange text-light";
																							} else if ($statId == 2) {
																								echo "bg-success  text-light";
																							} else if ($statId == 3) {
																								echo "bg-danger  text-light";
																							} else {
																								echo "bg-warning  text-dark";
																							}
																							?>
																							 ">
																									<?php
																									if ($statId == 1) {
																										echo "Pending";
																									} else if ($statId == 2) {
																										echo "Approved";
																									} else if ($statId == 3) {
																										echo "Rejected";
																									} else {
																										echo "Emergency";
																									}
																									?>
																								</span>

																							</td>
																							<td><?php echo $leave["leave_date"] ?></td>
																						</tr>
																				<?php
																					}
																				} else {
																				}

																				?>




																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
													</div>


												</div>
												<div class="tab-pane fade" id="twoA" role="tabpanel">

													<div class="row">
														<div class="col-xxl-12">
															<div class="card mb-4">
																<div class="card-header">
																	<h5 class="card-title">Request For a Leave</h5>
																</div>
																<div class="card-body">
																	<!-- Row start -->
																	<div class="row" aria-disabled="">
																		<div class="col-12 alert alert-danger d-none" id="infoMessage" role="alert">
																		</div>


																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Date</label>
																				<input type="date" class="form-control removeCorner" id="date" placeholder="Enter Date" value="" />
																			</div>
																		</div>


																		<div class="col-sm-6 col-12">
																			<div class="mb-3">
																				<label class="form-label">Reason <small>(max characters: 1000)</small></label>
																				<textarea class="form-control removeCorner" id="reason" placeholder="mention your reason" rows="10"></textarea>
																			</div>
																		</div>
																	</div>
																	<!-- Row end -->
																</div>
																<div class="card-footer">
																	<div class="d-flex gap-2 justify-content-center">
																		<button type="button" class="btn btn-dark backgroundColorChange removeCorner" onclick="requestForLeave()">Request</button>

																	</div>
																	<div class="col-12 col-lg-6 offset-lg-3 mt-3">
																		<p class="text-danger fw-bold">Please be informed of the specific procedure when you applying for leaves: </p>





																		<p>*Leave Policy:*</p>
																		<p class="mt-1">-Submit your leave request at least two days before.
																			<br>
																			-Each employee is entitled to a total of 3 leaves per month. <br>

																			-You can request a normal leave through the system <br> -Inform your divisional head.<br>

																		<p class="mt-2 bg-danger-subtle m-auto">- You can take up to 2 emergency leaves without prior notice, which will be deducted from your total leaves.📌
																			<br> Send an email to
																			<b><a href="mailto:info@jadetimes.com">info@jadetimes.com</a></b><br>

																			CC the email to <b>hr@ums.jadetimes.com</b>
																		</p>

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