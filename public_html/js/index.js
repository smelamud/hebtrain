function loadStatistics() {
    $.getJSON("/actions/statistics.php",
        function(data) {
            $("#words-total").text(data.words_total);
            $("#questions-total").text(data.questions_total);
            $("#questions-now").text(data.questions_now);
            var template = $("#questions .template");
            $.each(data.questions, function(index, question) {
                var newLine = template.clone();
                newLine.removeClass("template");
                newLine.find(".title").text(question.title);
                newLine.find(".total").text(question.total);
                newLine.find(".now").text(question.now);
                template.before(newLine);
            });
            template = $("#stages .template");
            $.each(data.stages, function(index, stage) {
                var newLine = template.clone();
                newLine.removeClass("template");
                newLine.find(".name").text(stage.name);
                $.each(stage.steps, function(step, count) {
                    newLine.find(".count" + step).text(count);
                });
                template.before(newLine);
            });
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
}

$(function() {
    $("body").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    }).ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadStatistics();
});
