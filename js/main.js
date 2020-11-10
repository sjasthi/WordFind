$(function(){

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
    $("#language").change(function(e){
        $('[name="filler_char_types"]').hide().prop('disabled', false);
        $('#' + e.target.value).show();
    });

    $("#controls input:checkbox").change(function(){
        $('#controls').submit();
    });

    // toggleBorders on table
    if($('#toggleBorders').prop('checked')){
        $('table tr td').css('border', '#000 solid 1px');
    } else {
        $('table tr td').css('border', '0');
    }

    $("#toggleBorders").click(function(){
        if($(this).prop('checked')){
            $('table tr td').css('border', '#000 solid 1px');
        } else {
            $('table tr td').css('border', '0');
        }
    });

    // toggleLabels on table
    if($('#toggleLabels').prop('checked')){
        $('.rowLabel').removeClass('d-none');
    } else {
        $('.rowLabel').addClass('d-none');
    }

    $("#toggleLabels").click(function(){
        if($(this).prop('checked')){
            $('.rowLabel').removeClass('d-none');
        } else {
            $('.rowLabel').addClass('d-none');
        }
    });

    // toggleAnswers on table
    if($('#toggleAnswers').prop('checked')){
        $('.solutionX').removeClass('d-none');
    } else {
        $('.solutionX').addClass('d-none');
    }

    $('#toggleAnswers').click(function(){
        if($(this).prop('checked')){
            $('.solutionX').removeClass('d-none');
        } else {
            $('.solutionX').addClass('d-none');
        }
    });

    // screenshot puzzle and display to user -allows for copy/paste of img
    $("#copyMe").click(function() {
        $("html, body").scrollTop(0);
        html2canvas(document.querySelector("#puzzle"), {scrollX: 0, scrollY: -22}).then(canvas => canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})])));
    });

    
    // if ($("table").length){
        
    //     // refresh page to get current cookie
    //     var url = window.location.href; // get the current url of page into variable
    //     {
    //     if (url.indexOf('?') > -1) { // url has a '?'
    //         if(url.indexOf('reloaded') < 0){ // url does not have the text 'reloaded'
    //                 url = url + "&reloaded=true"; // add the word 'reloaded' to url
    //                 window.location = url; // "reload" the page
    //         }
    //     }
    // }



        
    // }



});