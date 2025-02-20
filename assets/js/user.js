var baseUrl = "";

// function markAttendence() {

//     var msg = document.getElementById("infoMessage");
//     var date = document.getElementById("date");
//     var task = document.getElementById("task");




//     if (date.value.length == 0) {

//         msg.innerHTML = "Date is Empty";
//         msg.classList = "alert alert-danger";
//         backToTop(cbody);
//     } else if (task.value.length == 0) {

//         msg.innerHTML = "Cannot submit empty task";
//         msg.classList = "alert alert-danger";
//         backToTop(cbody);
//     } else if (task.value.length > 1000) {

//         msg.innerHTML = "Task is too lengthy max characters 1000";
//         msg.classList = "alert alert-danger";
//         backToTop(cbody);
//     } else {

//         var formData = new FormData();

//         formData.append("date", date.value);

//         formData.append("task", task.value);


//         fetch(baseUrl + "attendanceMarkProcess.php", {
//             method: "POST",
//             body: formData,

//         })
//             .then(function (resp) {

//                 try {
//                     let response = resp.json();
//                     return response;
//                 } catch (error) {
//                     msg.classList = "alert alert-danger";
//                     msg.innerHTML = "Something wrong please try again";
//                     emailField.classList = "form-control";
//                     passwordField.classList = "form-control";
//                 }

//             })
//             .then(function (value) {

//                 if (value.type == "error") {
//                     msg.classList = "alert alert-danger";
//                     msg.innerHTML = value.message;

//                 } else if (value.type == "success") {
//                     msg.classList = "alert alert-success";
//                     msg.innerHTML = value.message;

//                     setTimeout(() => {
//                         window.location = "userAttendence.php";
//                     }, 1000);
//                 } else {
//                     msg.classList = "alert alert-danger";
//                     msg.innerHTML = "Something wrong please try again";
//                     emailField.classList = "form-control";
//                     passwordField.classList = "form-control";
//                 }

//             })
//             .catch(function (error) {
//                 console.log(error);
//             });


//     }

// }
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
    fetch(baseUrl + "userHeadLeavesLoadProcess.php", {
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
                        window.location = "singleHeadLeaveVIew.php?aId=" + user[6];
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
                    } else {
                        salaryCell.innerText = "Emergency";
                        salaryCell.classList = "bg-warning text-black text-center";
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

function loadUserAttendanceHead(stat) {


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
    fetch(baseUrl + "userAttendanceLoadProcessToHead.php", {
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
                            window.location = "singleHeadAttendanceVIew.php?aId=" + user[8];
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
                    loadUserAttendanceHead(2);
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
                        loadUserAttendanceHead(2);
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
                        loadUserAttendanceHead(2);
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
                    loadUserAttendanceHead(2);
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
    loadUserAttendanceHead(1);



}
function updateUserProfile() {


    let emailField = document.getElementById("email");

    let noField = document.getElementById("no");
    let line1Field = document.getElementById("line1");
    let line2Field = document.getElementById("line2");
    let cityField = document.getElementById("city");
    let countryField = document.getElementById("country");


    let formFileField = document.getElementById("formFile");

    let message = document.getElementById("infoMessage");
    let cbody = document.getElementById("cbody");




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




        fetch(baseUrl + "userProfileUpdateProcess.php", {
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
                        window.location = "userProfile.php";
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

function changeImg() {
    var image = document.getElementById("formFile");
    var view = document.getElementById("view1");


    image.onchange = function () {
        var file = this.files[0];
        var url = window.URL.createObjectURL(file);

        view.src = url;

    }
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
    }
    else {

        var formData = new FormData();
        formData.append("date", date.value);
        formData.append("reason", reason.value);


        fetch(baseUrl + "userLeaveSubmitProcess.php", {
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
                    emailField.classList = "form-control";
                    passwordField.classList = "form-control";
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
                        window.location = "userLeaves.php";
                    }, 2000);

                } else {
                    msg.classList = "alert alert-danger";
                    msg.innerHTML = "Something wrong please try again";
                    emailField.classList = "form-control";
                    passwordField.classList = "form-control";
                    backToTop(cbody);
                }

            })
            .catch(function (error) {
                console.log(error);
            });


    }

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
        fetch(baseUrl + "changeTheUserPasswordProcess.php", {
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
                        window.location = "userProfile.php";
                    }, 2000);
                }
            })
            .catch(function (error) {
                console.log(error);
            });


    }



}

// function loadUserAttendance() {


//     fetch(baseUrl + "fetchAttendanceProcess.php", {
//         method: "POST",
//         headers: {

//             "Content-Type": "application/json;charset=UTF-8"
//         },

//     })
//         .then(function (resp) {

//             try {
//                 let response = resp.json();
//                 return response;
//             } catch (error) {
//                 msg.classList = "alert alert-danger";
//                 msg.innerHTML = "Something wrong please try again";
//                 emailField.classList = "form-control";
//                 passwordField.classList = "form-control";
//             }

//         })
//         .then(function (value) {

//             if (value.type == "info") {


//                 var attendanceArray = value.message;

//                 var eventArray = new Array();

//                 for (let index = 0; index < attendanceArray.length; index++) {
//                     const element = attendanceArray[index];
//                     var fetchDate = element[2];
//                     var component = {
//                         title: "Marked",
//                         start: fetchDate.split(" ")[0],
//                         color: "#90EE90",
//                         constraint: 'availableForMeeting',

//                     };
//                     eventArray.push(component);
//                 }

//                 for (let index = 0; index < value.pending.length; index++) {
//                     const element = value.pending[index];
//                     var fetchDate = element[0];
//                     var component = {
//                         title: "Pending",
//                         start: fetchDate.split(" ")[0],
//                         color: "#fee801",
//                         constraint: 'availableForMeeting',

//                     };
//                     eventArray.push(component);
//                 }

//                 for (let index = 0; index < value.leave.length; index++) {
//                     const element = value.leave[index];
//                     var fetchDate = element[0];
//                     if (element[1] == 2) {

//                         let component = {
//                             title: "Normal Leave",
//                             start: fetchDate,
//                             color: "#ff0d0d",
//                             constraint: 'availableForMeeting',

//                         };
//                         eventArray.push(component);
//                     } else if (element[1] == 4) {

//                         let component = {
//                             title: "Emergancy Leave",
//                             start: fetchDate,
//                             color: "#ffcc00",
//                             constraint: 'availableForMeeting',

//                         };
//                         eventArray.push(component);
//                     } else {

//                         let component = {
//                             title: "Special Leave",
//                             start: fetchDate,
//                             color: "#cc3300",
//                             constraint: 'availableForMeeting',

//                         };
//                         eventArray.push(component);
//                     }


//                 }


//                 var calendarEl = document.getElementById("dayGrid");
//                 var calendar = new FullCalendar.Calendar(calendarEl, {
//                     headerToolbar: {
//                         left: "prevYear,prev,next,nextYear today",
//                         center: "title",
//                         right: "dayGridMonth,dayGridWeek,dayGridDay",
//                     },
//                     initialDate: new Date().toISOString(),
//                     navLinks: true,
//                     editable: false,
//                     dayMaxEvents: true,

//                     events: eventArray,
//                 });






//                 calendar.render();

//             } else {
//                 msg.classList = "alert alert-danger";
//                 msg.innerHTML = "Something wrong please try again";
//                 emailField.classList = "form-control";
//                 passwordField.classList = "form-control";
//             }

//         })
//         .catch(function (error) {
//             console.log(error);
//         });



// }


function loadUserArticles(stat) {


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
    fetch(baseUrl + "userArticlessLoadProcess.php", {
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
                    idCell.textContent = user[3];

                    const roleCell = document.createElement('td');
                    roleCell.textContent = user[0] + " " + user[1] + " " + user[2];

                    const addressCell = document.createElement('td');
                    addressCell.textContent = user[5];

                    const endDateCell = document.createElement('td');
                    endDateCell.textContent = user[4];

                    const date = document.createElement('td');
                    date.textContent = user[6];

                    const salaryCell = document.createElement('td');

                    if (user[7] == 1) {
                        salaryCell.innerText = "Commercial";
                        salaryCell.classList = "bg-danger-subtle text-black text-center";
                    } else if (user[7] == 2) {
                        salaryCell.innerText = "non Commercial";
                        salaryCell.classList = "text-black text-center";
                    }



                    newRow.appendChild(nocell);
                    newRow.appendChild(idCell);
                    newRow.appendChild(roleCell);
                    newRow.appendChild(addressCell);


                    newRow.appendChild(endDateCell);
                    newRow.appendChild(date);
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
                    loadUserArticles(2);
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
                        loadUserArticles(2);
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
                        loadUserArticles(2);
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
                    loadUserArticles(2);
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






