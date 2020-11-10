

function circleAnswers(beginCoord, direction, length){

    // find max td width and make all tds same width
    // var maxWidth = -1;
    // $('table td').each(function() {
    //     maxWidth = Math.ceil(maxWidth > $(this).width()) ? maxWidth : Math.ceil($(this).width());
        $('table td').css('height', 50).css('width', 50);

    //     // cookie used in getSolutionLength() -functions.php
    //     document.cookie="width=" + maxWidth;

    // });

    var beginAnswer = $("table td[id=" + beginCoord + "]");
    $(beginAnswer).css('position', 'relative');
    var answer = $("<div></div>")
    $(answer).addClass('solutionX border border-primary');
    $(answer).css('position', 'absolute').css("width", length);
    
    switch(direction){
        case 0:
            $(answer).css("visibility", 'hidden');
            break;
        case 1:
            $(answer).css("msTransform", 'rotate(0deg)');
            $(answer).css("WebkitTransform", 'rotate(0deg)');
            $(answer).css('transform-origin', '24.5px 24.5px');
            $(answer).css('-webkit-transform-origin', '24.5px 24.5px');
            $(answer).css('-ms-transform-origin', '24.5px 24.5px');
            $(answer).css('-o-transform-origin', '24.5px 24.5px');
            break;
        case 2:
            $(answer).css("msTransform", 'rotate(180deg)');
            $(answer).css("WebkitTransform", 'rotate(180deg)');
            $(answer).css('transform-origin', '24.5px 24.5px');
            $(answer).css('-webkit-transform-origin', '24.5px 24.5px');
            $(answer).css('-ms-transform-origin', '24.5px 24.5px');
            $(answer).css('-o-transform-origin', '24.5px 24.5px');
            break;
        case 3:
            $(answer).css("msTransform", 'rotate(90deg)');
            $(answer).css("WebkitTransform", 'rotate(90deg)');
            $(answer).css('transform-origin', '24.5px 24.5px');
            $(answer).css('-webkit-transform-origin', '24.5px 24.5px');
            $(answer).css('-ms-transform-origin', '24.5px 24.5px');
            $(answer).css('-o-transform-origin', '24.5px 24.5px');
            break;
        case 4:
            $(answer).css("msTransform", 'rotate(270deg)');
            $(answer).css("WebkitTransform", 'rotate(270deg)');
            $(answer).css('transform-origin', '24.5px 24.5px');
            $(answer).css('-webkit-transform-origin', '24.5px 24.5px');
            $(answer).css('-ms-transform-origin', '24.5px 24.5px');
            $(answer).css('-o-transform-origin', '24.5px 24.5px');
            break;
        case 5:
            $(answer).css("msTransform", 'rotate(45deg)');
            $(answer).css("WebkitTransform", 'rotate(45deg)');
            $(answer).css('transform-origin', '23.5px 27px');
            $(answer).css('-webkit-transform-origin', '23.5px 27px');
            $(answer).css('-ms-transform-origin', '23.5px 27px');
            $(answer).css('-o-transform-origin', '23.5px 27px');
            break;
        case 6:
            $(answer).css("msTransform", 'rotate(225deg)');
            $(answer).css("WebkitTransform", 'rotate(225deg)');
            $(answer).css('transform-origin', '23.5px 24px');
            $(answer).css('-webkit-transform-origin', '23.5px 24px');
            $(answer).css('-ms-transform-origin', '23.5px 24px');
            $(answer).css('-o-transform-origin', '23.5px 24px');
            break;
        case 7:
            $(answer).css("msTransform", 'rotate(135deg)');
            $(answer).css("WebkitTransform", 'rotate(135deg)');
            $(answer).css('transform-origin', '23.5px 25px');
            $(answer).css('-webkit-transform-origin', '23.5px 25px');
            $(answer).css('-ms-transform-origin', '23.5px 25px');
            $(answer).css('-o-transform-origin', '23.5px 25px');
            break;
        case 8:
            $(answer).css("msTransform", 'rotate(315deg)');
            $(answer).css("WebkitTransform", 'rotate(315deg)');
            $(answer).css('transform-origin', '24.5px 23px');
            $(answer).css('-webkit-transform-origin', '24.5px 23px');
            $(answer).css('-ms-transform-origin', '24.5px 23px');
            $(answer).css('-o-transform-origin', '24.5px 23px');
    }
    $(beginAnswer).append(answer);
}

