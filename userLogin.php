<?php

$rememberEmail = "";
if (isset($_COOKIE["email_user"])) {
    $rememberEmail = $_COOKIE["email_user"];
}
$rememberPassword = "";
if (isset($_COOKIE["password_user"])) {
    $rememberPassword = $_COOKIE["password_user"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jadetimes - User Management System(UMS)</title>

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
    <link rel="stylesheet" href="assets/css/user.css" />
</head>

<body class="setBackImg">
    <!-- Container start -->
    <div class="container ">
        <div class="row">

        </div>

        <div class="row justify-content-center align-content-center vh-100">


            <div class="col-xl-4 col-lg-5 col-12 align-content-center ">

                <div class="border border-light  p-4 mt-5 bg-white removeCorner">
                    <div class="login-form">

                        <a href="index.php" class="mb-4 d-flex d-block justify-content-center">

                            <img src="assets/img/logoDark.jpg" style="height: 70px;width: auto;" class="img-fluid login-logo" alt="Jade Times User" />
                        </a>
                        <h4 class="fw-semibold mb-4 text-center">User Login</h4>
                        <div class="alert alert-danger d-none" id="infoMessage" role="alert">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control removeCorner" id="email" placeholder="Enter your email" value="<?php echo $rememberEmail ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control removeCorner" id="password" placeholder="Enter password" value="<?php echo $rememberPassword ?>" />
                                <a href="#" class="input-group-text removeCorner" onclick="togglePasswordVisibility()">
                                    <i class="bi bi-eye"></i>
                                </a>

                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="form-check m-0">
                                <input class="form-check-input" type="checkbox" value="" id="rememberPassword" />
                                <label class="form-check-label" for="rememberPassword">Remember</label>
                            </div>
                            <a href="forgotPassword.php" class="text-blue text-decoration-underline">Lost password?</a>
                        </div>
                        <div class="d-grid py-3 mt-2">
                            <button class="btn btn-lg btn-dark backgroundColorChange removeCorner" onclick="userSignin()">
                                Login
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="suspensionModal" tabindex="-1" aria-labelledby="suspensionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suspension Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="suspensionForm">
                        <div class="mb-3">
                            <label for="suspensionReason" class="form-label">Suspension Reason</label>
                            <p class="" id="suspensionReason"></p>
                        </div>
                        <div class="mb-3">
                            <label for="recoveryInfo" class="form-label">How to Recover UMS Account</label>
                            <p> &#9656; Contact Hr Department <br>
                                &#9656; Contact Your Department Coordinator <br>
                                &#9656; Email: hr@jadetimes.com
                            </p>

                        </div>

                    </form>
                    <hr>
                    <p class="text-center mt-3">
                        <a href="https://www.jadetimes.com/internship-policies" target="_blank">Jadetimes Internship Policies</a> |
                        <a href="https://www.jadetimes.com/terms-and-conditions" target="_blank">Jadetimes Terms and Conditions</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/userLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <script>
        function openSuspensionModal() {
            const suspensionModal = new bootstrap.Modal(document.getElementById('suspensionModal'));
            suspensionModal.show();
        }
    </script>
    <!-- Container end -->
</body>

</html>