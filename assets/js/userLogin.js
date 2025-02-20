function userSignin() {

    let emailField = document.getElementById("email");
    let passwordField = document.getElementById("password");
    let msg = document.getElementById("infoMessage");
    let rememberPassword = document.getElementById("rememberPassword");

    let email = emailField.value;
    let password = passwordField.value;

    if (email.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Email is Empty";
        emailField.classList = "form-control border-danger";
        passwordField.classList = "form-control";
    } else if (password.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Password is Empty";
        passwordField.classList = "form-control border-danger";
        emailField.classList = "form-control";

    } else {

        var send = {
            email: email,
            password: password,
            rememberPassword: rememberPassword.checked,
        }

        fetch("userSigninProcess.php", {
            method: "POST",
            headers: {

                "Content-Type": "application/json;charset=UTF-8"
            }, body: JSON.stringify(send),

        })
            .then(function (resp) {

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
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Incorrect Email or Password";
                    emailField.classList = "form-control";
                    passwordField.classList = "form-control";
                } else if (value.type == "success") {
                    window.location = "userDashBoard.php";
                } else if (value.type == "info") {
                    document.getElementById("suspensionReason").innerHTML=value.message;
                    openSuspensionModal();
                }
                else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";
                    emailField.classList = "form-control";
                    passwordField.classList = "form-control";
                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }



}

function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const fieldType = passwordField.getAttribute('type');
    if (fieldType === 'password') {
        passwordField.setAttribute('type', 'text');
    } else {
        passwordField.setAttribute('type', 'password');
    }
}