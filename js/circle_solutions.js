function circleAnswers(beginCoord, direction, length){
    
    $("table td[id=" +beginCoord+ "]").css('position', 'relative');

    var answer = $("<div></div>").text("");
    $(answer).addClass('solutionX');
    $(answer).addClass('border border-success');
    $(answer).css('position', 'absolute');
    $(answer).css("width", length);
    
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
            $(answer).css('transform-origin', '23.5px 24px');
            $(answer).css('-webkit-transform-origin', '23.5px 24px');
            $(answer).css('-ms-transform-origin', '23.5px 24px');
            $(answer).css('-o-transform-origin', '23.5px 24px');
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
            $(answer).css('transform-origin', '23.5px 25px');
            $(answer).css('-webkit-transform-origin', '23.5px 25px');
            $(answer).css('-ms-transform-origin', '23.5px 25px');
            $(answer).css('-o-transform-origin', '23.5px 25px');
    }
    $("table td[id*=" +beginCoord+ "]").append(answer);
}