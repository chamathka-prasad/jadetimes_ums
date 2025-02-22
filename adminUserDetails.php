<?php
session_start();
if (isset($_SESSION["jd_admin"])) {

	if (isset($_GET["userEmail"])) {
		require "connection.php";

		$useremail = $_GET["userEmail"];
		$admin = $_SESSION["jd_admin"];


?>


		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<title>Jade Times - update user profile / change status</title>

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
								<li class="breadcrumb-item">

									<a href="ManageUser.php">Manage User</a>
								</li>
								<li class="breadcrumb-item" aria-current="page">User Profile Single View</li>
							</ol>
							<!-- Breadcrumb end -->

							<!-- Sales stats start -->

							<!-- Sales stats end -->

						</div>
						<!-- App Hero header ends -->

						<!-- App body starts -->
						<div class="app-body smoothScroll" id="cbody">

							<!-- Row start -->

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
														<a class="nav-link" id="tab-task" data-bs-toggle="tab" href="#task" role="tab" aria-controls="task" aria-selected="false">
															<span class="badge  bg-info">User Task</span>
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link" id="tab-twoAAAA" data-bs-toggle="tab" href="#twoAAAA" role="tab" aria-controls="twoAAAA" aria-selected="false">
															<span class="badge  bg-danger">Password</span>
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link" id="tab-threeAAAA" data-bs-toggle="tab" href="#threeAAAA" role="tab" aria-controls="threeAAAA" aria-selected="false">
															<span class="badge bg-primary">Change Email</span>
														</a>
													</li>

												</ul>
												<div class="tab-content" id="customTabContent">

													<?php
													$resultProfile = Database::operation("SELECT `user`.`id`,`user`.`email`,`user`.`password`,`user`.`prev_attendance`,`user`.`fname`,`user`.`lname`,`user`.`sname`,`user`.`mname`,`user`.`mobile`,`user`.`jid`,`user`.`nic`,`user`.`duration`,`user`.`linkdin`,`user`.`dob`,`type`.`id` AS `user_typeid`,`position`.`id` AS `positionid`,`department`.`id` AS `departmentid`,`user`.`gender_id` AS `genderId`
													 ,`user`.`user_status_id`,`user`.`months` FROM `user` INNER JOIN `type` ON  `type`.`id`=`user`.`type_id` INNER JOIN  `user_status` ON `user`.`user_status_id`=`user_status`.`id`
 INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id`  WHERE `user`.`email`='" . $useremail . "';", "s");


													$Profile;

													if ($resultProfile->num_rows == 1) {

														$Profile = $resultProfile->fetch_assoc();
													} else {

													?>
														<script>
															window.location = "ManageUser.php";
														</script>
													<?php
													}
													?>
													<div class="tab-pane fade show active" id="oneAAAA" role="tabpanel">
														<?php
														if ($Profile["user_typeid"] != 3 && $Profile["user_typeid"] != 5) {
														?>
															<div class="row">
																<div class="col-12 col-md-12 col-xl-4">
																	<div class="card mb-4 bg-secondary">
																		<div class="card-body d-flex align-items-center p-0">
																			<div class="p-4">
																				<i class="bi bi-pie-chart fs-1 lh-1 text-dark "></i>
																			</div>
																			<div class="py-4">
																				<h5 class="text-white fw-light m-0">Attendance</h5>
																				<?php





																				$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `attendance` WHERE `attendance`.`user_id`='" . $Profile["id"] . "'", "s");
																				if ($userResultCount->num_rows == 1) {
																					$count = $userResultCount->fetch_assoc();

																				?>
																					<h1 class="m-0"><?php

																									$prev = 0;


																									if (!empty($Profile["prev_attendance"])) {
																										$prev = $Profile["prev_attendance"];
																									}

																									echo ($count["total_rows"] + $prev) . " days";
																									?> <br>
																						<span class="text-white fs-4"><?php if (($count["total_rows"] + $prev) == 0) {
																															echo 0;
																														} else {
																															echo floor(($count["total_rows"] + $prev) / 30);
																														}  ?> Months / <?php echo ($count["total_rows"] + $prev) % 30; ?> Days</span>

																					</h1>


																			</div>
																			<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">Total</span>
																		</div>
																	</div>
																</div>
																<div class="col-12 col-md-12 col-xl-4">
																	<div class="card mb-4 bg-danger-subtle">
																		<div class="card-body d-flex align-items-center p-0 ">
																			<div class="p-4">
																				<i class="bi bi-sticky fs-1 lh-1 text-dark"></i>
																			</div>
																			<div class="py-4">
																				<h5 class="text-secondary fw-light m-0">Total Leaves</h5>

																				<?php
																					$timezone = new DateTimeZone('Asia/Colombo');  // Set the timezone to Colombo
																					$date = new DateTime('now', $timezone);        // Get current date and time in Colombo timezone
																					$currentYearMonth = $date->format('Y-m');
																					$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `leave` WHERE `leave`.`leave_status_id` IN ('1','2','4','5') AND `leave`.`user_id`='" . $Profile["id"] . "' AND `leave`.`leave_date` LIKE '" . $currentYearMonth . "%'", "s");
																					if ($userResultCount->num_rows == 1) {
																						$count = $userResultCount->fetch_assoc();
																				?>
																					<h1 class="m-0 " id="count4"><?php echo $count["total_rows"] ?></h1>
																				<?php
																					}


																				?>




																			</div>
																			<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 ">All</span>
																		</div>
																	</div>
																</div>
																<div class="col-12 col-md-12 col-xl-4">
																	<div class="card mb-4 bg-info-subtle">
																		<div class="card-body d-flex align-items-center p-0 ">
																			<div class="p-4">
																				<i class="bi bi-sticky fs-1 lh-1 text-dark"></i>
																			</div>
																			<div class="py-4">
																				<h5 class="text-secondary fw-light m-0">Remaining Leaves</h5>

																				<?php
																					$timezone = new DateTimeZone('Asia/Colombo');  // Set the timezone to Colombo
																					$date = new DateTime('now', $timezone);        // Get current date and time in Colombo timezone
																					$currentYearMonth = $date->format('Y-m');
																					$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `leave` WHERE `leave`.`leave_status_id` IN ('1','2','4') AND `leave`.`user_id`='" . $Profile["id"] . "' AND `leave`.`leave_date` LIKE '" . $currentYearMonth . "%'", "s");
																					if ($userResultCount->num_rows == 1) {
																						$count = $userResultCount->fetch_assoc();
																				?>
																					<h1 class="m-0 " id="count4"><?php echo 3 - $count["total_rows"] ?></h1>
																				<?php
																					}


																				?>




																			</div>
																			<span class="badge backgroundColorChange position-absolute top-0 end-0 m-3 "><?php echo $currentYearMonth ?></span>
																		</div>
																	</div>
																</div>

															</div>
													<?php
																				}
																			}
													?>
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

																		<?php if (((($admin["user_type"] == "admin" || $admin["user_type"] == "superAdmin")) && $Profile["user_typeid"] != 3) || ($admin["id"] != $Profile["id"] && $Profile["user_typeid"] == 3 && $admin["user_type"] == "superAdmin")) {



																			if ($Profile["user_status_id"] == 1) {

																		?>
																				<div class="col-8">
																					<label class="text-success">Account is Active </label>
																					<button class="btn btn-danger rounded-0" data-bs-toggle="modal" data-bs-target="#suspendModal">Suspend The User</button>
																				</div>

																			<?php
																			} else {
																			?>
																				<div class="col-8">
																					<label class="text-danger">Account is Deactive</label>
																					<a href="#" class="text-succes text-decoration-underline" onclick="changeTheUserStatus('active')">Activate the Account</a>

																				</div>
																		<?php
																			}
																		} else {
																		} ?>


																		<div class="col-12 text-center">

																			<label class="form-label mt-2 fs-6">Profile Image</label>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12 d-none">
																			<div class="mb-3 ">

																				<input class="form-control" type="file" id="formFile" />
																			</div>
																		</div>

																		<div class="col-12">
																			<div class="card mb-4">
																				<div class="card-body">
																					<div class="row">
																						<div class="col-sm-12 text-center">

																							<?php
																							$imagePath = "";
																							$profileImgResult = Database::operation("SELECT * FROM `profile_image` WHERE `user_id`='" .  $Profile["id"] . "'", "s");
																							if ($profileImgResult->num_rows == 1) {
																								$image = $profileImgResult->fetch_assoc();
																								$imagePath = "resources/profileImg/" . $image["name"];
																							} else {
																								$imagePath = "assets/img/defaultProfileImage.png";
																							}
																							?>
																							<img src="<?php echo $imagePath ?>" class="img-fluid rounded-2 imageSize" id="view1" alt="" />
																						</div>
																						<div class="col-sm-12 text-center mt-1">
																							<div class="align-items-center">
																								<label for="formFile" class="btn btn-primary removeCorner " onclick="changeImg()">+</label>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Surname</label>
																				<input type="text" id="sname" class="form-control removeCorner" value="<?php echo $Profile["sname"] ?>" placeholder="Enter Surname" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label ">First Name</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="fname" class="form-control removeCorner" placeholder="Enter First Name" value="<?php echo $Profile["fname"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Middle Name</label>
																				<input type="text" id="mname" class="form-control removeCorner" placeholder="Enter Middle Name" value="<?php echo $Profile["mname"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Last Name</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="lname" class="form-control removeCorner" placeholder="Enter Last Name" value="<?php echo $Profile["lname"] ?>" />
																			</div>
																		</div>

																		<div class="col-12">
																			<hr>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Phone</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="mobile" class="form-control removeCorner" placeholder="Enter phone number" value="<?php echo $Profile["mobile"] ?>" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">NIC No/Passport No/Driving License No</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="nic" class="form-control removeCorner" placeholder="national ID" value="<?php echo $Profile["nic"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Date Of Birth</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="date" id="dob" class="form-control removeCorner" placeholder="date of birth" value="<?php echo $Profile["dob"] ?>" />
																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Gender</label><label class="colorRed ms-1 fs-6">*</label>
																				<select class="form-select removeCorner" id="gender">
																					<option value="0">Select</option>

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
																				<label class="form-label">Jades Id</label><label class="colorRed ms-1 fs-6">*</label>
																				<input type="text" id="jid" class="form-control removeCorner" placeholder="jade times id" value="<?php echo $Profile["jid"] ?>" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Department</label><label class="colorRed ms-1 fs-6">*</label>

																				<select class="form-select removeCorner" id="department" onchange="getThePositionForDepartment()">
																					<option value="0">Select</option>

																					<?php



																					$departResult = Database::operation("SELECT * FROM `department`", "s");
																					$dnum = $departResult->num_rows;
																					if ($departResult != 0) {
																						for ($h = 0; $h < $dnum; $h++) {
																							$department = $departResult->fetch_assoc();
																							$departmentID = $department["id"];
																					?>
																							<option value="<?php echo $departmentID ?>" <?php if ($Profile["departmentid"] == $departmentID) { ?> selected <?php } ?>><?php echo $department["name"] ?></option>
																					<?php
																						}
																					}
																					?>

																				</select>


																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Position</label><label class="colorRed ms-1 fs-6">*</label>
																				<select class="form-select removeCorner" id="position">


																					<?php



																					$posiResult = Database::operation("SELECT * FROM `position` WHERE `position`.`department_id`='" . $Profile["departmentid"] . "'", "s");
																					$pnum = $posiResult->num_rows;
																					if ($posiResult != 0) {
																						for ($h = 0; $h < $pnum; $h++) {
																							$position = $posiResult->fetch_assoc();
																							$positionId = $position["id"];
																					?>
																							<option value="<?php echo $positionId ?>" <?php if ($Profile["positionid"] == $positionId) { ?> selected <?php } ?>><?php echo $position["name"] ?></option>
																					<?php
																						}
																					}
																					?>

																				</select>


																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Duration</label>
																				<input type="text" id="duration" class="form-control removeCorner" placeholder="duration" value="<?php echo $Profile["duration"] ?>" />
																			</div>
																		</div>

																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Internship Duration</label>
																				
																				<select class="form-select removeCorner" id="months">
																					<option value="0" <?php
																										if ($Profile["months"] == null || $Profile["months"] == 0) {
																											echo "selected";
																										}
																										?>>Not Applicable</option>
																					<option value="3" <?php
																										if ($Profile["months"] == 3) {
																											echo "selected";
																										}
																										?>>3 Months</option>
																					<option value="6" <?php
																										if ($Profile["months"] == 6) {
																											echo "selected";
																										}
																										?>>6 Months</option>

																				</select>

																			</div>
																		</div>
																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Linkdin</label>
																				<input type="text" id="linkdin" class="form-control removeCorner" placeholder="linkdin" value="<?php echo $Profile["linkdin"] ?>" />
																			</div>
																		</div>



																		<div class="col-lg-3 col-sm-4 col-12 <?php if ($Profile["user_typeid"] == 3 && $admin["id"] == $Profile["id"]) {
																													echo "d-none";
																												} ?>">
																			<div class="mb-3">
																				<label class="form-label">User Type</label><label class="colorRed ms-1 fs-6">*</label>
																				<select class="form-select removeCorner" id="type">


																					<?php



																					$userTypeResult = Database::operation("SELECT * FROM `type`", "s");
																					$unum = $userTypeResult->num_rows;
																					if ($unum != 0) {
																						for ($i = 0; $i < $unum; $i++) {

																							$type = $userTypeResult->fetch_assoc();
																							$typeId = $type["id"];
																					?>
																							<option value="<?php echo $typeId ?>" <?php if ($typeId == $Profile["user_typeid"]) { ?> selected <?php } ?>><?php echo $type["name"] ?></option>
																						<?php
																						}
																						?>

																				</select>
																			</div>
																		</div>
																	<?php
																					}

																	?>
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
																		<label class="form-label mt-2 fs-6">Jadetimes Id Card</label>
																	</div>


																	<div class="col-12">
																		<div class="card mb-4">
																			<div class="card-body">
																				<div class="row">
																					<div class="col-sm-12 text-start">

																						<?php
																						$imagePath = "";
																						$profileImgResult = Database::operation("SELECT * FROM `id_image` WHERE `user_id`='" .  $Profile["id"] . "'", "s");
																						if ($profileImgResult->num_rows == 1) {
																							$image = $profileImgResult->fetch_assoc();
																							$imagePath = "resources/idImg/" . $image["name"];
																						} else {
																							$imagePath = "assets/img/card_icon.png";
																						}
																						?>
																						<img src="<?php echo $imagePath ?>" class="img-fluid  imageSize" id="view2" alt="" />
																						<label for="formFile2" class="btn btn-dark removeCorner " onclick="changeIdImg()">+</label>
																						<input type="file" id="formFile2" class="d-none" />
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

																		<button type="button" onclick="adminUpdateUserProfile()" class="btn btn-dark removeCorner backgroundColorChange w-50">
																			Update User The Profile
																		</button>
																	</div>
																</div>

															</div>
															<!-- Row end -->
														</div>
													</div>
													</div>


													<div class="tab-pane fade" id="task" role="tabpanel">
														<!-- Row start -->
														<div class="row">
															<div class="col-xxl-12">
																<div class="card mb-4">
																	<div class="card-header">
																		<h5 class="card-title">User Task</h5>
																	</div>

																	<div class="card-body">
																		<!-- Row start -->
																		<div class="row">
																			<div class="col-12 mb-3">
																				<div class="alert alert-danger d-none" id="infoMessagetask" role="alert">
																				</div>
																			</div>

																			<?php
																			$taskResultSet = Database::operation("SELECT * FROM `task` WHERE `task`.`user_id`='" . $Profile["id"] . "'", "s");
																			$taskValue = "";
																			if ($taskResultSet->num_rows == 1) {
																				$taskfetch = $taskResultSet->fetch_assoc();
																				$taskValue = $taskfetch["user_task"];
																			}

																			?>
																			<div class="col-12">
																				<div class="mb-3">
																					<label class="form-label">Task <small>(max characters: 1000)</small></label>

																					<textarea class="form-control removeCorner" id="userTask" placeholder="user Task" rows="10"><?php echo $taskValue ?></textarea>
																				</div>
																			</div>
																			<div class="col-12">
																				<button type="button" class="btn btn-info removeCorner" onclick="changeUserTask()">
																					Change the Task
																				</button>
																			</div>




																		</div>
																		<!-- Row end -->
																	</div>

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
																		<h5 class="card-title">Password</h5>
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
																					<label class="form-label">Password</label>

																					<?php
																					if ($Profile["user_typeid"] == "3") {
																						if ($admin["user_type"] == "superAdmin") {
																					?>

																							<input type="text" class="form-control removeCorner" id="oldPass" disabled placeholder="old" value="<?php echo $Profile["password"] ?>" />

																						<?php
																						}
																					} else {
																						?>
																						<input type="text" class="form-control removeCorner" id="oldPass" disabled placeholder="old" value="<?php echo $Profile["password"] ?>" />
																					<?php
																					}
																					?>



																				</div>
																			</div>
																		</div>
																		<!-- Row end -->
																	</div>

																</div>
															</div>
														</div>
													</div>
													<div class="tab-pane fade" id="threeAAAA" role="tabpanel">
														<div class="row">
															<div class="col-12 mb-3">
																<div class="alert alert-danger d-none" id="emailMessage" role="alert">
																</div>
															</div>
															<div class="col-lg-3 col-sm-4 col-12">
																<div class="mb-3">
																	<label class="form-label">Email</label>
																	<input type="email" id="email" class="form-control removeCorner" placeholder="Enter email address" disabled value="<?php echo $Profile["email"] ?>" />
																</div>
															</div>

															<div class="col-lg-3 col-sm-4 col-12">
																<div class="mb-3">
																	<label class="form-label">New Email</label><label class="colorRed ms-3 fs-6">*</label>
																	<input type="email" id="newemail" class="form-control removeCorner" placeholder="Enter new email address" />
																</div>
															</div>

															<div class="col-12 mb-3">
																<div class="d-flex gap-2 justify-content-start">

																	<button type="button" class="btn btn-danger removeCorner" onclick="updateUserEmail()">
																		Update The Email
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
											<!-- select end -->

										</div>
									</div>
								</div>

								<!-- App body ends -->

								<!-- App footer start -->

								<!-- App footer end -->

							</div>
						</div>


						<!-- App container ends -->
						<div class="app-footer">
							<span>© 2024 Jadetimes Media LLC. All rights reserved.</span>
						</div>

						<!-- Main container end -->

					</div>


					<!-- Bootstrap Modal -->
					<div class="modal fade  modal-lg" id="suspendModal" tabindex="-1" aria-labelledby="suspendModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Suspend the User</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">

									<div class="mb-3">
										<label for="subject" class="form-label">Subject</label>
										<input type="text" class="form-control" id="letterSubject" placeholder="Enter subject" required>
									</div>
									<div class="mb-3">
										<label for="body" class="form-label">Body</label>
										<textarea class="form-control" id="letterBody" rows="10" placeholder="Write the suspension letter..." required></textarea>
									</div>
									<button type="submit" class="btn btn-danger w-100 rounded-0" onclick="changeTheUserStatus('deactive')">Suspend</button>

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
			window.location = "ManageUser.php";
		</script>
	<?php
	}
} else {
	?>
	<script>
		window.location = "adminLogin.php"
	</script>
<?php
}
?>