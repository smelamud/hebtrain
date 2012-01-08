$(function() {
    $("#add").click(function() {
        $(".spinner img").css("visibility", "visible");
        $.post("/actions/item-modify.php", $("#addform").serialize(),
            function(data) {
                $(".spinner img").css("visibility", "hidden");
                var newLine = $(".template").clone();
                newLine.removeClass();
                newLine.find(".hebrew").text(data.hebrew);
                newLine.find(".russian").text(data.russian);
                $(".template").before(newLine);
                $("#adder input").val("");
            }
        ).error(
            function() {
                $(".spinner img").css("visibility", "hidden");
                alert("Error!");
            }
        );
        return false;
    });
});
