<?php
if (isset($_SESSION["jd_admin"])) {

    $admin = $_SESSION["jd_admin"];
?>




    <!-- App header starts -->
    <div class="app-header d-flex align-items-center bg-white">

        <!-- Toggle buttons start -->
        <div class="d-flex d-lg-none d-md-block">
            <button class="btn btn-outline-dark  me-2 toggle-sidebar" id="toggle-sidebar">
                <i class="bi bi-text-indent-left fs-5"></i>
            </button>
            <button class="btn btn-outline-dark me-2  pin-sidebar" id="pin-sidebar">
                <i class="bi bi-text-indent-left fs-5"></i>
            </button>
        </div>
        <!-- Toggle buttons end -->


        <!-- App brand sm start -->
        <div class="app-brand-sm d-md-none d-sm-block text-center">
            <a href="adminPanel.php">
                <img src="assets/img/logoDark.jpg" class="logo" alt="Bootstrap Gallery">
            </a>
        </div>
        <!-- App brand sm end -->

        <!-- App header actions start -->
        <div class="header-actions">
         



            <div class="dropdown ms-3">
                <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center ps-3 border-start" href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    
                    <img src="<?php if (empty($admin["imgPath"])) {
                                ?>assets/img/defaultProfileImage.png<?php
                                                                } else {
                                                                    echo "resources/profileImg/" . $admin["imgPath"];
                                                                }  ?>" class="rounded-circle img-3x" alt="Bootstrap Gallery" />
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <a class="dropdown-item d-flex align-items-center" href="adminProfile.php"><i class="bi bi-person fs-4 me-2"></i>Profile</a>

                    <a class="dropdown-item d-flex align-items-center" href="adminLogOutProcess.php"><i class="bi bi-escape fs-4 me-2"></i>Logout</a>
                </div>
            </div>
        </div>
        <!-- App header actions end -->

    </div>
    <!-- App header ends -->
<?php

}
?>