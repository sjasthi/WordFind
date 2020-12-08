$(function(){ // docuemnt ready

    // hide alert when x is clicked
    // bootstrap data-dismiss does not allow alert to come back after being dismissed
    // this is the work around
    $(function(){
        $("[data-hide]").on("click", function(){
            $(this).closest("." + $(this).attr("data-hide")).hide();
        });
    });

    // register
    $('#register').click(function(e){
        e.preventDefault();
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var email = $('#registerEmail').val();
        var password = $('#registerPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        var error = false;

        if(firstName == ""){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Enter your first name');
        } else if (lastName == ""){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Enter your last name');
        } else if (email == ""){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Enter your email');
        } else if (email.indexOf("@") < 0 || email.indexOf(".") < 0){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Invalid email');
        } else if (password == ""){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Enter your password');
        } else if (!(password.length >= 5 && password.length <= 16)) {
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Password must be between 5 and 16 characters!');
        } else if (confirmPassword == ""){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Confirm your password');
        } else if (password != confirmPassword){
            error = true;
            $('#registerAlert').show();
            $('#registerAlert span').first().text('Password do not match!');
        }

        if(error == false){
            $.ajax({
                method: 'POST',
                data: {
                    register: 1,
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    password: password
                },
                success: function(response){
                    if(response.indexOf('registered') >= 0){
                        $('#registerModal').modal('toggle');
                        $("#loginBtn" ).trigger( "click" );
                        $('#loginAlert').removeClass('alert-danger');
                        $('#loginAlert').addClass('alert-success');
                        $('#loginAlert').show();
                        $('#loginAlert span').first().text(response);
                    } else {
                        $('#registerAlert').show();
                        $('#registerAlert span').first().text(response);
                    }
                },
                dataType: 'text'
            });
        }
    });

    // login
    $('#login').click(function(e){
        e.preventDefault();
        var email = $('#loginEmail').val();
        var password = $('#loginPassword').val();
        var error = false;

        if(email == ""){
            error = true;
            $('#loginAlert').show();
            $('#loginAlert span').first().text('Enter your email');
        }

        if(password == ""){
            error = true;
            $('#loginAlert').show();
            $('#loginAlert span').first().text('Enter your password');
        }

        if(email == "" && password == ""){
            error = true;
            $('#loginAlert').show();
            $('#loginAlert span').first().text('Enter your email and password');
        }

        if(error == false){
            $.ajax({
                method: 'POST',
                data: {
                    login: 1,
                    email: email,
                    password: password
                },
                success: function(response){
                    if(response.indexOf('success') >= 0){
                        window.location = window.location.href;
                    } else {
                        $('#loginAlert').show();
                        $('#loginAlert span').first().text(response);
                    }
                },
                dataType: 'text'
            });
        }
    });

    // disable search btn if input is empty
    $('#search button').prop('disabled',true);
    $('#search input[type="search"]').keyup(function(){
        $('#search button').prop('disabled', this.value == "" ? true : false);
        // disable search btn if the x is clicked 
        document.querySelector("#search input[type='search']").addEventListener("search", function(event) {
            $('#search button').prop('disabled', this.value == "" ? true : false);
          });
    });

    // Change Filler Character Types Dropdown on Language Dropdown Event Change
    $('#language').change(function () {
        if($("#language").val() == 'English'){
            $("#fillerCharTypes option[value='VM']").hide().prop('disabled', false);
            $("#fillerCharTypes option[value='SCB']").hide().prop('disabled', false);
            $("#fillerCharTypes option[value='DCB']").hide().prop('disabled', false);
            $("#fillerCharTypes option[value='TCB']").hide().prop('disabled', false);
            $("#fillerCharTypes option[value='CBV']").hide().prop('disabled', false);
        } else {
            $("#fillerCharTypes option[value='VM']").show();
            $("#fillerCharTypes option[value='SCB']").show();
            $("#fillerCharTypes option[value='DCB']").show();
            $("#fillerCharTypes option[value='TCB']").show();
            $("#fillerCharTypes option[value='CBV']").show();
        }
    }).trigger('change');
    
    // toggle controls
    $("#controls input:checkbox").change(function(){
        $('#controls').submit();
    });

    // toggleBorders on table
    toggleBorders();
    $("#toggleBorders").click(toggleBorders);
    function toggleBorders(){
        if($('#toggleBorders').prop('checked')){
            $('table tr td').css('border', '#000 solid 1px');
        } else {
            $('table tr td').css('border', '0');
        }
    }

    // toggleLabels on table
    toggleLables();
    $("#toggleLabels").click(toggleLables);
    function toggleLables(){
        if($('#toggleLabels').prop('checked')){
            $('.row-label').removeClass('d-none');
        } else {
            $('.row-label').addClass('d-none');
        }
    }

    // toggleSolutionLines on table
    toggleSolutionLines();
    $("#toggleSolutionLines").click(toggleSolutionLines);
    function toggleSolutionLines(){
        if($('#toggleSolutionLines').prop('checked')){
            $('.solutionX').removeClass('d-none');
        } else {
            $('.solutionX').addClass('d-none');
        }
    }

    // toggleWordList
    toggleWordList();
    $("#toggleWordList").click(toggleWordList);
    function toggleWordList(){
        if($('#toggleWordList').prop('checked')){
            $('.word-list').removeClass('d-none');
            $("label[for='toggleWordList']").text("Hide");
        } else {
            $('.word-list').addClass('d-none');
            $("label[for='toggleWordList']").text("Show");
        }
    }

    // screenshot puzzle and display to user -allows for copy/paste of img
    $("#copyMe").click(function(){
        $("html, body").scrollTop(0);
        html2canvas(document.querySelector("#puzzle"), {letterRendering:true, scrollX: 0, scrollY: -3}).then(canvas => canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})])));
    });

    // gameMode
    $("#play").click(toggleGameMode);
    function toggleGameMode(){
        if($(this).text() == "Play"){
            // disable showSolution
            $(".solutionX").remove();
            $('#toggleSolutionLines').prop('checked', false).prop('disabled', true);
            $('#edit').prop('disabled', true);
            $('#delete').prop('disabled', true);
            $('#copyMe').prop('disabled', true);
            $('#play').removeClass('btn-outline-primary').addClass('btn-danger').text('STOP');
            playGame();
        } else {
            location.reload();
        }
    }

    function playGame(){

        // set data-word attr from charbank array w/ no spaces
        $("#bank span").each(function(i){
            $(this).attr('data-word', charBank[i]);
        });

        var colNumber = $('.bg-success .row-label').length - 1;
        if(colNumber >= 16){
            $("#puzzle td").css('height', '39px').css('min-width', '39px').css('font-size', '22px');
        }
        
        $('#gameInstructions').show();
        $("#controlBtns").prepend("<span id=timer><span id=hr>00</span>:<span id=mins>00</span>:<span id=secs class=mr-2>00</span></span>");
        $("#controls").removeAttr('id');
        $("#puzzle").css('user-select', 'none');
        $("#puzzle").css('border-collapse', 'unset').css('border-spacing', '10px');
        var timerVar = setInterval(countTimer, 1000);
        var selectedWord = [];
        var mouseDown = false;
        var mouseOver = false;
        gameMode = true;

        $("#puzzle .char").mousedown(function(e){
            e.preventDefault();
            if(gameMode){
                $(this).addClass('bg-secondary');
                selectedWord.push($(this).html());
                mouseDown = true;
            }
            
        }).mouseover(function(){
            if(mouseDown){
                mouseOver = true
                $(this).addClass('bg-secondary');
                selectedWord.push($(this).html());
            }
        }).mouseup(function(){
            mouseDown = false;
            if(mouseOver){
               selectWord();
            }
        });
        
        $(document).keydown(function(e){
            if(e.keyCode == 16){
                selectWord();
            }
        });
        
        // user released mouse outside of puzzle
        $(document).mouseup(function(e){
            if(!$("#puzzle .char").is(e.target) && mouseDown){
                selectWord();
            }
        });

        function selectWord(){
            var selectedWordReversed = selectedWord.slice().reverse();
            var counter = 0;
                $("#words span").each(function(key, item){
                    if(selectedWord == $(item).data('word') || selectedWordReversed == $(item).data('word')){
                        $(".bg-secondary").removeClass("bg-secondary").addClass("bg-warning");
                        $(this).addClass('strike');
                        if($(".strike").length != charBank.length){
                            new Audio('audio/correct.mp3').play();
                            mouseDown = false;
                            counter++
                        }
                    }
                
                    // game won
                    if($(".strike").length == charBank.length){
                        $("#words").empty().append("<span id=message>You win! You found every word!!</span>");
                        $('#play').removeClass('btn-danger').addClass('btn-primary').text('Reset');
                        clearInterval(timerVar);
                        $("table").css('cursor', 'default');
                        new Audio('audio/win.mp3').play();
                        gameMode = false;
                    }                        
                });
                
            if(counter != 1 && gameMode){
                new Audio('audio/wrong.mp3').play();
            }
            selectedWord = [];
            mouseOver = false;
            $(".bg-secondary").removeClass("bg-secondary");
        }

    var totalSeconds = 0;
    function countTimer(){
        ++totalSeconds;
        var hour = Math.floor(totalSeconds / 3600);
        var minute = Math.floor((totalSeconds - hour * 3600) / 60);
        var seconds = totalSeconds - (hour*3600 + minute * 60);
        if(hour < 10)
            hour = "0" + hour;
        if(minute < 10)
            minute = "0" + minute;
        if(seconds < 10)
            seconds = "0" + seconds;
        $("#hr").text(hour);
        $("#mins").text(minute);
        $("#secs").text(seconds);
    }
}

}); // end document ready