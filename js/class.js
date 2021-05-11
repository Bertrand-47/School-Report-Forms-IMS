$(document).ready( function () {

    //get params
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    let sessionID = getUrlParameter("session");
    let school_level = getUrlParameter("school_level");
    let status = $(".status").val();

    //ui show or hide depends on your permission
    if ($(".permission").val() =='Administrator' && status !== 'Terminate') {
        $(".form-box").show();
    }else{
        $(".form-box").hide();
        $(".panel-data").removeClass("col-sm-8");
        $(".panel-data").addClass("col-sm-12");
    }

    //hide form inputs
    $(".numbericnumber").val("");
    $(".submit").show;
    $(".updatebtn").hide();

    //get school levels
    function retrieveSchoolLevel() {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/sitemanagement.php',
            data: {school_level: school_level},
            success: function(data) {
                for (let i in data){
                    $(".school_level").append("<option value='"+data[i].id+"'>"+data[i].level+"</option>");
                }
            }
        });
    }

    //call method
    retrieveSchoolLevel();

    //get teacher
    function retrieveTeacherData() {
        if ($(".permission").val() == 'Administrator') {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/teacher.php',
                data: {all: true,schoolkey: $(".schoolkey").val(),school_level: school_level, sessionid: sessionID},
                success: function(data) {
                    for (let i in data){
                        $(".teacher").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                    if (data.length == 0){
                        $(".teacher").val("<option>No data available</option>");
                    }
                }
            });
        }else if ($('.classID').val() !== null || $('.classID').val() !== '') {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/teacher.php',
                data: {classID: $('.classID').val(),schoolkey: $(".schoolkey").val(),school_level: school_level, sessionid: sessionID},
                success: function(data) {
                    for (let i in data){
                        $(".teacher").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                    if (data.length > 0){
                        $(".teacher").val("<option>No data available</option>");
                    }
                }
            });
        }
    }

    retrieveTeacherData();

    $(".addclass").on("submit", function (e) {
        e.preventDefault();

        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');

        if ($(".schoolkey").val() === ''){
            alert("School key is required  required");
        }
        if ($(".school_level").val() === ''){
            $(".error-school_level").html("School level field is required");
            $(".form-group-school_level").addClass("has-error");
            $(".label-school_level").addClass("text-danger");
        }
        if ($(".numbericnumber").val() === ''){
            $(".error-numbericnumber").html("Numeric name should be required");
            $(".form-group-numbericnumber").addClass("has-error");
            $(".label-numbericnumber").addClass("text-danger");
        }
        if ($(".section").val() === ''){
            $(".error-section").html("Section should be required");
            $(".form-group-section").addClass("has-error");
            $(".label-section").addClass("text-danger");
        }

        if ($(".schoolkey").val() === '' || $(".school_level").val() === '' || $(".numbericnumber").val() === '' || $(".section").val() === '' ){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/class.php',
                data: {
                    schoolkey: $(".schoolkey").val(),
                    school_level: $(".school_level").val(),
                    numbericnumber: $(".numbericnumber").val(),
                    sessionid: $(".sessionid").val(),
                    section: $(".section").val(),
                    teacher: $(".teacher").val() =='Select teacher' ? '' : $(".teacher").val(),
                    school_level: school_level,
                    sessionid: sessionID
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

                        $(".classname").val("");
                        $(".numbericnumber").val("");

                        //retrieve teachers
                        retrieveData();

                    }else if (data.status == "exist") {
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").addClass("alert-warning");
                        $(".text-alert").html("Warning! Class data is already exist, please use different email");
                    }
                }
            });
        }
    });

    //get classes
    function retrieveData() {

        //admin
        if ($(".permission").val() == 'Administrator'){
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/class.php',
                data: {sessionid: $(".sessionid").val(), schoolkey: $(".schoolkey").val(),school_level: school_level, sessionid: sessionID},
                success: function(data) {

                    //make empty table to prevent the deplication
                    $("#myTable tbody").html("");

                    //empty
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data avalable</td></tr>");
                    }
                    else{
                        //loop all classes

                        for (let i in data){
                            let cname = ''
                            if ( data[i].level == 'Primary'){
                                cname +='P'+data[i].numbericname+data[i].section;
                            }else if ( data[i].level == 'Nursery'){
                                cname +='N'+data[i].numbericname+data[i].section;
                            }
                            let html = '';
                            html += "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].level+"</td><td>"+data[i].numbericname+"</td><td style='text-transform: uppercase;'>"+cname+"</span></td>";

                            //check if you are an admin to show you the delete button
                            if ($(".permission").val() === 'Administrator' && status !== 'Terminate'){
                                html += "<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='editclass' data-key='"+data[i].id+"'>Edit</a></li><li><a href=\"#\" class='deleteclass' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>";
                            } else{
                                html += "<td></td>";
                            }

                            html+= "</tr>";
                            $("#myTable tbody").append(html);
                        }
                    }
                    //edit teacher
                    $(".editclass").click(function (e) {
                        e.preventDefault();

                        editClass($(this).attr("data-key"))
                    });
                    $(".deleteclass").click(function (e) {
                        e.preventDefault();

                        deleteClass($(this).attr("data-key"))
                    });
                }
            });
        }

        //teacher
        else{
			$.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/class.php',
                data: {teacher_id: $(".teacher_id").val(), school_level: school_level, sessionid: sessionID},
                success: function(data) {

                    //make empty table to prevent the deplication
                    $("#myTable tbody").html("");

                    //empty
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='6' align='center'>No data avalable</td></tr>");
                    }
                    else{
                        //loop all classes

                        for (let i in data){
                            let cname = ''
                            if ( data[i].level == 'Primary'){
                                cname +='P'+data[i].numbericname+data[i].section;
                            }else if ( data[i].level == 'Nursery'){
                                cname +='N'+data[i].numbericname+data[i].section;
                            }
                            let html = '';
                            html += "<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].level+"</td><td>"+data[i].numbericname+"</td><td style='text-transform: uppercase;'>"+cname+"</span></td><td>-</td>";

                            //check if you are an admin to show you the delete button
                            if ($(".permission").val() === 'Administrator' && status !== 'Terminate'){
                                html += "<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='editclass' data-key='"+data[i].id+"'>Edit</a></li><li><a href=\"#\" class='deleteclass' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>";
                            } else{
                                html += "<td></td>";
                            }

                            html+= "</tr>";
                            $("#myTable tbody").append(html);
                        }
                    }
                    //edit teacher
                    $(".editclass").click(function (e) {
                        e.preventDefault();

                        editClass($(this).attr("data-key"))
                    });
                    $(".deleteclass").click(function (e) {
                        e.preventDefault();

                        deleteClass($(this).attr("data-key"))
                    });
                }
            });
		}
    }

    //call retrieve class method

    retrieveData();

    //edit
    function editClass(id){
        $(".numbericnumber").val("");
        $(".alert").css("display", "none");
        $(".submit").css("display", "none");
        $(".updatebtn").show();

        $(".updatebtn").attr("data-key", id);

        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/class.php?id='+id,
            data: {schoolkey: $(".schoolkey").val(), school_level: school_level},
            success: function(data) {
                if (data.length > 0) {

                    $(".numbericnumber").val(data[0].numbericname);
                    $(".section").val(data[0].section);

                    $(".teacher option").each(function(){
                        if ($(this).text() == data[0].name){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].teacher_id);
                        }
                    });

                    $(".school_level option").each(function(){
                        if ($(this).text() == data[0].level){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].school_level_id);
                        }
                    });
                }
            }
        });
    }

    //update
    $(".updatebtn").on("click", function (e) {
        e.preventDefault();
        $(".updatebtn").prop("disabled", true);
        $(".updatebtn").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');

        if ($(".schoolkey").val() === ''){
            alert("School key is required  required");
        }
        if ($(".school_level").val() === ''){
            $(".error-school_level").html("School level field is required");
            $(".form-group-school_level").addClass("has-error");
            $(".label-school_level").addClass("text-danger");
        }
        if ($(".numbericnumber").val() === ''){
            $(".error-numbericnumber").html("Numeric name should be required");
            $(".form-group-numbericnumber").addClass("has-error");
            $(".label-numbericnumber").addClass("text-danger");
        }
        if ($(".section").val() === ''){
            $(".error-section").html("Section should be required");
            $(".form-group-section").addClass("has-error");
            $(".label-section").addClass("text-danger");
        }

        if ($(".schoolkey").val() === '' || $(".school_level").val() === '' || $(".numbericnumber").val() === '' || $(".section").val() === '' ){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/class.php',
                data: {
                    schoolkey: $(".schoolkey").val(),
                    id: $(this).attr("data-key"),
                    isUpdate: true,
                    school_level: $(".school_level").val(),
                    numbericnumber: $(".numbericnumber").val(),
                    section: $(".section").val(),
                    teacher: $(".teacher").val(),
                    sessionid: $(".sessionid").val(),
                    school_level: school_level
                },
                success: function(data) {

                    $(".updatebtn").prop("disabled", false);
                    $(".updatebtn").html('Update');

                    $(".updatebtn").hide();
                    $(".submit").show();

                    if(data.status == "success"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been updated successfully");

                        //retrieve teachers
                        retrieveData();
                    }
                }
            });
        }
    });

    //delete
    function deleteClass(id) {
        if(confirm("Are you sure to delete this data")){
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/class.php',
                data: {
                    id: id,
                    isDelete: true,
                },
                success: function(data) {

                    if(data.status == "success"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been deleted successfully");

                        //retrieve teachers
                        retrieveData();
                    }
                }
            });
        }
    }

    function random_char() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    //export
    $(".exportexcel").click(function () {
        exportEXCEL($(".schoolname").val());
    });
    $(".exportpdf").click(function () {
        exportPDF($(".schoolname").val());
    });

    //export
    function exportEXCEL(schoolname) {
        $('#myTable').tableExport({
            fileName: "Classes_"+schoolname+"_"+random_char(),
            type: 'csv',
            ignoreColumn:[5],
            postCallback: function () {}
        });
    }

    function exportPDF(schoolname) {
        $('#myTable').tableExport({
            fileName: "Classes_"+schoolname+"_"+random_char(),
            type: 'pdf',
            ignoreColumn:[5],
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
} );