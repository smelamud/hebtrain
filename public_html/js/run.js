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
    window.testStatus = "loading";
    $("#restart").hide();
    $("#start").show();
    $("#loading").show();
    $("#loaded").hide();
    $("#buttons-start").hide();

    var qv = getURLParameter('qv') || 0;
    $.getJSON("/actions/test-load.php?qv=" + qv,
        function(data) {
            window.testMaxCorrect = data.max_correct;
            window.testMinQuestions = data.min_questions;
            window.testData = data.tests;
            $.each(window.testData, function(index, item) {
                item.answers_total = 0;
                item.answers_correct = 0;
            });
            window.testStatus = "loaded";
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
    window.loopNumber = 0;
    nextQuestion();
}

function showQuestion() {
    window.testStatus = "asking";
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
    if (data.input) {
        $("#answer-input").val("").show().focus();
    } else {
        $("#answer-input").hide();
    }
    $("#answer-input-text").hide();
    $("#answer").hide();
    $("#buttons-correct").hide();
}

function answered() {
    window.testStatus = "answered";
    $("#answer-input-text").text($("#answer-input").val()).show();
    $("#answer-input").hide();
    hideKeyboard();
    $("#buttons-answer").hide();

    var data = window.testData[window.testCurrent];
    $("#answer").text(data.answer);
    $("#answer").show();
    $("#buttons-correct").show();
    $(document).focus();
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

            if (window.loopNumber++ > 0) {
                showIntermezzo();
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

function showIntermezzo() {
    $("#run").hide();
    $("#loop-number").text(window.loopNumber);
    window.setTimeout(function() {
        $("#intermezzo").fadeIn("slow").delay(800).fadeOut("slow");
        window.setTimeout(function() {
            $("#run").show();
        }, 2200);
    }, 200);
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
    window.testStatus = "finished";
    $("#run").hide();
    $("#stop").show();
}

function restartTest() {
    window.testStatus = "saved";
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

activeElements = {
    "loading": {},
    "loaded": {
        13: "button-start"
    },
    "asking": {
        13: "button-answer"
    },
    "answered": {
        107: "button-correct",
        109: "button-incorrect"
    },
    "finished": {
        13: "button-save"
    },
    "saved": {
        13: "button-restart"
    }
};

function keyboardNavigation(event) {
    if (activeElements[window.testStatus][event.which]) {
        var element = $("#" + activeElements[window.testStatus][event.which]);
        element.attr("data-loading-text", element.text());
        element.button("loading");
        window.setTimeout(function(element) {
            element.button("reset").click();
        }, 300, element);
        event.stopPropagation();
        event.preventDefault();
    }
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
    }).ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    $(document).keydown(keyboardNavigation);
    loadTest();
});
