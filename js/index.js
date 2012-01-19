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
                newLine.find(".count").text(stage.count);
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
    $("#main").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    });
    $("#main").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadStatistics();
});
