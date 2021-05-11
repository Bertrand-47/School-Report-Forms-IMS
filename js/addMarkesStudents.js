$(document).ready( function () {

    //get parameters from url

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

    //prepare params

    let schoolkey = getUrlParameter("schoolkey");
    let sessionID = getUrlParameter("sessionID");
    let classID = getUrlParameter("classID");
    let termID = getUrlParameter("termID");
    let school_level = getUrlParameter("school_level");
    let status = $(".status").val();

    //call basic functions

    getClass(getUrlParameter("classID"));

    getTerm(getUrlParameter("termID"))

    //tauchs ui a little bit

    $(".addcourse").on("submit", function (e) {
        e.preventDefault();

        $(".submit").prop("disabled", true);
        $(".submit").html('<i class="fa fa-spinner fa-spin"></i> &nbspPlease wait');
    });

    //get class id
    function getClass(id){
        //get all classes if you are admin
        if (id == '') {
            if($(".teacher_id").val() !== ""){
                $.ajax({
                    type: 'GET',
                    url: '/schoolreport/controllers/class.php?id=',
                    data: {teacher_id: $(".teacher_id").val(),sessionid: $(".sessionid").val(), school_level:school_level},
                    success: function(data) {
                        $(".viewStudentByClass").html("");
                        let cname = '';
                        for (var i = 0 ; i < data.length; i++) {
                            if (data[i].level == 'Primary') {
                                cname += 'P' + data[i].numbericname+data[i].section;
                                $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px; text-transform: uppercase" data-key='+data[i].id+' data-class="P'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> P'+ data[i].numbericname+data[i].section+'</button>');
                            } else if (data[i].level == 'Nursery') {
                                cname += 'N' + data[i].numbericname+data[i].section;
                                $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px; text-transform:uppercase" data-key='+data[i].id+' data-class="N'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> N'+ data[i].numbericname+data[i].section+'</button>');
                                $(".studentclass").html('N'+ data[i].numbericname+data[i].section);
                            }
                        }
    
                        $('.viewStudentByClass').find('button').click(function(e) {
    
                            e.preventDefault();

                            if(status === "Terminate"){
                                if($(this).attr("data-key") == ''){
                                    alert("Please choose a class to preview report");
                                }else{
                                    //preview multiple student
                                    if(school_level == 1){
                                        window.open("/schoolreport/generateReport.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                    }else if(school_level == 2){
                                      window.open("/schoolreport/generateReport_nursery.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                    }
                                }
                            }else{
                                $(".studentclass").html($(this).attr("data-class"));
    
                                //load data according to the class selected
                                getDataByClassId($(this).attr("data-key"));
        
                                return;
                            }
                        })
                    }
                });
            }else{
                $.ajax({
                    type: 'GET',
                    url: '/schoolreport/controllers/class.php?id=',
                    data: {sessionid: $(".sessionid").val(), schoolkey: $(".schoolkey").val(),school_level:school_level},
                    success: function(data) {
                        $(".viewStudentByClass").html("");
                        let cname = '';
                        for (var i = 0 ; i < data.length; i++) {
                            if (data[i].level == 'Primary') {
                                cname += 'P' + data[i].numbericname+data[i].section;
                                $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px; text-transform: uppercase" data-key='+data[i].id+' data-class="P'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> P'+ data[i].numbericname+data[i].section+'</button>');
                            } else if (data[i].level == 'Nursery') {
                                cname += 'N' + data[i].numbericname+data[i].section;
                                $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px; text-transform: uppercase" data-key='+data[i].id+' data-class="N'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> N'+ data[i].numbericname+data[i].section+'</button>');
                                $(".studentclass").html('N'+ data[i].numbericname+data[i].section);
                            }
                        }
    
                        $('.viewStudentByClass').find('button').click(function(e) {
    
                            e.preventDefault();
    
                            if(status === "Terminate"){
                                if($(this).attr("data-key") == ''){
                                    alert("Please choose a class to preview report");
                                }else{
                                    //preview multiple student
                                    if(school_level == 1){
                                        window.open("/schoolreport/generateReport.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                    }else if(school_level == 2){
                                      window.open("/schoolreport/generateReport_nursery.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                    }
                                }
                            }else{
                                $(".studentclass").html($(this).attr("data-class"));
    
                                //load data according to the class selected
                                getDataByClassId($(this).attr("data-key"));
        
                                return;
                            }
                        })
                    }
                });
            }
        }else if (id !== '') {
            $.ajax({
                type: 'GET',
                url: '/schoolreport/controllers/class.php?id='+id,
                data: {classID: id, schoolkey: $(".schoolkey").val(),school_level:school_level},
                success: function(data) {
                    $(".viewStudentByClass").html("");
                    let cname = '';
                    for (var i = 0 ; i < data.length; i++) {
                        if (data[i].level == 'Primary') {
                            cname += 'P' + data[i].numbericname+data[i].section;
                            $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px" data-key='+data[i].id+' data-class="P'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> P'+ data[i].numbericname+data[i].section+'</button>');
                            $(".studentclass").html('"P'+ data[i].numbericname+data[i].section+'"');
                        } else if (data[i].level == 'Nursery') {
                            cname += 'N' + data[i].numbericname+data[i].section;
                            $(".viewStudentByClass").append('<button type="button" class="btn btn-default" style="margin-right: 5px; text-transform: uppercase" data-key='+data[i].id+' data-class="N'+ data[i].numbericname+data[i].section+'"><i class="fa fa-chevron-right" aria-hidden="true"></i> N'+ data[i].numbericname+data[i].section+'</button>');
                            $(".studentclass").html('N'+ data[i].numbericname+data[i].section);
                        }
                    }

                    $('.viewStudentByClass').find('button').click(function(e) {

                        e.preventDefault();

                        if(status === "Terminate"){
                            if($(this).attr("data-key") == ''){
                                alert("Please choose a class to preview report");
                            }else{
                                //preview multiple student
                                if(school_level == 1){
                                    window.open("/schoolreport/generateReport.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                }else if(school_level == 2){
                                  window.open("/schoolreport/generateReport_nursery.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+$(this).attr("data-key")+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
                                }
                            }
                        }else{
                            $(".studentclass").html($(this).attr("data-class"));

                            //load data according to the class selected
                            getDataByClassId($(this).attr("data-key"));
    
                            return;
                        }
                    });
                }
            });
        }
    }

    //get term by id
    function getTerm(id) {
        $.ajax({
            type: 'GET',
            url: '/schoolreport/controllers/term.php?id='+id,
            data: {schoolkey: $(".schoolkey").val(),school_level:school_level,sessionID:sessionID},
            success: function(data) {
                if (data.length == 1){
                    $(".studentterm").text(data[0].term);
                }
            }
        });
    }

    //get class by id
    function getDataByClassId(id){
        if (id !== undefined) {
            window.location.href = "/schoolreport/AddMarkStudents.php?schoolkey="+schoolkey+"&sessionID="+sessionID+"&termID="+termID+"&classID="+id+"&school_level="+school_level;

            return;
        }
    }

    //table data to save into db

    $('#myTable tbody').find('tr td input').click(function() {
        var student_id = $(this).attr("data-student");

        $(this).closest("td table")
               .find("[class^='course_tr']").click(function(){

            //have id for every course row
            var index = $(this).attr("index");

            //get value for every input in row
            //cat
            let maxcat = $(this).find("td input.cat"+index).attr("max");

            let errorcat = $(this).find("span.errorcat"+index);
            $(this).find("td input.cat"+index).keyup(function () {
                if (parseFloat($(this).val()) > maxcat){
                    errorcat.text(" >>>CAT <= "+maxcat);
                    errorcat.css("color", "#F50")
                    // actionbtn.attr("disabled", true);
                    return;
                }else{
                    errorcat.text(">>>CAT= "+maxcat);
                    errorcat.css("color", "#777")
                    // actionbtn.attr("disabled", false);
                }
            });

            //exam
            let maxexam = $(this).find("td input.exam"+index).attr("max");
            let errorexam = $(this).find("span.errorexam"+index);
            $(this).find("td input.exam"+index).keyup(function () {
                if (parseFloat($(this).val()) > parseFloat(maxexam)){
                    errorexam.text(" >>>EXAM <= "+maxexam);
                    errorexam.css("color", "#F50")
                    // actionbtn.attr("disabled", true);
                    return;
                }else{
                    errorexam.text(">>>EXAM= "+maxexam);
                    errorexam.css("color", "#777")
                }
            });

            //SUBMIT CAT
            $(this).find("td input.cat"+index).blur(function () {
                if ($(this).val() !== ''){
                    var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td input').attr("disabled", true);
                    $(".alert-form-danger").show();
                    $(".alert-form-danger").removeClass("alert-danger");
                    $(".alert-form-danger").addClass("alert-info");
                    $(".text-alert").html("<i class='fa fa-spinner fa-spin'></i> Submitting, please hold on a second..");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {schoolkey: schoolkey, sessionID: sessionID, termID: termID, classID: classID,courseID: course_id,studentID: student_id, cat: $(this).val() == '' ? '' : parseFloat($(this).val())},
                        success: function(data) {
                            $('#myTable tbody').find('tr td input').attr("disabled", false);
                            $(".alert-form-danger").show();
                            $(".alert-form-danger").removeClass("alert-danger");
                            $(".alert-form-danger").addClass("alert-success");
                            $(".text-alert").text("CAT added success");
                        }
                    });
                }else{
					var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td input').attr("disabled", true);
                    $(".alert-form-danger").show();
                    $(".alert-form-danger").removeClass("alert-danger");
                    $(".alert-form-danger").addClass("alert-info");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {schoolkey: schoolkey, sessionID: sessionID, termID: termID, classID: classID,courseID: course_id,studentID: student_id, cat: ''},
                        success: function(data) {
                            $('#myTable tbody').find('tr td input').attr("disabled", false);
                            $(".alert-form-danger").show();
                            $(".alert-form-danger").removeClass("alert-danger");
                            $(".alert-form-danger").addClass("alert-success");
                            $(".text-alert").text("CAT added success");
                        }
                    });
				}
            });

            //SUBMIT EXAM
            $(this).find("td input.exam"+index).blur(function () {
                if ($(this).val() !== '') {
                    var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td input').attr("disabled", true);
                    $(".alert-form-danger").show();
                    $(".alert-form-danger").removeClass("alert-danger");
                    $(".alert-form-danger").addClass("alert-info");
                    $(".text-alert").html("<i class='fa fa-spinner fa-spin'></i> Submitting, please hold on a second..");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {
                            schoolkey: schoolkey,
                            sessionID: sessionID,
                            termID: termID,
                            classID: classID,
                            courseID: course_id,
                            studentID: student_id,
                            exam: $(this).val() == '' ? '' : parseFloat($(this).val())
                        },
                        success: function (data) {
                            $('#myTable tbody').find('tr td input').attr("disabled", false);
                            $(".alert-form-danger").show();
                            $(".alert-form-danger").removeClass("alert-danger");
                            $(".alert-form-danger").addClass("alert-success");
                            $(".text-alert").text("EXAM added success");
                        }
                    });
                }else{
					var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td input').attr("disabled", true);
                    $(".alert-form-danger").show();
                    $(".alert-form-danger").removeClass("alert-danger");
                    $(".alert-form-danger").addClass("alert-info");
                    $(".text-alert").html("<i class='fa fa-spinner fa-spin'></i> Submitting, please hold on a second..");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {
                            schoolkey: schoolkey,
                            sessionID: sessionID,
                            termID: termID,
                            classID: classID,
                            courseID: course_id,
                            studentID: student_id,
                            exam: ''
                        },
                        success: function (data) {
                            $('#myTable tbody').find('tr td input').attr("disabled", false);
                            $(".alert-form-danger").show();
                            $(".alert-form-danger").removeClass("alert-danger");
                            $(".alert-form-danger").addClass("alert-success");
                            $(".text-alert").text("EXAM added success");
                        }
                    });
				}
            });
        });
    });

    //nursery school
    $('#myTable tbody').find('tr td select').click(function() {
        var student_id = $(this).attr("data-student");

        $(this).closest("td table")
               .find("[class^='course_tr']").click(function(){

            //have id for every course row
            var index = $(this).attr("index");

            // quotation for nursery
            let quotation = $(this).find("td select.cotation"+index).attr("max");
            let errorcotation = $(this).find("span.errorcotation"+index);
            $(this).find("td select.cotation"+index).on("change", function (e) {
				e.preventDefault();
                if ($(this).val() == 'Select quotation'){
                    errorcotation.text("Please select quotation");
                    errorcotation.css("color", "#F50");
                    return;
                }else{
                    errorcotation.text("");
					var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td select').attr("disabled", true);
					$(".alert-form-danger").show();
					$(".alert-form-danger").removeClass("alert-danger");
					$(".alert-form-danger").addClass("alert-info");
					$(".text-alert").html("<i class='fa fa-spinner fa-spin'></i> Submitting, please hold on a second..");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {nursery: true,school_level: school_level,schoolkey: schoolkey, sessionID: sessionID, termID: termID, classID: classID,courseID: course_id,studentID: student_id, quotation: $(this).val()},
                        success: function(data) {
                            $('#myTable tbody').find('tr td select').attr("disabled", false);
							$('#myTable tbody').find('tr td input').attr("disabled", false);
							$(".alert-form-danger").show();
							$(".alert-form-danger").removeClass("alert-danger");
							$(".alert-form-danger").addClass("alert-success");
							$(".text-alert").text("Mark added success");
                        }
                    });
                }
            });

            //SUBMIT QUOTATION
            $(this).find("td select.cotation"+index).on("blur",function (e) {
				e.preventDefault();
                /*if ($(this).val() !== 'Select quotation') {
                    var course_id = $(this).attr("data-course");
                    $('#myTable tbody').find('tr td select').attr("disabled", true);
					$(".alert-form-danger").show();
					$(".alert-form-danger").removeClass("alert-danger");
					$(".alert-form-danger").addClass("alert-info");
					$(".text-alert").html("<i class='fa fa-spinner fa-spin'></i> Submitting, please hold on a second..");
                    $.ajax({
                        type: 'POST',
                        url: '/schoolreport/controllers/AddStudentMarks.php',
                        data: {nursery: true,school_level: school_level,schoolkey: schoolkey, sessionID: sessionID, termID: termID, classID: classID,courseID: course_id,studentID: student_id, quotation: $(this).val()},
                        success: function(data) {
                            $('#myTable tbody').find('tr td select').attr("disabled", false);
							$('#myTable tbody').find('tr td input').attr("disabled", false);
							$(".alert-form-danger").show();
							$(".alert-form-danger").removeClass("alert-danger");
							$(".alert-form-danger").addClass("alert-success");
							$(".text-alert").text("Mark added success");
                        }
                    });
                }else{
                    //reload page
                    window.location.reload();
                }*/
            });
        });
    });

    $(".viewResults").click(function () {
		if(classID == ''){
			alert("Please choose a class to preview report");
		}else{
			//preview multiple student
			if(school_level == 1){
				window.open("/schoolreport/generateReport.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+classID+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
			}else if(school_level == 2){
			  window.open("/schoolreport/generateReport_nursery.php?&schoolkey="+schoolkey+"&termID="+termID+"&classID="+classID+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
			}
		}
        //window.location.href = "/schoolreport/viewMarks.php?studentID="+studentID+"&schoolkey="+schoolkey+"&classID="+classID+"&termID="+termID+"&sessionID="+$(".sessionid").val()+"&multipleStudent="+true+"&school_level="+school_level;
    });

    $(".generate_sample_report").click(function () {
		if(classID == ''){
			alert("Please choose a class to preview report");
		}else{
			//preview multiple student
			if(school_level == 1){
				window.open("/schoolreport/generateReport.php?&schoolkey="+schoolkey+"&termID="+termID+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
			}else if(school_level == 2){
			  window.open("/schoolreport/generateReport_nursery.php?&schoolkey="+schoolkey+"&termID="+termID+"&sessionID="+$(".sessionid").val()+"&school_level="+school_level, '_blank');
			}
		}
    });
} );