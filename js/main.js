// index.php
// wtf does this do??
function fctCheck(language) {
    var elems = document.getElementsByName("fillerTypes");
    for (var i = 0; i < elems.length; i++) {
        elems.item(i).style.display = "none";
    }
    document.getElementById(language).style.display = "block";
}

// only used in index.backup
// not used??
function changeTest(obj){
    alert(obj.options[obj.selectedIndex].value);
}
