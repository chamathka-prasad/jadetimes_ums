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
		<title>Jade Times - manage departments and positions </title>

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
							<li class="breadcrumb-item" aria-current="page">Manage departments and positions</li>
						</ol>
						<!-- Breadcrumb end -->



					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">


						<!-- Row start -->
						<div class="row">
							<div class="col-xl-4 col-md-6 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Add new Position</h5>
									</div>
									<div class="card-body">
										<div class="col-12 mb-3">
											<div class="alert alert-danger d-none" id="infoMessage" role="alert">
											</div>
										</div>
										<div class="col-12">
											<div class="mb-3">
												<label class="form-label">Department</label><label class="colorRed ms-3 fs-6">*</label>

												<select class="form-select removeCorner" id="department">
													<option value="0">Select</option>

													<?php



													$departResult = Database::operation("SELECT * FROM `department`", "s");
													$dnum = $departResult->num_rows;
													if ($departResult != 0) {
														for ($h = 0; $h < $dnum; $h++) {
															$department = $departResult->fetch_assoc();
															$departmentID = $department["id"];
													?>
															<option value="<?php echo $departmentID ?>"><?php echo $department["name"] ?></option>
													<?php
														}
													}
													?>

												</select>


											</div>
										</div>

										<div class="col-12">
											<div class="mb-3">
												<label class="form-label">Position</label><label class="colorRed ms-3 fs-6">*</label>
												<input type="text" id="position" class="form-control removeCorner" placeholder="position" />


											</div>
										</div>
										<div class="col-12">
											<div class="d-flex gap-2 justify-content-center">

												<button type="button" onclick="addNewPosition()" class="btn btn-dark removeCorner backgroundColorChange">
													ADD
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-md-6 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Registred Positions</h5>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table align-middle">
												<thead>
													<tr>
														<th>id</th>
														<th>department</th>
														<th>position</th>
													</tr>
												</thead>
												<tbody>


													<?php

													$positionList = Database::operation("SELECT `department`.`id` AS `dip`,`position`.`id`,`department`.`name` AS `department`,`position`.`name` AS `position` FROM `position` INNER JOIN `department` ON `position`.`department_id`=`department`.`id`", "s");
													$modelLoad = $positionList;
													if ($positionList->num_rows != 0) {
														for ($l = 0; $l < $positionList->num_rows; $l++) {
															$position = $positionList->fetch_assoc();
													?>


															<tr data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $l ?>">
																<td>
																	<?php echo $position["id"] ?>
																</td>
																<td><?php echo $position["department"] ?></td>
																<td><?php echo $position["position"] ?></td>

															</tr>
															<div class="modal fade" id="staticBackdrop<?php echo $l ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="staticBackdropLabel">
																				Edit Position
																			</h5>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																		</div>
																		<div class="modal-body">
																			<div class="row">
																				<div class="col-12 mb-3">
																					<div class="alert alert-danger d-none" id="infoMessageUpdatePosition<?php echo $position["id"] ?>" role="alert">
																					</div>
																				</div>
																				<div class="col-12">
																					<span> <b>Id :</b> <?php echo $position["id"] ?></span> <br>
																					<span><b> Department :</b> <?php echo $position["department"] ?></span>
																					<input type="text" id="position<?php echo $position["id"] ?>" class="form-control removeCorner" value="<?php echo $position["position"] ?>" placeholder="position" />

																				</div>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-secondary  removeCorner" data-bs-dismiss="modal">
																				Close
																			</button>
																			<button type="button" class="btn btn-primary backgroundColorChange removeCorner" onclick='updatePositionName(<?php echo $position["id"] ?>,<?php echo $position["dip"] ?>)'>
																				EDIT
																			</button>
																		</div>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>

												</tbody>



											</table>


										</div>
									</div>
								</div>
							</div>



							<div class="col-xl-8 col-md-6 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Add new Department</h5>
									</div>
									<div class="card-body">
										<div class="col-12 mb-3">
											<div class="alert alert-danger d-none" id="infoMessagedip" role="alert">
											</div>
										</div>


										<div class="col-12">
											<div class="mb-3">
												<label class="form-label">Department</label><label class="colorRed ms-3 fs-6">*</label>
												<input type="text" id="addNewDepartment" class="form-control removeCorner" placeholder="department" />


											</div>
										</div>
										<div class="col-12">
											<div class="d-flex gap-2 justify-content-center">

												<button type="button" onclick="addNewDepartment()" class="btn btn-dark removeCorner backgroundColorChange">
													ADD
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="col-xl-4 col-md-6 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Registred Departments</h5>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table align-middle">
												<thead>
													<tr>
														<th>id</th>
														<th>department</th>

													</tr>
												</thead>
												<tbody>


													<?php

													$departmentList = Database::operation("SELECT * FROM `department`", "s");

													if ($departmentList->num_rows != 0) {
														for ($m = 0; $m < $departmentList->num_rows; $m++) {
															$departmentResult = $departmentList->fetch_assoc();
													?>


															<tr data-bs-toggle="modal" data-bs-target="#staticBackdropdip<?php echo $m ?>">
																<td>
																	<?php echo $departmentResult["id"] ?>
																</td>
																<td><?php echo $departmentResult["name"] ?></td>


															</tr>
															<div class="modal fade" id="staticBackdropdip<?php echo $m ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="staticBackdropLabel">
																				Edit Department
																			</h5>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																		</div>
																		<div class="modal-body">
																			<div class="row">
																				<div class="col-12 mb-3">
																					<div class="alert alert-danger d-none" id="infoMessageUpdatedepartment<?php echo $departmentResult["id"] ?>" role="alert">
																					</div>
																				</div>
																				<div class="col-12">
																					<span> <b>Id :</b> <?php echo $departmentResult["id"] ?></span> <br>

																					<input type="text" id="departmentupdate<?php echo $departmentResult["id"] ?>" class="form-control removeCorner" value="<?php echo $departmentResult["name"] ?>" placeholder="department" />

																				</div>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-secondary removeCorner" data-bs-dismiss="modal">
																				Close
																			</button>
																			<button type="button" class="btn btn-primary backgroundColorChange removeCorner" onclick='updateDepartmentName(<?php echo $departmentResult["id"] ?>)'>
																				EDIT
																			</button>
																		</div>
																	</div>
																</div>
															</div>
													<?php
														}
													}
													?>

												</tbody>



											</table>


										</div>
									</div>
								</div>
							</div>




						</div>
						<!-- Row end -->

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
		<script src="assets/vendor/apex/custom/dash2/sparkline.js"></script>
		<script src="assets/vendor/apex/custom/dash2/traffic.js"></script>
		<script src="assets/vendor/apex/custom/dash2/active-users.js"></script>
		<script src="assets/vendor/apex/custom/dash2/sessions.js"></script>

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