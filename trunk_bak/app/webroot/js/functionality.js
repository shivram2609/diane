$(document).ready(function(){
	
	var module = '';
	var lecture = '';
	var quiz = '';
	var type = '';
	var typeswap = '';
	var courseidajax = '';
	
	
	
	$("#CoursePromovideo").live("change",function(){
		$(".filename").html($(this).val());
	});
	
	$("#Free,#Paid,#Paids").live("click",function(){
		$("#CoursePricetype").val($(this).attr("id"));
	});
	
	$("#Paids").live("click",function(){
		$("#CoursePrice").attr("disabled",true);
		$("#savePrice").attr("disabled",true);
	});
	
	$("#Free").live("click",function(){
		$("#savePrice").removeAttr("disabled");
	});
	
	$(".addpaypal").live("click",function(){
		$("#UserdetailPaypalaccount").removeAttr("disabled");
		$("#tabs").slideUp("slow");
		$("#paypal").slideDown("slow");
	});
	
	$("#cancelpaypal").live("click",function(){
		$("#UserdetailPaypalaccount").attr("disabled",true);
		$("#tabs").slideDown("slow");
		$("#paypal").slideUp("slow");
	});
	
	$(".remov-logo").click(function(){
		if (confirm("Do you really want to remove lincense?")) {
			url = BASE_URL+"courses/removelogo/"+$(this).attr("id");
			location.href = url;
		}
	});
	
	$(".importyoutube").live("click",function(e){
		$(".manualfile").slideUp("slow");
		$("#CoursePromovideo").attr("disabled",true);
		$(".youtubefile").slideDown("slow");
		$("#CoursePromovideo1").removeAttr("disabled");
	});
	
	$("#cancleyoutube").live("click",function(e){
		$(".youtubefile").slideUp("slow");
		$("#CoursePromovideo1").attr("disabled",true);
		$(".manualfile").slideDown("slow");
		$("#CoursePromovideo").removeAttr("disabled");
	});
	
	/***** code to add new functionality to edit curriculum :( ******/
	/*code to add new lecture in a module*/
	$(".add_new_sec_lec").live("click",function(e){
		var moduleid = $(this).attr("id").split("_");
		$(this).attr("disabled",true);
		moduleid = moduleid[3];
		$(".msg"+moduleid).show();
		$.ajax({
			url: BASE_URL+"courses/addlecture",
			type: 'post',
			data  : "courseid="+$("#CourseId").val()+"&sectionid="+moduleid+"&heading=A New Lesson", 
			success: function(data) {
				refreshcurriculum();
			},
			error : function(err, req) {
				$(this).removeAttr("disabled");
				$(".msg"+moduleid).hide();
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	/*code to add new lecture in a module end here*/
	
	/*code to add new Module in a Course*/
	$(".add_new_module").live("click",function(e){
		$(".add_new_mod").show();
		$(this).attr("disabled",true);
		$.ajax({
			url: BASE_URL+"courses/addsection",
			type: 'post',
			data  : "id="+$("#CourseId").val()+"&heading=A new module", 
			success: function(data) {
				$(".add_new_mod").hide();
				refreshcurriculum();
			},
			error : function(err, req) {
				$(this).removeAttr("disabled");
				$(".add_new_mod").hide();
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	/*code to add new module in a course end here*/
	
	$(".delquiz").live("click",function(e){
			var lecid = $(this).attr("id").split("_");
			if(confirm("Do you really want to delete this Quiz: "+$(this).attr("val"))) {
				$.ajax({
					url: BASE_URL+"courses/deletequiz",
					type: 'post',
					data  : "quizid="+lecid[1], 
					success: function(data) {
						if(parseInt(data) == 1) {
							refreshcurriculum();
						} else {
							$(".succ"+lecid[1]).html("Quiz can not be deleted.");
							$(".succ"+lecid[1]).addClass("err"+lecid[1]);
						}
						setInterval('$(".succ'+lecid[1]+'").hide();',2000);
					},
					error : function(err, req) {
						alert("Your browser broke!");
					}
				});
			} 
			e.stopImmediatePropagation();
		});
	
	
	/*code to add new Module in a Course*/
	$(".add_new_sec_quiz").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$(this).attr("disabled",true);
		$(".msg"+id[3]).show();
		$.ajax({
			url: BASE_URL+"courses/addquiz",
			type: 'post',
			data  : "sectionid="+id[3]+"&lectureid="+id[4]+"&heading=A new Quiz", 
			success: function(data) {
				refreshcurriculum();
			},
			error : function(err, req) {
				$(this).removeAttr("disabled");
				$(".msg"+id[3]).hide();
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	/*code to add new module in a course end here*/
	
	$(".sel_lect").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$(".syllabus-rt").hide();
		$(".P,.V,.D,.T,.M,.A").hide();
		if($(".addnew_cont_row_"+id[2]).hasClass("row3")) {
			lecture = '';
			type = '';
			$(".addnew_cont_row_"+id[2]).removeClass("row3");
			$(".add-item").slideUp('slow');
			$(this).children("a").html("Add Content");
			$("a.sel_lects").html("Add Content");
		} else {
			if($("div.row3").length > 0 ) {
				$("div.row3").removeClass("row3");
				$(".add-item").slideUp('slow');
				$(".sel_lects").html("Add Content");
			}
			$(".addnew_cont_row_"+id[2]).addClass("row3");
			$("#addcontentright_"+id[2]).show();
			lecture = id[2];
			type = $(this).attr("val");
			$(this).children("a").html("Cancel");
			$(this).children("a").attr("title","Cancel");
			$(".sel_lecture_"+id[2]).addClass("selected_lecture");
		}
		e.stopImmediatePropagation();
	});
	
	/* code to add quiz question */
	
	$(".sel_quiz").live("click",function(e){
		$(".addquizcontent").hide();
		var quizid = $(this).attr("id").split("_");
		quiz = quizid[2];
		if(quiz.length > 0){
			$("a.sel_quizs").html("Add Question");
			$("a.moreqst").html("Add More Questions");
			$("a.sel_quizs").attr("title","Add Question");
			$("a.moreqst").attr("title","Add More Questions");
			var qid = quiz;
			if ($(".quizextra_"+qid).html()) {
				$("#sel_quiz_"+qid).children("a").html("Add Question");
				$("#sel_quiz_"+qid).children("a").attr("title","Add Question");
				$("#sel_quiz_"+qid).children("a.moreqst").html("Add More Questions");
				$("#sel_quiz_"+qid).children("a.moreqst").attr("title","Add More Questions");
				$("#quz_add_mnu_"+qid).html('');
				$(".quizextra_"+qid).remove();
			} else {
				$.ajax({
					url: BASE_URL+"courses/createquizform",
					type: 'post',
					data  : "quizid="+qid, 
					success: function(data) {
						$("#sel_quiz_"+qid).children("a").html("Cancel");
						$("#sel_quiz_"+qid).children("a").attr("title","Cancel");
						//$(".quizcontainer_"+qid).after(data);
						$("#quz_add_mnu_"+qid).html(data);
						$("#quz_add_mnu_"+qid).show();
					},
					error : function(err, req) {
						alert("Your browser broke!");
					}
				});
			}
		} 
		e.stopImmediatePropagation();
	});
	/* code to add quiz question end here */
	
	/* code to delete quiz question */
	$(".delqst").live("click",function(e){
		if(confirm("Do you really want to delete this question?")) {
			var qstid = $(this).attr("id").split("_");
			$.ajax({
				url: BASE_URL+"courses/deletequizquestion",
				type: 'post',
				data  : "quizqstid="+qstid[1], 
				success: function(data) {
					if(parseInt(data) == 1) {
						refreshcurriculum();
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
		e.stopImmediatePropagation();
	});
	/* code to delete quiz question end here */
	
	$(".editqst").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$.ajax({
			url: BASE_URL+"courses/editquizquestioninline",
			type: 'post',
			data  : "questionid="+id[1], 
			success: function(data) {
				$("#quz_add_mnu_"+id[2]).html(data);
				$("#quz_add_mnu_"+id[2]).show();
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	
	
	/***** end here *************************************************/
	
	
	
	$(".add_click_new_module").live("click",function(){
		$(".addnewmodule").show();
		var top = (parseInt($(".addnewmodule").offset().top)-30);
		$('html, body').animate({scrollTop: top}, 2000);
	});
	
	$(".select_this_module").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$(".add_lec").hide();
		$(".V,.A,.P,.M,.D,.T,.N,.S").hide();
		$(".sel_lecture").removeClass("selected_lecture");
		$(".sel_lect").children("a").html("Select Lecture");
		if($(".section_"+id[1]).hasClass("selected_module")) {
			module = '';
			$(".section_"+id[1]).removeClass("selected_module");
			$(".sel_title").html("Select Module");
		} else {
			if($("div.selected_module").length > 0 ) {
				$(".sections").removeClass("selected_module");
				$(".sel_title").html("Select Module");
			}
			module = id[1];
			$(this).children("a.sel_title").html("Deselect Module");
			$(".section_"+id[1]).addClass("selected_module");
		}
		e.stopImmediatePropagation();
	});
	
	$(".add_click_new_lecture").live("click",function(e){
		$(".add_lec").hide();
		if (module.length == 0) {
			alert("Please select a module before creating a new lecturea new lecture.");
		} else {
			$(".add_new_lecture_"+module).show();
			var top = (parseInt($(".add_new_lecture_"+module).offset().top));
			$('html, body').animate({scrollTop: top}, 2000);
		}
		e.stopImmediatePropagation();
	});
	
	$(".cancelsec").live("click",function(e){
		$(".add_lec").hide();
		e.stopImmediatePropagation();
	});
	
	$(".sel_lect").live("click",function(e){
		var id = $(this).attr("id").split("_");
		if($(".sel_lecture_"+id[2]).hasClass("selected_lecture")) {
			lecture = '';
			type = '';
			$(".sel_lecture_"+id[2]).removeClass("selected_lecture");
			$(this).children("a").html("Select Lecture");
			$("a.sel_lects").html("Select Lecture");
		} else {
			if($("div.selected_lecture").length > 0 ) {
				$(".sel_lecture").removeClass("selected_lecture");
				$(".sel_lects").html("Select Lecture");
			}
			lecture = id[2];
			type = $(this).attr("val");
			$(this).children("a").html("Deselect Lecture");
			$(".sel_lecture_"+id[2]).addClass("selected_lecture");
		}
		e.stopImmediatePropagation();
	});
	
	$(".add_click_new_quiz").live("click",function(e){
		if (module == '' && lecture == '') {
			alert("Please select a module or lesson before creating a new quiz.");
		} else {
			$(".add_lec").hide();
			$(".add_new_quiz_"+module).show();
			var top = (parseInt($(".add_new_quiz_"+module).offset().top));
			$('html, body').animate({scrollTop: top}, 2000);
			
		}
		e.stopImmediatePropagation();
	});
	
	$(".add_sub_quiz").live("click",function(e){
		var id = $(this).attr("id").split("_");
		id = id[3];
		if(parseInt(id) == id) {
			$.ajax({
					url: BASE_URL+"courses/addquiz",
					type: 'post',
					data  : "sectionid="+module+"&lectureid="+lecture+"&heading="+$("#CourseLectureQuiz"+id).val(), 
					success: function(data) {
						$("#CourseQuizHeading").val('');
						//$("#uploadcont").html(data);
						refreshcurriculum();
					},
					error : function(err, req) {
						alert("Your browser broke!");
					}
				});
		} else {
			alert("Some error occured.");
		}
		e.stopImmediatePropagation();
	});
	
	
	$(".cancelquiz").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$(".add_new_quiz_"+id[1]).slideToggle('slow');
		e.stopImmediatePropagation();
	});
	
	$(".addcontent").live("click",function(e){
		if(type.length == 0) {
			e.preventDefault();
		} else {
			$("#CourseLecturetextid").val(lecture);
			var cont = type.split("_");
			var cont_type = $(this).attr("val");
			$(".bxhead").html($(this).attr("title"));
			if(cont[1] == 'N' || cont_type == 'S' || cont[1] == cont_type) {
				$("."+removeSpaces(cont[0])).show();
				if(cont[1] == 'N') {
					$("."+removeSpaces(cont[0])).children("span").each(function(){
						if($(this).hasClass(removeSpaces(cont_type))) {
						} else {
							$(this).slideUp("1000");
						}
					});
				//	$(".bxhead").slideToggle("slow");
					$("."+removeSpaces(cont[0])).children("."+removeSpaces(cont_type)).slideDown(1000);
				} else if(cont_type == 'S') {
					$("."+removeSpaces(cont[0])).children(".S").slideDown(1000);
				} else {
					$("."+removeSpaces(cont[0])).children("."+removeSpaces(cont[1])).slideDown(1000);
				}
			} else {
				//alert("here");
			}
		}
		e.stopImmediatePropagation();
	});
	
	
	/* code to remove downloadable files */
	$(".removefile").live("click",function(e){
		if (confirm("Do you really want to delete this file?")) {
			var ids = $(this).attr("id").split("_");
			$.ajax({
				url: BASE_URL+"courses/removefile",
				type: 'post',
				data  : "id="+ids[1], 
				success: function(data) {
					if (parseInt(data) == 1 ) {
						$(".removefile_"+ids[1]).remove();
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	/* code to remove downloadable files end here */
	
	
	/* code to remove questions added */
	$(".remqst").live("click",function(e){
		if (confirm("Do you really want to delete this question?")) {
			var ids = $(this).attr("id").split("_");
			$.ajax({
				url: BASE_URL+"courses/removeqst",
				type: 'post',
				data  : "qstid="+ids[1], 
				success: function(data) {
					if (parseInt(data) == 1 ) {
						$("#qstrow_"+ids[1]).remove();
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	/* code to remove questions added end here */
	
	
	$('.acc_drpdwn1').click(function(){
					$('.preview_btn').slideToggle('1000');
					$('.account_btn1').fadeOut('fast');
					$('.discover').fadeOut('fast');
					$('.nav_btn1').fadeOut('fast');
					$('.nav_btn2').fadeOut('fast');
				});
				
	$('.acc_drpdwn2').click(function(){
					$('.nav_btn1').slideToggle('1000');
					$('.preview_btn').fadeOut('fast');
					$('.account_btn1').fadeOut('fast');
					$('.discover').fadeOut('fast');
					$('.nav_btn2').fadeOut('fast');
				});
				
	$('.acc_drpdwn3').click(function(){
					$('.nav_btn2').slideToggle('1000');
					$('.preview_btn').fadeOut('fast');
					$('.account_btn1').fadeOut('fast');
					$('.discover').fadeOut('fast');
					$('.nav_btn1').fadeOut('fast');
				});
	
	$("#CourseInstructorsForm").submit(function(e){
		var err = 0;
		$(".commissionval").each(function(event){
			if($(this).val() <= 0 ) {
				$(this).attr("style","border:1px solid red;");
				$(this).addClass("errrev");
				err++;
			} else if($(this).hasClass("errrev")) {
				$(this).removeClass("errrev");
				$(this).attr("style","border:1px solid #A7A7A7;");
			}
		});
		if(err > 0) {
			$(".errrev:first").focus();
			$("#revenue_err").show();
			e.preventDefault();
		}
	});
	
	$("#show_askquestion_id,.closewithcancle").live("click",function(){
		$("#CourseViewlectureForm").slideToggle();
	});
	
	
	//contacts us message validation
	$("#PageContactusForm").validate({
		rules : {
			'data[Page][first_name]' : {
				required	:	true,
				letterssonly:   true
			},
			'data[Page][email]' : {
				required	:	true,
				email:true
			},
			'data[Page][phone]' : {
				required : false,
				number	: true
			},
			'data[Page][type]' : {
				required	:	true
			},
			'data[Page][message]' : {
				required	:	true
			}
			
		},
		messages : {
			'data[Page][first_name]' : {
				required	: "Please enter your name.",
				letterssonly: "Please enter valid name."
			},
			'data[Page][email]' : {
				required	: "Please enter email.",
				email		: "Please enter valid email."
			},
			'data[Page][phone]' : {
				number : "Please enter valid phone number."
			},
			'data[Page][type]' : {
				required	: "Please select user type."
			},
			'data[Page][message]' : {
				required : "Please enter message."
			}	
		}
	});	
	//end contact us validation
	
	/* code to validate paypal form */
	$("#UserPremiumInstructorForm").validate({
		rules:{
			'data[Userdetail][paypalaccount]':{
				required	:	true,
				email		:	true
			}
		},
		messages:{
			'data[Userdetail][paypalaccount]':{
				required	:	"Please enter paypal email.",
				email		:	"Please enter valid paypal email."
			}
		}
	});
	/* code to validate paypal form end here */
	
	$("#more").click(function(e){
		$(".viewprofilelarge").slideToggle("slow");
		$(".viewprofile").slideToggle("slow");
		if ($(this).text() == '+ More'){
			$(this).children("a").html("- Less");
		} else {
			$(this).children("a").html("+ More");
		}
	});
	
	/* code to add supplimentary stuf to download */
	$(".suppliupload").live("change",function(e){
		$(".progress_bar").remove();
		$(".progres-bar-new").remove();
		$(this).after("<br/><label class='hide progress_bar'></label><br/><div class='progres-bar-new hide'><div class='upper-new'></div></div>");
		var currentid = $(this).attr("id");
        var currval = currentid.split("_");
        $("."+currval[0]+"response").html("Uploading, please wait...");
        $("."+currval[0]+"response").show();
        $(".progres-bar-new").show();
        $(".progress_bar").show();
		$.ajax({
			url: BASE_URL+"courses/setlectureid",
			type: 'post',
			data  : "filetype="+currval[0]+"&lectureid="+currval[1]+"&sectionid="+currval[2]+"&courseid="+currval[3], 
			success: function(data) {
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		$(".suppliresponse"+currval[1]).attr("style","color: green;font-size: 14px;");
		$(".suppliresponse"+currval[1]).html("File uploading, please wait...");
		$(".suppliresponse"+currval[1]).show();
		var data = new FormData();
        data.append('file',$(this)[0].files[0]);
        $.ajax({
			xhr: function()
		   {
			 var xhr = new XMLHttpRequest();
			 //Upload progress
			 xhr.upload.addEventListener("progress", function(evt){
			   if (evt.lengthComputable) {
				 var percentComplete = evt.loaded / evt.total;
				 //Do something with upload progress
				 var len = (((percentComplete*100).toFixed(2))-1);
				 $(".upper-new").attr("style","width:"+len+"%;");
				 $(".progress_bar").html("Uploading "+parseInt(len)+"%");
				 if((percentComplete*100).toFixed(2) > 99.50) {
					 //refreshcurriculum();
				 }
				 console.log(percentComplete);
				// $("."+currval[0]+"response").append(percentComplete);
			   }
			 }, false);
			 //Download progress
			 xhr.addEventListener("progress", function(evt){
			   if (evt.lengthComputable) {
				 var percentComplete = evt.loaded / evt.total;
				 //Do something with download progress
				 console.log(percentComplete);
			   }
			 }, false);
			 return xhr;
		   },
			url:BASE_URL+"courses/uploadsupplimentary",
			type:'post',
			processData:false,
			contentType:false,
			data:data,
			success:function(data){
				if(parseInt(data) == 2) {
					$(".suppliresponse"+currval[1]).html("File uploaded successfuly.");
					refreshcurriculum();
					//location.href= BASE_URL+"course-manage/edit-curriculum/"+currval[3];
				} else if(parseInt(data) == 9) {
					$(".suppliresponse"+currval[1]).attr("style","color: red;font-size: 14px;");
					$(".suppliresponse"+currval[1]).html("File type is not valid.");
					$(".progress_bar").remove();
					$(".progres-bar-new").remove();
					$(".suppliresponse"+currval[1]).show();
				} else if(parseInt(data) == 9) {
					$(".suppliresponse"+currval[1]).attr("style","color: red;font-size: 14px;");
					$(".suppliresponse"+currval[1]).html("File can not be uploaded, please try again.");
					$(".progress_bar").remove();
					$(".progres-bar-new").remove();
					$(".suppliresponse"+currval[1]).show();
				}
			}
		});
	});
	
	$(".addexternal").live("click",function(e){
		var id = $(this).attr("id").split("_");
		$(".addext_"+id[1]).slideToggle("slow");
		$(".addsup_"+id[1]).slideToggle("slow");
		e.stopImmediatePropagation();
	});
	
	$(".addext").live("click",function(e){
		var lectureid = $(this).attr("id").split("_");
		var link = $("#supplimentary_"+lectureid[1]).val();
		$.ajax({
			url:BASE_URL+"courses/addexternalupload",
			type:'post',
			data:'lectureid='+lectureid[1]+"&link="+link,
			success:function(data){
				if(parseInt(data) == 1) {
					$(".suppliresponse"+lectureid).html("Successfully uploaded.");
					window.location.reload();
				} else if(parseInt(data) == 2) {
					$(".supplierrresponse"+lectureid).html("The data can not be uploaded, please try again.");
				} else if(parseInt(data) == 3) {
					$(".supplierrresponse"+lectureid).html("The provided url is not valid.");
				}
			}
		});
		e.stopImmediatePropagation();	
	});
	
	$(".complimentary").live("click",function(e){
		var id = parseInt($(this).attr("id"));
		var maincont = "addsupp_"+id;
		$("."+maincont).slideToggle("slow");
		e.stopImmediatePropagation();
	});
	
	/* code to add supplimentary stuf to download end here */
	
	
	/* code to validate ask question form */
	$("#CourseUserQuestionAnswerViewuserquestionForm").validate({
		rules:{
			'data[CourseUserQuestionAnswer][answer]':{
				required	:	true
			}
		},
		messages:{
			'data[CourseUserQuestionAnswer][answer]':{
				required	:	"Please enter your comment."
			}
		}
	});
	/* code to validate ask question form end here */
	
	
	/* code to mark a lecture complete */
	$(".marklecturecomplete").click(function(e){
		var ids = $(this).attr("id").split("_");
		var img = $(this).children("img").attr("src");
		var img1 = img.split("/");
		img1[img1.length-1] = "gray-bullet.png";
		var grayimg = img1.join("/");
		img1[img1.length-1] = "rt-bullet.png";
		var blueimg = img1.join("/");
		$.ajax({
			url: BASE_URL+"courses/marklecturecomplete",
			type: 'post',
			data  : "courseid="+ids[0]+"&lectureid="+ids[1], 
			success: function(data) {
				if (data == 1) {
					$(".drp-box2").html("Mark as Completed");
					$(".marklecturecomplete").children("img").attr("src",grayimg);
				} else {
					$(".drp-box2").html("Mark as Incompleted");
					$(".marklecturecomplete").children("img").attr("src",blueimg);
				}
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	/* code to mark a lecture complete end here*/
	
	/* code to view post add preview quiz */
	$(".nextquestion").click(function(e){
		var ids = $(this).attr("val").split("_");
		$.ajax({
			url: BASE_URL+"courses/viewquiz",
			type: 'post',
			data  : "quizqstid="+ids[0]+"&quizid="+ids[1]+"&quiztype="+$("#quiztype").val(), 
			success: function(data) {
				$(".quiz-cont").html(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	
	$(".submitquestion").click(function(e){
		var answerid = '';
		var useranswer = '';
		var answer = '';
		var userrawanswer = '';
		if($("#qsttype").val() == "B" || $("#qsttype").val() == "M") {
			if($(".chkoptionans:checked").length == 1) {
				var answerid = $(".chkoptionans:checked").val();
			} else {
				alert("Please select one answer.");
				return false;
			}
		} else {
			var answer = '';
			$(".fill").each(function(){
				useranswer += $(this).val();
				userrawanswer += $(this).val()+",";
			});
			var answer = $("#fanswer").val();
		}
		var ids = $(this).attr("val").split("_");
		$.ajax({
			url: BASE_URL+"courses/viewquiz",
			type: 'post',
			data  : "quizqstid="+ids[0]+"&quizid="+ids[1]+"&type="+$("#qsttype").val()+"&answer="+answerid+"&question="+$("#questionid").val()+"&fanswer="+answer+"&useranswer="+useranswer+"&rawans="+userrawanswer+"&quiztype="+$("#quiztype").val(), 
			success: function(data) {
				$(".quiz-cont").html(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	$(".submitlastquestion").click(function(e){
		var answerid = '';
		var useranswer = '';
		var answer = '';
		var userrawanswer = '';
		
		if($("#qsttype").val() == "B" || $("#qsttype").val() == "M") {
			if($(".chkoptionans:checked").length == 1) {
				var answerid = $(".chkoptionans:checked").val();
			} else {
				alert("Please select one answer.");
				return false;
			}
		} else {
			var answer = '';
			$(".fill").each(function(){
				useranswer += $(this).val();
				userrawanswer += $(this).val()+",";
			});
			var answer = $("#fanswer").val();
		}
		var ids = $(this).attr("val").split("_");
		$.ajax({
			url: BASE_URL+"courses/viewquiz",
			type: 'post',
			data  : "quizqstid="+ids[0]+"&quizid="+ids[1]+"&type="+$("#qsttype").val()+"&answer="+answerid+"&question="+$("#questionid").val()+"&fanswer="+answer+"&useranswer="+useranswer+"&lastquestion=1&rawans="+userrawanswer+"&quiztype="+$("#quiztype").val(), 
			success: function(data) {
				$(".quiz-cont").html(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	
	
	
	$(".editqstuser").click(function(e){
		var ids = $(this).attr("val").split("^");
		$.ajax({
			url: BASE_URL+"courses/editquizquestion",
			type: 'post',
			data  : "questionid="+ids[0]+"&previd="+ids[1], 
			success: function(data) {
				$(".quiz-cont").html(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	$(".deleteqstuser").click(function(e){
		if (confirm("Do you really want to delete this question?")) {
			var ids = $(this).attr("val").split("_");
			$.ajax({
				url: BASE_URL+"courses/deletequizquestion",
				type: 'post',
				data  : "quizqstid="+ids[0]+"&quizid="+ids[1], 
				success: function(data) {
					data = parseInt(data);
					if(data == 1) {
						window.location.reload();
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
		e.preventDefault();
	});
	$(".chkoptionans").click(function(e){
		$(".chkoptionans").removeAttr("checked");
		$(this).attr("checked","checked");
	});
	
	$("#CourseQuizQuestionEditquizquestionForm").ajaxForm({
		success:function(response){
			var ids = $(".nextquestion").attr("val").split("_");
			$.ajax({
				url: BASE_URL+"courses/viewquiz",
				type: 'post',
				data  : "quizqstid="+ids[0]+"&quizid="+ids[1], 
				success: function(data) {
					$(".quiz-cont").html(data);
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
			e.preventDefault();
		}
	});
	$("#CourseQuizQuestionEditquizquestioninlineForm").ajaxForm({
		success:function(response){
			var ids = $(".nextquestion").attr("val").split("_");
			refreshcurriculum();
		}
	});
	
	$("#cancleqst").live("click",function(){
		refreshcurriculum();
	});
	
	/* code to view post add preview quiz end here*/
	
	
	$(".pge-no").live("click",function(){
		var href = $(this).children("span").children("a").attr("href");
		location.href = href;
	});
	
	$("#expandwindow").click(function(){
		if ($(".lectr-lt").hasClass("fullwidth")) {
			$("#minimum").removeClass("newmargin");
			if ($("#minimum_wrapper").html()) {
				$("#minimum_wrapper").removeClass("fullwidth");
			}
			$(".lectr-lt").removeClass("fullwidth");
			$(".lectr-rt").show();
			$(this).addClass("rt-blue-arrow");
			$(this).removeClass("rt-blue-arrow_rev");
		} else {
			$("#minimum").addClass("newmargin");
			$(".lectr-lt").addClass("fullwidth");
			if ($("#minimum_wrapper").html()) {
				$("#minimum_wrapper").addClass("fullwidth");
			}
			$(".lectr-rt").hide();
			$(this).removeClass("rt-blue-arrow");
			$(this).addClass("rt-blue-arrow_rev");
		}
		
		
	});
	
	$("#closewindow").click(function(){
		
	});
	
	
	/* code to add youtobe/vimeo file in video content */
	$(".addyoutube").live("click",function(){
		var id = $(this).attr("id").split("_");
		var contid = "file_"+id[1];
		var extid = "ext_"+id[1];
		$("."+contid).hide();
		$("."+extid).show();
		
	});
	$(".cancelyoutube").live("click",function(e){
		var id = $(this).attr("id").split("_");
		var contid = "file_"+id[1];
		var extid = "ext_"+id[1];
		var videocont = "previewextvideo_"+id[1];
		$("."+contid).show();
		$("."+extid).hide();
		$("#"+videocont).hide();
		$(".videoresponse").hide();
		e.preventDefault();
	});
	
	$(".previewyoutube").live("click",function(e){
		var id = $(this).attr("id").split("_");
		var val = $(".extfile_"+id[1]).val();
		//$("#previewextvideo_"+id[1]).html("Please wait, while we are fetching the video..");
		$("#previewextvideo_"+id[1]).show();
		$.ajax({
			url: BASE_URL+"courses/getvideopreview",
			type: 'post',
			data  : "link="+val+"&lectid="+$(".extfile_"+id[1]).attr("id"), 
			success: function(data) {
				//$("#previewextvideo_"+id[1]).html(data);
				$("#previewvideoinline_"+id[1]).html(data);
				$("#videoresponse").hide();
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
		
	});
	
	$(".uploadexternallink").live("click",function(e){
		var id = $(this).attr("id").split("_");
		id = id[1];
		var lectdata = "ids="+$("#extlectid_"+id).val();
		lectdata += "&linkid="+$("#extlinkid_"+id).val();
		lectdata += "&linktype="+$("#exttypeid_"+id).val();
		lectdata += "&linktitle="+$("#exttitleid_"+id).val();
		$.ajax({
			url: BASE_URL+"courses/uploadextfile",
			type: 'post',
			data  : lectdata, 
			success: function(data) {
				if(parseInt(data) == 2) {
					refreshcurriculum();
				} else {
				}
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
		
	});
	
	/* code to add youtobe/vimeo file in video content end here */
	
	
	/* code to downloadfile */
	$(".downloadfile").click(function(e){
		var id = $(this).attr("id").split("_");
		var link = BASE_URL+"courses/downlodfiles/"+id[1];
		location.href = link;
		e.stopImmediateProppagation();
	});
	/* code to downloadfile end here */
	
	
	/* code top add from library in add lecture */
	$(".addfromlibrary").live("click",function(e){
		var id = $(this).attr("id").split("_");
		id = id[1];
		var extid = $(this).attr("extid");
		var mediatype = $(this).attr("val");
		$("#addlibrary_"+extid).slideToggle("slow");
		$.ajax({
			url: BASE_URL+"courses/getlibcontent",
			type: 'post',
			data  : "userid="+id+"&lecturetype="+mediatype+"&lectureid="+extid, 
			success: function(data) {
				$("#addlibrary_"+extid).html(data);
				
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	
	$(".selectlibrarycontent").live("click",function(e){
		var lecid = $(this).attr("id");
		var curlecid = $("#thislectid").val();
		var type = $(this).attr("val");
		$.ajax({
			url: BASE_URL+"courses/insertfromlibrary",
			type: 'post',
			data  : "lectureid="+lecid+"&curlec="+curlecid+"&value="+type, 
			success: function(data) {
				if(parseInt(data) == 2) {
					window.location.reload();
				} else {
					
				}
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.preventDefault();
	});
	/* code top add from library in add lecture end here*/
	
	
	
	
	
	
	/* limit characters in text box */
	$('.controlChars').each(function(){
		var chars = $(this).val().length;
		$(this).next().text(($(this).attr('maxlength') - chars));
	});
	$('.controlChars').live("keyup",function(){
			var max = $(this).attr('maxlength');
			var valLen=$(this).val().length;
			$(this).next().text(max-valLen);
	});
	/* limit characters in text box */
	
	/* getting started Page */
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
	
	$('.goToSteps').click(function(e){
		e.preventDefault();
		$("ul.tabs li").removeClass("active");
		var id = $(this).attr('href'); // id of tab
		var last = id.substr(id.length-1); 
		$(id).addClass("active");
		$(".tab_content").hide();
		$('#tab'+last).fadeIn();
	});
	
	/* getting started Page */
	/* code to show privacy options on course privacy page */
	
	/*if($("#CourseVisibility").val() == "Public"){
		$("#Public").addClass("ui-tabs-active");
	} else{
		$("#Private").addClass("ui-tabs-active");
	}*/
	/* end here */
	
	
	/* code to send message */
	$("#sendmessageid").click(function(){
		$("#messagecontid").slideDown("1000");
		$("#showmessageuser").slideUp("1000");
	});
	
	$("#MessageSendmessageForm").ajaxForm({
		success: function(response) { // do some ui update .. 
			if (parseInt(response) == 1) {
				$("#messagecontid").html("Message has been sent.");
				$("#messagecontid").addClass("success-msg");
			} else {
				$("#messagecontid").html("Message can not be sent.");
				$("#messagecontid").addClass("error");
			}
		}
	});

	/* code to send message end here*/

	$(".savetext").live("click",function(){
		$("#CourseEditcurriculumForm").find("a,input,textarea").attr("disabled",true);
		$("#CourseLecturetextid").removeAttr("disabled");
		$("#CourseText"+$("#CourseLecturetextid").val()).removeAttr("disabled");
	});
	
	
	$("#CourseEditcurriculumForm").ajaxForm({
		beforeSubmit:function(){
		//	alert("here");
			
		},
		success:function(response){
			if( parseInt(response) == 1) {
				$(".errmsg").html("Content has been updated.");
				$(".errmsg").attr("style","color:green;width:150px;font-size:12px;");
				$(".errmsg").show();
				setInterval('$(".errmsg").slideUp(1000)',1000);
				refreshcurriculum();
				//$(".errmsg").html("");
			} else {
				$(".errmsg").html("Content can not be updated.");
				$(".errmsg").attr("style","color:red;width:150px;font-size:12px;");
				$(".errmsg").show();
				$("#CourseEditcurriculumForm").find("a,input,textarea").attr("disabled",false);
				setInterval('$(".errmsg").slideUp(1000)',1000);
				//refreshcurriculum();
				//$(".errmsg").html("");
			}
			
		}
	});


	
	/* code to mark rating on view course page */
	$(".ratestar").click(function(e){
		var id = $(this).attr("id").split("_");
		$(".ratestar").attr("src",DEFAULT_LINK+"img/rating-star-1.png");
		$("#CourseReviewRating").val(id[1]);
		id = id[1];
		$(".ratestar").each(function(e){
			if(id > 0) {
				$("#rate_"+id).attr("src",DEFAULT_LINK+"img/rating-star.png");
			}
			id--;
		});
		
	});
	
	$("#CourseReviewViewForm").ajaxForm({
		success: function(response) {
			if(parseInt(response) == 1) {
				alert("Please enter valid data");
			} else {
				location.href = response;
			}
		}
	});
	/* code to mark rating on view course page end here*/
	
	/* Price Page */
	var pricetype = $("#CoursePricetype").val();
	var priceval = $("#CoursePrice").val();
	if(pricetype == 'Paid'){
		$("#Paid").addClass("ui-tabs-active");
	} else{
		$("#CoursePrice").val(0);
		$("#Free").addClass("ui-tabs-active");
	}
	$(".priceSetting").click(function(){
		$("#CoursePricetype").val($(this).attr('id'));
		if ($(this).attr('id') == 'Paid') {
			$("#CoursePrice").removeAttr("disabled");
			$("#CoursePrice").val(priceval);
		} else {
			$("#CoursePrice").val(0);
			$("#CoursePrice").attr("disabled");
		}
		
	});
	
	
	/*if($("#price_cont").text() == 'Paid'){
		$("#tabs-1").hide();
		$("#tabs-2").show();
		$("#CoursePrice").removeAttr("disabled");
		if($("#CoursePrice").val() != 0 ){
			$("#CoursePrice").val(priceval);
		}
	} else{
		$("#tabs-2").hide();
		$("#tabs-1").show();
		$("#CoursePrice").attr("disabled");
		$("#CoursePrice").val(0);
	}
	$("#CoursePricetype").change(function(){
		if ($(this).val() == 'Paid') {
			$(".tabs-1").slideUp(1000);
			$(".tabs-2").slideDown(1000);
			$("#CoursePrice").removeAttr("disabled");
			if($("#CoursePrice").val() != 0 ){
				$("#CoursePrice").val(priceval);
			}
		} else {
			$(".tabs-2").slideUp(1000);
			$(".tabs-1").slideDown(1000);
			$("#CoursePrice").attr("disabled");
			$("#CoursePrice").val(0);
		}
	});*/
	
	/* End Price Page */
	
	$("#CourseInstructors,#MessageUser").keyup(function(){
		if($(this).val() && removeSpaces($(this).val()) != '') {
			$.ajax({
				url: BASE_URL+"users/getusers",
				type: 'post',
				data  : "keyword="+$(this).val(), 
				success: function(data) {
					if(parseInt(data) != 1) {
						$("#instructcont").removeClass("hide");
						$("#instructcont").html(data);
					} else {
						$("#instructcont").addClass("hide");
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			$("#instructcont").addClass("hide");
		}
	});
	
	/* code to open message popup */
	$(".students").click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: BASE_URL+"messages/openmessagepopup",
			type: 'post',
			data  : "userid="+id, 
			success: function(data) {
				//alert(data);
				$("#inline_content").html(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
	});
	/* code to open message popup end here */
	
	
	$("#CourseInstructors").blur(function(){
		//$("#instructcont").addClass("hide");
	});
	
	$("#searchgo").live("click",function(){
		$("#CourseSearchForm").submit();
	});
	
	$(".listsearch").live("click",function(){
		var val = $(this).children("p").html();
		if($("#MessageUser").val()) {
			$("#MessageUser").val(val);
			$("#MessageUserid").val($(this).attr("id"));
			$("#instruct_"+$(this).attr("id"));
			$("#msgusr").attr("src",$("#instruct_"+$(this).attr("id")).attr("src"));
		} else {
			$(".thum-img").children("img").attr("src",$("#instruct_"+$(this).attr("id")).attr("src"));
			$("#CourseInstructors").val(val);
			$("#CourseInstructorUserId").val($(this).attr("id"));
		}
		$("#instructcont").addClass("hide");
		
	});
	
	$(".opensectioncont").live("click",function(){
		var viewid = "viewsection"+$(this).attr("id");
		var editid = "editsection"+$(this).attr("id");
		$("."+viewid).hide();
		$("."+editid).slideDown(1000);
	});
	
	$(".change").live("click",function(e){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var val_id = "CourseSectionHeading"+id;
		$(".module"+id).show();
		if($("#"+val_id).val().length > 0) {
			$.ajax({
				url: BASE_URL+"courses/chnagesectionheading",
				type: 'post',
				data  : "courseid="+id+"&heading="+$("#"+val_id).val(), 
				success: function(data) {
					var res = parseInt(data);
					if(res == 1) {
						$(".module"+id).removeClass("err-messg");
						$(".module"+id).addClass("succ-messg");
						$(".module"+id).html("Module has been updated.");
						//refreshcurriculum(); 
					} else {
						$(".module"+id).html("Module can not be updated.");
						$(".module"+id).removeClass("succ-messg");
						$(".module"+id).addClass("err-messg");
					}
				},
				error : function(err, req) {
					
					alert("Your browser broke!");
				}
			});
		} else {
			$("#instructcont").addClass("hide");
		}
		setInterval('$(".module'+id+'").hide();',3000);
	});
	
	$(".changelecture").live("click",function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var val_id = "lecture_"+id;
		var desc_id = "lecturedesc_"+id;
		$(".lecture_err"+id).show();
		if($("."+val_id).val() && removeSpaces($("."+val_id).val()) != '') {
			$.ajax({
				url: BASE_URL+"courses/chnagelectureheading",
				type: 'post',
				data  : "lectureid="+id+"&heading="+$("."+val_id).val()+"&desc="+$("."+desc_id).val(), 
				success: function(data) {
					var res = parseInt(data);
					if(res == 1) {
						$(".lecture_err"+id).removeClass("err-messg");
						$(".lecture_err"+id).addClass("succ-messg");
						$("."+val_id).attr("vale",$("."+val_id).val());
						$(".lecture_err"+id).html("Lesson has been updated.");
					} else {
						$(".lecture_err"+id).html("Lesson can not be updated.");
						$(".lecture_err"+id).removeClass("succ-messg");
						$(".lecture_err"+id).addClass("err-messg");
					}
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			$("#instructcont").addClass("hide");
		}
		setInterval('$(".lecture_err'+id+'").hide();',3000);
	});
	
	$(".addsec").live("click",function(){
		var id = $(this).attr("id");
		if($("#CourseSectionHeading").val() && removeSpaces($("#CourseSectionHeading").val()) != '') {
			$.ajax({
				url: BASE_URL+"courses/addsection",
				type: 'post',
				data  : "id="+$(this).attr("id")+"&heading="+$("#CourseSectionHeading").val(), 
				success: function(data) {
					$("#CourseSectionHeading").val('');
					$(".addnewmodule").hide();
					refreshcurriculum();
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			alert("Module heading can not be blank");
		}
	});
	
	$(".add_lecture").live("click",function(){
		if($("#CourseLectureHeading").val() && removeSpaces($("#CourseLectureHeading").val()) != '') {
			var cid = $(this).attr("id");
			$.ajax({
				url: BASE_URL+"courses/addlecture",
				type: 'post',
				data  : "courseid="+$(this).attr("id")+"&heading="+$("#CourseLectureHeading").val(), 
				success: function(data) {
					refreshcurriculum();
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			alert("Lesson heading can not be blank.");
		}
	});
	
	$(".add_sub_lecture").live("click",function(){
		var cid = $(this).attr("id").split("_");
		if($(".courselectureval_"+cid[3]).val() && removeSpaces($(".courselectureval_"+cid[3]).val()) != '') {
			$.ajax({
				url: BASE_URL+"courses/addlecture",
				type: 'post',
				data  : "courseid="+cid[5]+"&sectionid="+cid[4]+"&heading="+$(".courselectureval_"+cid[3]).val(), 
				success: function(data) {
					$("#CourseLectureHeading").val('');
					refreshcurriculum();
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			alert("Lesson heading can not be blank.");
		}
	});
	
	$(".cancel").live("click",function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var viewid = "viewsection"+id;
		var editid = "editsection"+id;
		$("."+viewid).show();
		$("."+editid).hide();
	});
	
	$(".delete").live("click",function(){
		if(confirm("Do you really want to delete Module: "+$(this).attr("val")+"?")) {
			var id = $(this).attr("id");
			id = id.split("_");
			id = id[1];
			var viewid = "viewsection"+id;
			var editid = "editsection"+id;
			var indexid = $("#hiddenid"+id).val();
			var courseid = $("#hiddencourseid"+id).val();
			$.ajax({
				url: BASE_URL+"courses/deletesection",
				type: 'post',
				data  : "sectionid="+id+"&index="+indexid+"&courseid="+courseid, 
				success: function(data) {
					var res = parseInt(data);
					//$("#uploadcont").html(data);
					refreshcurriculum();
					//location.href= BASE_URL+"course-manage/edit-curriculum/"+courseid;
					/*if(res == 1) {
						$("."+viewid).remove();
						$("."+editid).remove();
					}*/
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	
	$(".deletelecture").live("click",function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var viewid = "viewlecture"+id;
		var editid = "editlecture"+id;
		var indexid = $("#hiddenidlecture"+id).val();
		var courseid = $("#CourseId").val();
		if(confirm("Do you really want to delete Lesson: "+$(this).attr("val")+"?")) {
			$.ajax({
				url: BASE_URL+"courses/deletelecture",
				type: 'post',
				data  : "sectionid="+id+"&index="+indexid+"&courseid="+courseid, 
				success: function(data) {
					var res = parseInt(data);
					$("#uploadcont").html(data);
					//window.location.reload();
					refreshcurriculum();
					/*if(res == 1) {
						$("."+viewid).remove();
						$("."+editid).remove();
					}*/
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	
	$(".addsectionlink").click(function(){
		//$("#CourseSectionHeading").val('');
		$(".addnewmodule").slideToggle('slow');
	});
	
	$(".addlecturelink").live("click",function(){
		var id = $(this).attr("id").split("_");
		$("#CourseSectionHeading"+id[1]).val('');
		$("#add_sub_lecture_"+id[1]).slideToggle('slow');
	});
	
	$(".view-all-message-on-click").live("click",function(e){
		$(".msg-row-evn").show();
		$(".msg-row-od").show();
		$(".view-all").hide();
	});
	
	
	
	$(".addsublecturelink").live("click",function(e){
		var id = $(this).attr("id").split("_");
		var contid = "add_sub_lecture_"+id[2];
		$("#"+contid).slideToggle("slow");
	});
	
	$(".openlecturecont").live("click",function(){
		var viewid = "viewlecture"+$(this).attr("id");
		var editid = "editlecture"+$(this).attr("id");
		//$("."+viewid).hide();
		$("."+editid).slideDown(1000);
	});
	
	$(".cancellecture").live("click",function(){
		
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var viewid = "viewlecture"+id;
		var editid = "editlecture"+id;
		//$("."+viewid).show();
		$("."+editid).hide();
	});
	
	
	$(".addlecturecontent").live("click",function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "addcontentcontainer"+id;
		$("."+containerid).slideToggle('slow');
	});
	
	
	/* code to open adding quiz container */
	$(".addquizlink").live('click',function(){
		$(".addquiz").slideToggle("slow");
	});
	/* code to open adding quiz container end here */
	
	
	/* code to add new quiz */
	$(".addquizbtn").live("click",function(){
		if($("#CourseQuizHeading").val() && removeSpaces($("#CourseQuizHeading").val()) != '') {
			var cid = $(this).attr("id");
			$.ajax({
				url: BASE_URL+"courses/addquiz",
				type: 'post',
				data  : "courseid="+$(this).attr("id")+"&heading="+$("#CourseQuizHeading").val(), 
				success: function(data) {
					$("#CourseQuizHeading").val('');
					//$("#uploadcont").html(data);
					refreshcurriculum();
					//location.href= BASE_URL+"course-manage/edit-curriculum/"+cid;
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		} else {
			alert("Quiz heading can not be blank.");
		}
	});
	/* code to add new quiz end here */
	
	/* code to add content for lectures */
		
	/* code to upload video files */
	$(".addlecturevideocontent").live("click",function(e){
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "addvideocontainer"+id;
		var maincont = "editlecturecontent"+id;
		$("."+maincont).slideToggle("slow",function(){ $("."+containerid).slideToggle("slow"); });
		e.stopImmediatePropagation();
	});	
	/* end here */
	
	
	/* code to upload video files */
	$(".addlectureaudiocontent").live("click",function(e){
		//$(".addcont").hide();
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "addaudiocontainer"+id;
		var maincont = "editlecturecontent"+id;
		$("."+maincont).slideToggle("slow");
		$("."+containerid).slideToggle("slow");
		e.stopImmediatePropagation();
	});	
	/* end here */
		
	/* code to upload video files */
	$(".addlecturepresentcontent").live("click",function(e){
		//$(".addcont").hide();
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "addpresentcontainer"+id;
		var maincont = "editlecturecontent"+id;
		$("."+maincont).slideToggle("slow");
		$("."+containerid).slideToggle("slow");
		e.stopImmediatePropagation();
	});	
	/* end here */
	
	/* code to upload video files */
	$(".addlecturedoccontent").live("click",function(){
		//$(".addcont").hide();
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "adddoccontainer"+id;
		var maincont = "editlecturecontent"+id;
		$("."+maincont).slideToggle("slow");
		$("."+containerid).slideToggle("slow");
		e.stopImmediatePropagation();
	});	
	/* end here */
	
	/* code to upload video files */
	$(".addlecturetextcontent").live("click",function(event){
		//$(".addcont").hide();
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		$("#CourseLecturetextid").val(id);
		$(".addtextcontainer"+id).slideToggle('slow');
		var maincont = "editlecturecontent"+id;
		$("."+maincont).slideToggle("slow");
		event.stopImmediatePropagation();
	});	
	/* end here */

	/* code to upload mashup files */
	$(".addlecturemashupcontent").live("click",function(){
		//$(".addcont").hide();
		$(".fileoupload").val('');
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		var containerid = "addlecturemashupcontent"+id;
		var maincont = "editlecturecontent"+id;
		$("."+containerid).slideToggle("slow");
		$("."+maincont).slideToggle("slow");
	});	
	/* end here */
	
	
	$(".fileoupload").live("change",function(e){
		var currentid = $(this).attr("id");
        var currval = currentid.split("_");
        if ($("#CourseLecture"+currval[1]).val() != $("#CourseLecture"+currval[1]).attr("vale")) {
			if(confirm("The title of your Lesson has not been saved. You'll have to re-enter a title. Do you still want to proceed without saving your changes?")) {
				
			} else {
				return false;
			}
		}
		if (currval[0] == 'video') {
			var extarray = new Array("mp4","mov","wmv","flv","3gp","quicktime","avi","mpeg","x-wav");
		} else if (currval[0] == 'audio') {
			var extarray = new Array("mp3","wav","wma","ra","ram","rm","ogg","m4a");
		} else if (currval[0] == 'presentation') {
			var extarray = new Array("pdf","ppt","pptx","notebook");
		} else if (currval[0] == 'document') {
			var extarray = new Array("pdf","doc","docx");
		}
		var errflag = false;	
		var extension = $(this).val().split(".");
		$("."+currval[0]+"response"+currval[1]).attr("style","color: green;display: block;font-size: 14px;");
		if (!in_array(removeSpaces(extension[extension.length - 1]).toLowerCase(), extarray, true)) {
			$("#CourseEditcurriculumForm").find("a,input").attr("disabled",false);
			$(".progress_bar").remove();
			$(".progres-bar-new").remove();
			$(".sel_lect11").addClass("sel_lect");
			$(".sel_lect").removeClass("sel_lect11");
			$("."+currval[0]+"response"+currval[1]).html("File type is not valid.");
			$("."+currval[0]+"response"+currval[1]).attr("style","color: red;display: block;font-size: 14px;");
			setInterval('$(".'+currval[0]+'response'+currval[1]+'").hide();',3000);
			return false;
		}
		$("#CourseEditcurriculumForm").find("a,input").attr("disabled", true);
		$(".sel_lect").addClass("sel_lect11");
		$(".sel_lect11").removeClass("sel_lect");
		$(".progress_bar").remove();
		$(".progres-bar-new").remove();
		$(this).after("<br/><label class='hide progress_bar'></label><br/><div class='progres-bar-new hide'><div class='upper-new'></div></div>");
		$("."+currval[0]+"response"+currval[1]).html("Uploading, please wait...");
        $("."+currval[0]+"response"+currval[1]).show();
        $(".progres-bar-new").show();
        $(".progress_bar").show();
        typeswap = type;
        type = '';
		$.ajax({
			url: BASE_URL+"courses/setlectureid",
			type: 'post',
			data  : "filetype="+currval[0]+"&lectureid="+currval[1]+"&sectionid="+currval[2]+"&courseid="+currval[3],
			success: function(data) {
				console.log(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		
		//submitform();
        /*alert("here");
        $('#CourseEditcurriculumForm').submit(function(e){ alert("here1"); e.preventDefault(); });
        $('#CourseEditcurriculumForm').bind('submit',function(e) {
			alert("here");
			e.preventDefault(); // prevent native submit
			$(this).ajaxSubmit({
				type: "POST",
				url: BASE_URL+"courses/uploadvideofiles", 
				data: $("#CourseEditcurriculumForm").serialize(), 
				success: function(data) {
					console.log(data);
				}
			})
		});
        */
        var data = new FormData();
        data.append('file',$(this)[0].files[0]);
        $.ajax({
			xhr: function()
		   {
			 var xhr = new XMLHttpRequest();
			 //Upload progress
			 xhr.upload.addEventListener("progress", function(evt){
			   if (evt.lengthComputable) {
				 var percentComplete = evt.loaded / evt.total;
				 //Do something with upload progress
				 var len = (((percentComplete*100).toFixed(2))-1);
				 $(".upper-new").attr("style","width:"+len+"%;");
				 $(".progress_bar").html("Uploading "+parseInt(len)+"%");
				 if((percentComplete*100).toFixed(2) > 99.50) {
					 //refreshcurriculum();
				 }
				 console.log(percentComplete);
				// $("."+currval[0]+"response").append(percentComplete);
			   }
			 }, false);
			 //Download progress
			 xhr.addEventListener("progress", function(evt){
			   if (evt.lengthComputable) {
				 var percentComplete = evt.loaded / evt.total;
				 //Do something with download progress
				 console.log(percentComplete);
			   }
			 }, false);
			 return xhr;
		   },
			url:BASE_URL+"courses/uploadvideofiles",
			type:'post',
			processData:false,
			contentType:false,
			data:data,
			success:function(data){
				if(parseInt(data) == 2) {
					$("."+currval[0]+"response"+currval[1]).html("File uploaded successfuly.");
					refreshcurriculum();
				} else if(parseInt(data) == 1) {
					type= typeswap;
					$("#CourseEditcurriculumForm").find("a,input").attr("disabled",false);
					$(".progress_bar").remove();
					$(".progres-bar-new").remove();
					$(".sel_lect11").addClass("sel_lect");
					$(".sel_lect").removeClass("sel_lect11");
					$("."+currval[0]+"response"+currval[1]).html("File type is not valid.");
				}
				//location.href= BASE_URL+"course-manage/edit-curriculum/"+currval[3];
			}
		}); 
	});
	
	$(".uploadbutton").live("click",function(){
		//$('#CourseEditcurriculumForm').find('input, textarea, button, select').attr('disabled','disabled');
		//$("."+$(this).attr("id")).removeAttr("disabled");
		//$(this).removeAttr("disabled");
	});
	
	
	/* end here */
	
	/*$("#CourseEditcurriculumForm").ajaxForm({
		success: function(response) { // do some ui update .. 
			window.location.reload();
		}
    });
	*/

	

	
	/* code to add quiz question */
	$(".addqusetion").live("click",function(){
		var qid = $(this).attr("id");
		if ($(".quizextra_"+qid).html()) {
			$(".quizextra_"+qid).remove();
		} else {
			$.ajax({
				url: BASE_URL+"courses/createquizform",
				type: 'post',
				data  : "quizid="+qid, 
				success: function(data) {
					//$(".quizcontainer_"+qid).after(data);
					$("#quz_add_mnu_"+qid).html(data);
					$("#quz_add_mnu_"+qid).show();
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	/* code to add quiz question end here */
	
	
	
	/* code to create form to add question */
	$(".createquestion").live("click",function(e){
		$(".createquestion").removeClass("selected");
		$(this).addClass("selected");
		var quizid	= 	$(this).attr("id");
		quizid		=	quizid.split("_");
		if($(".addquestionnew").html()) {
			$(".addquestionnew").hide();
			$(".addquestionnew").remove();
		} 
		$.ajax({
			url: BASE_URL+"courses/createaddquestionform",
			type: 'post',
			data  : "quizid="+quizid[1]+"&questiontype="+quizid[0], 
			success: function(data) {
				$(".addquestionnew").html('');
				$("#qstoption_"+quizid[1]).after(data);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
		e.stopImmediatePropagation();
	});
	
	
	/* code to view questions of a quiz */
	$(".viewqusetion").live("click",function(){
		var quizid	= 	$(this).attr("id");
		if($(".viewqusetion"+quizid).html()) {
			$(".viewqst_"+quizid).slideUp("1000");
			$(".viewqusetion"+quizid).remove();
		} else {
			$.ajax({
				url: BASE_URL+"courses/viewquizquestions",
				type: 'post',
				data  : "quizid="+quizid, 
				success: function(data) {
					$(".viewqst_"+quizid).html(data);
					$(".viewqst_"+quizid).slideDown("1000");
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	/* code to view questions of a quiz end here */
	
	$(".editquiz").live("click",function(){
		var qid = $(this).attr("id").split("_");
		qid = qid[1];
		if ($(".quizextra_"+qid).html()) {
			$(".quizextra_"+qid).remove();
		} else {
			$.ajax({
				url: BASE_URL+"courses/createquizform",
				type: 'post',
				data  : "quizid="+qid+"&quizcont=1", 
				success: function(data) {
					//$(".quizcontainer_"+qid).after(data);
					$("#quz_add_mnu_"+qid).html(data);
					$("#quz_add_mnu_"+qid).show();
				},
				error : function(err, req) {
					alert("Your browser broke!");
				}
			});
		}
	});
	
	/* code to create form to add question */
	
	$(".searchcourse").live("change",function(){
		$("#CourseSearchFormFilter").submit();
	});
	
	/* code to show password options on course privacy page */
	//$('#tabs').tabs();
	
	
	
	$(".optradio").click(function(){
		if ($(this).val() == 2) {
			$("#privacy_id").slideDown('1000');
			$("#CoursePasswordPassword").removeAttr("disabled");
		} else {
			$("#CoursePasswordPassword").val('');
			$("#CoursePasswordPassword").attr("disabled","disabled");
		}
	});
	/* end here */
	
	/* code to diable copy paste in change password */
	$('#UserCurrentpassword,#UserNewpassword,#UserConfirmpassword').bind("cut copy paste",function(e) {
	  e.preventDefault();
	});
	/* end here */
	
	/* code to open drop down on profile link */
	$('.acc_drpdwn').click(function(){
		$('.account_btn1').slideToggle('1000');
	});
	/* end here */
	
	
	
	/* code to delete profile */
	$("#deleteprofile").click(function(e){
		if (confirm("Do you really want to delete your IOT Profile?")) {
			return true;
		} else {
			e.preventDefault();
			return false;
		}
	});
	/* end here */
	
	$(".editlecturecontent,.closeeditlecture").live("click",function(event){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		if($(this).attr("show")) {
			$("#addlibrary_"+id).slideUp();
			$(".editlecturecontent"+id).slideUp("1000");
			$(this).removeAttr("show");
			event.stopImmediatePropagation();
		} else {
			$(".editlecturecontent"+id).slideDown("1000");
			$(this).attr("show",1);
			event.stopImmediatePropagation();
		}
		
	});
	
	
	/* code to add more goals, audience and requirement on course details page */
	var count = $(".goals").length;
	$("#addgoals img").click(function() {
		var str = '<input type="text" id="CourseGoalTitle'+(++count)+'" class="goals goalsextra" maxlength=100 name="data[CourseGoal][title]['+(count)+']"><a href="javascript:void(0)" id="'+(count)+'" class="remgoal fltrght">Remove</a>'
		if($(".remgoal").length == 0){
			$(".goals:last").after(str);
		} else {
			$(".remgoal:last").after(str);
		}
	});
	
	$(".remgoal").live("click",function(){
		var id = "CourseGoalTitle"+$(this).attr("id");
		$("#"+id).remove();
		$(this).remove();
	});
	
	var count1 = $(".audience").length;
	$("#addaudience img").click(function() {
		var str = '<input type="text" id="CourseAudienceTitle'+(++count1)+'" class="audience goalsextra" maxlength=100 name="data[CourseAudience][title]['+(count1)+']"><a href="javascript:void(0)" id="'+(count1)+'" class="remaudience fltrght">Remove</a>'
		if($(".remaudience").length == 0){
			$(".audience:last").after(str);
		} else {
			$(".remaudience:last").after(str);
		}
	});
	
	$(".remaudience").live("click",function(){
		var id = "CourseAudienceTitle"+$(this).attr("id");
		$("#"+id).remove();
		$(this).remove();
	});
	
	var count1 = $(".requirement").length;
	$("#addrequirement img").click(function() {
		var str = '<input type="text" id="CourseRequirementTitle'+(++count1)+'" class="requirement goalsextra" maxlength=100 name="data[CourseRequirement][title]['+(count1)+']"><a href="javascript:void(0)" id="'+(count1)+'" class="remrequirement fltrght">Remove</a>'
		if($(".remrequirement").length == 0){
			$(".requirement:last").after(str);
		} else {
			$(".remrequirement:last").after(str);
		}
	});
	
	$(".remrequirement").live("click",function(){
		var id = "CourseRequirementTitle"+$(this).attr("id");
		$("#"+id).remove();
		$(this).remove();
	});
	
	/* end here */
	
	/* code to check only letter */
	$.validator.addMethod("letterssonly", function(value, element) {
		return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);
	}, "Letters only please"); 
	/* end here */
	
	/* code to check only letter and allow some special charcters*/
	$.validator.addMethod("letterssconly", function(value, element) {
		return this.optional(element) || /^[a-zA-Z\&\,\.\-\0-9\s]*$/.test(value);
	}, "Please enter valid value."); 
	/* end here */
	
	/*$("#CoursePriceForm").validate({
		rules:{
			'data[Course][price]':{
				required	:	true,
				number		: true
			}
		},
		messages:{
			'data[Course][price]':{
				required	:	'Please enter price.',
				number		: 'Please enter valid price.'
			}
		}
	});*/
	$('#CoursePriceForm').submit(function(e){
		var regex = /[0-9]|\./;
		if(($('#CoursePrice').val() <= 0) && ($("#CoursePricetype").val() == 'Paid')){
			$('.error-message').text('Please enter price greater than 0.');
			e.preventDefault();
		} else if (($("#CoursePricetype").val() == 'Paid') && isNaN(parseFloat($("#CoursePrice").val()))) { 
			if(!isFinite($("#CoursePrice").val())) {
				$('.error-message').text('Please enter valid price.');
				e.preventDefault();
			}
		} else{
			$('#CoursePriceForm').submit();
		}
	});
	
	$("#CourseMakepaymentForm").validate({
		rules:{
			'data[Course][first_name]':{
				required	:	true
			},
			'data[Course][last_name]':{
				required	:	true
			},
			'data[Course][customer_address1]':{
				required	:	true
			},
			'data[Course][customer_city]':{
				required	:	true
			},
			'data[Course][customer_state]':{
				required	:	true
			},
			'data[Course][customer_zip]':{
				required	:	true
			},
			'data[Course][customer_country]':{
				required	:	true
			},
			'data[Course][card_number]':{
				required	:	true,
				creditcard : true
			},
			'data[Course][card_type]':{
				required	:	true
			},
			'data[Course][cvv]':{
				required	:	true
			},
			'data[Course][exp_year]':{
				required	:	true
			},
			'data[Course][exp_month]':{
				required	:	true
			}
		},
		messages:{
			'data[Course][first_name]':{
				required	:	'Please enter first name.'
			},
			'data[Course][last_name]':{
				required	:	'Please enter last name.'
			},
			'data[Course][customer_address1]':{
				required	:	'Please enter address line 1.',
			},
			'data[Course][customer_city]':{
				required	:	'Please enter city.'
			},
			'data[Course][customer_state]':{
				required	:	'Please enter state.'
			},
			'data[Course][customer_zip]':{
				required	:	'Please enter zip.'
			},
			'data[Course][customer_country]':{
				required	:	'Please select country.'
			},
			'data[Course][card_number]':{
				required	:	'Please enter card number.',
				creditcard : 'Please enter valid card number.'
			},
			'data[Course][card_type]':{
				required	:	'Please select card type.',
			},
			'data[Course][cvv]':{
				required	:	'Please enter security code.',
			},
			'data[Course][exp_year]':{
				required	:	'Please select years.',
			},
			'data[Course][exp_month]':{
				required	:	'Please select months.',
			}
			
		}
	});
	
	$("#CoursePrivacyForm").validate({
		rules:{
			'data[CoursePassword][password]':{
				required	:	true,
				minlength	:	5,
				maxlength	:	15
			}
		},
		messages:{
			'data[CoursePassword][password]':{
				required	:	PASSWORDSIGNUPEMPTYMSG,
				minlength	:	PASSWORDSIGNUPMINLNMSG,
				maxlength	:	PASSWORDSIGNUPMINLNMSG
			}
		}
	});
	
	$.validator.addMethod("lettersonly", function(value, element) { 
		return this.optional(element) || /^[a-z\s]*$/.test(value);
	}, "Please enter only letters");
	
	
	$("#UserSignupForm,#UserdetailEditForm, #UserdetailEditProfileForm").validate({
		rules:{
			'data[User][username]' : {
				required	: true,
				email		: true
		
			},
			'data[User][password]' : {
				required	:	true,
				minlength	:	5,
				maxlength	:	15
			},
			'data[Userdetail][first_name]' : {
				required	:	true,
				letterssonly	:	true
			}
			,
			'data[Userdetail][last_name]' : {
				required	:	true,
				letterssonly	:	true
			}
		},
		messages:{
			'data[User][username]' : {
				required	: EMPTYSIGNUPEMAILMESSAGE,
				email		: VALIDSIGNUPEMAILMESSAGE
			},
			'data[User][password]' : {
				required	:	PASSWORDSIGNUPEMPTYMSG,
				minlength	:	PASSWORDSIGNUPMINLNMSG,
				maxlength	:	PASSWORDSIGNUPMINLNMSG
			},
			'data[Userdetail][first_name]' : {
				required	:	NAMESIGNUPMESSAGE,
				letterssonly	:	'Please enter valid name.'
			}
			,
			'data[Userdetail][last_name]' : {
				required	:	LASTNAMESIGNUPMESSAGE,
				letterssonly	:	'Please enter valid last name.'
			}
		}
	});	
	
	
	$("#CourseCoverimageForm").validate({
		rules:{
			'data[Course][coverimage]' : {
				required 	:	true,
				accept		:	'jpeg|jpg|png|gif'
			}
		},
		messages:{
			'data[Course][coverimage]' : {
				required	:	"Please choose an Image to upload.",
				accept		:	VALIDCOVERIMAGE
			}
		}
	});	
	
	$("#UserdetailEditProfilePhotoForm").validate({
		rules:{
			'data[Userdetail][image]' : {
				required	: 	true,
				accept		:	'jpeg|jpg|png|gif'
			}
		},
		messages:{
			'data[Userdetail][image]' : {
				required	: 	"Please select a picture to upload.",
				accept		:	VALIDCOVERIMAGE
			}
		}
	});	
	
	
	$("#CoursePromovideoForm").validate({
		rules:{
			'data[Course][promovideo]' : {
				required	: 	true,
				accept		:	'mp4|mov|wmv|flv|3gp|quicktime|avi|mpeg|x-wav|wav'
			}
		},
		messages:{
			'data[Course][promovideo]' : {
				required	: 	"Please choose a video to upload.",
				accept		:	VALIDPROMOVIDEO
			}
		}
	});	
	
	
	
	$(".action").click(function(e){
		if($(".error").text().length == 0) {
			$("#uploadstatus").show();
		}
	});
	
	$("#UserdetailEmail").keyup(function(){
		
	});
	
	
	$("#UserChangepasswordForm,#UserEditProfileAccountForm").validate({
		rules : {
			'data[User][currentpassword]' : {
				required	:	true,
				minlength	:	5,
				maxlength	:	15
			},
			'data[User][password]' : {
				required	:	true,
				minlength	:	5,
				maxlength	:	15
			},
			'data[User][confirmpassword]' : {
				required	:	true,
				equalTo		:	'#UserPassword',
				minlength	:	5,
				maxlength	:	15
			}
		},
		messages : {
			'data[User][currentpassword]' : {
				required	:	'Please enter current password.',
				minlength	:	'Password cannot be less than 5 characters.',
				maxlength	:	'Password cannot be more than 15 characters.'
			},
			'data[User][password]' : {
				required	:	'Please enter new password.',
				minlength	:	'Password cannot be less than 5 characters.',
				maxlength	:	'Password cannot be more than 15 characters.'
			},
			'data[User][confirmpassword]' : {
				required	:	'Please re-type new password.',
				equalTo		:	'New and Re-type password do not match.',
				minlength	:	'Password cannot be less than 5 characters.',
				maxlength	:	'Password cannot be more than 15 characters.'
			}
		}
	});
	
	$("#CourseAddForm").validate({
		rules : {
			'data[Course][title]' : {
				required : true,
				letterssconly:true
			}
		},
		messages : {
			'data[Course][title]' : {
				required : VALIDATECOURSETITLE,
				letterssconly:"Only characters like (,), (&), (-) and (.) are allowed."
			}
		}
	});
	
	$("#UserForgotpasswordForm").validate({
		rules:{
			'data[User][username]'	:{
				required	:	true,
				email		:	true
			}
		},
		messages:{
			'data[User][username]'	:{
				required	:	EMPTYEMAILMESSAGE,
				email		:	VALIDEMAILMESSAGE
			}
		}
	});
	
	
	$("#UserLoginForm").validate({
		rules:{
			'data[User][username]'	:{
				required	:	true,
				email	:	true
			},
			'data[User][password]'	:{
				required	: true,
				minlength	: 5
			}
		},
		messages:{
			'data[User][username]'	:{
				required	:	'Please enter email.',
				email		:	VALIDEMAILMESSAGE
			},
			'data[User][password]'	:{
				required	:	EMPTYPASSWORDMESSAGE,
				minlength	:	PASSWORD5LENGTHMESSAGE
			}
		}
	});
	
	$("#MessageViewmessagesForm,#MessageContactpublisherForm").validate({
		rules:{
			'data[Message][subject]'	:{
				required	: true
			},
			'data[Message][message]'	:{
				required	: true
			}
		},
		messages:{
			'data[Message][subject]'	:{
				required	: 'Please enter subject.'
			},
			'data[Message][message]'	:{
				required	: 'Please enter message.'
			}
		}
	});
	
	$('#a-reload').click(function() {
		var captcha = $("#img-captcha");
		captcha.attr('src',captcha.attr('src')+'?'+Math.random());
		return false;
	});
	
	/* below code is to perform  functionality */
	$("#checkall").click(function(){
		$(".chk").attr("checked",this.checked);
	});
	
	$(".chk").click(function(){
	
		if($(".chk").length == $(".chk:checked").length){
			
			$("#checkall").attr("checked","checked");
		}else{
			$("#checkall").removeAttr("checked");
		}
	});
	/* end here */
	var searchButton 	= '';
	
	$(".submitsearch").click(function() {
		
		searchButton = $(this).attr('attr');
		
	});
	/* below code is to validate checkall functionality for every page on which we perform delete multiple or update multiple functionalioty*/
	$("#CampaignMycampaignsForm,#MessageInboxForm__,#MessageSentmessageForm__,#MessageTrashmessageForm__").submit(function(){ if(searchButton == ''){ return validatemultipleaction($(this).attr("id")); }else{ $(".chk").removeAttr("checked"); return true; } });
	/* end here */
	
	
	/* Basic Page JS */
	//$(".controlChars").charCounter(6);
	//$("#message2").charCount(230);
	
	$('#subtitleQue').click(function(){
		$('#subTitleoverlay').show();
		$('.subtitleHelp').show();
	});
	$('#closePop').click(function(){
		$('#subTitleoverlay').hide();
		$('.subtitleHelp').hide();
	});
	
	$("#CourseBasicForm").validate({
		rules : {
			'data[Course][title]' : {
				required	:	true,
				letterssconly	:	true
			},
			'data[Course][source_url]' : {
				required	:	false,
				url			:	true
			},
			'data[Course][lincence_url]' : {
				required	:	false,
				url			:	true
			},
			'data[Course][lincence_logo]' : {
				required	: false,
				accept		:	'jpeg|jpg|png|gif'
			}
		},
		messages : {
			'data[Course][title]' : {
				required	:	'Please enter course title.'
			},
			'data[Course][source_url]' : {
				url			:	'Please enter valid source url.'
			},
			'data[Course][lincence_url]' : {
				url			:	'Please enter valid lincense url.'
			},
			'data[Course][lincence_logo]' : {
				accept		:	'Please enter image with jpeg, jpg, png, gif only.'
			}
		}
	});
	
	/* End Basic Page JS */
	/* Course Pages Help JS */
	$("#helpMe").click(function(e){
		e.preventDefault();
		$('.live-sess-popup').show();
		$('.blackOpcty_quote').show();
	});
	$('#closeMe').click(function(e){
		e.preventDefault();
		$('.blackOpcty_quote').hide();
		$('.live-sess-popup').hide();
	});
	
	$(".helpMe,#cancelprice").live("click",function(){
		$(".price").slideToggle("1000");
		$(".pricecont").slideToggle("1000");
		e.preventDefault();
	});
	
	/* Course Pages Help JS */
	
	/* View Courses Page */
	
	$('.viewPage a').click(function(e){
			e.preventDefault();
			$('#CourseViewPage').val($(this).attr('id'));
			$('#CourseSearchFormFilter').submit();
	});
	 $('.price-btn1').click(function(){
			$('.price-btn').slideToggle('1000');
			$('.sort-btn').fadeOut('fast');
			$('.language').fadeOut('fast');
			$('.account_btn1').fadeOut('fast');
			$('.discover').fadeOut('fast');
		});	
		
		$('.sort-btn1').click(function(){
			$('.sort-btn').slideToggle('1000');
			$('.price-btn').fadeOut('fast');
			$('.language').fadeOut('fast');
			$('.account_btn1').fadeOut('fast');
			$('.discover').fadeOut('fast');
		});	
		
		$('.language1').click(function(){
			$('.language').slideToggle('1000');
			$('.sort-btn').fadeOut('fast');
			$('.price-btn').fadeOut('fast');
			$('.account_btn1').fadeOut('fast');
			$('.discover').fadeOut('fast');
		});	
		
		$('.language,.sort-btn,.price-btn,.discover,.account_btn1').mouseleave(function(){
			$('.language').fadeOut('fast');
			$('.sort-btn').fadeOut('fast');
			$('.price-btn').fadeOut('fast');
			$('.discover').fadeOut('fast');
			$('.account_btn1').fadeOut('fast');
		});	
		/* code to set profile notification on profile page */
		$('#dontSendNotification').click(function(){
			if ($('#dontSendNotification').is(':checked')) {
				$(".notifications").attr("disabled", true);
			} else {
				$(".notifications").removeAttr("disabled");
			} 
		});
		if ($('#dontSendNotification').is(':checked')) {
			$(".notifications").attr("disabled", true);
		} else {
			$(".notifications").removeAttr("disabled");
		} 
		/* code to set profile notification on profile page end here */
		/* Code for profile privacy settings */
		$('input.setting').click(function(e){
			e.preventDefault();
			if($(this).val() == 0){
				$(this).attr('src','app/webroot/img/on-btn.png');
				$(this).parent().next().attr('value',1);
				$(this).attr('value',1);
				$(this).next().attr('value',1);
			} else if($(this).val() == 1){
				$(this).attr('src','app/webroot/img/off-btn.png');
				$(this).parent().next().attr('value',0);
				$(this).attr('value',0);
				$(this).next().attr('value',0);
			}
		
		});
		/* End Code for profile privacy settings */

	/* code to add course in wishlist */
	$(".addwishlist").click(function(){
		var courseid = $(this).attr("id").split("_");
		$.ajax({
			url: BASE_URL+"courses/addwishlist",
			type: 'post',
			data  : "courseid="+courseid[1], 
			success: function(data) {
				if(parseInt(data) == 1) {
					$(".addwishlist").html('<span class="wand"></span>Wishlisted');
				} else {
					$(".addwishlist").html('<span class="wand"></span>Wishlist');
				}
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
	});
	

	/* code to add course in wishlist end here */
	
	/* code to mark course as complete */
	$(".markcomplete").click(function(){
		var courseid = $(this).attr("id").split("_");
		$.ajax({
			url: BASE_URL+"courses/markcomplete",
			type: 'post',
			data  : "courseid="+courseid[1], 
			success: function(data) {
				if(parseInt(data) == 1) {
					$(".markcomplete").html('Completed');
				} else {
					$(".markcomplete").html('Mark as Completed');
				}
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
	});
	

	/* code to mark course as complete end here */
	
	/* code to show & hide question and notes panel */
	$(".addnotes").click(function(){
		$(".notescont").show();
		$(".qstcont").hide();
		$("#CourseNotes").removeAttr("disabled");
		$("#CourseQuestion").attr("disabled","disabled");
		$("#CourseQuestion").val('');
		var str = $("#CourseViewlectureForm").serialize();
		$.ajax({
			url: BASE_URL+"courses/viewlisting",
			type: 'post',
			data  : "data="+str+"&type=notes", 
			success: function(html) {
				$("#notescont").html(html);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
	});
	$(".askquestion").click(function(){
		$(".notescont").hide();
		$(".qstcont").show();
		$("#CourseQuestion").removeAttr("disabled");
		$("#CourseNotes").attr("disabled","disabled");
		$("#CourseNotes").val('');
		var str = $("#CourseViewlectureForm").serialize();
		$.ajax({
			url: BASE_URL+"courses/viewlisting",
			type: 'post',
			data  : "data="+str+"&type=questions", 
			success: function(html) {
				$("#questcontnew").html(html);
			},
			error : function(err, req) {
				alert("Your browser broke!");
			}
		});
	});
	/* code to show & hide question and notes panel end here*/
	
	$("#CourseViewlectureForm").validate({
		rules:{
			'data[Course][heading]'	:{
				required     :  true
			},
			'data[Course][question]'	:{
				required     :  true
			}
		},
		messages:{
			'data[Course][heading]'	:{
				required     :  "Please enter heading.",
				letterssonly:   "Please enter letters only."
			},
			'data[Course][question]'	:{
				required     :  "Please enter question text.",
				letterssonly:   "Please enter letters only."
			}
		}
	});
	
	$("#CoursePromovideoForm").ajaxSubmit({
		success:function(response) {}
	});
	
	$("#CourseViewlectureForm").ajaxForm({
		beforeSubmit:function(){
				$(".all-btn").attr("disabled",true);
		},
		success: function(response) { // do some ui update .. 
			if(parseInt(response) == 1 || parseInt(response) == 2) {
				//alert("Sucessfully added");
				if(parseInt(response) == 1) {
					var type = "notes";
				} else {
					var type = "questions";
				}
				$(".notescont").hide();
				if(type == 'notes') {
					//$("#CourseNotes").attr("disabled","disabled");
					$("#CourseQuestion").attr("disabled","disabled");
					$("#CourseNotes").val('');
				} else {
					$("#CourseNotes").attr("disabled","disabled");
					$("#CourseQuestion").val('');
				}
				
				//$(".qstcont").hide();
				//$("#CourseQuestion").attr("disabled","disabled");
				//$("#CourseQuestion").val('');
				
				var str = $("#CourseViewlectureForm").serialize();
				$.ajax({
					url: BASE_URL+"courses/viewlisting",
					type: 'post',
					data  : "data="+str+"&type="+type, 
					success: function(html) {
						window.parent.location.reload();
						if(type == 'notes') {
							//$("#notescont").html(html);
						} else {
							//$("#questcontnew").html(html);
						}
					},
					error : function(err, req) {
						alert("Your browser broke!");
					}
				});
				
			} else {
				alert("Please enter valid data.");
			}
		}
    });
	
});


/*
 * @function name	: validatemultipleaction
 * @purpose			: validate if any checkbox checked before changing status or deleting with it also validate if there is any data to be prossesed or not
 * @arguments		: none
 * @return			: none 
 * @created by		: shivam sharma
 * @created on		: 10th oct 2012
 * @description		: NA
*/
	function validatemultipleaction(id){
		
		var count		= $(".chk:checked").length;
		var counter		= $(".chk").length;
		var PageOptions	= $(".options").val();
		var appmessage  = " "+count+" records?";
		if(PageOptions == ''){
			$("#checkerr").html(CHECKBLANKERROR);
			$("#checkerr").show();
			$(".options").focus();
			return false;
		}
		
		if(counter < 1){
			$("#checkerr").html(CHECKMULTIPLENONEERROR);
			$("#checkerr").show();
			return false;
		}
		
		if(count < 1){
			$("#checkerr").html(CHECKMULTIPLEERROR);
			$("#checkerr").show();
			return false;
		}
		
		
		
		if(PageOptions == 'Delete'){
			if(confirm(DELETEALERTMESSAGE+appmessage)){
				
			}else{
				return false;
			}
			
		}
		
		if(PageOptions == 'messagestatus' ){
			if( id == "MessageInboxForm") {
				if(confirm("Do you really want to move to trash "+appmessage)){
					
				}else{
					return false;
				}
			}
			if (id == "MessageTrashmessageForm") {
				if(confirm("Do you really want to restore "+appmessage)){
					
				} else{
					return false;
				}
			}
		}
			
		
		
		if(PageOptions == 'Active'){
			
			if(confirm(ACTIVEALERTMESSAGE+appmessage)){
				
			}else{
				return false;
			}
			
		}
		
		if(PageOptions == 'Inactive'){
			
			if(confirm(INACTIVEALERTMESSAGE+appmessage)){
				
			}else{
				return false;
			}
			
		}
	}
/*end here*/
/* function to remove white spaces from string or text */
function removeSpaces(string1) {
	if(string1 != '') {
		var val = string1.split(' ');
		val = val.join('')
		return val;
	}
}
/* end of function */


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,3}))$/;
    return re.test(email);
}


function refreshcurriculum() {
	var cid = $("#CourseId").val();
	$.ajax({
		url: BASE_URL+"courses/editcurriculumajax",
		type: 'post',
		data  : "courseid="+cid, 
		success: function(data) {
			$("#editcoursecon").html(data);
		},
		error : function(err, req) {
			alert("Your browser broke!");
		}
	});
}

function submitform() {
//	alert("here");
	$(function() {
		$("#CourseEditcurriculumForm").ajaxForm({
			type: "POST",
			url: BASE_URL+"courses/uploadvideofiles", 
			success: function(data) {
				console.log(data);
			}
		});
	});
}

		$(function() {
			var pull 		= $('#pull');
				menu 		= $('nav ul');
				menuHeight	= menu.height();

			$(pull).on('click', function(e) {
				e.preventDefault();
				menu.slideToggle();
			});

			$(window).resize(function(){
        		var w = $(window).width();
        		if(w > 320 && menu.is(':hidden')) {
        			menu.removeAttr('style');
        		}
    		});
		});


function in_array (needle, haystack, argStrict) {
  // http://kevin.vanzonneveld.net
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: vlado houba
  // +   input by: Billy
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
  // *     returns 1: true
  // *     example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
  // *     returns 2: false
  // *     example 3: in_array(1, ['1', '2', '3']);
  // *     returns 3: true
  // *     example 3: in_array(1, ['1', '2', '3'], false);
  // *     returns 3: true
  // *     example 4: in_array(1, ['1', '2', '3'], true);
  // *     returns 4: false
  var key = '',
    strict = !! argStrict;

  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}
