var rndrdImgPnlDiv1 = "renderedImgPnlDiv1", rndrdImgPnlDiv2 = "renderedImgPnlDiv2", prviwImgDivId = "prviewSlctdImgDiv", prevCnt1 = prevCnt2 = 0, lwrPnlTtlFitdImgs = 4, UprPnlTtlFitdImgs = UprPnlTtlFitdImgsTmp = 4, UprPnlTtlFitdImgsFs = 13, lwrPnlTtlImgs = UprPnlTtlImgs = 0, rendrdImgWdthLwrPnl = rendrdImgHeightLwrPnl = 90, rendrdImgsLwrPnlMrgn = 15, rendrdImgWdthUprPnl = rendrdImgHeightUprPnl = 80, rendrdImgsUprPnlMrgn = 15, mshupArrIndx = mrkdMshupPontsSize = 0, mshupStrtTime = 0;
var PRVIEW_IMG_DIV_WDTH = "43%", PRVIEW_IMG_DIV_HEGHT = "200", PRVIEW_IMG_DIV_WDTH_FS = "43%", PRVIEW_IMG_DIV_HEGHT_FS = "70%";

VID_PLYR_FS_WDTH = "50%", VID_PLYR_FS_HEGHT = "77%", VID_OTR_BX_WDTH = "495px",SEEKBAR_OUTR_WIDTH = 20, SEEKBAR_OUTR_WIDTH_FS = 72; //overriding video player fullscreen width*height values


var loadMashupImages = function() {
    $.ajax({
        type: "GET",
        url: mashupImagesXmlUrl,
        dataType: "xml",
        success: function(xml) {
            $(xml).find("images").children("image").each(function() {
                $("#renderedImgUl-2").append('<li id="renderedImgLi_' + lwrPnlTtlImgs + '" class="renderedImgLi"><img src="' + $(this).children("source").text() + '" alt="' + $(this).children("name").text() + '" class="renderedImgs" width="' + rendrdImgWdthLwrPnl + '" height="' + rendrdImgHeightLwrPnl + '" /></li>');
                lwrPnlTtlImgs++;
            });
            lodImgsProcesing("renderedImgUl-2", "renderedImgsLoding");
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError);
        }
    });
};

//Seek bar update method
var seekBarUpdate = function() {
    if (!seekSliding) {
        $seekSlider.slider("value", $vid[0].currentTime); //update seek bar slider value
    }
    var curmins = Math.floor($vid[0].currentTime / 60);
    var cursecs = Math.floor($vid[0].currentTime - curmins * 60);
    var durmins = Math.floor($vid[0].duration / 60);
    var dursecs = Math.floor($vid[0].duration - durmins * 60);
    cursecs = cursecs < 10 ? "0" + cursecs : cursecs;
    dursecs = dursecs < 10 ? "0" + dursecs : dursecs;
    curmins = curmins < 10 ? "0" + curmins : curmins;
    durmins = durmins < 10 ? "0" + durmins : durmins;
    $curTimeTxt.html(curmins + ":" + cursecs); //Update current time div
    $durTimeTxt.html(durmins + ":" + dursecs); //Fill total duration time div
    if ($vid[0].currentTime == $vid[0].duration) { //when current time reached on total duration then   
        $vid.unbind('click'); //unbind click event from video box
        $playBtn.css('background', "url(" + IMAGES_PATH + "play_button_2.png)no-repeat"); //change playbtn icon
        $vidCntrPly.css('background', "url(" + IMAGES_PATH + "reload.png) no-repeat scroll center center"); //change playbtn icon
        $vidCntrPly.show(); //Display center play icon
    }
};


$(document).ready(function() {
    $("#nextUpr").click(function(e) {
        e.preventDefault();
        if (UprPnlTtlImgs > UprPnlTtlFitdImgs && (UprPnlTtlImgs - UprPnlTtlFitdImgs) > prevCnt1) {
            var a = $('#renderedImgUl-1 li:first-child');
            $('#renderedImgUl-1').animate({
                opacity: 1,
                left: '-=115'
            }, 500, function() {
                $('#renderedImgUl-1').css('left', '0px');
                $('#renderedImgUl-1').append(a);
            });
            prevCnt1++;
        }
    });
    $("#prevUpr").click(function(e) {
        e.preventDefault();
        if (prevCnt1) {
            var a = $('#renderedImgUl-1 li:last-child');
            $('#renderedImgUl-1').animate({
                opacity: 1,
                left: '+=115'
            }, 500, function() {
                $('#renderedImgUl-1').css('left', '0px');
                $('#renderedImgUl-1').prepend(a);
            });
            prevCnt1--;
        }
    });
    $("#nextLwr").click(function(e) {
        e.preventDefault();
        if (lwrPnlTtlImgs > lwrPnlTtlFitdImgs && (lwrPnlTtlImgs - lwrPnlTtlFitdImgs) > prevCnt2) {
            var a = $('#renderedImgUl-2 li:first-child');
            $('#renderedImgUl-2').animate({
                opacity: 1,
                left: '-=115'
            }, 500, function() {
                $('#renderedImgUl-2').css('left', '0px');
                $('#renderedImgUl-2').append(a);
            });
            prevCnt2++;
        }
    });

    $("#prevLwr").click(function(e) {
        e.preventDefault();
        if (prevCnt2) {
            var a = $('#renderedImgUl-2 li:last-child');
            $('#renderedImgUl-2').animate({
                opacity: 1,
                left: '+=115'
            }, 500, function() {
                $('#renderedImgUl-2').css('left', '0px');
                $('#renderedImgUl-2').prepend(a);
            });
            prevCnt2--;
        }
    });

    $(".renderedImgs").die("click").live("click", function(e) {
        e.preventDefault();
        if (parseInt($vid[0].currentTime) > 0 && mshupStrtTime != parseInt($vid[0].currentTime)) {
            $("#renderedImgUl-1").append('<li id="selectedImgLi_' + mshupArrIndx + '" class="selectedImgsLi"><img src="' + $(this).attr('src') + '" alt="' + mshupArrIndx + '" class="selectedImgs" width="' + rendrdImgWdthUprPnl + '" height="' + rendrdImgHeightUprPnl + '" /></li>');
            mrkdMshupPontsSize = Array.size(mrkdMshupPonts);
            mshupStrtTime = 0;
            for (var i = 0; i < mshupArrIndx; i++) {
                if (typeof mrkdMshupPonts[i] !== "undefined" && mrkdMshupPonts[i][2] < parseInt($vid[0].currentTime) && mrkdMshupPonts[i][2] > mshupStrtTime) {
                    mshupStrtTime = mrkdMshupPonts[i][2];
                }
            }
            mshupStrtTime = (mshupStrtTime == 0 ? mshupStrtTime : mshupStrtTime + 1);
            for (var i = 0; i < mshupArrIndx; i++) {
                if (typeof mrkdMshupPonts[i] !== "undefined" && mrkdMshupPonts[i][1] == mshupStrtTime) {
                    mrkdMshupPonts[i][1] = parseInt($vid[0].currentTime) + 1;
                }
            }
            mrkdMshupPonts[mshupArrIndx] = [$(this).attr('alt'), mshupStrtTime, parseInt($vid[0].currentTime)];
            console.log(mrkdMshupPonts[mshupArrIndx]+', array-index : '+mshupArrIndx);
            UprPnlTtlImgs++;
            mshupArrIndx++;
        }
    });

    $(".selectedImgs").live("click", function(e) {
        e.preventDefault();
        $("#prviewSlctdImgDiv").html('<a href="javascript:void(0);" val="' + $(this).attr('alt') + '" class="imgPrviwDelLnk" id="mshupImgPrviwDelLnk" style="position:absolute;">del</a><img src="' + $(this).attr('src') + '" alt="' + $(this).attr('alt') + '" id="mashupImgPreview" width="100%" height="100%" />');
        $vid[0].currentTime = mrkdMshupPonts[$(this).attr('alt')][1]
    });

    $("#mshupImgPrviwDelLnk").live("click", function(e) {
        e.preventDefault();
        delete mrkdMshupPonts[$(this).attr('val')];
        $("#selectedImgLi_" + $(this).attr('val')).remove();
        $("#prviewSlctdImgDiv").html('');
        UprPnlTtlImgs--;
    });

    $(".mashup_action_button").click(function(e) {
        e.preventDefault();
        var args = $(this).val();
        $.ajax({
            url: BASE_URL + "courses/generateMashupXml",
            type: 'post',
            dataType: "json",
            data: {data: mrkdMshupPonts, videoName: mashupVideoName, docName: mashupDocName},
            success: function(resp1) {
                if (resp1['error'] == "false") {
                    if (args == "Preview") {
                        //window.open(BASE_URL + "courses/mashupPreview", "height=800,width=900");
                        window.open(BASE_URL + "courses/mashupPreview", '_blank');
                    } else {
                        window.location.href = BASE_URL + "courses/createMashup";
                    }
                } else {
                    alert(resp1['error']);
                    return false;
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });

});
