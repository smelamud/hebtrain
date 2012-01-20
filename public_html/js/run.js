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
    $("#restart").hide();
    $("#start").show();
    $("#loading").show();
    $("#loaded").hide();
    $("#buttons-start").hide();

    $.getJSON("/actions/test-load.php",
        function(data) {
            window.testMaxCorrect = data.max_correct;
            window.testMinQuestions = data.min_questions;
            window.testData = data.tests;
            $.each(window.testData, function(index, item) {
                item.answers_total = 0;
                item.answers_correct = 0;
            });
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
    window.testCurrent = window.testData.length;
    nextQuestion();
}

function showQuestion() {
    var title = $(".question-title-show");
    title.removeClass("question-title-show");
    title.addClass("question-title-hide");

    var data = window.testData[window.testCurrent];
    title = $("#question-title-" + data.question);
    title.removeClass("question-title-hide");
    title.addClass("question-title-show");

    $("#question-word").text(data.word);
    if (data.comment.length > 0) {
        $("#question-comment").text("[" + data.comment + "]");
    } else {
        $("#question-comment").text("");
    }

    $("#buttons-answer").show();
    $("#answer").hide();
    $("#buttons-correct").hide();
}

function answered() {
    $("#buttons-answer").hide();

    var data = window.testData[window.testCurrent];
    $("#answer").text(data.answer);
    $("#answer").show();
    $("#buttons-correct").show();
}

function answerCorrect() {
    var data = window.testData[window.testCurrent];
    data.answers_total++;
    data.answers_correct++;

    nextQuestion();
}

function answerIncorrect() {
    var data = window.testData[window.testCurrent];
    data.answers_total++;
    
    nextQuestion();
}

function nextQuestion() {
    while (true) {
        window.testCurrent++;
        if (window.testCurrent >= window.testData.length) {
            if (getOpenQuestionsCount() <= window.testMinQuestions) {
                stopTest();
                return;
            }
            shuffle(window.testData);
            window.testCurrent = 0;
        }
        var data = window.testData[window.testCurrent];
        if (data.answers_correct < window.testMaxCorrect) {
            break;
        }
    }
    showQuestion();
}

function getOpenQuestionsCount() {
    count = 0;
    for (var i = 0; i < window.testData.length; i++) {
        if (window.testData[i].answers_correct < window.testMaxCorrect) {
            count++;
        }
    }
    return count;
}

function stopTest() {
    $("#run").hide();
    $("#stop").show();
}

function restartTest() {
    $("#stop").hide();
    $("#restart").show();
}

function saveResult() {
    $.post("/actions/test-save.php", { data: window.testData },
        function(data) {
            restartTest();
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
}

$(function() {
    $("#button-start").click(startTest);
    $("#button-answer").click(answered);
    $("#button-correct").click(answerCorrect);
    $("#button-incorrect").click(answerIncorrect);
    $("#button-save").click(saveResult);
    $("#button-restart").click(loadTest);
    $("#main").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    });
    $("#main").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadTest();
});
