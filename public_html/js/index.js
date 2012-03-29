function loadStatistics() {
    $.getJSON("/actions/statistics.php",
        function(data) {
            $("#words-total").text(data.words_total);
            $("#questions-total").text(data.questions_total);
            $("#questions-now").text(data.questions_now);
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
            $.each(data.stages, function(index, stage) {
                var newLine = template.clone();
                newLine.removeClass("template").addClass("item");
                newLine.find(".name").text(stage.name);
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
