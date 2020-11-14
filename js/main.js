$(function(){ // docuemnt ready

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

    // // toggleSolutionLines on table
    toggleSolutionLines();
    $("#toggleSolutionLines").click(toggleSolutionLines);
    function toggleSolutionLines(){
        if($('#toggleSolutionLines').prop('checked')){
            $('.solutionX').removeClass('d-none');
        } else {
            $('.solutionX').addClass('d-none');
        }
    }

    // screenshot puzzle and display to user -allows for copy/paste of img
    $("#copyMe").click(function() {
        $("html, body").scrollTop(0);
        html2canvas(document.querySelector("#puzzle"), {letterRendering:true, scrollX: -8, scrollY: -22}).then(canvas => canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})])));
    });

}); // end document ready