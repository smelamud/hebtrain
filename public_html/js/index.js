function loadStatistics() {
    $.getJSON("/actions/statistics.php",
        function(data) {
            $("#words-total").text(data.words_total);
            $("#words-active").text(data.words_active);
            $("#tests-done-today").text(data.tests_done_today);
            $("#questions-total").text(data.questions_total);
            $(".questions-now").text(data.questions_now);
            $("#items-now").text(data.items_now);
            var testsNow = data.items_now / data.questions_per_test;
            $("#tests-now").text(Math.round(testsNow));
            $("#questions .item").remove();
            var template = $("#questions .template");
            $.each(data.questions, function(index, question) {
                var newLine = template.clone();
                newLine.removeClass("template").addClass("item");
                newLine.find(".title").text(question.title);
                newLine.find(".total").text(question.total);
                newLine.find(".now").text(question.now);
                template.before(newLine);
            });
            $("#stages .item").remove();
            template = $("#stages .template");
            var questionsDayTotal = 0;
            $.each(data.stages, function(index, stage) {
                var questionsDay = stage.count / stage.period;
                questionsDayTotal += questionsDay;
                var newLine = template.clone();
                newLine.removeClass("template").addClass("item");
                newLine.find(".name").text(stage.name);
                newLine.find(".count-day").text(
                    Math.round(questionsDay * 100) / 100);
                $.each(data.ready, function(index, info) {
                    if (info.stage == stage.stage) {
                        newLine.find(".count-ready").text(info.count);
                    }
                });
                $.each(stage.steps, function(step, count) {
                    newLine.find(".count" + step).text(count);
                });
                template.before(newLine);
            });
            $("#questions-day").text(Math.round(questionsDayTotal * 100) / 100);
            var testsDay = questionsDayTotal / data.questions_per_test;
            $("#tests-day").text(Math.round(testsDay * 100) / 100);
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
    window.setTimeout(loadStatistics, 30 * 60 * 1000);
}

$(function() {
    $("body").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    }).ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadStatistics();
});
