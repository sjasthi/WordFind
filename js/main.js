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

$("#toggleBorders").click(toggleBorders);
function toggleBorders(){
    if($(this).prop('checked')){
        $('table tr td').css('border', '#000 solid 1px');
    } else {
        $('table tr td').css('border', '0');
    }
}

// toggleLabels on table
if($('#toggleLabels').prop('checked')){
    $('.rowLabel').removeClass('d-none');
} else {
    $('.rowLabel').addClass('d-none');
}

$("#toggleLabels").click(toggleLabels);
function toggleLabels(){
    if($(this).prop('checked')){
        $('.rowLabel').removeClass('d-none');
    } else {
        $('.rowLabel').addClass('d-none');
    }
}

// toggleAnswers on table
if($('#toggleAnswers').prop('checked')){
    $('.solutionX').removeClass('d-none');
} else {
    $('.solutionX').addClass('d-none');
}

$("#toggleAnswers").click(toggleAnswers);
function toggleAnswers(){
    if($(this).prop('checked')){
        console.log('checked');
        $('.solutionX').removeClass('d-none');
    } else {
        console.log('NOT checked');
        $('.solutionX').addClass('d-none');
    }
}