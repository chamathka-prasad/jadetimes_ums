<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_admin"])) {

	$admin = $_SESSION["jd_admin"];
	$autoGeneratedPassword = uniqid() . $admin["id"];

	$d = new DateTime();
	$tz = new DateTimeZone("Asia/Colombo");
	$d->setTimezone($tz);
	$today = $d->format("Y-m-d");

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - Manage Users add /edit</title>

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

	<body class="backgroundColorChange" onload="loadStaffDateToFront(0)">

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">
				<?php require "adminSideBar.php" ?>


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
							<li class="breadcrumb-item" aria-current="page">Payments</li>
						</ol>
						<!-- Breadcrumb end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body" id="cbody">
						<div class="row mb-5">
							<div class="col-12">
								<p class="d-inline-flex gap-1">

									<button class="btn btn-dark backgroundColorChange removeCorner" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
										<i class="bi bi-person-plus"></i> Create A Payment Profile
									</button>
								</p>
								<div class="collapse" id="collapseExample">
									<div class="card card-body">

										<div class="row">
											<div class="col-xxl-12">
												<div class="card mb-4">

													<div class="card-body">
														<!-- Row start -->
														<div class="row">
															<div class="col-12 mb-3">
																<div class="alert alert-danger d-none" id="infoMessageProfileUpdate" role="alert">
																</div>
															</div>
															<div class="col-12 text-center mb-3">

															</div>

															<div class="col-lg-6 col-sm-6 col-12">
																<div class="mb-3">
																	<label class="form-label">Select User</label><label class="colorRed ms-3 fs-6">*</label>
																	<select class="form-select removeCorner" id="adduser">
																		<option value="0">Select user</option>
																		<?php



																		$userResultAttendance = Database::operation("SELECT * FROM `user` WHERE `user`.`user_status_id`='1'", "s");
																		$addNewList = $userResultAttendance;

																		if ($addNewList->num_rows != 0) {
																			for ($adi = 0; $adi < $addNewList->num_rows; $adi++) {
																				$userselect = $addNewList->fetch_assoc();

																		?>
																				<option value="<?php echo $userselect["id"] ?>"><?php echo $userselect["fname"] . " " . $userselect["lname"] . " " . $userselect["jid"] ?></option>
																		<?php
																			}
																		}

																		?>
																	</select>
																</div>
															</div>
															<div class="col-lg-6 col-sm-6 col-12">
																<div class="mb-3">
																	<label class="form-label">Select The Payment Method</label><label class="colorRed ms-3 fs-6">*</label>
																	<select class="form-select removeCorner" id="ptype">
																		<option value="0">Select Method</option>
																		<option value="1">Fixed Payment</option>
																		<option value="2">Project Base Payment</option>
																		
																		
																	</select>
																</div>
															</div>
															<div class="col-lg-6 col-sm-6 col-12">
																<div class="mb-3">
																	<label class="form-label">Payment Profile Registred</label>
																	<input type="date" id="dor" class="form-control removeCorner" placeholder="The day Became a Staff Member" value="" />
																</div>
															</div>

														</div>
														<!-- Row end -->
													</div>
													<div class="col-12 mt-4">
														<div class="d-flex gap-2 justify-content-center">

															<button type="button" onclick="registerNewStaff()" class="btn btn-dark removeCorner backgroundColorChange w-50">
																Register New Payment Profile
															</button>
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
						<div class="row">
							<div class="col-lg-3 col-sm-4 col-12">
								<div class="mb-3">
									<div class="row">
										<div class="col-12"><label class="form-label fs-6">Search By :</label></div>

									</div>


								</div>
							</div>
						</div>



						<!-- Row start -->
						<div class="row ">

							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="mb-3">
									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">Name -</label></div>
										<div class="col-9"><input type="text" id="searchname" class="form-control removeCorner smallText" placeholder="Search by first name" oninput="loadStaffDateToFront(1)" /></div>
									</div>

								</div>
							</div>

							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="mb-3">


									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">email -</label></div>
										<div class="col-9"><input type="text" id="searchemail" class="form-control removeCorner smallText" placeholder="Search by first name" value="" oninput="loadStaffDateToFront(1)" /></div>
									</div>


								</div>
							</div>
							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="">
									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">ID -</label></div>
										<div class="col-9"><input type="text" id="searchid" class="form-control removeCorner smallText" placeholder="Search by Jade Times ID" value="" oninput="loadStaffDateToFront(1)" /></div>
									</div>


								</div>
							</div>
							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="">
									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">Position -</label></div>
										<div class="col-9"><input type="text" id="searchposition" class="form-control removeCorner smallText" placeholder="Search by user position" oninput="loadStaffDateToFront(1)" value="" /></div>
									</div>


								</div>
							</div>
							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="mb-3">
									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">Type -</label></div>
										<div class="col-9">

											<select class="form-select removeCorner smallText" id="searchtype" onchange="loadStaffDateToFront(1)">
												<option value="0" selected>All</option>

												<?php



												$typeResultListForSearch = Database::operation("SELECT * FROM `type`", "s");
												$typeResultListForSearchNumbers = $typeResultListForSearch->num_rows;
												if ($typeResultListForSearchNumbers != 0) {
													for ($typ = 0; $typ < $typeResultListForSearchNumbers; $typ++) {
														$typeSrh = $typeResultListForSearch->fetch_assoc();

												?>
														<option value="<?php echo $typeSrh["id"] ?>"><?php echo $typeSrh["name"] ?></option>
												<?php
													}
												}
												?>

											</select>
										</div>


									</div>






								</div>
							</div>

							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="mb-3">


									<div class="row">
										<div class="col-3 text-end"><label class="form-label smallText">Status -</label></div>

										<div class="col-9">

											<select class="form-select removeCorner smallText" id="searchstatus" onchange="loadStaffDateToFront(1)">
												<option value="0" selected>All</option>

												<?php



												$statusResultListForSearch = Database::operation("SELECT * FROM `user_status`", "s");
												$statusResultListForSearchNumbers = $statusResultListForSearch->num_rows;
												if ($statusResultListForSearchNumbers != 0) {
													for ($sty = 0; $sty < $statusResultListForSearchNumbers; $sty++) {
														$statusSrh = $statusResultListForSearch->fetch_assoc();

												?>
														<option value="<?php echo $statusSrh["id"] ?>" <?php if ($statusSrh["name"] == "ACTIVE") {
																										?>selected <?php
																											} ?>><?php echo $statusSrh["name"] ?></option>
												<?php
													}
												}
												?>

											</select>
										</div>

									</div>


								</div>
							</div>
							<div class="col-lg-3 col-sm-4 col-12 text-center">
								<div class="mb-3">



									<div class="row">
										<div class="col-12 text-start">
											<button class="btn btn-danger removeCorner" onclick="clearSearchDataStaff()"><i class="bi bi-x"></i></button>
										</div>
									</div>


								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-xxl-12">
								<div class="card mb-4">
									<div class="card-body">
										<div class="row">
											<div class="col-12 justify-content-center">

												<div class="container mt-5">
													<div class="horizontal-scroll-menu-container">
														<label class="btn btn-outline-info removeCorner" id="scroll-left">&#8672;</label>

														<div class="horizontal-scroll-menu" id="scroll-menu">
															<div class="card removeCorner">
																<div class="card-body removeCorner">
																	<div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
																		<input type="radio" class="btn-check" id="depAll" name="btnradio" checked="" value="0" onchange='loadStaffDateToFront(1)' />
																		<label class="btn btn-outline-info removeCorner" for="depAll">All</label>
																		<?php

																		$departmentResult = Database::operation("SELECT * FROM `department`", "s");
																		if ($departmentResult->num_rows != 0) {

																			for ($i = 0; $i < $departmentResult->num_rows; $i++) {
																				$departmenData = $departmentResult->fetch_assoc();
																		?>
																				<input type="radio" class="btn-check removeCorner" name="btnradio" value='<?php echo $departmenData["id"] ?>' id="dep<?php echo $i ?>" onchange="loadStaffDateToFront(1)" />
																				<label class="btn btn-outline-info removeCorner" for="dep<?php echo $i ?>"><?php echo $departmenData["name"] ?></label>

																		<?php
																			}
																		}
																		?>




																	</div>
																</div>
															</div>
														</div>
														<span class="btn btn-outline-info removeCorner removeCorner" id="scroll-right">&#8674;</span>
													</div>
													<!-- Card start -->

													<!-- Card end -->
												</div>
											</div>
											<div class="table-responsive">
												<table class="table align-middle table-hover m-0">
													<thead>
														<tr>
															<th scope="col">NO</th>
															<th scope="col">Id</th>
															<th scope="col">Name</th>
															<th scope="col">Email</th>
															<th scope="col">Mobile</th>
															<th scope="col">Profile Create Date</th>
															<th scope="col">Department</th>
															<th scope="col">Position</th>
															<th scope="col">User Type</th>
															<th scope="col">Status</th>

														</tr>
													</thead>
													<tbody id="tableBodyUser">

													</tbody>
												</table>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col-12 text-center">
												<!-- Card start -->
												<div class="card mb-4">
													<div class="card-body">
														<div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" id="pagicontainer">

														</div>
													</div>
												</div>
												<!-- Card end -->
											</div>
										</div>

									</div>
								</div>

							</div>


							<div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card mb-4">
									<div class="card-header">
										<h5 class="card-title">Pending Payments</h5>
									</div>
									<div class="card-body">
										<div class="col-12 mb-3">
											<div class="alert alert-danger d-none" id="infoMessagePaymentUpdate" role="alert">
											</div>
										</div>
										<div class="table-responsive">
											<table class="table align-middle">
												<thead>
													<tr>
														<th>user</th>
														<th>Month</th>
														<th></th>
													</tr>
												</thead>
												<tbody id="tableBodypp">

												</tbody>



											</table>


										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="row">
									<div class="card mb-4">
										<div class="card-header">
											<h5 class="card-title">Payment History</h5>
										</div>
										<div class="card-body">
											<div class="col-12 mb-3">
												<div class="alert alert-danger d-none" id="infoMessagePaymentUpdate" role="alert">
												</div>
											</div>
											<div class="col-12 text-center">
												<div class="mb-3">
													<div class="row">
														<div class="col-3 text-end"><label class="form-label smallText">Name -</label></div>
														<div class="col-9"><input type="text" id="searchnamePH" class="form-control removeCorner smallText" placeholder="Search by first name" oninput="loadpaymentHistory(1)" /></div>
													</div>




												</div>
											</div>
											<div class="table-responsive">
												<table class="table align-middle">
													<thead>
														<tr>
															<th>Jid</th>
															<th>User</th>
															<th>Note</th>
															<th>Date</th>
															<th>Payment</th>
														</tr>
													</thead>
													<tbody id="tableBodyphistory">

													</tbody>



												</table>


											</div>

											<div class="row mt-3">
												<div class="col-12 text-center">
													<!-- Card start -->
													<div class="card mb-4">
														<div class="card-body">
															<div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" id="pagicontainerph">

															</div>
														</div>
													</div>
													<!-- Card end -->
												</div>
											</div>
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

		<!-- Custom JS files -->
		<script src="assets/js/custom.js"></script>

		<script src="assets/js/admin.js"></script>
		<!-- Bootstrap JS and dependencies -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<!-- Custom JS -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const scrollMenu = document.getElementById('scroll-menu');
				const scrollLeft = document.getElementById('scroll-left');
				const scrollRight = document.getElementById('scroll-right');

				scrollLeft.addEventListener('click', function() {
					scrollMenu.scrollBy({
						left: -200,
						behavior: 'smooth'
					});
				});

				scrollRight.addEventListener('click', function() {
					scrollMenu.scrollBy({
						left: 200,
						behavior: 'smooth'
					});
				});
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