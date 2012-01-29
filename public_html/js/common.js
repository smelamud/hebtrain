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
            var hch = $(this).find(".hebrew-letter").text();
            var s = window.keyboardElement.val();
            window.keyboardElement.val(s + hch.charAt(hch.length - 1));
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
