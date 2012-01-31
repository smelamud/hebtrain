function addLetter() {
    var notEntered = $("#not-entered");
    var txt = notEntered.text();
    while (txt.length < 25) {
        var code = getRandomInt(0x05d0, 0x05eb);
        txt += String.fromCharCode(code);
    }
    notEntered.text(txt);
}

function letterEntered() {
    var notEntered = $("#not-entered");
    var entered = $("#entered");
    var txt = entered.text();
    if (txt.length >= 25) {
        txt = txt.slice(-25);
    }
    var ch = notEntered.text().charAt(0);
    $("#entering").text(ch);
    entered.text(txt + ch);
    notEntered.text(notEntered.text().slice(1));
}

function keyboardCallback() {
    var ch = $("#entering").text();
    if ($("#not-entered").text().charAt(0) == ch) {
        letterEntered();
        addLetter();
//        $("#entering").text("");
    }
}

$(function() {
    addLetter();
});
