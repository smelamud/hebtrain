function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

function showKeyboard(element) {
    window.keyboardElement = element
    var off = element.offset();
    $("#keyboard").show().offset({left: off.left, top: off.top + 50});
}

function hideKeyboard() {
    window.keyboardElement = null;
    $("#keyboard").hide();
}

function getKeyHebrewChar(key) {
    var hch = key.find(".hebrew-letter").text();
    return hch.charAt(hch.length - 1);
}

function keyboardKeyPress(event) {
    if (!window.keyboardElement) {
        return;
    }
    if (event.ctrlKey || event.altKey || event.metaKey) {
        return;
    }

    var ch = String.fromCharCode(event.charCode);
    $("#keyboard .key").each(function() {
        var latin = $(this).find(".latin-letter");
        if (latin.text() == ch || latin.attr("data-second") == ch) {
            var s = window.keyboardElement.val();
            window.keyboardElement.val(s + getKeyHebrewChar($(this)));
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
}

$(function() {
    $("#topbar").dropdown();
    $(document).keypress(keyboardKeyPress);
});
