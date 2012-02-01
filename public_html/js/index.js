function loadStatistics() {
    $.getJSON("/actions/statistics.php",
        function(data) {
            $("#words-total").text(data.words_total);
            $("#questions-total").text(data.questions_total);
            $("#questions-now").text(data.questions_now);
            var template = $("#stages .template");
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
