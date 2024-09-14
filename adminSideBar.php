<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper backgroundColorChange">

	<!-- App brand starts -->
	<div class="app-brand p-4 mt-lg-0 mt-5">
		<a href="adminPanel.php">
			<img src="assets/img/darkLogo.png" style="height: 60px;width: auto;"  alt="Bootstrap Gallery" />
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
			<li class="<?php if ($currentPage == "manageLeaves.php") {
							echo "active current-page";
						} ?>">
				<a href="manageLeaves.php">
					<i class="bi bi-calendar2-date"></i>
					<span class="menu-text">Manage Leaves</span>
				</a>
			</li>
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
			
			if($_SESSION["jd_admin"]["user_type"]=="admin"){
			    ?>
			    <li class="<?php if ($currentPage == "adminAttendence.php") {
							echo "active current-page";
						} ?>">
				<a href="adminAttendence.php">
					<i class="bi bi-building"></i>
					<span class="menu-text">My Attendence</span>
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