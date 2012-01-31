flexions = [
    "катав - ктав",
    "кутив - ктив",
    "котэв - ктэв",
    "ктив - катив",
    "ктэв - катэв",
    "ктав - кутав",
    "ктив - кутив",
    "ктав - катв",
    "ктув - кутв",
    "ктэв - кэтв",
    "катв - ктав",
    "кутв - ктув",
    "кэтв - ктэв",
    "катав - катив",
    "катав - катув",
    "катав - кутив",
    "кутив - кэтов",
    "ктав - ктив",
    "ктэв - ктув",
    "катв - кутв",
    "китв - кэтв",
    "катав - ктув",
    "кэтов - ктэв",
    "ктав - китв",
    "кутв - ктэв"
]

consonants = "бвгдзйклмнпрстфхцш";

function showFlexion() {
    $("#example-text").text(flexions[window.currentFlexion]);
    $("#prev-example").css("visibility",
        window.currentFlexion > 0 ? "visible" : "hidden");
    $("#next-example").css("visibility",
        window.currentFlexion < flexions.length - 1 ? "visible" : "hidden");
    $("#current").text(window.currentFlexion + 1);
    $("#total").text(flexions.length);
}

function generateRoots() {
    var template = $("#roots .template");
    for (var i = 0; i < 16; i++) {
        var s = "";
        for (var j = 0; j < 3; j++) {
            k = getRandomInt(0, consonants.length);
            s += consonants[k];
        }
        var newLine = template.clone();
        newLine.text(s);
        template.before(newLine);
    }
}

$(function() {
    window.currentFlexion = 0;
    showFlexion();
    generateRoots();
    $("#prev-example").click(function() {
        window.currentFlexion--;
        if (window.currentFlexion < 0) {
            window.currentFlexion = 0;
        }
        showFlexion();
    });
    $("#next-example").click(function() {
        window.currentFlexion++;
        if (window.currentFlexion >= flexions.length) {
            window.currentFlexion = flexions.length - 1;
        }
        showFlexion();
    });
});
