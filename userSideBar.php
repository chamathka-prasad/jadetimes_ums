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


			<li class="<?php if ($currentPage == "userAttendence.php") {
							echo "active current-page";
						} ?>">
				<a href="userAttendence.php">
					<i class="bi bi-building"></i>
					<span class="menu-text">Attendence</span>
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
			<li class="<?php if ($currentPage == "userProfile.php") {
							echo "active current-page";
						} ?>">
				<a href="userProfile.php">
					<i class="bi bi-person-square"></i>
					<span class="menu-text">My Profile</span>
				</a>
			</li>


			<?php

			if ($_SESSION["jd_user"]["user_type"] == "head") {
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