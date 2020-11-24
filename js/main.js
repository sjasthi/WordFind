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
            $('.rowLabel').removeClass('d-none');
        } else {
            $('.rowLabel').addClass('d-none');
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
    $("#copyMe").click(function() {
        $("html, body").scrollTop(0);
        html2canvas(document.querySelector("#puzzle"), {letterRendering:true, scrollX: -8, scrollY: -22}).then(canvas => canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})])));
    });

}); // end document ready