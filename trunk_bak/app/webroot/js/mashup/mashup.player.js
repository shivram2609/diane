var rndrdImgPnlDiv1 = "renderedImgPnlDiv1", prviwImgDivId = "prviewSlctdImgDiv", prevCnt1 = 0, UprPnlTtlFitdImgs = UprPnlTtlFitdImgsTmp = 5, UprPnlTtlFitdImgsFs = 13, UprPnlTtlImgs = mrkdMshupPontsSize = mshupPontsFlg = 0, lastSlctdArrIndx = '', rendrdImgWdthUprPnl = 80, rendrdImgHeightUprPnl = 80, rendrdImgsUprPnlMrgn = 15, mashupXmlUrl;

var PRVIEW_IMG_DIV_WDTH = "43%", PRVIEW_IMG_DIV_HEGHT = "320", PRVIEW_IMG_DIV_WDTH_FS = "43%", PRVIEW_IMG_DIV_HEGHT_FS = "70%";

VID_PLYR_FS_WDTH = "50%", VID_PLYR_FS_HEGHT = "77%"; //overriding video player fullscreen width*height values

var loadMashupImages = function() {
    $.ajax({
        type: "GET",
        url: mashupXmlUrl,
        success: function(xml) {
            $(xml).find("images").children("image").each(function() {
                $("#renderedImgUl-1").append('<li id="selectedImgLi_' + UprPnlTtlImgs + '" class="selectedImgsLi"><img src="' + $(this).children("source").text() + '" alt="' + UprPnlTtlImgs + '" class="selectedImgs" width="' + rendrdImgWdthUprPnl + '" height="' + rendrdImgHeightUprPnl + '" /></li>');
                mrkdMshupPonts[UprPnlTtlImgs] = [$(this).children("source").text(), $(this).children("name").text(), $(this).children("start").text(), $(this).children("end").text()];
                UprPnlTtlImgs++;
            });
            mrkdMshupPontsSize = Array.size(mrkdMshupPonts);
            UprPnlTtlFitdImgs = parseInt(parseInt($("#" + rndrdImgPnlDiv1).css("width")) / (parseInt(rendrdImgWdthUprPnl) + rendrdImgsUprPnlMrgn));
            lodImgsProcesing("renderedImgUl-1", "slctdImgsLoding");
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
    mshupPontsFlg = 1;
    for (var i = 0; i < mrkdMshupPontsSize; i++) {
        if (parseInt($vid[0].currentTime) >= mrkdMshupPonts[i][2] && parseInt($vid[0].currentTime) <= mrkdMshupPonts[i][3]) {
            if (lastSlctdArrIndx.length == 0 || lastSlctdArrIndx != i) { //current values should not equals to the last value 
                $("#selectedImgLi_" + lastSlctdArrIndx).css('border', '1px solid #FF0000');
                $("#selectedImgLi_" + i).css('border', '1px solid #008000');
                $("#prviewSlctdImgDiv").html('<img src="' + mrkdMshupPonts[i][0] + '" alt="' + mrkdMshupPonts[i] + '" id="mashupImgPreview" width="100%" height="100%" />');
                lastSlctdArrIndx = i;
                if ($("#selectedImgLi_" + i).position().left > parseInt($("#" + rndrdImgPnlDiv1).css("width"))) { //if selected document is not visible then auto slide div
                    var totalClick = UprPnlTtlImgs - UprPnlTtlFitdImgs - prevCnt1
                    totalClick = (totalClick > UprPnlTtlFitdImgs) ? UprPnlTtlFitdImgs : totalClick;
                    $('#renderedImgUl-1').animate({
                        opacity: 1,
                        left: '-=' + (parseInt(rendrdImgWdthUprPnl) + rendrdImgsUprPnlMrgn)*totalClick //scroll slider according to the numbr of images left
                    }, 300, function() {
                        $('#renderedImgUl-1').css('left', '0px');
                    });
                    for (var j = 0; j < totalClick; j++) { //shift the div's accordingly
                        var a = $('#renderedImgUl-1 li:first-child');
                        $('#renderedImgUl-1').append(a);
                        prevCnt1++;
                    }
                }
            }
            mshupPontsFlg = 0;
            return false;
        }
    }
    if (mshupPontsFlg) {
        $("#prviewSlctdImgDiv").html('');
        $(".selectedImgsLi").css('border', '1px solid #FF0000');
    }
    if ($vid[0].currentTime == $vid[0].duration) { //when current time reached on total duration then   
        $vid.unbind('click'); //unbind click event from video box
        $playBtn.css('background', "url(" + IMAGES_PATH + "play_button_2.png) no-repeat"); //change playbtn icon
        $vidCntrPly.css('background', "url(" + IMAGES_PATH + "reload.png) no-repeat scroll center"); //change playbtn icon
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
                left: '-=' + (parseInt(rendrdImgWdthUprPnl) + rendrdImgsUprPnlMrgn)
            }, 300, function() {
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
                left: '+=' + (parseInt(rendrdImgWdthUprPnl) + rendrdImgsUprPnlMrgn)
            }, 300, function() {
                $('#renderedImgUl-1').css('left', '0px');
                $('#renderedImgUl-1').prepend(a);
            });
            prevCnt1--;
        }
    });

    $(".selectedImgs").live("click", function(e) {
        e.preventDefault();
        $("#prviewSlctdImgDiv").html('<img src="' + $(this).attr('src') + '" alt="' + $(this).attr('alt') + '" id="mashupImgPreview" width="100%" height="100%" />');
        $vid[0].currentTime = mrkdMshupPonts[$(this).attr('alt')][2]
    });
});
