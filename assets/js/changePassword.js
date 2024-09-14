function getVerificationCode() {

    var forgotEmail = document.getElementById("forgotEmail");
    var msg = document.getElementById("infoMessage");
    if (forgotEmail.value.length == 0) {

        msg.innerHTML = "email is empty";
        msg.classList = "alert alert-danger";

    } else {



        var reqbox = document.getElementById("reqbox");
        var refbox = document.getElementById("refbox");
        var formData = new FormData();
        formData.append("email", forgotEmail.value);

        fetch("sendReferenceCodeToUser.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {

                if (value.type == "success") {
                    msg.innerHTML = value.message;
                    msg.classList = "alert alert-success";
                    reqbox.classList = "col-12 d-none";
                    refbox.classList = "col-12";


                } else if (value.type == "error") {
                    msg.innerHTML = value.message;
                    msg.classList = "alert alert-danger";

                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }
}

function recoverAndChangeThePassword() {

    var reference = document.getElementById("frefcode");
    var newPassword = document.getElementById("fnewPassword");
    var repeatPassword = document.getElementById("frepPassword");
    var forgotEmail = document.getElementById("forgotEmail");


    var msg = document.getElementById("infoMessage");
    if (reference.value.length == 0) {
        msg.innerHTML = "Reference Code is Empty";
        msg.classList = "alert alert-danger";
    } else if (newPassword.value.length == 0) {
        msg.innerHTML = "Change your password";
        msg.classList = "alert alert-danger";
    } else if (newPassword.value.length < 8 || newPassword.value.length > 12) {
        msg.innerHTML = "New Password must be larger than 8 and smaller than 12 Characters";
        msg.classList = "alert alert-danger";
    } else if (newPassword.value != repeatPassword.value) {
        msg.innerHTML = "repeat the password correctly";
        msg.classList = "alert alert-danger";
    } else {

        var formData = new FormData();
        formData.append("email", forgotEmail.value);
        formData.append("new", newPassword.value);
        formData.append("rep", repeatPassword.value);
        formData.append("reference", reference.value);
        fetch("forgotpasswordoptionProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {

                if (value.type == "success") {
                    msg.innerHTML = value.message;
                    msg.classList = "alert alert-success";

                    setTimeout(() => {
                        window.location = "forgotPassword.php";
                    }, 2000);

                } else if (value.type == "error") {
                    msg.innerHTML = value.message;
                    msg.classList = "alert alert-danger";

                }

            })
            .catch(function (error) {
                console.log(error);
            });


    }
}