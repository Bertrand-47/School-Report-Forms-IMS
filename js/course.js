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
	//$(".form-box").hide();

    //calculate %

    function percentage() {
        if ($(".p_parcentage").val() !== ''){
            var p_pacentage = parseInt($(".p_parcentage").val()) * 100 / 100 + "%";
            return p_pacentage
        }else{
            var p_pacentage =0;
            return p_pacentage;
        }
    }

    //handle ui
    $(".submit").show();

    $(".updatebtn").hide();

    $(".p_parcentage").keyup(function () {
        if (parseInt($(this).val()) > 100) {
            $(".error-p_parcentage").html("Passing percantage should not exceed 100%");
            $(".form-group-p_parcentage").addClass("has-error");
            $(".label-p_parcentage").addClass("text-danger");
        }else if (parseInt($(this).val()) < 100) {
            $(".form-group-p_parcentage").removeClass("has-error");
            $(".label-p_parcentage").removeClass("text-danger");
        }
    });

    $(".school_level").change(function(){

        //call method to retrieve the subjects
        retrieveSubjectsData();
    });

    //get teachers
    function retrieveTeacherData() {
        if ($(".permission").val() == 'Administrator') {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/teacher.php',
                data: {all: true,schoolkey: $(".schoolkey").val(),school_level: school_level, sessionid: sessionID},
                success: function(data) {
                    $(".teacher").html("<option>Select a teacher</option>");
                    for (let i in data){
                        $(".teacher").append("<option value='" + data[i].teacher_key + "'>" + data[i].name + "</option>");
                    }
                }
            });
        }
    }

    //get school levels
    function retrieveSchoolLevel() {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/sitemanagement.php',
            data: {school_level: school_level},
            success: function(data) {
                for (let i in data){
                    if(data[i].level == 'Nursery'){
                        $(".form-group-subjectname").hide();
                        $(".form-group-exam").hide();
                        $(".form-group-cat").hide();
                    }
                    $(".school_level").append("<option value='"+data[i].id+"' data-level='"+data[i].level+"'>"+data[i].level+"</option>");
                }
            }
        });
    }

    //call methods
    retrieveTeacherData();
    retrieveSchoolLevel();

    //get subjects
    function retrieveSubjectsData() {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/subject.php',
            data: {school_level: $(".school_level").val(), schoolkey: $(".schoolkey").val(), sessionid: $(".sessionid").val()},
            success: function(data) {

                for (let i in data){
                    $(".subjectname").append("<option style='text-transform: uppercase' value='" + data[i].id + "'>" + data[i].subjectname + "</option>");
                }
            }
        });
    }

    //add course
    $(".addcourse").on("submit", function (e) {
        e.preventDefault();

        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');
        if ($(".school_level").val() === '' || $(".classname").val() === 'Select level'){
            $(".error-school_level").html("School level field must be required");
            $(".form-group-school_level").addClass("has-error");
            $(".label-school_level").addClass("text-danger");
        }
        if ($(".coursename").val() === ''){
            $(".error-coursename").html("Course name should be required");
            $(".form-group-coursename").addClass("has-error");
            $(".label-coursename").addClass("text-danger");
        }
        if (school_level !=2 && $(".cat").val() === ''|| parseInt($(".cat").val()) == 0){
            $(".error-cat").html("MAX CAT should be required");
            $(".form-group-cat").addClass("has-error");
            $(".label-cat").addClass("text-danger");
        }
        if (school_level !=2 &&$(".exam").val() === '' || parseInt($(".exam").val()) == 0){
            $(".error-exam").html("MAX EXAM name should be required");
            $(".form-group-exam").addClass("has-error");
            $(".label-exam").addClass("text-danger");
        }

        if ($(".schoolkey").val() === '' || $(".coursename").val() === '' || $(".classname").val() === '' || $(".classname").val() === 'Select class'){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
            alert(this)

            return;
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/course.php',
                data: {
                    schoolkey: $(".schoolkey").val(),
                    subjectname: $(".subjectname").val(),
                    coursename: $(".coursename").val(),
                    cat: $(".cat").val(),
                    exam: $(".exam").val(),
                    school_level: $('.school_level').val(),
                    teacher: $(".teacher").val() !== 'Select a teacher' ? $(".teacher").val() : null,
                    sessionid: $(".sessionid").val(),
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

                        $(".subjectname").val("");
                        $(".coursename").val("");
                        $(".cat").val(0);
                        $(".exam").val(0);
                        $(".p_parcentage").val(0);
                        // $(".classname").html("<option selected>Select class</option>");
                        $(".school_level").prop("selectedIndex", 0);

                        retrieveSubjectsData();

                        //retrieve teachers
                        retrieveData();

                    }else if (data.status == "exist") {
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").addClass("alert-warning");
                        $(".text-alert").html("Warning! Data is already exist, please make sure it is unique class, section, and teacher");
                    }
                }
            });
        }
    });

    //retrieve

    function retrieveData() {
        //admin
        if ($(".permission").val() === "Administrator"){
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/course.php',
                data: {all: true, sessionid: $(".sessionid").val(),school_level: school_level},
                success: function(data) {

                    //empty table
                    $("#myTable tbody").html("");

                    //check data
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='10' align='center'>Not data is available</td></tr>");
                    }
                    for (let i in data){
                        let html = '';
                        html+="<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].level+"</td>";
                        if (data[i].subjectname !== null) {
                            html+="<td>"+data[i].subjectname+"</td>";
                        }else {
                            html+="<td>-</td>";
                        }
                        html+="<td>"+data[i].coursename+"</td>";

                        if (school_level != 2 && data[i].maxcat !== undefined) {
                            html+="<td>"+data[i].maxcat+"</td>";
                        }

                        if (school_level != 2 && data[i].maxexam !== undefined) {
                            html+="<td>"+data[i].maxexam+"</td>";
                        }

                        if ($(".permission").val() === 'Administrator' && status !== 'Terminate'){
                            html+="<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='edit' data-key='"+data[i].id+"'>Edit</a></li><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>"
                        }else{
                            html+="<td></td>";
                        }
                        html+="</tr>";
                        $("#myTable tbody").append(html);
                    }

                    //edit
                    $(".edit").click(function (e) {
                        e.preventDefault();

                        editData($(this).attr("data-key"))
                    });
                    $(".delete").click(function (e) {
                        e.preventDefault();

                        deleteData($(this).attr("data-key"))
                    });
                }
            });
        }else{
            //by teacher id
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/course.php',
                data: {teacher_key: $(".teacher_key").val(),email: $(".email").val(),sessionid: $(".sessionid").val(),schoolkey: $(".school_level").val(),school_level: school_level},
                success: function(data) {
                    //empty table
                    $("#myTable tbody").html("");

                    //check data
                    if (data.length == 0){
                        $("#myTable tbody").html("<tr><td colspan='10' align='center'>Not data is available</td></tr>");
                    }
                    for (let i in data){
                        let html = '';
                        html+="<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].level+"</td>";
                        if (data[i].subjectname !== null) {
                            html+="<td>"+data[i].subjectname+"</td>";
                        }else {
                            html+="<td>-</td>";
                        }
                        html+="<td>"+data[i].coursename+"</td>";

                        if (data[i].maxcat !== undefined) {
                            html+="<td>"+data[i].maxcat+"</td>";
                        }else {
                            html+="<td>-</td>";
                        }

                        if (data[i].maxexam !== undefined) {
                            html+="<td>"+data[i].maxexam+"</td>";
                        }else {
                            html+="<td>-</td>";
                        }

                        if ($(".permission").val() === 'Administrator' && status !== 'Terminate'){
                            html+="<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='edit' data-key='"+data[i].id+"'>Edit</a></li><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>"
                        }else{
                            html+="<td></td>";
                        }
                        html+="</tr>";
                        $("#myTable tbody").append(html);
                    }

                    //edit
                    $(".edit").click(function (e) {
                        e.preventDefault();

                        editData($(this).attr("data-key"))
                    });
                    $(".delete").click(function (e) {
                        e.preventDefault();

                        deleteData($(this).attr("data-key"))
                    });
                }
            });
        }
    }

    retrieveData();

    //edit
    function editData(id){
        $(".coursename").val();
        $(".school_level").html('<option>Select level</option>');
        $(".cat").val(0);
        $(".exam").val(0);
        $(".alert").css("display", "none");
        $(".submit").hide();
        $(".updatebtn").show();
		$(".form-box").show();
		$(".panel-data").removeClass("col-sm-12");
        $(".panel-data").addClass("col-sm-8");
        $(".subjectname").html("<option>Select a subject</option>");

        //apend id to update btn
        $(".updatebtn").attr("data-key", id);

        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/course.php?id='+id,
            data:{school_level:school_level},
            success: function(data) {
				
                if (data.length > 0){
                    $(".school_level").html("<option selected value='"+data[0].school_level_id+"'>"+data[0].level+"</option>");
                    $(".updatebtn").attr("disabled", false);
					
                    $(".coursename").val(data[0].coursename);
                    $(".cat").val(data[0].maxcat);
                    $(".exam").val(data[0].maxexam);

                    
                    retrieveSubjectsData();
                    $(".subjectname").append("<option selected value="+data[0].sub_id+">"+data[0].subjectname+"</option>");


                    $(".school_level option").each(function(){
                        if ($(this).text() == data[0].level){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].school_level_id);
                        }
                    });

                    $(".subjectname option").each(function(){
                        if ($(this).val() == data[0].subjectname.toUpperCase()){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].sub_id);
                        }
                    });
                }
            }
        });
    }

    $(".teacher").change(function () {
        $(".updatebtn").attr("disabled", false);
    })

    //update

    $(".updatebtn").on("click", function (e) {
        e.preventDefault();
        $(".updatebtn").prop("disabled", true);
        $(".updatebtn").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');

        if ($(".schoolkey").val() === ''){
            alert("School key is required");
        }
        if (school_level ==1 && $(".subjectname").val() === '' || $(".subjectname").val() === 'Select subject'){
			$(".error-subjectname").html("Subject name should be required");
			$(".form-group-subjectname").addClass("has-error");
			$(".label-subjectname").addClass("text-danger");
        }
        if ($(".school_level").val() === '' || $(".school_level").val() === null){
            $(".error-school_level").html("School level field must be required");
            $(".form-group-school_level").addClass("has-error");
            $(".label-school_level").addClass("text-danger");
        }
        if ($(".coursename").val() === ''){
            $(".error-coursename").html("Course name should be required");
            $(".form-group-coursename").addClass("has-error");
            $(".label-coursename").addClass("text-danger");
        }
        if (school_level !=2 && $(".cat").val() === ''|| parseInt($(".cat").val()) == 0){
            $(".error-cat").html("MAX CAT should be required");
            $(".form-group-cat").addClass("has-error");
            $(".label-cat").addClass("text-danger");
        }
        if (school_level !=2 &&$(".exam").val() === '' || parseInt($(".exam").val()) == 0){
            $(".error-exam").html("MAX EXAM name should be required");
            $(".form-group-exam").addClass("has-error");
            $(".label-exam").addClass("text-danger");
        }

        if ($(".schoolkey").val() === '' || $(".coursename").val() === ''){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/course.php',
                data: {
                    id: $(this).attr("data-key"),
                    isUpdate: true,
                    schoolkey: $(".schoolkey").val(),
                    subjectname: $(".subjectname").val(),
                    coursename: $(".coursename").val(),
                    cat: $(".cat").val(),
                    exam: $(".exam").val(),
                    p_percentage: percentage(),
                    school_level: school_level,
                   // classname: $(".classname").val(),
                    teacher: $(".teacher").val() == 'Select a teacher' ? '' : $(".teacher").val(),
                    sessionid: $(".sessionid").val(),
                },
                success: function(data) {

                    $(".updatebtn").prop("disabled", false);
                    $(".updatebtn").html('Update');

                    if(data.status == "success"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data has been updated successfully");

                        $(".subjectname").val("");
                        $(".coursename").val("");
                        $(".cat").val(0);
                        $(".exam").val(0);
                        $(".p_parcentage").val(0);

                        $(".submit").show();
                        $(".updatebtn").hide();

                        //call functions
                        retrieveSubjectsData();
                        retrieveTeacherData();

                        //retrieve teachers
                        retrieveData();
                    }else if(data.status == "exist"){
                        $(".alert-form-danger").css("display","block");
                        $(".alert-form-danger").removeClass("alert-warning");
                        $(".alert-form-danger").removeClass("alert-danger");
                        $(".alert-form-danger").addClass("alert-success");
                        $(".text-alert").html("Well! Data is already exist, please make sure it is unique class, section, and teacher");
                    }
                }
            });
        }
    });

    function deleteData(id) {
        if(confirm("Are you sure to delete this data")){
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/course.php',
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
    $(".exportexcel").click(function () {
        exportEXCEL();
    });
    $(".exportpdf").click(function () {
        exportPDF();
    });

    //export
    function exportEXCEL() {
        $('#myTable').tableExport({
            fileName: "Courses_"+random_char(),
            type: 'csv',
            ignoreColumn:[8],
            postCallback: function () {}
        });
    }

    function exportPDF() {
        $('#myTable').tableExport({
            fileName: "Courses_"+random_char(),
            type: 'pdf',
            ignoreColumn:[8],
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
