$(document).ready( function () {

    //ui show or hide depends on your permission
    if ($(".permission").val() =='Administrator') {
        $(".form-box").show()
    }else{
        $(".form-box").hide()
    }

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

    //set random key
    function random_char() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 8; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    //get schools
    function retrieveSchoolData() {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/sitemanagement.php',
            data: {schoolkey: $(".schoolkey").val()},
            success: function(data) {
                if (data.length == 0) {
                    $(".school_list").html("<tr><td colspan='9' align='center'>No data available</td></tr>");
                }

                else if (data.length == 1){
                    $(".school_list").html("<option value='"+data[0].id+"'>"+data[0].schoolname+"</option>")
                } else{
                    for (let i in data){
                        $(".school_list").append("<option value='"+data[i].id+"'>"+data[i].schoolname+"</option>")
                    }
                }
            }
        });
    }

    retrieveSchoolData();

    //get school levels
    function retrieveSchoolLevel() {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/sitemanagement.php',
            data: {school_level: school_level},
            success: function(data) {
                $(".school_level").html("");
                for (let i in data){
                    $(".school_level").append("<option value='"+data[i].id+"'>"+data[i].level+"</option>");
                }
            }
        });
    }

    retrieveSchoolLevel();

    //get classes
    // function retrieveClassData() {

    //     $.ajax({
    //         type: 'GET',
    //         url: '/schoolreport/controllers/class.php',
    //         data: {sessionid: $(".sessionid").val(), schoolkey: $(".schoolkey").val(), school_level: school_level},
    //         success: function(data) {
    //             for (let i in data){
    //                 let cname = ''
    //                 if ( data[i].level == 'Primary'){
    //                     if (data[i].section == null){
    //                         cname +='P'+data[i].numbericname;
    //                     } else{
    //                         cname +='P'+data[i].numbericname+data[i].section;
    //                     }
    //                 }else if ( data[i].level == 'Nursery'){
    //                     if (data[i].section == null){
    //                         cname +='N'+data[i].numbericname;
    //                     }else{
    //                         cname +='N'+data[i].numbericname+data[i].section;
    //                     }
    //                 }
    //                 $(".classname").append("<option value='"+data[i].id+"'>"+cname+"</option>")
    //             }
    //         }
    //     });
    // }

    //on change permission
    // $(".permission_selected").change(function () {
    //     if ($(this).val() =='Teacher'){

    //         //show ui on teacher for more info
    //         $(".classnamebx").css("display","block");
    //         $(".school_levelbx").css("display","block");

    //         //retrieve classes
    //         retrieveClassData();
    //     }
    // });

    //hide form inputs
    $(".password").val("demo");
    $(".names").val("");
    $(".email").val("");
    $(".submit").show;
    $(".updatebtn").hide();

    //save

    $(".savedata").on("submit", function (e) {
        e.preventDefault();

        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');

        if ($(".schoolkey").val() === ''){
            alert("Schook key is required");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".password").val() === ''){
            $(".error-schoolkey").html("Password field is required");
            $(".form-group-password").addClass("has-error");
            $(".label-password").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".names").val() === ''){
            $(".error-names").html("Account name field is required");
            $(".form-group-names").addClass("has-error");
            $(".label-names").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }
        if ($(".email").val() === ''){
            $(".error-email").html("Email address / Phone number field is required");
            $(".form-group-email").addClass("has-error");
            $(".label-email").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".permission_selected").val() === ''|| $(".permission_selected").val() === 'Select permission level'){
            $(".error-email").html("Permission field is required");
            $(".form-group-email").addClass("has-error");
            $(".label-email").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }

        if ($(".school_list").val() === ''|| $(".school_list").val() === 'Select a school'){
            $(".error-email").html("School field is required");
            $(".form-group-school_list").addClass("has-error");
            $(".label-school_list").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }

        if ($(".permission_selected").val() === ''){
            $(".error-permission").html("Permission field is required");
            $(".form-group-permission").addClass("has-error");
            $(".label-permission").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }
        if ($(".schoolkey").val() === '' && $(".names").val() === '' && $(".password").val() === '' && $(".email").val() === '' && $(".permission").val() === '' && $(".school_list").val() === 'Select a school'){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/account.php',
                data: {
                    names: $(".names").val(),
                    password: $(".password").val(),
                    email: $(".email_form").val(),
                    permission: $(".permission_selected").val(),
                    //classname: $(".classname").val(),
                    schoolkey: $(".school_list").val(),
                    school_level: school_level,
                    sessionid: sessionID,
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
                        retrieveData();

                        $(".names").val("");
                        $(".email_form").val("");
                        $(".permission_selected").val("Select permission level");
                        $(".password").val(random_char());

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

    //retrieve accounts
    function retrieveData() {

        //for admin
        if ($(".permission").val() == 'Administrator'){
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/account.php',
                data: {r_t: true, schoolkey:$(".schoolkey").val(), school_level: school_level},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0) {
                        $("#myTable tbody").html("<tr><td colspan='9' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        // let cname = ''
                        // if ( data[i].level == 'Primary'){
                        //     cname +='P'+data[i].numbericname+data[i].section;
                        // }else if ( data[i].level == 'Nursery'){
                        //     cname +='N'+data[i].numbericname+data[i].section;
                        // }
                        let html = "";

                        html +="<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].schoolname+"</td><td>"+data[i].names+"</td><td>"+data[i].email+"</td><td>"+data[i].permission+"</td>";

                        //check admin
                        if ($(".permission").val() === 'Administrator'){
                            html += "<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='edit' data-key='"+data[i].id+"' data-teacher_prev_email='"+data[i].email+"'>Edit</a></li><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>";
                        } else{
                            html += "<td></td></tr>";
                        }
                        $("#myTable tbody").append(html);
                    }
                    //edit
                    $(".edit").click(function (e) {
                        e.preventDefault();

                        editData($(this).attr("data-key"), $(this).attr("data-teacher_prev_email"))
                    });

                    //delete
                    $(".delete").click(function (e) {
                        e.preventDefault();

                        deleteData($(this).attr("data-key"))
                    });
                }
            });
        }

        //for teachers
        else{
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/account.php',
                data: {teacher: true, schoolkey:$(".schoolkey").val(),user_key:$(".user_key").val(), school_level: school_level},
                success: function(data) {
                    $("#myTable tbody").html("");
                    if (data.length == 0) {
                        $("#myTable tbody").html("<tr><td colspan='9' align='center'>No data available</td></tr>");
                    }
                    for (let i in data){
                        let html = "";

                        html +="<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].schoolname+"</td><td>"+data[i].names+"</td><td>"+data[i].email+"</td><td>"+data[i].permission+"</td>";

                        //check admin
                        if ($(".user_key").val() === data[i].id){
                            html += "<td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='edit' data-key='"+data[i].id+"' data-teacher_prev_email='"+data[i].email+"'>Edit</a></li><li><a href=\"#\" class='delete' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td>";
                        } else{
                            html += "<td></td></tr>";
                        }
                        $("#myTable tbody").append(html);
                    }

                    //edit
                    $(".edit").click(function (e) {
                        e.preventDefault();

                        editData($(this).attr("data-key"), $(this).attr("data-teacher_prev_email"))
                    });

                    //delete
                    $(".delete").click(function (e) {
                        e.preventDefault();

                        deleteData($(this).attr("data-key"))
                    });
                }
            });
        }
    }

    //call method to retrieve
    retrieveData();

    //edit
    function editData(id, teacher_prev_email){
        $(".names").val("");
        $(".password").val(random_char());
        $(".alert").css("display", "none");
        $(".submit").css("display", "none");
        $(".updatebtn").show();
        $(".form-box").show();

        $(".updatebtn").attr("data-key", id);
        $(".updatebtn").attr("data-teacher_prev_email", teacher_prev_email);
        // $(".email").val("");

        //retrieve classes again
        //retrieveClassData();

        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/account.php?id='+id,
            data: {schoolkey:$(".schoolkey").val()},
            success: function(data) {

                //empty selection to prevent the duplicate
                $(".permission_selected").val("");
                //check if returns data
                if (data.length == 1){
                    $(".names").val(data[0].names);
                    if (data[0].default_password == 0){
                        $(".password").attr('placeholder', 'Change your password');
                        $(".password").removeAttr("disabled");

                        $(".password").val("")

                        $(".error-password").html("Please change your password to secure your account");
                        $(".form-group-password").addClass("has-error");
                        $(".label-password").addClass("text-danger");
                    }else{
                        $(".password").val("");
                        $(".password").removeAttr("disabled")
                    }
                    $(".email_form").val(data[0].email);

                    //fill permission selected
                    $(".permission_selected option").each(function(){
                        if ($(this).text() == data[0].permission){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].permission);
                        }
                    });

                    //fill class selected
                    // $(".classname option").each(function(){

                    //     //prepare class name
                    //     let cname = ''
                    //     if ( data[0].level == 'Primary'){
                    //         if (data[0].section == null){
                    //             cname +='P'+data[0].numbericname;
                    //         } else{
                    //             cname +='P'+data[0].numbericname+data[0].section;
                    //         }
                    //     }else if ( data[0].level == 'Nursery'){
                    //         if (data[0].section == null){
                    //             cname +='N'+data[0].numbericname;
                    //         }else{
                    //             cname +='N'+data[0].numbericname+data[0].section;
                    //         }
                    //     }

                    //     if ($(this).text() == cname){
                    //         $(this).attr("selected",true);
                    //         $(this).attr("value",data[0].classID);
                    //     }
                    // });

                    //fill school level selected
                    $(".school_level option").each(function(){
                        if ($(this).text() == data[0].level){
                            $(this).attr("selected",true);
                            $(this).attr("value",data[0].school_level_id);
                        }
                    });

                    //show those hidden fields

                    if (data[0].permission == 'Teacher'){
                        //show ui on teacher for more info
                        $(".classnamebx").css("display","block");
                        $(".school_levelbx").css("display","block");
                    }
                }else{
                    alert("There is not account founds");
                }
            }
        });
    }

    //update
    $(".updatebtn").on("click", function () {
        $(".updatebtn").prop("disabled", true);
        $(".updatebtn").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');

        if ($(".schoolkey").val() === ''){
            alert("Schook key is required");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".password").val() === ''){
            $(".error-schoolkey").html("Password field is required");
            $(".form-group-password").addClass("has-error");
            $(".label-password").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".names").val() === ''){
            $(".error-names").html("Account name field is required");
            $(".form-group-names").addClass("has-error");
            $(".label-names").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }
        if ($(".email_form").val() === ''){
            $(".error-email").html("Email address / Phone number field is required");
            $(".form-group-email").addClass("has-error");
            $(".label-email").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }
        if ($(".permission_selected").val() === ''|| $(".permission_selected").val() === 'Select permission level'){
            $(".error-email").html("Permission field is required");
            $(".form-group-email").addClass("has-error");
            $(".label-email").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }

        if ($(".school_list").val() === ''|| $(".school_list").val() === 'Select a school'){
            $(".error-email").html("School field is required");
            $(".form-group-school_list").addClass("has-error");
            $(".label-school_list").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');
        }

        if ($(".permission_selected").val() === ''){
            $(".error-permission").html("Permission field is required");
            $(".form-group-permission").addClass("has-error");
            $(".label-permission").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }
        if ($(".permission_selected").val() === 'Teacher'&& $(".classname").val() === 'Select class'){
            $(".error-classname").html("Class field is required");
            $(".form-group-classname").addClass("has-error");
            $(".label-classname").addClass("text-danger");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }

        if ($(".schoolkey").val() === '' && $(".names").val() === '' && $(".password").val() === '' && $(".email_form").val() === '' && $(".permission").val() === '' && $(".school_list").val() === 'Select a school'){
            $(".alert-form-danger").css("display","block");
            $(".submit").prop("disabled", false);
            $(".submit").html('Submit');

            return;
        }else{
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/account.php',
                data: {
                    id: $(this).attr("data-key"),
                    teacher_email: $(this).attr("data-teacher_prev_email"),
                    isUpdate: true,
                    names: $(".names").val(),
                    password: $(".password").val(),
                    email: $(".email_form").val(),
                    permission: $(".permission_selected").val(),
                    //classname: $(".classname").val(),
                    schoolkey: $(".school_list").val(),
                    school_level: $(".school_level").val(),
					sessionid: sessionID
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

                        //retrieve teachers
                        retrieveData();

                        $(".error-password").html("");
                        $(".form-group-password").removeClass("has-error");
                        $(".label-password").removeClass("text-danger");
                    }
                }
            });
        }
    });

    function deleteData(id) {
        if(confirm("Are you sure to delete this data")){
            $.ajax({
                type: 'POST',
                url: '/schoolreport/controllers/account.php',
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

    $(".exportexcel").click(function () {
        exportEXCEL();
    });
    $(".exportpdf").click(function () {
        exportPDF();
    });

    //export
    function exportEXCEL() {
        $('#myTable').tableExport({
            fileName: "Accounts_"+random_char(),
            type: 'csv',
            ignoreColumn:[8],
            postCallback: function () {}
        });
    }

    function exportPDF() {
        $('#myTable').tableExport({
            fileName: "Accounts_"+random_char(),
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