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
		<title>Jade Times - update jade times profile </title>

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
							<li class="breadcrumb-item" aria-current="page">Profile</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->
						<div class="ms-auto d-flex flex-row">
							<div class="d-flex flex-column me-5 text-end">

								<h3 class="m-0"><?php echo $admin["jid"] ?></h3>
							</div>

						</div>
						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body smoothScroll" id="cbody">

						<!-- Row start -->
						<div class="row justify-content-center">
							<div class="col-xxl-12">
								<div class="card mb-4">
									<div class="card-body">
										<!-- Row start -->
										<div class="row align-items-center">
											<div class="col-auto">
												<img src="assets/img/iconImg.jpg" class="img-5xx rounded-circle" alt="Bootstrap Gallery" />
											</div>
											<div class="col">
												<h4 class="m-0"><?php echo $admin["fname"] . " " . $admin["lname"] ?></h4>
												<h6 class="text-primary"><?php echo $admin["department"] ?></h6>


											</div>

											<div class="col-12 bg-light-subtle col-md-auto text-center">
												<h5 class="m-0 text-primary"><?php echo $admin["position"] ?></h5>
											</div>
										</div>
										<!-- Row end -->
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<!-- select Start -->
						<div class="row">
							<div class="col-xxl-12">
								<div class="card mb-4">
									<div class="card-body">
										<div class="custom-tabs-container">
											<ul class="nav nav-tabs justify-content-end" id="customTab5" role="tablist">
												<li class="nav-item" role="presentation">
													<a class="nav-link active" id="tab-oneAAAA" data-bs-toggle="tab" href="#oneAAAA" role="tab" aria-controls="oneAAAA" aria-selected="true">
														<span class="badge bg-succes backgroundColorChange">Profile</span>
													</a>
												</li>
												<li class="nav-item" role="presentation">
													<a class="nav-link" id="tab-twoAAAA" data-bs-toggle="tab" href="#twoAAAA" role="tab" aria-controls="twoAAAA" aria-selected="false">
														<span class="badge  bg-danger">Password</span>
													</a>
												</li>

											</ul>
											<div class="tab-content" id="customTabContent">

												<?php
												$resultProfile = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`fname`,`user`.`lname`,`user`.`sname`,`user`.`mname`,`user`.`mobile`,`user`.`jid`,`user`.`nic`,`user`.`dob`,`user`.`duration`,`user`.`linkdin`,`type`.`name` AS `user_type`,`position`.`name` AS `position`,`department`.`name` AS `department`,`user`.`gender_id` AS `genderId` FROM `user` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN  `user_status` ON `user`.`user_status_id`=`user_status`.`id`
 INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id`  WHERE `user`.`id`='" . $admin["id"] . "';", "s");


												$Profile;

												if ($resultProfile->num_rows == 1) {
													$Profile = $resultProfile->fetch_assoc();
												} else {
												?>
													<script src="adminLogin.php"></script>
												<?php
												}
												?>
												<div class="tab-pane fade show active" id="oneAAAA" role="tabpanel">
													<!-- Row start -->
													<div class="row">
														<div class="col-xxl-12">
															<div class="card mb-4">

																<div class="card-body">
																	<!-- Row start -->
																	<div class="row">
																		<div class="col-12 mb-3">
																			<div class="alert alert-danger d-none" id="infoMessage" role="alert">
																			</div>
																		</div>
																		<div class="col-12 text-center mb-3">

																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Surname</label>
																				<input type="text" id="sname" disabled class="form-control removeCorner" value="<?php echo $Profile["sname"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label ">First Name</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="fname" disabled class="form-control removeCorner" value="<?php echo $Profile["fname"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Middle Name</label>
																				<input type="text" id="mname" disabled class="form-control removeCorner" value="<?php echo $Profile["mname"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Last Name</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="lname" disabled class="form-control removeCorner" value="<?php echo $Profile["lname"] ?>" />
																			</div>
																		</div>

																		<div class="col-12">
																			<hr>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Email</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="email" id="email" disabled class="form-control removeCorner" value="<?php echo $Profile["email"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Phone</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="mobile" disabled class="form-control removeCorner" value="<?php echo $Profile["mobile"] ?>" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">NIC No/Passport No/Driving License No</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="nic" disabled class="form-control removeCorner" value="<?php echo $Profile["nic"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Date Of Birth</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="date" id="dob" disabled class="form-control removeCorner" value="<?php echo $Profile["dob"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Gender</label><label class="colorRed ms-1 fs-6">*</label>

																				<select class="form-select  removeCorner" id="gender" disabled>
																					<option value="0"></option>

																					<?php



																					$genderResult = Database::operation("SELECT * FROM `gender`", "s");
																					$gnum = $genderResult->num_rows;
																					if ($gnum != 0) {
																						for ($i = 0; $i < $gnum; $i++) {
																							$genders = $genderResult->fetch_assoc();
																							$genderId = $genders["id"];
																					?>
																							<option value="<?php echo $genderId ?>" <?php if ($genderId == $Profile["genderId"]) {
																																	?>selected<?php
																																			} ?>><?php echo $genders["name"] ?></option>
																					<?php
																						}
																					}
																					?>

																				</select>
																			</div>
																		</div>


																		<div class="col-12">
																			<hr>

																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Department</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" class="form-control removeCorner" disabled placeholder="department" value="<?php echo $Profile["department"] ?>" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Position</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" class="form-control removeCorner" disabled placeholder="position" value="<?php echo $Profile["position"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Duration</label>
																				<input type="text" disabled id="duration" class="form-control removeCorner" value="<?php echo $Profile["duration"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Linkdin</label>
																				<input type="text" disabled id="linkdin" class="form-control removeCorner" value="<?php echo $Profile["linkdin"] ?>" />
																			</div>
																		</div>
																		<?php

																		$num = "";
																		$line1 = "";
																		$line2 = "";
																		$cit = "";
																		$conId = "";

																		$addressResult = Database::operation("SELECT * FROM `address` WHERE `address`.`user_id`='" . $Profile["id"] . "'", "s");
																		if ($addressResult->num_rows == 1) {

																			$address = $addressResult->fetch_assoc();
																			$num = $address["no"];
																			$line1 = $address["line1"];
																			$line2 = $address["line2"];
																			$cit = $address["city"];
																			$conId = $address["country_id"];
																		}
																		?>

																		<div class="col-12">
																			<hr>
																			<label class="form-label mt-2 fs-6">Address</label>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">No</label>
																				<input type="text" id="no" class="form-control removeCorner" value="<?php echo $num ?>" placeholder="Enter no" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Line 1</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="line1" class="form-control removeCorner" value="<?php echo $line1 ?>" placeholder="Enter Line 1" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Line 2</label>
																				<input type="text" id="line2" class="form-control removeCorner" value="<?php echo $line2 ?>" placeholder="Enter Line 2" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">City</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="city" class="form-control removeCorner" value="<?php
																																						echo $cit

																																						?>" placeholder="Enter city" />
																			</div>
																		</div>


																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Select Country</label><label class="colorRed ms-1 fs-6">*</label>
																				<select class="form-select removeCorner" id="country">
																					<option value="0">Select</option>

																					<?php



																					$citiesResult = Database::operation("SELECT * FROM `country`", "s");
																					$num = $citiesResult->num_rows;
																					if ($num != 0) {
																						for ($i = 0; $i < $num; $i++) {
																							$city = $citiesResult->fetch_assoc();
																							$cityId = $city["id"];
																					?>
																							<option value="<?php echo $cityId ?>" <?php if ($cityId == $conId) {
																																	?>selected<?php
																																			} ?>><?php echo $city["name"] ?></option>
																					<?php
																						}
																					}
																					?>

																				</select>
																			</div>
																		</div>
																		<div class="col-12">
																			<hr>
																			<label class="form-label mt-2 fs-6">Profile Image</label>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12 d-none">
																			<div class="mb-3 ">

																				<input class="form-control" type="file" id="formFile" />
																			</div>
																		</div>

																		<div class="col-lg-6 col-sm-12 col-12">
																			<div class="card mb-4">
																				<div class="card-body">
																					<div class="row">
																						<div class="col-sm-6">
																							<img src="<?php if (empty($admin["imgPath"])) {
																										?>assets/img/defaultProfileImage.png<?php
																																		} else {
																																			echo "resources/profileImg/" . $admin["imgPath"];
																																		}  ?>" class="img-fluid rounded-2" id="view1" alt="" />
																						</div>
																						<div class="col-sm-6">
																							<div class="align-items-center">

																								<p></p>


																								<label for="formFile" class="btn btn-primary removeCorner " onclick="changeImg()">+</label>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>

																	</div>
																	<!-- Row end -->
																</div>
																<div class="col-12 mt-4">
																	<div class="d-flex gap-2 justify-content-center">

																		<button type="button" onclick="updateAdminProfile()" class="btn btn-dark removeCorner backgroundColorChange w-50">
																			Update The Profile
																		</button>
																	</div>
																</div>

															</div>
															<!-- Row end -->
														</div>
													</div>
												</div>

											</div>
											<div class="tab-pane fade" id="twoAAAA" role="tabpanel">
												<!-- Row start -->
												<div class="row">
													<div class="col-xxl-12">
														<div class="card mb-4">
															<div class="card-header">
																<h5 class="card-title">Change the Password</h5>
															</div>

															<div class="card-body">
																<!-- Row start -->
																<div class="row">
																	<div class="col-12 mb-3">
																		<div class="alert alert-danger d-none" id="infoMessagePassword" role="alert">
																		</div>
																	</div>


																	<div class="col-lg-3 col-sm-4 col-12">
																		<div class="mb-3">
																			<label class="form-label">Enter the OLD password</label>
																			<input type="text" class="form-control removeCorner" id="oldPass" placeholder="old" />
																		</div>
																	</div>

																	<div class="col-lg-3 col-sm-4 col-12">
																		<div class="mb-3">
																			<label class="form-label">Enter the NEW password</label>
																			<input type="text" class="form-control removeCorner" id="newPass" placeholder="new" />
																		</div>
																	</div>

																	<div class="col-lg-3 col-sm-4 col-12">
																		<div class="mb-3">
																			<label class="form-label">Repeat the NEW password</label>
																			<input type="text" class="form-control removeCorner" id="repertPass" placeholder="repeart" />
																		</div>
																	</div>
																	<div class="col-12 mb-3">
																		<div class="d-flex gap-2 justify-content-start">

																			<button type="button" class="btn btn-danger removeCorner" onclick="changeThePassword()">
																				Update The Password
																			</button>

																			<a class="btn btn-dark backgroundColorChange removeCorner" href="forgotPassword.php">Forgot Password ?</a>
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
									<!-- select end -->

								</div>
								<!-- App body ends -->

								<!-- App footer start -->

								<!-- App footer end -->

							</div>
							<!-- App container ends -->

						</div>
						<!-- Main container end -->

					</div>
					<div class="app-footer">
						<span>© 2024 Jadetimes Media LLC. All rights reserved.</span>
					</div>
				</div>
				<!-- Page wrapper end -->

				<!-- *************
			************ JavaScript Files *************
		************* -->
				<!-- Required jQuery first, then Bootstrap Bundle JS -->
				<script src="assets/js/jquery.min.js"></script>
				<script src="assets/js/bootstrap.bundle.min.js"></script>
				<script src="assets/js/modernizr.js"></script>
				<script src="assets/js/moment.min.js"></script>
				<!-- *************
			************ Vendor Js Files *************
		************* -->

				<!-- Overlay Scroll JS -->
				<script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
				<script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

				<!-- Apex Charts -->
				<script src="assets/vendor/apex/apexcharts.min.js"></script>
				<script src="assets/vendor/apex/custom/profile/sales.js"></script>

				<!-- Custom JS files -->
				<script src="assets/js/custom.js"></script>

				<script src="assets/js/admin.js"></script>
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