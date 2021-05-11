$(document).ready(function () {

    if ($(".permission").val() == 'Super administrator' || $(".permission").val() == 'Administrator'){
        $(".form-box").show();
    }

    //date picker
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        endDate: '+0d',
        autoclose: true
    }).datepicker("setDate",'now');

    //tabs
    $(".listing_box").hide();
    $(".exportbtn").hide();


    $(".add_attendance").click(function (e) {
        e.preventDefault();

        $(".add_box").show();
        $(".listing_box").hide();
        $(".exportbtn").hide();
    });

    $(".list_attendance").click(function (e) {
        e.preventDefault();

        $(".add_box").hide();
        $(".listing_box").show();
        $(".exportbtn").show();

        getAttendance($(".permission").val(), $(".date").val());
    });

    getAttendance($(".permission").val(), $(".date").val());

    $("#myTable tbody").html("<tr><td colspan='6' align='center'>No available data</td></tr>");
    $("#ListmyTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>")
    
    function getTeacher(classID, permission, date) {
        if (classID === ''){
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/teacher.php',
                data: {attendance: true,all: true, date: $(".date").val() ,all: true, classID: $(".classID").val(),schoolkey: $(".schoolkey").val()},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        let cname = ''
                        if (data[i].classname == 'Primary') {
                            cname += 'P' + data[i].numbericname + data[i].section;
                        } else if (data[i].classname == 'Nursery') {
                            cname += 'N' + data[i].numbericname + data[i].section;
                        }
                        let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td>";

                        if (data[i].date == $(".date").val()){
                            html += "<td>"+data[i].date+"</td><td>";
                        }
                        else{
                            html += "<td>"+date+"</td><td>";
                        }

                        html += "<select class='form-control status'>";

                        if (data[i].status !== null && data[i].date === $(".date").val()) {
                            if (data[i].status =='Absent') {
                                html +="<option>Select attendance status</option><option selected>"+data[i].status+"</option><option>Present</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"'>Update</button> </td></tr>";
                            }else if (data[i].status =='Present') {
                                html +="<option>Select attendance status</option><option selected>"+data[i].status+"</option><option>Absent</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"'>Update</button> </td></tr>";
                            }
                        }else{
                            html +="<option selected>Select attendance status</option><option>Absent</option><option>Present</option></select></td><td><button class='btn btn-default submitdata' data-id='"+data[i].id+"'  data-classID='"+data[i].classID+"'>Submit</button> </td></tr>";
                        }

                        $("#myTable tbody").append(html);
                    }

                    //submit
                    $(".submitdata").click(function () {
                        submitAttendance($(this).attr("data-id"), $(this).attr("data-classID"), date, $(".status").val());
                    });

                    //update
                    $(".updatedata").click(function () {
                        $('#myTable tbody').find('tr').click( function(){
                            updateAttendance($(this).find(".updatedata").attr("data-attendance_id"), $(this).find(".updatedata").attr("data-id"), $(this).find(".updatedata").attr('data-classID'), date, $(this).find(".status > option:selected").val());
                        });
                    });
                }
            });
        }
        else {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/teacher.php',
                data: {attendance: true,date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val(),},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        let cname = ''
                        if (data[i].classname == 'Primary') {
                            cname += 'P' + data[i].numbericname + data[i].section;
                        } else if (data[i].classname == 'Nursery') {
                            cname += 'N' + data[i].numbericname + data[i].section;
                        }
                        let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td>";

                        if (data[i].date == $(".date").val()){
                            html += "<td>"+data[i].date+"</td><td>";
                        }
                        else{
                            html += "<td>"+date+"</td><td>";
                        }

                        html += "<select class='form-control status'>";

                        if (data[i].status !== null && data[i].date === $(".date").val()) {
                            if (data[i].status =='Absent') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Present</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"' >Update</button> </td></tr>";
                            }else if (data[i].status =='Present') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Absent</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"'>Update</button> </td></tr>";
                            }
                        }else{
                            html +="<option selected>Select attendance status</option><option>Absent</option><option>Present</option></select></td><td><button class='btn btn-default submitdata' data-id='"+data[i].id+"'  data-classID='"+data[i].classID+"'>Submit</button> </td></tr>";
                        }

                        $("#myTable tbody").append(html);
                    }

                    //submit
                    $(".submitdata").click(function () {
                        submitAttendance($(this).attr("data-id"), $(this).attr("data-classID"), date, $(".status").val());
                    });

                    //update
                    $(".updatedata").click(function () {
                        $('#myTable tbody').find('tr').click( function(){
                            updateAttendance($(this).find(".updatedata").attr("data-attendance_id"), $(this).find(".updatedata").attr("data-id"), $(this).find(".updatedata").attr('data-classID'), date, $(this).find(".status > option:selected").val());
                        });
                    });
                }
            });
        }
    }

    //get student attendance
    function getStudent(classID, permission, date) {
        if (classID === '' || classID === 0){
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/student.php',
                data: {attendance: true,date: $(".date").val() ,all: true, classID: $(".classID").val(),schoolkey: $(".schoolkey").val(),},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        let cname = ''
                        if (data[i].classname == 'Primary') {
                            cname += 'P' + data[i].numbericname + data[i].section;
                        } else if (data[i].classname == 'Nursery') {
                            cname += 'N' + data[i].numbericname + data[i].section;
                        }
                        let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].firstname+" "+data[i].lastname+"</td><td style='text-transform: uppercase'>"+cname+"</td>";

                        if (data[i].date == $(".date").val()){
                            html += "<td>"+data[i].date+"</td><td>";
                        }
                        else{
                            html += "<td>"+date+"</td><td>";
                        }

                        html += "<select class='form-control status'>";

                        if (data[i].status !== null && data[i].date === $(".date").val()) {
                            if (data[i].status =='Absent') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Present</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"' >Update</button> </td></tr>";
                            }else if (data[i].status =='Present') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Absent</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"'>Update</button> </td></tr>";
                            }
                        }else{
                            html +="<option selected>Select attendance status</option><option>Absent</option><option>Present</option></select></td><td><button class='btn btn-default submitdata' data-id='"+data[i].id+"'  data-classID='"+data[i].classID+"'>Submit</button> </td></tr>";
                        }

                        $("#myTable tbody").append(html);
                    }

                    //submit
                    $(".submitdata").click(function () {
                        submitAttendance($(this).attr("data-id"), $(this).attr("data-classID"), date, $(".status").val());
                    });

                    //update
                    $(".updatedata").click(function () {
                        $('#myTable tbody').find('tr').click( function(){
                            updateAttendance($(this).find(".updatedata").attr("data-attendance_id"), $(this).find(".updatedata").attr("data-id"), $(this).find(".updatedata").attr('data-classID'), date, $(this).find(".status > option:selected").val());
                        });
                    });
                }
            });
        }
        else {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/student.php',
                data: {attendance: true,date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val(),},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        let cname = ''
                        if (data[i].classname == 'Primary') {
                            cname += 'P' + data[i].numbericname + data[i].section;
                        } else if (data[i].classname == 'Nursery') {
                            cname += 'N' + data[i].numbericname + data[i].section;
                        }
                        let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].firstname+" "+data[i].lastname+"</td><td style='text-transform: uppercase'>"+cname+"</td>";

                        if (data[i].date == $(".date").val()){
                            html += "<td>"+data[i].date+"</td><td>";
                        }
                        else{
                            html += "<td>"+date+"</td><td>";
                        }

                        html += "<select class='form-control status'>";

                        if (data[i].status !== null && data[i].date === $(".date").val()) {
                            if (data[i].status =='Absent') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Present</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"' >Update</button> </td></tr>";
                            }else if (data[i].status =='Present') {
                                html +="<option value='"+data[i].status+"'>"+data[i].status+"</option><option>Absent</option></select></td><td><button class='btn btn-default updatedata' data-attendance_id='"+data[i].attendance_id+"' data-id='"+data[i].id+"' data-classID='"+data[i].classID+"'>Update</button> </td></tr>";
                            }
                        }else{
                            html +="<option selected>Select attendance status</option><option>Absent</option><option>Present</option></select></td><td><button class='btn btn-default submitdata' data-id='"+data[i].id+"'  data-classID='"+data[i].classID+"'>Submit</button> </td></tr>";
                        }

                        $("#myTable tbody").append(html);
                    }

                    //submit
                    $(".submitdata").click(function () {
                        submitAttendance($(this).attr("data-id"), $(this).attr("data-classID"), date, $(".status").val());
                    });

                    //update
                    $(".updatedata").click(function () {
                        $('#myTable tbody').find('tr').click( function(){
                            updateAttendance($(this).find(".updatedata").attr("data-attendance_id"), $(this).find(".updatedata").attr("data-id"), $(this).find(".updatedata").attr('data-classID'), date, $(this).find(".status > option:selected").val());
                        });
                    });
                }
            });
        }
    }

    $(".attendancetype").change(function () {
        $("#myTable tbody").html("");
        if ($(this).val() === 'Select type of attendance') {
            $(".error-attendancetype").html("Select type of attendance");
            $(".form-group-attendancetype").addClass("has-error");
            $(".label-attendancetype").addClass("text-danger");
        }else if ($(this).val() !== '' && $(".attendancetype").val() !== 'Select type of attendance' && $(".attendancetype").val() === 'Teacher'){
            getTeacher($(".classID").val(),$(".permission").val(),$('.date').val());
            getAttendance($(".permission").val(), $(".date").val());

            return;
        } else if ($(this).val() !== '' && $(this).val() === 'Student') {
            getAttendance($(".permission").val(), $(".date").val());
            getStudent($(".classID").val(),$(".permission").val(),$('.date').val());
            return;
        }
        else{
            $(".error-attendancetype").html("");
            $(".form-group-attendancetype").removeClass("has-error");
            $(".label-attendancetype").removeClass("text-danger");
            return;
        }
    });

    $(".date").change(function () {
        $("#myTable tbody").html("");
        if ($(this).val() !== '' && $(".attendancetype").val() !== 'Select type of attendance' && $(".attendancetype").val() === 'Teacher') {
            getTeacher($(".classID").val(),$(".permission").val(),$(this).val());
            getAttendance($(".permission").val(), $(".date").val());
        }else if ($(this).val() !== 'Select type of attendance' && $(".attendancetype").val() === 'Student') {
            getAttendance($(".permission").val(), $(".date").val());
            getStudent($(".classID").val(),$(".permission").val(),$('.date').val());
        }
        else if ($(this).val() == '') {
            $(".error-date").html("Select date");
            $(".form-group-date").addClass("has-error");
            $(".label-date").addClass("text-danger");
        }
    });

    //submit
    function submitAttendance(user_id, classID, date, status) {
        if (user_id == '' || classID == '' || date == '' || status =='Select attendance status'){
            alert("Please some data has missing, please check and try again")
        } else {
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/attendance.php',
                data: {
                    schoolkey: $(".schoolkey").val(),
                    session_id: $(".sessionid").val(),
                    type: $(".attendancetype").val(),
                    user_id: user_id,
                    classID: classID,
                    date: date,
                    status:status
                },
                success: function(data) {

                    $(".submit").prop("disabled", false);
                    $(".submit").html('Submit');

                    if(data.status == "success"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been saved successfully");

                        //retrieve
                        if ($(".attendancetype").val() === 'Teacher') {
                            getTeacher($(".classID").val(),$(".permission").val(),$(".date").val());
                            return;
                        }else if ($(".attendancetype").val() === 'Student') {
                            getStudent($(".classID").val(),$(".permission").val(),$(".date").val());
                            return
                        }

                    }else if (data.status == "exist") {
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").addClass("alert-warning");
                        $(".text-alert").html("Warning! Class data is already exist, please use different email");
                    }
                }
            });
        }
    }

    //update
    function updateAttendance(id,user_id, classID, date, status) {
        if (id == '' || user_id == '' || classID == '' || date == '' || status =='Select attendance status'){
            alert("Please some data has missing, please check and try again");
            return;
        } else {
            alert(date)
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/attendance.php',
                data: {
                    schoolkey: $(".schoolkey").val(),
                    session_id: $(".sessionid").val(),
                    user_id: user_id,
                    classID: classID,
                    date: date,
                    status:status,
                    isUpdate: true,
                    id: id
                },
                success: function(data) {

                    $(".submit").prop("disabled", false);
                    $(".submit").html('Submit');

                    if(data.status == "success"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been saved successfully");

                        //retrieve
                        if ($(".attendancetype").val() === 'Teacher') {
                            getTeacher($(".classID").val(),$(".permission").val(),$(".date").val());
                            return;
                        }else if ($(".attendancetype").val() === 'Student') {
                            getStudent($(".classID").val(),$(".permission").val(),$(".date").val());
                            return
                        }

                    }else if (data.status == "exist") {
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").addClass("alert-warning");
                        $(".text-alert").html("Warning! Class data is already exist, please use different email");
                    }
                }
            });
        }
    }

    //get attendance
    function getAttendance(permission, date) {
        if (date != undefined &&  $(".attendancetype").val() !== 'Select type of attendance'){
            if (permission == 'Super administrator' || permission == 'Administrator') {
                //for teachers
                if ($(".attendancetype").val() == 'Teacher'){
                    $.ajax({
                        type: 'GET',
                        url: '/schoolreport/controllers/attendance.php',
                        data: {teacher: true, attendancetype: $(".attendancetype").val(), all: true,date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val()},
                        success: function(data) {
                            $("#ListmyTable tbody").html("");
                            if (data.length == 0){
                                $("#ListmyTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>")
                            } else{
                                for (var i in data){
                                    let cname = ''
                                    if (data[i].classname == 'Primary') {
                                        cname += 'P' + data[i].numbericname + data[i].section;
                                    } else if (data[i].classname == 'Nursery') {
                                        cname += 'N' + data[i].numbericname + data[i].section;
                                    }
                                    let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td><td>"+date+"</td><td>"+data[i].status+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>";

                                    $("#ListmyTable tbody").append(html);
                                }
                                //delete
                                $(".delete").click(function () {
                                    $('#ListmyTable tbody').find('tr').click( function(){
                                        deleteAttendance($(this).find(".delete").attr("data-key"));
                                    });
                                });
                            }
                        }
                    });
                }else{
                    $.ajax({
                        type: 'GET',
                        url: '/schoolreport/controllers/attendance.php',
                        data: {student: true, attendancetype: $(".attendancetype").val(), all: true,date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val()},
                        success: function(data) {
                            $("#ListmyTable tbody").html("");
                            if (data.length == 0){
                                $("#ListmyTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>")
                            } else{
                                for (var i in data){
                                    let cname = ''
                                    if (data[i].classname == 'Primary') {
                                        cname += 'P' + data[i].numbericname + data[i].section;
                                    } else if (data[i].classname == 'Nursery') {
                                        cname += 'N' + data[i].numbericname + data[i].section;
                                    }
                                    let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td><td>"+date+"</td><td>"+data[i].status+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>";

                                    $("#ListmyTable tbody").append(html);
                                }
                                //delete
                                $(".delete").click(function () {
                                    $('#ListmyTable tbody').find('tr').click( function(){
                                        deleteAttendance($(this).find(".delete").attr("data-key"));
                                    });
                                });
                            }
                        }
                    });
                }
            }else{
                //for teachers
                if ($(".attendancetype").val() == 'Teacher'){
                    $.ajax({
                        type: 'GET',
                        url: '/schoolreport/controllers/attendance.php',
                        data: {teacher: true, attendancetype: $(".attendancetype").val(),date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val()},
                        success: function(data) {
                            $("#ListmyTable tbody").html("")
                            if (data.length == 0){
                                $("#ListmyTable tbody").html("<tr><td colspan='6' align='center'>No data available</td></tr>");
                            } else{
                                for (var i in data){
                                    let cname = ''
                                    if (data[i].classname == 'Primary') {
                                        cname += 'P' + data[i].numbericname + data[i].section;
                                    } else if (data[i].classname == 'Nursery') {
                                        cname += 'N' + data[i].numbericname + data[i].section;
                                    }
                                    let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td><td>"+date+"</td><td>"+data[i].status+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>";

                                    $("#ListmyTable tbody").append(html);
                                }
                                //delete
                                $(".delete").click(function () {
                                    $('#ListmyTable tbody').find('tr').click( function(){
                                        deleteAttendance($(this).find(".delete").attr("data-key"));
                                    });
                                });
                            }
                        }
                    });
                }else{
                    $.ajax({
                        type: 'GET',
                        url: '/schoolreport/controllers/attendance.php',
                        data: {student: true, attendancetype: $(".attendancetype").val(),date: $(".date").val() , classID: $(".classID").val(),schoolkey: $(".schoolkey").val()},
                        success: function(data) {
                            $("#ListmyTable tbody").html("")
                            if (data.length == 0){
                                $("#ListmyTable tbody").html("<tr><td colspan='5'>No data available</td></tr>")
                            } else{
                                for (var i in data){
                                    let cname = ''
                                    if (data[i].classname == 'Primary') {
                                        cname += 'P' + data[i].numbericname + data[i].section;
                                    } else if (data[i].classname == 'Nursery') {
                                        cname += 'N' + data[i].numbericname + data[i].section;
                                    }
                                    let html = "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].name+"</td><td style='text-transform: uppercase'>"+cname+"</td><td>"+date+"</td><td>"+data[i].status+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>";

                                    $("#ListmyTable tbody").append(html);
                                }
                                //delete
                                $(".delete").click(function () {
                                    $('#ListmyTable tbody').find('tr').click( function(){
                                        deleteAttendance($(this).find(".delete").attr("data-key"));
                                    });
                                });
                            }
                        }
                    });
                }
            }
        }
    }

    function deleteAttendance(id){
        if (confirm("Are you sure to delete this data")) {
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/attendance.php',
                data: {
                    id: id,
                    isDelete: true
                },
                success: function (data) {

                    if (data.status == "success") {
                        $(".alert-form-danger").css("display", "block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been deleted successfully");

                        //retrieve teachers
                        getAttendance($(".permission").val(), $(".date").val());

                        getTeacher($(".classID").val(),$(".permission").val(),$(this).val());

                        getStudent($(".classID").val(),$(".permission").val(),$('.date').val());
                    }
                }
            });
        }
    }

    $(".exportexcel").click(function () {
        exportEXCEL($(".schoolname").val(),$(".classname").text());
    });
    $(".exportpdf").click(function () {
        exportPDF($(".schoolname").val(),$(".classname").text());
    });

    //export
    function exportEXCEL(schoolname,classname) {
        if (classname == null){
            $('#ListmyTable').tableExport({
                fileName: "Attendance_"+schoolname,
                type: 'csv',
                ignoreColumn:[9],
                postCallback: function () {}
            });
        } else{
            $('#ListmyTable').tableExport({
                fileName: "Attendance_"+schoolname+"_"+classname,
                type: 'csv',
                ignoreColumn:[9],
                postCallback: function () {}
            });
        }
    }

    function exportPDF(schoolname, classname) {
        if (classname == null){
            $('#ListmyTable').tableExport({
                fileName: "Attendance_"+schoolname,
                type: 'pdf',
                jspdf: {
                    format: 'bestfit',
                    margins: {left: 20, right: 10, top: 20, bottom: 20},
                    autotable: {
                        styles: {overflow: 'linebreak'},
                        tableWidth: 'wrap',
                        tableExport: {
                            onBeforeAutotable: "DoBeforeAutotable",
                            onCellData: "DoCellData"
                        }
                    }
                }
            });
        } else{
            $('#ListmyTable').tableExport({
                fileName: "Attendance_"+schoolname+"_"+classname,
                type: 'pdf',
                jspdf: {
                    format: 'bestfit',
                    margins: {left: 20, right: 10, top: 20, bottom: 20},
                    autotable: {
                        styles: {overflow: 'linebreak'},
                        tableWidth: 'wrap',
                        tableExport: {
                            onBeforeAutotable: "DoBeforeAutotable",
                            onCellData: "DoCellData"
                        }
                    }
                }
            });
        }
    }
})