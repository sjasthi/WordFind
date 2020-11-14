function highlightSolution(beginCoord, direction, length, language){

    var beginAnswer = $("table td[id=" + beginCoord + "]");
    $(beginAnswer).css('position', 'relative');
    var answer = $("<div></div>").addClass('solutionX border-primary').css('position', 'absolute').css("width", length);

    // transform origin
    var horizontalVertical = '24.5px 24.5px';
    var diagonalOne = '23.5px 27px';
    var diagonalTwo = '23.5px 24px';
    var diagonalThree = '23.5px 25px';
    var diagonalFour = '24.5px 23px';
    
    // make lines
    var lineWidth = length - 30;
    var lineLocation = 25;
    var td = $("table td");

    if(language != 'English'){
        td.css('height', '60px').css('min-width', '60px');
        var horizontalVertical = '29.5px 29.5px';

        var diagonalOne = '29.5px 33px';
        var diagonalTwo = '29.5px 30px';
        var diagonalThree = '29.5px 31px';
        var diagonalFour = '30.5px 29px';
        lineLocation = 30;
    }

    // $('.toggle-solution-options').change(function(){
    //     if($('#toggleSolutionCircles').prop('checked')){
    //         $(answer).css('border-radius', '20px');
    //     }
    //  });

    switch(direction){
        case 0:
            $(answer).css("visibility", 'hidden');
            break;
        case 1:
            $(answer).addClass('border-top');
            $(answer).css("msTransform", 'rotate(0deg)');
            $(answer).css("WebkitTransform", 'rotate(0deg)');
            $(answer).css('transform-origin', horizontalVertical);
            $(answer).css('-webkit-transform-origin', horizontalVertical);
            $(answer).css('-ms-transform-origin', horizontalVertical);
            $(answer).css('-o-transform-origin', horizontalVertical);
            $(answer).css('margin-top', lineLocation);
            $(answer).css('width', lineWidth);
            $(answer).css('margin-left', '15px');
            break;
        case 2:
            $(answer).addClass('border-bottom');
            $(answer).css("msTransform", 'rotate(180deg)');
            $(answer).css("WebkitTransform", 'rotate(180deg)');
            $(answer).css('transform-origin', horizontalVertical);
            $(answer).css('-webkit-transform-origin', horizontalVertical);
            $(answer).css('-ms-transform-origin', horizontalVertical);
            $(answer).css('-o-transform-origin', horizontalVertical);
            $(answer).css('margin-bottom', lineLocation);
            $(answer).css('width', lineWidth);
            $(answer).css('margin-left', '-15px');
            break;
        case 3:
            $(answer).addClass('border-top');
            $(answer).css("msTransform", 'rotate(90deg)');
            $(answer).css("WebkitTransform", 'rotate(90deg)');
            $(answer).css('transform-origin', horizontalVertical);
            $(answer).css('-webkit-transform-origin', horizontalVertical);
            $(answer).css('-ms-transform-origin', horizontalVertical);
            $(answer).css('-o-transform-origin', horizontalVertical);
            $(answer).css('margin-top', '15px');
            $(answer).css('width', lineWidth);
            $(answer).css('margin-left', -lineLocation + 1);
            break;
        case 4:
            $(answer).addClass('border-top');
            $(answer).css("msTransform", 'rotate(270deg)');
            $(answer).css("WebkitTransform", 'rotate(270deg)');
            $(answer).css('transform-origin', horizontalVertical);
            $(answer).css('-webkit-transform-origin', horizontalVertical);
            $(answer).css('-ms-transform-origin', horizontalVertical);
            $(answer).css('-o-transform-origin', horizontalVertical);
            $(answer).css('margin-top', '-15px');
            $(answer).css('width', lineWidth);
            $(answer).css('margin-left', lineLocation);
            break;
        case 5:
            $(answer).addClass('border-bottom');
            $(answer).css("msTransform", 'rotate(45deg)');
            $(answer).css("WebkitTransform", 'rotate(45deg)');
            $(answer).css('transform-origin', diagonalOne);
            $(answer).css('-webkit-transform-origin', diagonalOne);
            $(answer).css('-ms-transform-origin', diagonalOne);
            $(answer).css('-o-transform-origin', diagonalOne);
            $(answer).css('margin-left', lineLocation + 25);
            $(answer).css('margin-top', '-35px');
            $(answer).css('width', lineWidth + 5);
            break;
        case 6:
            $(answer).addClass('border-top');
            $(answer).css("msTransform", 'rotate(225deg)');
            $(answer).css("WebkitTransform", 'rotate(225deg)');
            $(answer).css('transform-origin', diagonalTwo);
            $(answer).css('-webkit-transform-origin', diagonalTwo);
            $(answer).css('-ms-transform-origin', diagonalTwo);
            $(answer).css('-o-transform-origin', diagonalTwo);
            $(answer).css('margin-left', lineLocation - 15);
            $(answer).css('margin-top', '-25px');
            $(answer).css('width', lineWidth + 5);
            break;
        case 7:
            $(answer).addClass('border-bottom');
            $(answer).css("msTransform", 'rotate(135deg)');
            $(answer).css("WebkitTransform", 'rotate(135deg)');
            $(answer).css('transform-origin', diagonalThree);
            $(answer).css('-webkit-transform-origin', diagonalThree);
            $(answer).css('-ms-transform-origin', diagonalThree);
            $(answer).css('-o-transform-origin', diagonalThree);
            if(language == 'English'){
                $(answer).css('margin-left', -lineLocation + 15);
                    $(answer).css('margin-bottom', '30px');
                    $(answer).css('width', lineWidth + 10);
            } else {
                $(answer).css('margin-left', -lineLocation + 25);
                $(answer).css('margin-bottom', '30px');
                $(answer).css('width', lineWidth + 20);
            }
            break;
        case 8:
            $(answer).addClass('border-bottom');
            $(answer).css("msTransform", 'rotate(315deg)');
            $(answer).css("WebkitTransform", 'rotate(315deg)');
            $(answer).css('transform-origin', diagonalFour);
            $(answer).css('-webkit-transform-origin', diagonalFour);
            $(answer).css('-ms-transform-origin', diagonalFour);
            $(answer).css('-o-transform-origin', diagonalFour);
            if(language == 'English'){
                $(answer).css('margin-left', lineLocation - 15);
                $(answer).css('margin-bottom', '30px');
                $(answer).css('width', lineWidth + 10);
            } else {
                $(answer).css('margin-left', lineLocation - 25);
                $(answer).css('margin-bottom', '35px');
                $(answer).css('width', lineWidth + 15);
            }
    }
    $(beginAnswer).append(answer);
}