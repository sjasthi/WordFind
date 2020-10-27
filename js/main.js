// Change Filler Character Types Dropdown on Language Dropdown Event Change
var selectLanguage = document.getElementById("language");
selectLanguage.addEventListener('change', changeLanguage);

function changeLanguage(e){
    var elems = document.getElementsByName("filler_char_types");
    for (var i = 0; i < elems.length; i++) {
        elems.item(i).style.display = "none";

        // disable select
        elems.item(i).disabled = false;
    }
    document.getElementById(e.target.value).style.display = "block";
}