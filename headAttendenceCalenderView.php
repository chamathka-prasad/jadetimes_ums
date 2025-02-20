<?php
session_start();
require "connection.php";
if (isset($_SESSION["jd_user"]) && $_SESSION["jd_user"]["user_type"]=="head") {

	$userSession = $_SESSION["jd_user"];
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Jade Times - Manage user Attendance</title>

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
							<li class="breadcrumb-item" aria-current="page">Attendence Calender View</li>
						</ol>
						<!-- Breadcrumb end -->

						<!-- Sales stats start -->

						<!-- Sales stats end -->

					</div>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">



						<div class="row">
							<div class="col-12">
								<div class="mb-3">
									<label class="form-label">Name</label><label class="colorRed ms-3 fs-6">*</label>
									<select class="form-select removeCorner" id="adduser" onchange="employeeCalenderView()">
										<option value="0">Select user</option>
										<?php


										$userResultAttendance = Database::operation("SELECT `user`.`id`,`user`.`fname`,`user`.`lname`,`user`.`jid` FROM `user` INNER JOIN `position` ON `position`.`id`=`user`.`position_id` INNER JOIN `department` ON `department`.`id`=`position`.`department_id` WHERE `user`.`user_status_id`='1' AND  `department`.`id`='".$userSession["department_id"]."' AND `type_id`IN('1','2','4')", "s");
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
							<div class="col-xxl-4 col-md-12 col-sm-12 col-lg-3">
								<!-- Card start -->
								<div class="card">
									<div class="card-body" id="attendanceDetails">
										Click ON THE DATE TO VIEW DETAILS
									</div>
								</div>
								<!-- Card end -->
							</div>
							<div class="col-xxl-8 col-md-12 col-sm-12 col-lg-9 mt-2">
								<!-- Card start -->
								<div class="card">
									<div class="card-body">
										<div id="dayGrid">
											SELECT A USER
										</div>
									</div>
								</div>
								<!-- Card end -->
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
		<script src="assets/js/admin.js"></script>
	</body>

	<script>
		var allresultArray = "";
		var allLeaveAray = "";

		function employeeCalenderView() {

			var id = document.getElementById("adduser").value;
			history.replaceState(null, null, window.location.pathname);
			document.getElementById("attendanceDetails").innerHTML = "Click ON THE DATE TO VIEW DETAILS";
			if (id == 0) {

				document.getElementById("dayGrid").innerHTML = "SELECT A USER";
				return;
			}


			fetch(baseUrl + "headfetchUserAttendanceCalenderProcess.php?id=" + id, {
					method: "GET",
					headers: {

						"Content-Type": "application/json;charset=UTF-8"
					},

				})
				.then(function(resp) {

					try {
						let response = resp.json();
						return response;
					} catch (error) {


					}

				})
				.then(function(value) {

					if (value.type == "info") {



						if (value.message == "") {
							document.getElementById("dayGrid").innerHTML = "Empty Details";
							return;
						}
						document.getElementById("dayGrid").innerHTML = "";
						var attendanceArray = value.message;
						allresultArray = value.message;
						allLeaveAray = value.leave;


						var eventArray = new Array();

						for (let index = 0; index < attendanceArray.length; index++) {
							const element = attendanceArray[index];
							var fetchDate = element[2];
							var component = {
								title: "Marked",
								start: fetchDate.split(" ")[0],
								color: "#90EE90",
								constraint: 'availableForMeeting',
								url: "#at=" + element[0],


							};

							eventArray.push(component);
						}

						for (let index = 0; index < value.leave.length; index++) {

							const element = value.leave[index];
							var fetchDate = element[0];

							var fetchDate = element[0];
							if (element[1] == 2) {

								let component = {
									title: "Normal Leave",
									start: fetchDate,
									color: "#ff0d0d",
									constraint: 'availableForMeeting',
									url: "#le=" + element[2],

								};
								eventArray.push(component);
							} else if (element[1] == 4) {

								let component = {
									title: "Emergancy Leave",
									start: fetchDate,
									color: "#ffcc00",
									constraint: 'availableForMeeting',
									url: "#le=" + element[2],

								};
								eventArray.push(component);
							} else {

								let component = {
									title: "Special Leave",
									start: fetchDate,
									color: "#cc3300",
									constraint: 'availableForMeeting',
									url: "#le=" + element[2],

								};
								eventArray.push(component);
							}


						}


						var calendarEl = document.getElementById("dayGrid");
						var calendar = new FullCalendar.Calendar(calendarEl, {
							headerToolbar: {
								left: "prevYear,prev,next,nextYear today",
								center: "title",
								right: "dayGridMonth,dayGridWeek,dayGridDay",
							},
							initialDate: new Date().toISOString(),
							navLinks: true,
							editable: false,
							dayMaxEvents: true,

							events: eventArray,
						});






						calendar.render();

					}

				})
				.catch(function(error) {
					console.log(error);
				});



		}
	</script>


	<script>
		function removeHashOnReload() {
			if (window.location.hash) {
				history.replaceState(null, null, window.location.pathname); // Remove hash without reloading
			}
		}

		// Run when page fully loads
		window.addEventListener("DOMContentLoaded", removeHashOnReload);

		function detectHashChange() {
			const hash = window.location.hash; // Get the current hash
			if (hash.startsWith("#at=")) {
				const idValue = hash.replace("#at=", ""); // Remove "#id="

				for (let index = 0; index < allresultArray.length; index++) {
					const element = allresultArray[index];

					if (element[0] == idValue) {

						document.getElementById("attendanceDetails").innerHTML = '<h1>Attendance</h1>' + element[3];

						break;
					}


				}
			}


			if (hash.startsWith("#le=")) {
				const idValue = hash.replace("#le=", ""); // Remove "#id="

				for (let index = 0; index < allLeaveAray.length; index++) {


					const element = allLeaveAray[index];
					var leaveType = " ";
					if (element[2] == idValue) {

						if (element[1] == 2) {

							leaveType = "Normal Leave";

						} else if (element[1] == 4) {


							leaveType = "Emergancy Leave";

						} else {
							leaveType = "Special Leave";

						}
						document.getElementById("attendanceDetails").innerHTML = `<h1>${leaveType}</h1>` + element[3];
						break;
					}






				}


			}
		}






		// Detect hash change when URL changes
		window.addEventListener("hashchange", detectHashChange);

		// Run on page load (in case hash is already present)
		detectHashChange();
	</script>

	</html>
<?php

} else {
?>
	<script>
		window.location = "adminLogin.php";
	</script>
<?php
}
?>