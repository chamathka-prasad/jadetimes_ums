<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper backgroundColorChange">

	<!-- App brand starts -->
	<div class="app-brand p-4 mt-lg-0 mt-5">
		<a href="adminPanel.php">
			<img src="assets/img/darkLogo.png" style="height: 60px;width: auto;" alt="Bootstrap Gallery" />
		</a>
	</div>
	<!-- App brand ends -->


	<!-- Sidebar menu starts -->
	<div class="sidebarMenuScroll">
		<ul class="sidebar-menu">
			<?php $currentPage = basename($_SERVER['PHP_SELF']) ?>
			<li class="<?php if ($currentPage == "adminPanel.php") {
							echo "active  current-page";
						} ?>">
				<a href="adminPanel.php">
					<i class="bi bi-pie-chart"></i>
					<span class="menu-text">Dashboard</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "ManageUser.php") {
							echo "active current-page";
						} ?>">
				<a href="ManageUser.php">
					<i class="bi bi-person-video2"></i>
					<span class="menu-text">Manage Users</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "manageAttendence.php") {
							echo "active current-page";
						} ?>">
				<a href="manageAttendence.php">
					<i class="bi bi-building-fill-gear"></i>
					<span class="menu-text">Manage Attendance</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "adminPendingAttendanceView.php") {
							echo "active current-page";
						} ?>">
				<a href="adminPendingAttendanceView.php">
					<i class="bi bi-hourglass-split"></i>
					<span class="menu-text">
						Pending Attendance

						<?php
						$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `pending_attendance` WHERE `status`='1'", "s");

						if ($userResultCount->num_rows != 0) {

							$number = $userResultCount->fetch_assoc();
							$rowCount = $number["total_rows"];


						?>
							<?php
							if ($rowCount != 0) {
							?><span class="badge text-bg-secondary">
									<?php echo $rowCount ?></span>
						<?php
							}
						}
						?>
					</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "manageArticles.php") {
							echo "active current-page";
						} ?>">
				<a href="manageArticles.php">
					<i class="bi bi-journal-bookmark"></i>
					<span class="menu-text">Articles</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "manageLeaves.php") {
							echo "active current-page";
						} ?>">
				<a href="manageLeaves.php">
					<i class="bi bi-calendar2-date"></i>
					<span class="menu-text">Manage Leaves</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "manageReports.php") {
							echo "active current-page";
						} ?>">
				<a href="manageReports.php">
					<i class="bi bi-flag"></i>
					<span class="menu-text">
						Manage Reports

						<?php
						$userResultCount = Database::operation("SELECT COUNT(*) AS total_rows FROM `report` WHERE `status`='0'", "s");

						if ($userResultCount->num_rows != 0) {

							$number = $userResultCount->fetch_assoc();
							$rowCount = $number["total_rows"];


						?>
							<?php
							if ($rowCount != 0) {
							?><span class="badge text-bg-secondary">
									<?php echo $rowCount ?></span>
						<?php
							}
						}
						?>
					</span>
				</a>
			</li>
			<li class="<?php if ($currentPage == "manageStaff.php") {
							echo "active current-page";
						} ?>">
				<a href="manageStaff.php">
				<i class="bi bi-currency-dollar"></i>
					<span class="menu-text">Payments</span>
				</a>
			</li>

			<?php

			if ($_SESSION["jd_admin"]["user_type"] == "admin" || $_SESSION["jd_admin"]["user_type"] == "superAdmin") {
			?>
				<li class="<?php if ($currentPage == "manageDocsAndFeedbacks.php") {
								echo "active current-page";
							} ?>">
					<a href="manageDocsAndFeedbacks.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">Documents & Feedbacks </span>
					</a>
				</li>

				<li class="<?php if ($currentPage == "profileStatus.php") {
								echo "active current-page";
							} ?>">
					<a href="profileStatus.php">
						<i class="bi bi-hourglass-split"></i>
						<span class="menu-text">Profile Status</span>
					</a>
				</li>





			<?php

			}
			?>
			<li class="<?php if ($currentPage == "managePositions.php") {
							echo "active current-page";
						} ?>">
				<a href="managePositions.php">
					<i class="bi bi-bar-chart-steps"></i>
					<span class="menu-text">Manage Positions</span>
				</a>
			</li>

			<li>
				<hr>
			</li>


			<?php

			if ($_SESSION["jd_admin"]["user_type"] == "admin") {
			?>
				<li class="<?php if ($currentPage == "adminAttendence.php") {
								echo "active current-page";
							} ?>">
					<a href="adminAttendence.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">My Attendence</span>
					</a>
				</li>

				<li class="<?php if ($currentPage == "reports.php") {
								echo "active current-page";
							} ?>">
					<a href="reports.php">
						<i class="bi bi-flag"></i>
						<span class="menu-text">Report</span>
					</a>
				</li>



				<li class="<?php if ($currentPage == "adminLeaves.php") {
								echo "active current-page";
							} ?>">
					<a href="adminLeaves.php">
						<i class="bi bi-calendar2-x"></i>
						<span class="menu-text">My Leaves</span>
					</a>
				</li>

			<?php

			}


			?>

			<li class="<?php if ($currentPage == "adminProfile.php") {
							echo "active current-page";
						} ?>">
				<a href="adminProfile.php">
					<i class="bi bi-person-square"></i>
					<span class="menu-text">My Profile</span>
				</a>
			</li>






		</ul>
	</div>
	<!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->