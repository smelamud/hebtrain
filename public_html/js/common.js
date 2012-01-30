function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

function showKeyboard(element) {
    window.keyboardElement = element;
    var positioning = element.attr("data-keyboard-positioning") || "bottom";
    var off = element.offset();
    if (positioning == "bottom") {
        var position = {left: off.left,
                        top: off.top + element.outerHeight() + 5};
    } else if (positioning == "right") {
        var position = {left: off.left + element.outerWidth() + 5,
                        top: off.top};
    } else if (positioning == "bottom-left") {
        var position = {left: off.left - 440,
                        top: off.top + element.outerHeight() + 5};
    }
    $("#keyboard").show().offset(position);
}

function hideKeyboard() {
    window.keyboardElement = null;
    $("#keyboard").hide();
}

function getKeyHebrewChar(key) {
    var hch = key.find(".hebrew-letter").text();
    return hch.charAt(hch.length - 1);
}

function enterHebrewChar(key) {
    var s = window.keyboardElement.val();
    var input = window.keyboardElement.get(0);
    var st = s.substring(0, input.selectionStart);
    var se = s.substring(input.selectionEnd);
    if (key.attr("data-special") != "BS") {
        window.keyboardElement.val(st + getKeyHebrewChar(key) + se);
        input.selectionStart = st.length + 1;
    } else {
        window.keyboardElement.val(st.slice(0, -1) + se);
        input.selectionStart = st.length - 1;
    }
    input.selectionEnd = input.selectionStart;
    key.removeClass("key-depressed").addClass("key-pressed");
    window.setTimeout(function() {
        key.removeClass("key-pressed").addClass("key-depressed");
    }, 200);
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
            enterHebrewChar($(this));
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });
}

function keyboardClick(event) {
    window.keyboardElement.focus();
    enterHebrewChar($(this));
    return false;
}

function bindKeyboard(element) {
    element.focus(function() {
        if (window.keyboardElement == null && element.is(":visible")) {
            showKeyboard($(this));
            window.mouseInKeyboard = false;
        }
    }).blur(function() {
        if (!window.mouseInKeyboard) {
            hideKeyboard();
        }
    });
}

function initKeyboard() {
    $(document).keypress(keyboardKeyPress);
    $("#keyboard").mouseover(function() {
        window.mouseInKeyboard = true;
    }).mouseout(function() {
        window.mouseInKeyboard = false;
    });
    $("#keyboard .key").click(keyboardClick);
    $("input.keyboard-enabled").each(function() {
        bindKeyboard($(this));
    });
}

$(function() {
    $("#topbar").dropdown();
    initKeyboard();
});
