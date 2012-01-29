function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

function showKeyboard(selector) {
    window.keyboardElement = $(selector);
    var off = window.keyboardElement.offset();
    $("#keyboard").show().offset({left: off.left, top: off.top + 50});
}

function hideKeyboard() {
    window.keyboardElement = null;
    $("#keyboard").hide();
}

function keyboardKeyDown(event) {
    if (!window.keyboardElement) {
        return;
    }
}

$(function() {
    $("#topbar").dropdown();
    $(document).keydown(keyboardKeyDown);
});
