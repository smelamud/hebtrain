function getRandomInt(min, max) {  
    return Math.floor(Math.random() * (max - min)) + min;  
}

function shuffle(arr) {
    for (var i = 0; i < arr.length; i++) {
        j = getRandomInt(0, arr.length);
        k = arr[i];
        arr[i] = arr[j];
        arr[j] = k;
    }
}

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}

function showKeyboard(element) {
    window.keyboardElement = element;
    redisplayKeyboard(true);
}

function redisplayKeyboard(animate) {
    var element = window.keyboardElement;
    window.mouseInKeyboard = false;
    
    var positioning = element.attr("data-keyboard-positioning") || "fixed";
    var off = element.offset();
    if (positioning == "fixed") {
        var position = {left: ($(window).width() - 568) / 2,
                        top: $(window).height() - (animate ? 0 : 170)};
    } else if (positioning == "bottom") {
        var position = {left: off.left,
                        top: off.top + element.outerHeight() + 5};
    } else if (positioning == "right") {
        var position = {left: off.left + element.outerWidth() + 5,
                        top: off.top};
    } else if (positioning == "bottom-left") {
        var position = {left: off.left - 440,
                        top: off.top + element.outerHeight() + 5};
    } else if (positioning == "bottom-center") {
        var position = {left: off.left + (element.outerWidth() - 568) / 2,
                        top: off.top + element.outerHeight() + 5};
    }

    $("#keyboard").show().offset(position);
    
    if (animate) {
        if (positioning == "fixed") {
            $("#keyboard").animate({top: $(window).height() - 170}, 100);
        }
    }
}

function hideKeyboard() {
    var positioning = null;
    if (window.keyboardElement != null) {
        positioning = window.keyboardElement.attr("data-keyboard-positioning")
            || "fixed";
        window.keyboardElement = null;
    }
    if (positioning == "fixed") {
        $("#keyboard").animate({top: $(window).height()}, 100,
            function() {
                $("#keyboard").hide();
            }
        );
    } else {
        $("#keyboard").hide();
    }
}

function getKeyHebrewChar(key) {
    var hch = key.find(".hebrew-letter").text();
    return hch.charAt(hch.length - 1);
}

function enterHebrewChar(key) {
    if (window.keyboardElement.is("input")) {
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
    } else {
        window.keyboardElement.text(getKeyHebrewChar(key));
    }
    if (typeof keyboardCallback == "function") {
        keyboardCallback(key);
    }
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
    if (element.is("input")) {
        element.focus(function() {
            if (window.keyboardElement == null) {
                if (element.is(":visible")) {
                    showKeyboard($(this));
                }
            } else {
                redisplayKeyboard(false);
            }
        }).blur(function() {
            if (!window.mouseInKeyboard) {
                hideKeyboard();
            }
        });
    } else {
        showKeyboard(element);
    }
}

function initKeyboard() {
    $(document).keypress(keyboardKeyPress);
    $("#keyboard").mouseover(function() {
        window.mouseInKeyboard = true;
    }).mouseout(function() {
        window.mouseInKeyboard = false;
    });
    $("#keyboard .key").click(keyboardClick);
    $(".keyboard-enabled").each(function() {
        bindKeyboard($(this));
    });
}

$(function() {
    $("#navbar").dropdown();
    initKeyboard();
});
