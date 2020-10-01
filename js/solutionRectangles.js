var rectangles = [];
    // Browser configs
    var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0; var isFirefox = typeof InstallTrigger !== 'undefined';
    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    var isChrome = !!window.chrome && !isOpera;
    var isIE = /*@cc_on!@*/!!document.documentMode;

    function getPosition(element) {
        var xPosition = 0;
        var yPosition = 0;
        while (element) {
            xPosition += (element.offsetLeft + element.clientLeft);
            yPosition += (element.offsetTop + element.clientTop);
            element = element.offsetParent;
        }
        console.log(' Left: ' + xPosition + ' Top: ' + yPosition);
        return {x: xPosition, y: yPosition};
    }

    function changeCSS(element, elementRef, direction, length) {
        var myElementRef = document.getElementById(elementRef);
        var position = getPosition(document.getElementById(elementRef));
        var myElement = document.getElementById(element);
        document.getElementById(element).style.position = 'absolute';
        document.getElementById(element).style.left = position.x +'px';
        document.getElementById(element).style.top = position.y +'px';
        document.getElementById(element).style.width = length +'px';
        switch (direction) {
            case 0:
                document.getElementById(element).style.visibility = 'hidden';
                break;
            case 1:
                document.getElementById(element).style.msTransform = 'rotate(0deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(0deg)';
                break;
            case 2:
                document.getElementById(element).style.msTransform = 'rotate(180deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(180deg)';
                break;
            case 3:
                document.getElementById(element).style.msTransform = 'rotate(90deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(90deg)';
                break;
            case 4:
                document.getElementById(element).style.msTransform = 'rotate(270deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(270deg)';
                break;
            case 5:
                document.getElementById(element).style.msTransform = 'rotate(45deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform= 'rotate(45deg)';
                break;
            case 6:
                document.getElementById(element).style.msTransform = 'rotate(225deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(225deg)';
                break;
            case 7:
                document.getElementById(element).style.msTransform = 'rotate(135deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(135deg)';
                break;
            case 8:
                document.getElementById(element).style.msTransform = 'rotate(315deg)'; /* IE 9 */
                document.getElementById(element).style.WebkitTransform = 'rotate(315deg)';
        }
    }

    function updateCSS(){
        console.log ('ZOOM');
        for (var i=0; i < rectangles.length; i++) {
            console.log(rectangles[i]);
            var element = rectangles[i][0];
            var elementRef = rectangles[i][1];
            var direction = rectangles[i][2];
            var length = rectangles[i][3];
            var myElementRef = document.getElementById(elementRef);
            var position = getPosition(myElementRef);
            var myElement = document.getElementById(element);

            document.getElementById(element).style.position = 'absolute';
            document.getElementById(element).style.left = position.x +'px';
            document.getElementById(element).style.top = position.y +'px';
            document.getElementById(element).style.width = length +'px';
        }

    }

    function showSolution() {
        document.getElementById('answer').style.visibility = 'visible';
        var els = document.getElementsByClassName('rectangle');
        for (var i = 0, len = els.length; i < len; ++i) {
            els[i].style.visibility = 'visible';
        }
    }
	 function changeTest(obj){
        	var option = document.getElementById(obj).value;
		alert(obj.options[obj.selectedIndex].value);
  }