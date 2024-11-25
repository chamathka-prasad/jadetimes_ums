<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_user"])) {
	$userSession = $_SESSION["jd_user"];
	$page = 0;

	if (isset($_GET["page"])) {
		$page = $_GET["page"];
		try {
			$page = (int)$page;
		} catch (Throwable $th) {

			$page = 0;
		}
	}


?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - Articles </title>

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

	<body class="backgroundColorChange">

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
							<li class="breadcrumb-item" aria-current="page">Article</li>
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
													<a class="nav-link " id="tab-twoA" data-bs-toggle="tab" href="#twoA" role="tab" aria-controls="twoA" aria-selected="false"><i class="bi bi-building-add text-dark"></i></a>
												</li>



											</ul>
											<div class="tab-content">
												<div class="tab-pane fade show active" id="oneA" role="tabpanel">
													<div class="row">

														<div class="col-xxl-12">
															<div class="card mb-4">
																<div class="card-body">
																	<div class="card-header">
																		<h5 class="card-title">My Articles</h5>
																	</div>
																	<div class="table-responsive mt-5">
																		<table class="table table-bordered m-0 w-100">
																			<thead>
																				<tr>
																					<th>#</th>
																					<th>Article Date</th>
																					<th>Title</th>
																					<th>Type</th>


																				</tr>
																			</thead>
																			<tbody>

																				<?php

																				$offset = 0;

																				if ($page > 0) {
																					$offset = ($page - 1) * 50;
																				}
																				$leaveResultset = Database::operation("SELECT * FROM `article` WHERE `user_id`='" . $userSession["id"] . "' ORDER BY `date` DESC LIMIT 50 OFFSET " . $offset, "s");
																				if ($leaveResultset->num_rows > 0) {


																					for ($i = 0; $i < $leaveResultset->num_rows; $i++) {
																						$leave = $leaveResultset->fetch_assoc();
																						$colorSet = "";
																						if ($leave["type"] == 1) {
																							$colorSet = "bg-danger-subtle";
																						}
																				?>
																						<tr>
																							<td class="<?php echo $colorSet ?>"><?php echo $i + 1 + $offset ?></td>
																							<td class="<?php echo $colorSet ?>"><?php echo $leave["date"] ?></td>
																							<td class="w-75 <?php echo $colorSet ?>"><?php echo $leave["title"] ?></td>
																							<td class="<?php echo $colorSet ?>"><?php
																																if ($leave["type"] == 1) {
																																	echo "paid";
																																} else {
																																	echo "none";
																																}
																																?></td>

																						</tr>
																				<?php
																					}
																				} else {
																				}

																				?>




																			</tbody>
																		</table>
																	</div>
																	<div class="card mt-4">
																		<div class="card-body">
																			<div class="col-12">
																				<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
																					<div class="btn-group removeCorner me-2 text-center" role="group" aria-label="First group">
																						<?php

																						$resultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `article` WHERE `user_id`='" . $userSession["id"] . "'", "s");
																						$resultRows = $resultCount->fetch_assoc();
																						$count = $resultRows["total_rows"];
																						$pagesCount = round($count / 50) + 1;

																						for ($p = 1; $p <= $pagesCount; $p++) {
																						?>
																							<a type="button" href="?page=<?php echo $p ?>" class="btn btn-outline-info removeCorner">
																								<?php echo $p ?>
																							</a>
																						<?php
																						}
																						?>
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
												<div class="tab-pane fade" id="twoA" role="tabpanel">
													<div class="row">
														<div class="col-xxl-12">
															<div class="card mb-4">
																<div class="card-header">
																	<h5 class="card-title">Add Article</h5>
																</div>
																<div class="card-body">

																	<!-- Row start -->
																	<div class="row" aria-disabled="">
																		<div class="col-12 alert alert-danger d-none" id="infoMessage" role="alert">
																		</div>


																		<div class="col-lg-3 col-sm-4 col-12">
																			<div class="mb-3">
																				<label class="form-label">Date</label>
																				<input type="date" class="form-control removeCorner" id="date" placeholder="Enter Date" />
																			</div>

																			<div class="mb-3">
																				<label class="form-label">Article Type</label>
																				<select id="articleType" class="form-control removeCorner">
																					<option value="0">Select</option>
																					<option value="1">Commercial</option>
																					<option value="2">Non Commercial</option>
																				</select>
																			</div>
																		</div>


																		<div class="col-sm-6 col-12">
																			<div class="mb-3">
																				<label class="form-label">Article Title </label>
																				<textarea class="form-control removeCorner" id="title" placeholder="Article title" rows="5"></textarea>
																			</div>
																		</div>
																	</div>
																	<!-- Row end -->
																</div>
																<div class="card-footer">
																	<div class="d-flex gap-2 justify-content-center">
																		<button type="button" onclick="addNewArticle()" class="btn btn-dark backgroundColorChange removeCorner">
																			Add Article
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
		<script>
			document.getElementById('title').addEventListener('paste', function(event) {
				event.preventDefault();
				let paste = (event.clipboardData || window.clipboardData).getData('text');
				paste = paste.replace(/[\x00-\x1F\x7F-\x9F]/g, ''); // Remove control characters
				document.getElementById('title').value = paste.trim(); // Clean and trim the pasted input
			});

			function addNewArticle() {
				var msg = document.getElementById("infoMessage");
				var title = document.getElementById("title");
				var date = document.getElementById("date");
				var articleType = document.getElementById("articleType");


				if (!date.value) {

					msg.innerHTML = "Please Select A Date";
					msg.classList = "alert alert-danger";

				} else if (articleType.value == 0) {

					msg.innerHTML = "Please select an Article Type";
					msg.classList = "alert alert-danger";

				} else if (!title.value) {

					msg.innerHTML = "Title  is Empty";
					msg.classList = "alert alert-danger";

				} else {

					var formData = new FormData();
					formData.append("title", title.value);
					formData.append("date", date.value);
					formData.append("articleType", articleType.value);

					fetch(baseUrl + "articleSubmittProcess.php", {
							method: "POST",
							body: formData,

						})
						.then(function(resp) {

							try {
								let response = resp.json();
								return response;
							} catch (error) {
								msg.classList = "alert alert-danger";
								msg.innerHTML = "Something wrong please try again";
								emailField.classList = "form-control";
								passwordField.classList = "form-control";
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
									window.location = "contributorsArticle.php";
								}, 1000);
							} else {
								msg.classList = "alert alert-danger";
								msg.innerHTML = "Something wrong please try again";
								emailField.classList = "form-control";
								passwordField.classList = "form-control";
							}

						})
						.catch(function(error) {
							console.log(error);
						});


				}
			}
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