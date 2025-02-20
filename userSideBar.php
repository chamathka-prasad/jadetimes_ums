<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper backgroundColorChange">

	<!-- App brand starts -->
	<div class="app-brand p-4 mt-lg-0 mt-5">
		<a href="userDashBoard.php">
			<img src="assets/img/darkLogo.png" style="height: 60px;width: auto;" alt="jadetimes" />
		</a>
	</div>


	<?php $currentPage = basename($_SERVER['PHP_SELF']) ?>
	<!-- Sidebar menu starts -->
	<div class="sidebarMenuScroll">
		<ul class="sidebar-menu">
			<li class="<?php if ($currentPage == "userDashBoard.php") {
							echo "active current-page";
						} ?>">
				<a href="userDashBoard.php">
					<i class="bi bi-pie-chart"></i>
					<span class="menu-text">Dashboard</span>
				</a>
			</li>

			<?php

			if ($_SESSION["jd_user"]["user_type"] == "contributor") {
			?>

				<li class="<?php if ($currentPage == "contributorsArticle.php") {
								echo "active current-page";
							} ?>">
					<a href="contributorsArticle.php">
						<i class="bi bi-journal-bookmark"></i>
						<span class="menu-text">My Article</span>
					</a>
				</li>

			<?php
			} else if ($_SESSION["jd_user"]["user_type"] == "director") {
			} else {
			?>
				<li class="<?php if ($currentPage == "userAttendence.php") {
								echo "active current-page";
							} ?>">
					<a href="userAttendence.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">Calender/Attendence</span>
					</a>
				</li>
				<li class="<?php if ($currentPage == "userLeaves.php") {
								echo "active current-page";
							} ?>">
					<a href="userLeaves.php">
						<i class="bi bi-calendar2-x"></i>
						<span class="menu-text">Leave Request</span>
					</a>
				</li>
			<?php

			}
			?>

			<li class="<?php if ($currentPage == "userDocuments.php") {
							echo "active current-page";
						} ?>">
				<a href="userDocuments.php">
					<i class="bi bi-file-earmark"></i>
					<span class="menu-text">Documents</span>
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



			<li class="<?php if ($currentPage == "userProfile.php") {
							echo "active current-page";
						} ?>">
				<a href="userProfile.php">
					<i class="bi bi-person-square"></i>
					<span class="menu-text">My Profile</span>
				</a>
			</li>


			<?php

			if ($_SESSION["jd_user"]["user_type"] == "head" || $_SESSION["jd_user"]["user_type"] == "director") {
			?>
				<li class="">
					<hr>
				</li>

				<?php

				if ($_SESSION["jd_user"]["department_id"] == "4") {
				?>

					<li class="<?php if ($currentPage == "pendingAttendanceView.php") {
									echo "active current-page";
								} ?>">
						<a href="pendingAttendanceView.php">
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
					<li class="<?php if ($currentPage == "headmanageArticles.php") {
									echo "active current-page";
								} ?>">
						<a href="headmanageArticles.php">
							<i class="bi bi-journal-bookmark"></i>
							<span class="menu-text">Articles</span>
						</a>
					</li>
				<?php
				}
				?>
				<li class="">
					<hr>
				</li>
				<li class="<?php if ($currentPage == "HeadEmployeesView.php") {
								echo "active current-page";
							} ?>">
					<a href="HeadEmployeesView.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">Department Employees</span>
					</a>
				</li>



				<li class="<?php if ($currentPage == "headAttendence.php") {
								echo "active current-page";
							} ?>">
					<a href="headAttendence.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">Department Attendence</span>
					</a>
				</li>
				<li class="<?php if ($currentPage == "manageHeadLeaves.php") {
								echo "active current-page";
							} ?>">
					<a href="manageHeadLeaves.php">
						<i class="bi bi-building"></i>
						<span class="menu-text">Department Leaves</span>
					</a>
				</li>

			<?php
			}
			?>


		</ul>
	</div>
	<!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->