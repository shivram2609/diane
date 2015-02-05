$(document).ready(function(){
	
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
			refreshcurriculum();
		}
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
	/* code to view post add preview quiz end here*/
});
