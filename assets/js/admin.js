function changeImg() {
    var image = document.getElementById("formFile");
    var view = document.getElementById("view1");


    image.onchange = function () {
        var file = this.files[0];
        var url = window.URL.createObjectURL(file);

        view.src = url;

    }
}

var baseUrl="";


function adminUpdateUserProfile() {
    let surnameField = document.getElementById("sname");
    let fnameField = document.getElementById("fname");
    let mnameField = document.getElementById("mname");
    let lnameField = document.getElementById("lname");

    let emailField = document.getElementById("email");
    let mobileField = document.getElementById("mobile");
    let nicField = document.getElementById("nic");
    let dobField = document.getElementById("dob");
    let noField = document.getElementById("no");
    let line1Field = document.getElementById("line1");
    let line2Field = document.getElementById("line2");
    let cityField = document.getElementById("city");
    let countryField = document.getElementById("country");
    let genderField = document.getElementById("gender");

    let jidField = document.getElementById("jid");

    let formFileField = document.getElementById("formFile");

    let message = document.getElementById("infoMessage");
    let cbody = document.getElementById("cbody");
    let type = document.getElementById("type");

    let duration = document.getElementById("duration");
    let linkdin = document.getElementById("linkdin");

    let position = document.getElementById("position");




    const regex = /^\+?\d+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    const nicregex = /^[a-zA-Z0-9\- ]+$/;


    if (fnameField.value.length == 0) {

        message.innerHTML = "First Name is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (lnameField.value.length == 0) {
        message.innerHTML = "Last Name is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (emailField.value.length == 0) {
        message.innerHTML = "Email is Empty Reload the page";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    }
    // else if (mobileField.value.length == 0) {
    //     message.innerHTML = "Mobile number is Empty";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (!regex.test(mobileField.value)) {
    //     message.innerHTML = "Number must be a numeric";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (mobileField.value.length > 16) {
    //     message.innerHTML = "Mobile number is Invalid";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (nicField.value.length == 0) {
    //     message.innerHTML = "NIC is Empty";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (!nicregex.test(nicField.value)) {
    //     message.innerHTML = "NIC is Empty";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (dobField.value.length == 0) {
    //     message.innerHTML = "DOB is Empty";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (new Date(dobField.value) >= new Date()) {
    //     message.innerHTML = "ADD a Valid DOB";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (genderField.value == 0) {
    //     message.innerHTML = "Select a gender";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);

    // } else if (jidField.value.length == 0) {

    //     message.innerHTML = "Jades Id is empty";
    //     message.classList = "alert alert-danger";
    //     backToTop(cbody);
    // } 

    else {

        message.innerHTML = "";
        message.classList = "";


        var formData = new FormData();
        formData.append("sname", surnameField.value);
        formData.append("fname", fnameField.value);
        formData.append("mname", mnameField.value);
        formData.append("lname", lnameField.value);
        formData.append("email", emailField.value);
        formData.append("mobile", mobileField.value);
        formData.append("nic", nicField.value);
        formData.append("dob", dobField.value);
        formData.append("type", type.value);
        formData.append("position", position.value);
        formData.append("jid", jidField.value);

        formData.append("gender", genderField.value);
        formData.append("no", noField.value);
        formData.append("line1", line1Field.value);
        formData.append("line2", line2Field.value);
        formData.append("city", cityField.value);
        formData.append("country", countryField.value);
        formData.append("type", type.value);

        formData.append("duration", duration.value);
        formData.append("linkdin", linkdin.value);

        formData.append("img", formFileField.files[0]);




        fetch(baseUrl + "adminUserProfileUpdateProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {

                if (value.type == "success") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-success";
                    backToTop(cbody);
                    setTimeout(() => {
                        window.location = "adminUserDetails.php?userEmail=" + emailField.value;
                    }, 2000)

                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";
                    backToTop(cbody);
                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }



}

function loadUserAttendanceTODashBoard(stat) {


    var selectUser = document.getElementById("select-state");


    var ele = document.getElementsByName('btnradio');
    var dip = ""
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
            dip = ele[i].value;
        }

    }
    var page = 1;

    if (stat == 2) {
        var pagi = document.getElementsByName('pagi');

        for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
                page = Number(pagi[j].value);
            }

        }
    }


    var formData = new FormData();
    formData.append("selectUser", selectUser.value);

    formData.append("order", dip);
    formData.append("page", page);






    var tablebody = document.getElementById("tableBodyUser");
    tablebody.innerHTML = "";
    fetch(baseUrl + "userAttendanceLoadProcessToDashboard.php", {
        method: "POST",
        body: formData,


    }).then(function (resp) {
        return resp.json();

    })
        .then(function (value) {

            var pagicontainer = document.getElementById('pagicontainer');
            pagicontainer.innerHTML = "";

            if (value.type == "success") {
                var userSearchData = value.message;

                for (let index = 0; index < userSearchData.length; index++) {
                    const user = userSearchData[index];

                    const newRow = document.createElement('tr');

                    const nocell = document.createElement('td');
                    nocell.textContent = index + 1;
                    const idCell = document.createElement('td');
                    idCell.textContent = user[5];

                    const roleCell = document.createElement('td');
                    roleCell.textContent = user[1] + " " + user[2];

                    const addressCell = document.createElement('td');
                    addressCell.textContent = user[3];

                    const endDateCell = document.createElement('td');

                    if (user[7] == null) {
                        endDateCell.innerText = "NOT";
                        endDateCell.classList = "bg-danger text-black text-center";
                    } else {
                        endDateCell.textContent = user[7];
                    }

                    const salaryCell = document.createElement('td');
                    if (user[7] == null) {
                        salaryCell.innerText = "Marked";
                        salaryCell.classList = "bg-danger text-black text-center";
                    } else {
                        salaryCell.innerText = "Marked";
                        salaryCell.classList = "bg-success text-black text-center";
                    }



                    newRow.appendChild(nocell);
                    newRow.appendChild(idCell);
                    newRow.appendChild(roleCell);
                    newRow.appendChild(addressCell);


                    newRow.appendChild(endDateCell);
                    newRow.appendChild(salaryCell);

                    tablebody.appendChild(newRow);
                }


                var btnCount = value.buttoncount;


                var firstpagi = document.createElement('input');
                firstpagi.type = 'radio';
                firstpagi.className = 'btn-check';
                firstpagi.name = 'pagi';
                firstpagi.id = 'firstpagi';

                firstpagi.value = 1;
                firstpagi.onchange = function () {
                    loadUserAttendanceTODashBoard(2);
                }



                var firstlabel = document.createElement('label');
                firstlabel.className = 'btn btn-outline-info removeCorner';
                firstlabel.htmlFor = 'firstpagi';
                firstlabel.innerText = "First";



                pagicontainer.appendChild(firstpagi);
                pagicontainer.appendChild(firstlabel);



                var startPage = 1;

                var endpage = 5;



                var val = page + 4;





                if ((page + 4) < btnCount) {
                    endpage = page + 4;
                    startPage = page;

                } else {

                    if (btnCount >= 5) {
                        startPage = btnCount - 4;

                    } else {

                        startPage = 1;

                    }
                    endpage = btnCount;
                }



                if (page != 1 && btnCount > 5) {
                    var frontPagi = document.createElement('input');
                    frontPagi.type = 'radio';
                    frontPagi.className = 'btn-check';
                    frontPagi.name = 'pagi';
                    frontPagi.id = 'btnpagifront';

                    frontPagi.value = Number(startPage) - 1;
                    frontPagi.onchange = function () {
                        loadUserAttendanceTODashBoard(2);
                    }

                    var labelfrontpagi = document.createElement('label');
                    labelfrontpagi.className = 'btn btn-outline-info removeCorner';
                    labelfrontpagi.htmlFor = 'btnpagifront';
                    labelfrontpagi.innerText = Number(startPage) - 1;



                    pagicontainer.appendChild(frontPagi);
                    pagicontainer.appendChild(labelfrontpagi);

                }

                for (let i = startPage - 1; i < endpage; i++) {



                    var radioButton = document.createElement('input');
                    radioButton.type = 'radio';
                    radioButton.className = 'btn-check';
                    radioButton.name = 'pagi';
                    radioButton.id = 'btnpagi' + i;
                    var pageVal = i + 1;
                    radioButton.value = pageVal;
                    radioButton.onchange = function () {
                        loadUserAttendanceTODashBoard(2);
                    }
                    if (page == pageVal) {
                        radioButton.checked = true;
                    }


                    var label = document.createElement('label');
                    label.className = 'btn btn-outline-info removeCorner';
                    label.htmlFor = 'btnpagi' + i;
                    label.innerText = pageVal;



                    pagicontainer.appendChild(radioButton);
                    pagicontainer.appendChild(label);

                }


                var lastpagi = document.createElement('input');
                lastpagi.type = 'radio';
                lastpagi.className = 'btn-check';
                lastpagi.name = 'pagi';
                lastpagi.id = 'lastpagi';

                lastpagi.value = btnCount;
                lastpagi.onchange = function () {
                    loadUserAttendanceTODashBoard(2);
                }



                var lastlabel = document.createElement('label');
                lastlabel.className = 'btn btn-outline-info removeCorner';
                lastlabel.htmlFor = 'lastpagi';
                lastlabel.innerText = "Last (" + btnCount + ")";



                pagicontainer.appendChild(lastpagi);
                pagicontainer.appendChild(lastlabel);




            } else if (value.type = "error") {

                tablebody.innerHTML = value.message;

            }
        })
        .catch(function (error) {
            console.log(error);
        });



}




function updateAdminProfile() {

    let emailField = document.getElementById("email");

    let dobField = document.getElementById("dob");
    let noField = document.getElementById("no");
    let line1Field = document.getElementById("line1");
    let line2Field = document.getElementById("line2");
    let cityField = document.getElementById("city");
    let countryField = document.getElementById("country");


    let formFileField = document.getElementById("formFile");

    let message = document.getElementById("infoMessage");
    let cbody = document.getElementById("cbody");

    const regex = /^\+?\d+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    const nicregex = /^[a-zA-Z0-9\- ]+$/;


    var ds = formFileField.files[0];

    if (line1Field.value.length == 0) {
        message.innerHTML = "Address line 1 is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (cityField.value.length == 0) {
        message.innerHTML = "city is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (countryField.value == 0) {
        message.innerHTML = "select a country";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else {

        message.innerHTML = "";
        message.classList = "";
        backToTop(cbody);

        var formData = new FormData();

        formData.append("email", emailField.value);

        formData.append("no", noField.value);
        formData.append("line1", line1Field.value);
        formData.append("line2", line2Field.value);
        formData.append("city", cityField.value);
        formData.append("country", countryField.value);
        formData.append("img", formFileField.files[0]);




        fetch(baseUrl + "adminProfileUpdateProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {

                if (value.type == "success") {
                    message.innerHTML = "Profile Update Success";
                    message.classList = "alert alert-success";
                    backToTop(cbody);
                    setTimeout(() => {
                        window.location = "adminProfile.php";
                    }, 2000);
                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";
                    backToTop(cbody);
                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }



}

function backToTop(id) {
    id.scrollTop = 0;
}
function changeThePassword() {

    let oldPass = document.getElementById("oldPass").value;
    let newPass = document.getElementById("newPass").value;
    let repertPass = document.getElementById("repertPass").value;


    let message = document.getElementById("infoMessagePassword");
    if (oldPass.length == 0) {
        message.innerHTML = "Enter the Old Password";
        message.classList = "alert alert-danger";

    } else if (newPass.length == 0) {
        message.innerHTML = "Enter the New Password";
        message.classList = "alert alert-danger";

    } else if (newPass.length < 8 || newPass.length > 12) {
        message.innerHTML = "New Password must be larger than 8 and smaller than 12 Characters";
        message.classList = "alert alert-danger";

    } else if (repertPass.length == 0) {
        message.innerHTML = "Repeat the New Password";
        message.classList = "alert alert-danger";

    } else if (newPass != repertPass) {
        message.innerHTML = "Repeat the Password Correctly ";
        message.classList = "alert alert-danger";

    } else {


        var send = {
            "oldPassword": oldPass,
            "newPassword": newPass,
            "repeatPassword": repertPass
        }
        fetch(baseUrl + "changeThePasswordProcess.php", {
            method: "POST",
            headers: {

                "Content-Type": "application/json;charset=UTF-8"
            }, body: JSON.stringify(send),

        })
            .then(function (resp) {

                return resp.json();
            })
            .then(function (value) {

                if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";
                } else if (value.type == "success") {
                    message.innerHTML = "Profile Update Success";
                    message.classList = "alert alert-success";

                    setTimeout(() => {
                        window.location = "adminProfile.php";
                    }, 2000);
                }
            })
            .catch(function (error) {
                console.log(error);
            });


    }



}

function getThePositionForDepartment() {


    var department = document.getElementById("department").value;
    var positionTag = document.getElementById("position");


    positionTag.innerHTML = "";

    if (department != 0) {
        fetch(baseUrl + "getPositionForDepartment.php", {
            method: "POST",
            headers: {

                "Content-Type": "application/json;charset=UTF-8"
            }, body: JSON.stringify(department),

        })
            .then(function (resp) {

                return resp.json();
            })
            .then(function (value) {

                if (value.type == "error") {

                } else if (value.type == "success") {

                    for (let index = 0; index < value.message.length; index++) {
                        var option = document.createElement("option");
                        option.innerHTML = value.message[index][1];
                        option.value = value.message[index][0];
                        positionTag.appendChild(option);
                    }



                }
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        positionTag.innerHTML = "";
    }



}

function registerNewUser(type) {


    let surnameField = document.getElementById("sname");
    let fnameField = document.getElementById("fname");
    let mnameField = document.getElementById("mname");
    let lnameField = document.getElementById("lname");

    let emailField = document.getElementById("email");
    let mobileField = document.getElementById("mobile");
    let nicField = document.getElementById("nic");
    let dobField = document.getElementById("dob");

    let genderField = document.getElementById("gender");
    let positionField = document.getElementById("position");
    let jadeTimesIdField = document.getElementById("jtid");

    let durationField = document.getElementById("duration");
    let linkdinField = document.getElementById("linkdin");
    let noField = document.getElementById("no");
    let line1Field = document.getElementById("line1");
    let line2Field = document.getElementById("line2");
    let cityField = document.getElementById("city");
    let country = document.getElementById("country");

    let passwordField = document.getElementById("password");

    let regDateField = document.getElementById("regDate");

    let message = document.getElementById("infoMessageProfileUpdate");
    let cbody = document.getElementById("cbody");




    let userType = "";


    const regex = /^\+?\d+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    const nicregex = /^[a-zA-Z0-9\- ]+$/;


    if (passwordField.value.length == 0) {
        message.innerHTML = "Please Reload the Page";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    }
    else if (fnameField.value.length == 0) {

        message.innerHTML = "First Name is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (lnameField.value.length == 0) {
        message.innerHTML = "Last Name is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (jadeTimesIdField.value.length == 0) {
        message.innerHTML = "Add the jadeTimes id";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (type == "superAdmin" && document.getElementById("type").value == 0) {
        message.innerHTML = "Select a User type";
        message.classList = "alert alert-danger";
        backToTop(cbody);


    } else if (emailField.value.length == 0) {
        message.innerHTML = "Email is Empty";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (!emailRegex.test(emailField.value)) {
        message.innerHTML = "Email is Invalid";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if ((mobileField.value.length != 0 && !regex.test(mobileField.value)) || mobileField.value.length > 16) {
        message.innerHTML = "Invalid Mobile number";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (nicField.value.length != 0 && !nicregex.test(nicField.value)) {
        message.innerHTML = "Invalid Nic";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (dobField.value.length != 0 && new Date(dobField.value) >= new Date()) {
        message.innerHTML = "Invalid DOB";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else if (positionField.value == 0) {
        message.innerHTML = "Select the Position Of the User";
        message.classList = "alert alert-danger";
        backToTop(cbody);

    } else {

        message.innerHTML = "";
        message.classList = "";

        if (type == "superAdmin") {
            userType = document.getElementById("type").value;
        }

        var formData = new FormData();
        formData.append("sname", surnameField.value);
        formData.append("fname", fnameField.value);
        formData.append("mname", mnameField.value);
        formData.append("lname", lnameField.value);
        formData.append("email", emailField.value);
        formData.append("mobile", mobileField.value);
        formData.append("nic", nicField.value);
        formData.append("dob", dobField.value);
        formData.append("gender", genderField.value);
        formData.append("position", positionField.value);
        formData.append("dob", dobField.value);
        formData.append("password", passwordField.value);
        formData.append("jtid", jadeTimesIdField.value);

        formData.append("duration", durationField.value);
        formData.append("linkdin", linkdinField.value);

        formData.append("no", noField.value);
        formData.append("line1", line1Field.value);
        formData.append("line2", line2Field.value);
        formData.append("city", cityField.value);
        formData.append("country", country.value);


        formData.append("type", userType);


        formData.append("regDate", regDateField.value);

        fetch(baseUrl + "registerNewUserProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {


                if (value.type == "success") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-success";
                    backToTop(cbody);
                    setTimeout(() => {
                        window.location = "ManageUser.php";
                    }, 2000);
                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";
                    backToTop(cbody);
                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }

}

function loadUserDateToFront(stat) {



    var searchtext = document.getElementById("searchname");
    var searchemail = document.getElementById("searchemail");
    var searchid = document.getElementById("searchid");
    var searchposition = document.getElementById("searchposition");
    var searchtype = document.getElementById("searchtype");
    var searchstatus = document.getElementById("searchstatus");


    var ele = document.getElementsByName('btnradio');
    var dip = ""
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
            dip = ele[i].value;
        }

    }
    var page = 1;

    if (stat == 2) {
        var pagi = document.getElementsByName('pagi');

        for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
                page = Number(pagi[j].value);
            }

        }
    }


    var formData = new FormData();
    formData.append("searchText", searchtext.value);
    formData.append("searchemail", searchemail.value);
    formData.append("searchid", searchid.value);
    formData.append("searchposition", searchposition.value);
    formData.append("searchtype", searchtype.value);
    formData.append("searchstatus", searchstatus.value);
    formData.append("department", dip);
    formData.append("page", page);






    var tablebody = document.getElementById("tableBodyUser");
    tablebody.innerHTML = "";
    fetch(baseUrl + "userLoadProcess.php", {
        method: "POST",
        body: formData,


    }).then(function (resp) {
        return resp.json();

    })
        .then(function (value) {

            var pagicontainer = document.getElementById('pagicontainer');
            pagicontainer.innerHTML = "";

            if (value.type == "success") {
                var userSearchData = value.message;

                for (let index = 0; index < userSearchData.length; index++) {
                    const user = userSearchData[index];

                    const newRow = document.createElement('tr');
                    newRow.onclick = function () {
                        window.location = " adminUserDetails.php?userEmail=" + user[2];
                    }


                    const nocell = document.createElement('td');
                    nocell.textContent = index + 1;
                    const idCell = document.createElement('td');
                    idCell.textContent = user[4];

                    const roleCell = document.createElement('td');
                    roleCell.textContent = user[0] + " " + user[1];

                    const addressCell = document.createElement('td');
                    addressCell.textContent = user[2];

                    const ageCell = document.createElement('td');
                    ageCell.textContent = user[3];

                    const startDateCell = document.createElement('td');
                    startDateCell.textContent = user[7];

                    const endDateCell = document.createElement('td');
                    endDateCell.textContent = user[6];

                    const salaryCell = document.createElement('td');
                    salaryCell.textContent = user[5];

                    const lastUpdatedCell = document.createElement('td');
                    lastUpdatedCell.textContent = user[10];
                    
                    const durationCell = document.createElement('td');
                    durationCell.textContent = user[11];

                    const nextUpdateCell = document.createElement('td');
                    nextUpdateCell.textContent = user[8];

                    newRow.appendChild(nocell);
                    newRow.appendChild(idCell);
                    newRow.appendChild(roleCell);
                    newRow.appendChild(addressCell);
                    newRow.appendChild(ageCell);
                    newRow.appendChild(startDateCell);
                    newRow.appendChild(endDateCell);
                    newRow.appendChild(salaryCell);
                    newRow.appendChild(lastUpdatedCell);
                         newRow.appendChild(durationCell);
                    newRow.appendChild(nextUpdateCell);


                    tablebody.appendChild(newRow);
                }


                var btnCount = value.buttoncount;


                var firstpagi = document.createElement('input');
                firstpagi.type = 'radio';
                firstpagi.className = 'btn-check';
                firstpagi.name = 'pagi';
                firstpagi.id = 'firstpagi';

                firstpagi.value = 1;
                firstpagi.onchange = function () {
                    loadUserDateToFront(2);
                }



                var firstlabel = document.createElement('label');
                firstlabel.className = 'btn btn-outline-info removeCorner';
                firstlabel.htmlFor = 'firstpagi';
                firstlabel.innerText = "First";



                pagicontainer.appendChild(firstpagi);
                pagicontainer.appendChild(firstlabel);



                var startPage = 1;

                var endpage = 5;



                var val = page + 4;





                if ((page + 4) < btnCount) {
                    endpage = page + 4;
                    startPage = page;

                } else {

                    if (btnCount >= 5) {
                        startPage = btnCount - 4;

                    } else {

                        startPage = 1;

                    }
                    endpage = btnCount;
                }



                if (page != 1 && btnCount > 5) {
                    var frontPagi = document.createElement('input');
                    frontPagi.type = 'radio';
                    frontPagi.className = 'btn-check';
                    frontPagi.name = 'pagi';
                    frontPagi.id = 'btnpagifront';

                    frontPagi.value = Number(startPage) - 1;
                    frontPagi.onchange = function () {
                        loadUserDateToFront(2);
                    }

                    var labelfrontpagi = document.createElement('label');
                    labelfrontpagi.className = 'btn btn-outline-info removeCorner';
                    labelfrontpagi.htmlFor = 'btnpagifront';
                    labelfrontpagi.innerText = Number(startPage) - 1;



                    pagicontainer.appendChild(frontPagi);
                    pagicontainer.appendChild(labelfrontpagi);

                }

                for (let i = startPage - 1; i < endpage; i++) {



                    var radioButton = document.createElement('input');
                    radioButton.type = 'radio';
                    radioButton.className = 'btn-check';
                    radioButton.name = 'pagi';
                    radioButton.id = 'btnpagi' + i;
                    var pageVal = i + 1;
                    radioButton.value = pageVal;
                    radioButton.onchange = function () {
                        loadUserDateToFront(2);
                    }
                    if (page == pageVal) {
                        radioButton.checked = true;
                    }


                    var label = document.createElement('label');
                    label.className = 'btn btn-outline-info removeCorner';
                    label.htmlFor = 'btnpagi' + i;
                    label.innerText = pageVal;



                    pagicontainer.appendChild(radioButton);
                    pagicontainer.appendChild(label);

                }


                var lastpagi = document.createElement('input');
                lastpagi.type = 'radio';
                lastpagi.className = 'btn-check';
                lastpagi.name = 'pagi';
                lastpagi.id = 'lastpagi';

                lastpagi.value = btnCount;
                lastpagi.onchange = function () {
                    loadUserDateToFront(2);
                }



                var lastlabel = document.createElement('label');
                lastlabel.className = 'btn btn-outline-info removeCorner';
                lastlabel.htmlFor = 'lastpagi';
                lastlabel.innerText = "Last (" + btnCount + ")";



                pagicontainer.appendChild(lastpagi);
                pagicontainer.appendChild(lastlabel);




            } else if (value.type = "error") {

                tablebody.innerHTML = value.message;

            }
        })
        .catch(function (error) {
            console.log(error);
        });



}

function clearSearchData() {

    var searchtext = document.getElementById("searchname");
    var searchemail = document.getElementById("searchemail");
    var searchid = document.getElementById("searchid");
    var searchposition = document.getElementById("searchposition");
    var searchtype = document.getElementById("searchtype");
    var searchstatus = document.getElementById("searchstatus");


    searchtext.value = "";

    searchemail.value = "";
    searchid.value = "";
    searchposition.value = "";
    searchtype.value = 0;
    searchstatus.value = 1;


    loadUserDateToFront(1);


}

function updateUserEmail() {

    var email = document.getElementById("email");
    var newemail = document.getElementById("newemail");

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    let message = document.getElementById("emailMessage");

    if (email.value.length == 0) {
        message.innerHTML = "Please Reload the Page";
        message.classList = "alert alert-danger";
    } else if (newemail.value.length == 0) {
        message.innerHTML = "Add user new Email";
        message.classList = "alert alert-danger";
    } else if (!emailRegex.test(newemail.value)) {
        message.innerHTML = "User New email is Invalid";
        message.classList = "alert alert-danger";
    } else {
        message.innerHTML = "";
        message.classList = "";




        var formData = new FormData();
        formData.append("email", email.value);
        formData.append("newemail", newemail.value);

        fetch(baseUrl + "changeUserEmailProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {


                if (value.type == "success") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-success";

                    setTimeout(() => {
                        window.location = "adminUserDetails.php?userEmail=" + newemail.value;
                    }, 2000);


                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";

                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }
}

function loadUserAttendance(stat) {


    var selectUser = document.getElementById("select-state");
    var markStatus = document.getElementById("markStatus");

    var from = document.getElementById("from");
    var to = document.getElementById("to");





    var ele = document.getElementsByName('btnradio');
    var dip = ""
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
            dip = ele[i].value;
        }

    }
    var page = 1;

    if (stat == 2) {
        var pagi = document.getElementsByName('pagi');

        for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
                page = Number(pagi[j].value);
            }

        }
    }

    if (markStatus.value == 1 || markStatus.value == 3) {

        if (from.value.length == 0) {
            var today = new Date();


            var year = today.getFullYear();
            var month = ('0' + (today.getMonth() + 1)).slice(-2);
            var day = ('0' + today.getDate()).slice(-2);
            var formattedDate = year + '-' + month + '-' + day;


            from.value = formattedDate;
        }
        to.value = "";

    }


    var formData = new FormData();
    formData.append("selectUser", selectUser.value);
    formData.append("from", from.value);
    formData.append("to", to.value);
    formData.append("mark", markStatus.value);

    formData.append("order", dip);
    formData.append("page", page);






    var tablebody = document.getElementById("tableBodyUser");
    tablebody.innerHTML = "";
    fetch(baseUrl + "userAttendanceLoadProcess.php", {
        method: "POST",
        body: formData,


    }).then(function (resp) {
        return resp.json();

    })
        .then(function (value) {

            var pagicontainer = document.getElementById('pagicontainer');
            pagicontainer.innerHTML = "";

            if (value.type == "success") {
                var userSearchData = value.message;

                for (let index = 0; index < userSearchData.length; index++) {
                    const user = userSearchData[index];

                    const newRow = document.createElement('tr');
                    if (user[7] != null) {
                        newRow.onclick = function () {
                            window.location = "singleAttendanceVIew.php?aId=" + user[8];
                        }

                    }



                    const nocell = document.createElement('td');
                    nocell.textContent = index + 1;
                    const idCell = document.createElement('td');
                    idCell.textContent = user[4];

                    const roleCell = document.createElement('td');
                    roleCell.textContent = user[0] + " " + user[1];

                    const addressCell = document.createElement('td');
                    addressCell.textContent = user[2];

                    const endDateCell = document.createElement('td');
                    // endDateCell.textContent = user[6];
                    if (user[7] == null) {
                        endDateCell.innerText = "NOT";
                        endDateCell.style = "background-color: #ff0d0d"
                        endDateCell.classList = "text-black text-center backGroundRed";
                    } else {
                        endDateCell.textContent = user[6];
                    }

                    const salaryCell = document.createElement('td');
                    // salaryCell.innerText = "Marked";
                    // salaryCell.classList = "bg-success text-black text-center";
                    if (user[7] == null) {
                        salaryCell.innerText = "Marked";
                        salaryCell.style = "background-color: #ff0d0d";
                        salaryCell.classList = "text-black text-center backGroundRed";
                    } else {
                        salaryCell.innerText = "Marked";
                        salaryCell.classList = "bg-success text-black text-center";
                    }


                    newRow.appendChild(nocell);
                    newRow.appendChild(idCell);
                    newRow.appendChild(roleCell);
                    newRow.appendChild(addressCell);


                    newRow.appendChild(endDateCell);
                    newRow.appendChild(salaryCell);

                    tablebody.appendChild(newRow);
                }

                document.getElementById("markedCount").innerText = value.marked;
                document.getElementById("notMarkedCount").innerText = (value.total - value.marked);


                var btnCount = value.buttoncount;


                var firstpagi = document.createElement('input');
                firstpagi.type = 'radio';
                firstpagi.className = 'btn-check';
                firstpagi.name = 'pagi';
                firstpagi.id = 'firstpagi';

                firstpagi.value = 1;
                firstpagi.onchange = function () {
                    loadUserAttendance(2);
                }



                var firstlabel = document.createElement('label');
                firstlabel.className = 'btn btn-outline-info removeCorner';
                firstlabel.htmlFor = 'firstpagi';
                firstlabel.innerText = "First";



                pagicontainer.appendChild(firstpagi);
                pagicontainer.appendChild(firstlabel);



                var startPage = 1;

                var endpage = 5;



                var val = page + 4;





                if ((page + 4) < btnCount) {
                    endpage = page + 4;
                    startPage = page;

                } else {

                    if (btnCount >= 5) {
                        startPage = btnCount - 4;

                    } else {

                        startPage = 1;

                    }
                    endpage = btnCount;
                }



                if (page != 1 && btnCount > 5) {
                    var frontPagi = document.createElement('input');
                    frontPagi.type = 'radio';
                    frontPagi.className = 'btn-check';
                    frontPagi.name = 'pagi';
                    frontPagi.id = 'btnpagifront';

                    frontPagi.value = Number(startPage) - 1;
                    frontPagi.onchange = function () {
                        loadUserAttendance(2);
                    }

                    var labelfrontpagi = document.createElement('label');
                    labelfrontpagi.className = 'btn btn-outline-info removeCorner';
                    labelfrontpagi.htmlFor = 'btnpagifront';
                    labelfrontpagi.innerText = Number(startPage) - 1;



                    pagicontainer.appendChild(frontPagi);
                    pagicontainer.appendChild(labelfrontpagi);

                }

                for (let i = startPage - 1; i < endpage; i++) {



                    var radioButton = document.createElement('input');
                    radioButton.type = 'radio';
                    radioButton.className = 'btn-check';
                    radioButton.name = 'pagi';
                    radioButton.id = 'btnpagi' + i;
                    var pageVal = i + 1;
                    radioButton.value = pageVal;
                    radioButton.onchange = function () {
                        loadUserAttendance(2);
                    }
                    if (page == pageVal) {
                        radioButton.checked = true;
                    }


                    var label = document.createElement('label');
                    label.className = 'btn btn-outline-info removeCorner';
                    label.htmlFor = 'btnpagi' + i;
                    label.innerText = pageVal;



                    pagicontainer.appendChild(radioButton);
                    pagicontainer.appendChild(label);

                }


                var lastpagi = document.createElement('input');
                lastpagi.type = 'radio';
                lastpagi.className = 'btn-check';
                lastpagi.name = 'pagi';
                lastpagi.id = 'lastpagi';

                lastpagi.value = btnCount;
                lastpagi.onchange = function () {
                    loadUserAttendance(2);
                }



                var lastlabel = document.createElement('label');
                lastlabel.className = 'btn btn-outline-info removeCorner';
                lastlabel.htmlFor = 'lastpagi';
                lastlabel.innerText = "Last (" + btnCount + ")";



                pagicontainer.appendChild(lastpagi);
                pagicontainer.appendChild(lastlabel);




            } else if (value.type = "error") {

                tablebody.innerHTML = value.message;
                document.getElementById("markedCount").innerText = "0";
                document.getElementById("notMarkedCount").innerText = "0";

            }
        })
        .catch(function (error) {
            console.log(error);
        });



}


function clearSearchDataAttendance() {

    var selectUser = document.getElementById("select-state");


    var from = document.getElementById("from");
    var to = document.getElementById("to");

    selectUser.value = 0;
    from.value = "";
    to.value = "";
    document.getElementById("exampleRadios2").checked = true;

    document.getElementById("markStatus").value = 2;
    loadUserAttendance(1);



}

function adminMarkUserAttendance() {


    var user = document.getElementById("adduser");
    var date = document.getElementById("addDate");
    var tasks = document.getElementById("addtask");


    var message = document.getElementById("attendanceinfoMessage");


    if (user.value == 0) {
        message.innerHTML = "Please Select a User";
        message.classList = "alert alert-danger";

    } else if (date.value.length == 0) {
        message.innerHTML = "Please Add a Date";
        message.classList = "alert alert-danger";
    } else if (tasks.value.length == 0) {
        message.innerHTML = "Add user's tasks";
        message.classList = "alert alert-danger";
    } else {


        var formData = new FormData();
        formData.append("user", user.value);
        formData.append("date", date.value);
        formData.append("task", tasks.value);

        fetch(baseUrl + "adminSubmitAttendanceProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {


                if (value.type == "success") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-success";
                    date.value = "";
                    tasks.value = "";
                    loadUserAttendance(1);

                    setTimeout(() => {
                        message.innerHTML = "";
                        message.classList = "d-none";
                    }, 1200);


                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";

                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }

}

function adminAddLeave() {

    var user = document.getElementById("adduser");
    var date = document.getElementById("addDate");
    var reason = document.getElementById("addreason");
    var type = document.getElementById("addtype");



    var message = document.getElementById("attendanceinfoMessage");


    if (user.value == 0) {
        message.innerHTML = "Please Select a User";
        message.classList = "alert alert-danger";

    } else if (date.value.length == 0) {
        message.innerHTML = "Please Add a Date";
        message.classList = "alert alert-danger";
    } else if (reason.value.length == 0) {
        message.innerHTML = "Add user's reason";
        message.classList = "alert alert-danger";
    } else {


        var formData = new FormData();
        formData.append("user", user.value);
        formData.append("date", date.value);
        formData.append("reason", reason.value);
        formData.append("type", type.value);

        fetch(baseUrl + "adminSubmitLeaveProcess.php", {
            method: "POST",
            body: formData,

        }).then(function (resp) {
            return resp.json();

        })
            .then(function (value) {


                if (value.type == "success") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-success";
                    user.value = 0;
                    date.value = "";
                    reason.value = "";
                    loadUserLeaves(1);

                    setTimeout(() => {
                        message.innerHTML = "";
                        message.classList = "d-none";
                    }, 1200);


                } else if (value.type == "error") {
                    message.innerHTML = value.message;
                    message.classList = "alert alert-danger";

                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }

}




function loadUserLeaves(stat) {


    var selectUser = document.getElementById("select-state");

    var from = document.getElementById("from");
    var to = document.getElementById("to");
    var status = document.getElementById("status");




    var ele = document.getElementsByName('btnradio');
    var dip = ""
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked) {
            dip = ele[i].value;
        }

    }
    var page = 1;

    if (stat == 2) {
        var pagi = document.getElementsByName('pagi');

        for (j = 0; j < pagi.length; j++) {
            if (pagi[j].checked) {
                page = Number(pagi[j].value);
            }

        }
    }


    var formData = new FormData();
    formData.append("selectUser", selectUser.value);
    formData.append("from", from.value);
    formData.append("to", to.value);

    formData.append("order", dip);
    formData.append("status", status.value);
    formData.append("page", page);






    var tablebody = document.getElementById("tableBodyUser");
    tablebody.innerHTML = "";
    fetch(baseUrl + "userLeavesLoadProcess.php", {
        method: "POST",
        body: formData,


    }).then(function (resp) {
        return resp.json();

    })
        .then(function (value) {

            var pagicontainer = document.getElementById('pagicontainer');
            pagicontainer.innerHTML = "";

            if (value.type == "success") {
                var userSearchData = value.message;

                for (let index = 0; index < userSearchData.length; index++) {
                    const user = userSearchData[index];

                    const newRow = document.createElement('tr');
                    newRow.onclick = function () {
                        window.location = "singleLeaveVIew.php?aId=" + user[6];
                    }


                    const nocell = document.createElement('td');
                    nocell.textContent = index + 1;
                    const idCell = document.createElement('td');
                    idCell.textContent = user[3];

                    const roleCell = document.createElement('td');
                    roleCell.textContent = user[0] + " " + user[1];

                    const addressCell = document.createElement('td');
                    addressCell.textContent = user[2];

                    const endDateCell = document.createElement('td');
                    endDateCell.textContent = user[4];

                    const salaryCell = document.createElement('td');

                    if (user[5] == 1) {
                        salaryCell.innerText = "Pending";
                        salaryCell.classList = "bg-info text-black text-center";
                    } else if (user[5] == 2) {
                        salaryCell.innerText = "Approved";
                        salaryCell.classList = "bg-success text-black text-center";
                    } else if (user[5] == 3) {
                        salaryCell.innerText = "Rejected";
                        salaryCell.classList = "bg-danger text-black text-center";
                    } else if (user[5] == 4){

                        salaryCell.innerText = "Emergency";
                        salaryCell.classList = "bg-warning text-black text-center";
                    }else{
                     salaryCell.innerText = "Special Leave";
                        salaryCell.classList = "bg-primary text-black text-center";
                    }



                    newRow.appendChild(nocell);
                    newRow.appendChild(idCell);
                    newRow.appendChild(roleCell);
                    newRow.appendChild(addressCell);


                    newRow.appendChild(endDateCell);
                    newRow.appendChild(salaryCell);

                    tablebody.appendChild(newRow);
                }


                var btnCount = value.buttoncount;


                var firstpagi = document.createElement('input');
                firstpagi.type = 'radio';
                firstpagi.className = 'btn-check';
                firstpagi.name = 'pagi';
                firstpagi.id = 'firstpagi';

                firstpagi.value = 1;
                firstpagi.onchange = function () {
                    loadUserLeaves(2);
                }



                var firstlabel = document.createElement('label');
                firstlabel.className = 'btn btn-outline-info removeCorner';
                firstlabel.htmlFor = 'firstpagi';
                firstlabel.innerText = "First";



                pagicontainer.appendChild(firstpagi);
                pagicontainer.appendChild(firstlabel);



                var startPage = 1;

                var endpage = 5;



                var val = page + 4;





                if ((page + 4) < btnCount) {
                    endpage = page + 4;
                    startPage = page;

                } else {

                    if (btnCount >= 5) {
                        startPage = btnCount - 4;

                    } else {

                        startPage = 1;

                    }
                    endpage = btnCount;
                }



                if (page != 1 && btnCount > 5) {
                    var frontPagi = document.createElement('input');
                    frontPagi.type = 'radio';
                    frontPagi.className = 'btn-check';
                    frontPagi.name = 'pagi';
                    frontPagi.id = 'btnpagifront';

                    frontPagi.value = Number(startPage) - 1;
                    frontPagi.onchange = function () {
                        loadUserLeaves(2);
                    }

                    var labelfrontpagi = document.createElement('label');
                    labelfrontpagi.className = 'btn btn-outline-info removeCorner';
                    labelfrontpagi.htmlFor = 'btnpagifront';
                    labelfrontpagi.innerText = Number(startPage) - 1;



                    pagicontainer.appendChild(frontPagi);
                    pagicontainer.appendChild(labelfrontpagi);

                }

                for (let i = startPage - 1; i < endpage; i++) {



                    var radioButton = document.createElement('input');
                    radioButton.type = 'radio';
                    radioButton.className = 'btn-check';
                    radioButton.name = 'pagi';
                    radioButton.id = 'btnpagi' + i;
                    var pageVal = i + 1;
                    radioButton.value = pageVal;
                    radioButton.onchange = function () {
                        loadUserLeaves(2);
                    }
                    if (page == pageVal) {
                        radioButton.checked = true;
                    }


                    var label = document.createElement('label');
                    label.className = 'btn btn-outline-info removeCorner';
                    label.htmlFor = 'btnpagi' + i;
                    label.innerText = pageVal;



                    pagicontainer.appendChild(radioButton);
                    pagicontainer.appendChild(label);

                }


                var lastpagi = document.createElement('input');
                lastpagi.type = 'radio';
                lastpagi.className = 'btn-check';
                lastpagi.name = 'pagi';
                lastpagi.id = 'lastpagi';

                lastpagi.value = btnCount;
                lastpagi.onchange = function () {
                    loadUserLeaves(2);
                }



                var lastlabel = document.createElement('label');
                lastlabel.className = 'btn btn-outline-info removeCorner';
                lastlabel.htmlFor = 'lastpagi';
                lastlabel.innerText = "Last (" + btnCount + ")";



                pagicontainer.appendChild(lastpagi);
                pagicontainer.appendChild(lastlabel);




            } else if (value.type = "error") {

                tablebody.innerHTML = value.message;

            }
        })
        .catch(function (error) {
            console.log(error);
        });



}

function clearSearchDataLeave() {

    var selectUser = document.getElementById("select-state");
    var status = document.getElementById("status");
    var from = document.getElementById("from");
    var to = document.getElementById("to");

    selectUser.value = 0;
    from.value = "";
    to.value = "";
    status.value = 0;
    document.getElementById("exampleRadios2").checked = true;

    loadUserLeaves(1);



}

function updateLeaveStatus(uid) {

    var leaveState = document.getElementById("leave_state");
    var message = document.getElementById("infoMessage");

    var formData = new FormData();
    formData.append("leaveState", leaveState.value);
    formData.append("uid", uid);


    fetch(baseUrl + "updateLeaveStatus.php", {
        method: "POST",
        body: formData,

    }).then(function (resp) {

        return resp.json();

    })
        .then(function (value) {


            if (value.type == "success") {
                message.innerHTML = value.message;
                message.classList = "alert alert-success";

                setTimeout(() => {
                    window.location = "singleLeaveVIew.php?aId=" + uid;
                }, 1000);

            } else if (value.type == "error") {
                message.innerHTML = value.message;
                message.classList = "alert alert-danger";

            }

        })
        .catch(function (error) {
            console.log(error);
        });

}

function requestForLeave() {


    var msg = document.getElementById("infoMessage");
    var date = document.getElementById("date");
    var reason = document.getElementById("reason");

    var posibleDatesfilter = new Date(new Date().getTime() + (2 * 24 * 60 * 60 * 1000));


    var cbody = document.getElementById("mainRow");
    if (date.value.length == 0) {

        msg.innerHTML = "Date is Empty";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    }
    else if (new Date(date.value) < posibleDatesfilter) {
        msg.innerHTML = "Submit your leave request at least two days before. or use the emergency leave";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    }
    else if (reason.value.length == 0) {

        msg.innerHTML = "Reason is empty";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    } else if (reason.value.length > 1000) {

        msg.innerHTML = "Reason is too lengthy max characters 1000";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    } else {



        var formData = new FormData();
        formData.append("date", date.value);
        formData.append("reason", reason.value);


        fetch(baseUrl + "adminLeaveSubmitProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                    backToTop(cbody);
                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    backToTop(cbody);
                    setTimeout(() => {
                        window.location = "adminLeaves.php";
                    }, 2000);

                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                    backToTop(cbody);
                }

            })
            .catch(function (error) {
                console.log(error);
            });


    }

}

function loadUserAttendanceCalender() {


    fetch(baseUrl + "fetchAdminAttendanceProcess.php", {
        method: "POST",
        headers: {

            "Content-Type": "application/json;charset=UTF-8"
        },

    })
        .then(function (resp) {

            try {
                let response = resp.json();
                return response;
            } catch (error) {


            }

        })
        .then(function (value) {

            if (value.type == "info") {


                var attendanceArray = value.message;

                var eventArray = new Array();

                for (let index = 0; index < attendanceArray.length; index++) {
                    const element = attendanceArray[index];
                    var fetchDate = element[2];
                    var component = {
                        title: "Marked",
                        start: fetchDate.split(" ")[0],
                        color: "#90EE90",
                        constraint: 'availableForMeeting',

                    };
                    eventArray.push(component);
                }

                for (let index = 0; index < value.leave.length; index++) {
                    const element = value.leave[index];
                    var fetchDate = element[0];
                    var component = {
                        title: "On Leave",
                        start: fetchDate,
                        color: "#ff0d0d",
                        constraint: 'availableForMeeting',

                    };
                    eventArray.push(component);
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
        .catch(function (error) {
            console.log(error);
        });



}

function markAttendence() {


    var msg = document.getElementById("infoMessage");
    var date = document.getElementById("date");
    var task = document.getElementById("task");


    if (date.value.length == 0) {

        msg.innerHTML = "Date is Empty";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    } else if (task.value.length == 0) {

        msg.innerHTML = "Cannot submit empty task";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    } else if (task.value.length > 1000) {

        msg.innerHTML = "Task is too lengthy max characters 1000";
        msg.classList = "alert alert-danger";
        backToTop(cbody);
    } else {


        var send = {
            date: date.value,
            task: task.value,
        }

        fetch(baseUrl + "adminAttendanceMarkProcess.php", {
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
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "adminAttendence.php";
                    }, 1000);
                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });


    }

}


function changeTheUserStatus() {

    var stat = document.getElementById("flexSwitchCheckChecked");
    var email = document.getElementById("email");
    var msg = document.getElementById("infoMessage");
    var formData = new FormData();
    formData.append("status", stat.checked);
    formData.append("email", email.value);

    fetch(baseUrl + "changeUerStatus.php", {
        method: "POST",
        body: formData,

    })
        .then(function (resp) {

            try {
                let response = resp.json();
                return response;
            } catch (error) {

            }

        })
        .then(function (value) {

            if (value.type == "error") {
                msg.classList = "alert alert-danger";
                msg.innerHTML = value.message;

            } else if (value.type == "success") {
                msg.classList = "alert alert-success";
                msg.innerHTML = value.message;

            } else {
                msg.classList = "alert alert-danger";
                msg.innerHTML = "Something wrong please try again";

            }

        })
        .catch(function (error) {
            console.log(error);
        });

}

function addNewPosition() {

    var department = document.getElementById("department");
    var position = document.getElementById("position");
    var msg = document.getElementById("infoMessage");


    if (department.value == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Select a Department";
    } else if (position.value.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Position is Empty";
    } else {
        var formData = new FormData();
        formData.append("department", department.value);
        formData.append("position", position.value);

        fetch(baseUrl + "addNewPositionProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {

                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "managePositions.php";
                    }, 1000);


                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }


}

function updatePositionName(id, depid) {


    var position = document.getElementById("position" + id);
    var msg = document.getElementById("infoMessageUpdatePosition" + id);



    if (position.value.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Position is empty";

    } else {

        var formData = new FormData();
        formData.append("position", position.value);
        formData.append("id", id);
        formData.append("did", depid);


        fetch(baseUrl + "updatePositionProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {

                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "managePositions.php";
                    }, 1000);


                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }
}



function addNewDepartment() {

    var department = document.getElementById("addNewDepartment");
    var msg = document.getElementById("infoMessagedip");


    if (department.value.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Add a Department";
    } else {
        var formData = new FormData();
        formData.append("department", department.value);


        fetch(baseUrl + "addNewdepartmentProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {

                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "managePositions.php";
                    }, 1000);


                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }


}

function updateDepartmentName(id) {


    var department = document.getElementById("departmentupdate" + id);
    var msg = document.getElementById("infoMessageUpdatedepartment" + id);



    if (department.value.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Position is empty";

    } else {

        var formData = new FormData();
        formData.append("department", department.value);
        formData.append("id", id);



        fetch(baseUrl + "updateDepartmentProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {

                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "managePositions.php";
                    }, 1000);


                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });
    }
}


function changeUserTask() {

    var userTask = document.getElementById("userTask");
    var msg = document.getElementById("infoMessagetask");
    var email = document.getElementById("email");



    if (userTask.value.length == 0) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Task is empty";
    } else if (userTask.value.length > 1000) {
        msg.classList = "alert alert-danger";
        msg.innerHTML = "Task is too lengthy";
    } else {

        var formData = new FormData();
        formData.append("userTask", userTask.value);
        formData.append("email", email.value);

        fetch(baseUrl + "changeuserTaskProcess.php", {
            method: "POST",
            body: formData,

        })
            .then(function (resp) {

                try {
                    let response = resp.json();
                    return response;
                } catch (error) {

                }

            })
            .then(function (value) {

                if (value.type == "error") {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = value.message;

                } else if (value.type == "success") {
                    msg.classList = "alert alert-success";
                    msg.innerHTML = value.message;

                    setTimeout(() => {
                        window.location = "adminUserDetails.php?userEmail=" + email.value;
                    }, 1000);


                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";

                }

            })
            .catch(function (error) {
                console.log(error);
            });

    }
}

