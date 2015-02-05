var mashupVideoUrl = "";
var mashupImagesXmlUrl = "";
var mashupDocName = "";
var mashupVideoName = "";
var uploadMashupPdfProcessing = "It will take some time, please wait...";
var uploadMashupVideoProcessing = "Your video is uploading, please wait...";
function uploadMashupPdfProcessingMsg(id) {
    if ($('#pdf_uploading_status_msg_' + id).html() == "processing file...") {
        $('#pdf_uploading_status_msg_' + id).html(uploadMashupPdfProcessing);
    } else if ($('#pdf_uploading_status_msg_' + id).html() == uploadMashupPdfProcessing) {
        $('#pdf_uploading_status_msg_' + id).html('we really appreciate your patience... ');
    } else {
        $('#pdf_uploading_status_msg_' + id).html(uploadMashupPdfProcessing);
    }
    $('#pdf_uploading_status_msg_' + id).show('slow');
}
function uploadMashupVideoProcessingMsg(id) {
    if ($('#video_uploading_status_msg_' + id).html() == "uploading...") {
        $('#video_uploading_status_msg_' + id).html(uploadMashupVideoProcessing);
    } else if ($('#video_uploading_status_msg_' + id).html() == uploadMashupVideoProcessing) {
        $('#video_uploading_status_msg_' + id).html('we really appreciate your patience... ');
    } else {
        $('#video_uploading_status_msg_' + id).html(uploadMashupVideoProcessing);
    }
    $('#video_uploading_status_msg_' + id).show('slow');
}
$(document).ready(function() {
    /* method for uploading pdf file while creating mashup */
    $('.upload_mashup_pdf').die('click').live('click', function(e) {
        e.preventDefault();
        var ids = $(this).attr('id').split('_');
        var vals = $('#CourseMashupPdf' + ids[3]).val();
        if (vals.length == 0) {
            var responseMessage = ["Please select pdf file"];
            $('body').showMessage({thisMessage: responseMessage, zIndex: 99999, color: '#050304', className: 'fail'});
            setTimeout(function() {
                $('#show_pretty_message_close_link').click();
            }, 5000);
            return false;
        }
        $('#pdf_uploading_fade_span_' + ids[3]).show('slow');
        $('#pdf_uploading_status_msg_' + ids[3]).html('uploading document...');
        $("input").attr('disabled', 'disabled');
        $("#CourseMashupPdf" + ids[3]).removeAttr('disabled');
        $("#CourseEditcurriculumForm").ajaxSubmit({
            url: BASE_URL + "courses/uploadMashupPdf",
            type: 'post',
            dataType: "json",
            async: false,
            success: function(resp1, statusText, xhr) {
                if (resp1['error'] == 'false') {
                    var interval_1 = setInterval(function() {
                        uploadMashupPdfProcessingMsg(ids[3])
                    }, 10000);
                    mashupDocName = resp1['fileName'];
                    $('#pdf_uploading_status_msg_' + ids[3]).html('processing file...');
                    $.ajax({
                        url: BASE_URL + "courses/generateImagesFromPdf",
                        type: 'post',
                        dataType: "json",
                        data: 'fileName=' + resp1['fileName'],
                        success: function(resp2) {
                            clearInterval(interval_1);
                            if (resp2['error'] == 'false') {
                                mashupImagesXmlUrl = resp2['imagesXml'];
                                $.ajax({
                                    url: BASE_URL + "courses/mashupDocPreviewer",
                                    type: 'post',
                                    data: 'docXml=' + mashupImagesXmlUrl + "&uniqueId=" + ids[3],
                                    success: function(resp3) {
                                        $('#pdf_uploading_status_msg_' + ids[3]).html(resp3);
                                        $('#pdf_uploading_fade_span_' + ids[3]).hide('slow');
                                    }
                                });
                            } else {
                                $('#pdf_uploading_status_msg_' + ids[3]).html(resp2['error']);
                                $('#pdf_uploading_fade_span_' + ids[3]).hide('slow');
                            }
                        }
                    });
                } else {
                    $('#pdf_uploading_status_msg_' + ids[3]).html(resp1['error']);
                    $('#pdf_uploading_fade_span_' + ids[3]).hide('slow');
                }
                $("input").removeAttr('disabled');
            }
        });
    });
    /* end here */


    /* method for uploading pdf file while creating mashup */
    $('.upload_mashup_video').die('click').live('click', function(e) {
        e.preventDefault();
        var ids = $(this).attr('id').split('_');
        var vals = $('#CourseMashupVideo' + ids[3]).val();
        if (vals.length == 0) {
            var responseMessage = ["Please select video file"];
            $('body').showMessage({thisMessage: responseMessage, zIndex: 99999, className: 'fail'});
            setTimeout(function() {
                $('#show_pretty_message_close_link').click();
            }, 5000);
            return false;
        }
        var interval_2 = setInterval(function() {
            uploadMashupVideoProcessingMsg(ids[3])
        }, 10000);
        $("#CourseEditcurriculumForm :input").attr('disabled', true);
        $("#CourseMashupVideo" + ids[3]).removeAttr('disabled');
        $('#video_uploading_fade_span_' + ids[3]).show('slow');
        $('#video_uploading_status_msg_' + ids[3]).html('uploading...');
        $("#CourseEditcurriculumForm").ajaxSubmit({
            url: BASE_URL + "courses/uploadMashupVideo",
            type: 'post',
            dataType: "json",
            async: false,
            success: function(resp1, statusText, xhr) {
                clearInterval(interval_2);
                if (resp1['error'] == 'false') {
                    mashupVideoUrl = resp1['fileUrl'];
                    mashupVideoName = resp1['fileName'];
                    $.ajax({
                        url: BASE_URL + "courses/mashupVideoPlayer",
                        type: 'post',
                        data: 'mashupVideo=' + mashupVideoName + "&uniqueId=" + ids[3],
                        success: function(resp2) {
                            $('#video_uploading_status_msg_' + ids[3]).html(resp2);
                            $('#video_uploading_fade_span_' + ids[3]).hide('slow');
                        }
                    });
                } else {
                    $('#video_uploading_status_msg_' + ids[3]).html(resp1['error']);
                    $('#video_uploading_fade_span_' + ids[3]).hide('slow');
                }
                $("input").removeAttr('disabled');
                $("#CourseEditcurriculumForm :input").attr('disabled', false);
            }
        });
    });

    /* method for displayig mashup maker */
    $('.merge_video_pdf_link').die('click').live('click', function(e) {
        e.preventDefault();
        if (mashupVideoUrl == '' || mashupImagesXmlUrl == '') {
            var responseMessage = ["Please upload video and pdf files"];
            $('body').showMessage({thisMessage: responseMessage, zIndex: 99999, color: '#050304', className: 'fail'});
            setTimeout(function() {
                $('#show_pretty_message_close_link').click();
            }, 5000);
            return false;
        }
        var ids = $(this).attr('id').split('_');
        $('#mashup_maker_processing_span_' + ids[4]).show('slow');
        $.ajax({
            url: BASE_URL + "courses/mashupMaker/" + mashupVideoName + '/' + ids[4],
            type: 'get',
            success: function(resp1) {
                $('#mashup_maker_span_' + ids[4]).html(resp1);
                $('#mashup_maker_span_' + ids[4]).show('slow');
                $('#mashup_maker_span_' + ids[4]).css('display', 'inline-block');
                $('#mashup_maker_processing_span_' + ids[4]).hide('slow');
            }
        });
    });

});
