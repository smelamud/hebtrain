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

function loadTest() {
    $("#start").show();
    $("#loading").show();
    $("#loaded").hide();
    $("#buttons-start").hide();

    $.getJSON("/actions/test-load.php",
        function(data) {
            window.testData = data;
            $("#loading").hide();
            $("#loaded").show();
            $("#buttons-start").show();
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
}

function startTest() {
    $("#start").hide();
    $("#run").show();
    shuffle(window.testData);
    window.testCurrent = 0;
    showQuestion();
}

function showQuestion() {
    var title = $(".question-title-show");
    title.removeClass("question-title-show");
    title.addClass("question-title-hide");

    var data = window.testData[window.testCurrent];
    title = $("#question-title-" + data.question);
    title.removeClass("question-title-hide");
    title.addClass("question-title-show");

    var word = '';
    switch(data.question) {
        case 1: // QV_WORD_HE_RU
            word = data.hebrew;
            comment = data.hebrew_comment;
            break;
        case 2: // QV_WORD_BARE_HE_RU
            word = data.hebrew_bare;
            comment = data.hebrew_comment;
            break;
        case 3: // QV_WORD_RU_HE
        case 4: // QV_WORD_RU_HE_WRITE
        case 5: // QV_WORD_RU_HE_NEKUDOT
            word = data.russian;
            comment = data.russian_comment;
            break;
    }
    $("#question-word").text(word);
    if (comment.length > 0) {
        $("#question-comment").text("[" + comment + "]");
    } else {
        $("#question-comment").text("");
    }

    $("#buttons-answer").show();
}

function answered() {
    $("#buttons-answer").hide();

    var data = window.testData[window.testCurrent];
}

$(function() {
    $("#button-start").click(startTest);
    $("#button-answer").click(answered);
    $("#main").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    });
    $("#main").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadTest();
});
