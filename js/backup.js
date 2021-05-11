$(document).ready(function(){

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


    //show / hide menus
    if (getUrlParameter('session') !== undefined){
        $(".permitted_menus").css("display", "block");
        $(".unpermitted_menus").css("display", "none");
    }else{
        $(".permitted_menus").css("display", "none");
        $(".unpermitted_menus").css("display", "block");
    }

	let school_level = getUrlParameter("school_level");
	
	//backup
    $(".backup").click(function(e){
        e.preventDefault();

        $(this).html("PLEASE WAIT...");

        if (getUrlParameter("session") !== undefined) {
        	if (confirm("You are going to backup session's data, press OKAY to continue")) {
        		$.ajax({
		            type: 'POST',
					url: '/schoolreport/controllers/backup.php',
					//start working from here 
		            data: {all: true,schoolkey: $(".schoolkey").val(), school_level: school_level},
		            success: function (data) {
		            	$(".backup").html("BACKUP");
		            	alert("Backup of datas is successful");
		                fillTableBackup();
		            }
	        	});
        	}
        }
        // backup all database
        else{
        	if (confirm("You are going to backup the whole data from database, press OKAY to continue")) {
				$.ajax({
		            type: 'POST',
		            url: '/schoolreport/controllers/backup.php',
		            data: {all: true,schoolkey: $(".schoolkey").val()},
		            success: function (data) {
		            	$(".backup").html("BACKUP");
		            	alert("Backup of datas is successful")
		                fillTableBackup();
		            }
	        	});
			}
        }
    });

    $("#myTable tbody").html("<tr><td>No buckup available at this moment</td></tr>");

    function fillTableBackup(){
    	if (getUrlParameter("session") !== undefined) {
        	$.ajax({
	            type: 'GET',
	            url: '/schoolreport/controllers/backup.php',
	            data: {all: true,schoolkey: $(".schoolkey").val()},
	            success: function (data) {
	                $("#myTable tbody").html("");
	                if (data.length == 0) {
	                	$("#myTable tbody").html("<tr><td colspan=5 align='center'>No backup available at this moment</td></tr>");
	                }else{
	                	for (var i in data) {
	                		$("#myTable tbody").append("<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].filename+"</td><td><a href='"+data[i].file_url+"' target='_blank'>View</a></td><td>"+data[i].date_created+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='restoreDB' data-key='"+data[i].id+"'>Restore</a></li><li><a href=\"#\" class='deleteDB' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>");
	                	}

	                	//edit teacher
	                    $(".restoreDB").click(function (e) {
	                        e.preventDefault();

	                        restoreDB($(this).attr("data-key"));
	                    });
	                    $(".deleteDB").click(function (e) {
	                        e.preventDefault();

	                        deleteDB($(this).attr("data-key"));
	                    });
	                }
	            }
        	});
        }
        // backup all database
        else{
			$.ajax({
	            type: 'GET',
	            url: '/schoolreport/controllers/backup.php',
	            data: {all: true, schoolkey: $(".schoolkey").val()},
	            success: function (data) {
	                $("#myTable tbody").html("");
	                if (data.length == 0) {
	                	$("#myTable tbody").html("<tr><td colspan='5' align='center'>No backup available at this moment</td></tr>");
	                }else{
	                	for (var i in data) {
	                		$("#myTable tbody").append("<tr><td>"+(Number(i)+1)+"</td><td>"+data[i].filename+"</td><td><a href='"+data[i].file_url+"' target='_blank'>View</a></td><td>"+data[i].date_created+"</td><td><div class=\"btn-group\"><button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Action <span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"#\" class='restoreDB' data-key='"+data[i].id+"'>Restore</a></li><li><a href=\"#\" class='deleteDB' data-key='"+data[i].id+"'>Delete</a></li></ul></div></td></tr>");
	                	}

	                	//edit teacher
	                    $(".restoreDB").click(function (e) {
	                        e.preventDefault();

	                        restoreDB($(this).attr("data-key"));
	                    });
	                    $(".deleteDB").click(function (e) {
	                        e.preventDefault();

	                        deleteDB($(this).attr("data-key"));
	                    });
	                }
	            }
        	});
        }
    }

    fillTableBackup();

    //delete
    function deleteDB(id){
    	if (confirm("Are you sure to delete this backup")) {
    		$.ajax({
	            type: 'POST',
	            url: '/schoolreport/controllers/backup.php',
	            data: {id: id, isDelete: true},
	            success: function (data) {
	                alert("Deleted successful")
	            }
	    	});
    	}
    }

    //restore
    function restoreDB(id){
    	if (getUrlParameter("session") !== undefined) {
			if (confirm("This action will overwrite tables and datas on in session you have selected, Do you want to continue?")) {
	    		$.ajax({
		            type: 'POST',
		            url: '/schoolreport/controllers/backup.php',
		            data: {r_id: id, isRestore: true, isSessionExist: true,sessionID: getUrlParameter("session")},
		            success: function (data) {
		                
		               alert("Your databse is successful restored");

		               window.location.reload();
		               window.location.href ='/schoolreport/logout.php';
		            }
		    	});
	    	}
    	}else{
    		if (confirm("This action will overwrite tables and datas you have already in the database, Do you want to continue?")) {
	    		$.ajax({
		            type: 'POST',
		            url: '/schoolreport/controllers/backup.php',
		            data: {r_id: id, isRestore: true, _all: true},
		            success: function (data) {
		                
		               alert("Your databse is successful restored");

		               window.location.reload();
		               window.location.href ='/schoolreport/logout.php';
		            }
		    	});
	    	}
    	}
    }
})