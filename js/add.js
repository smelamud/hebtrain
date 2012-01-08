$(function() {
    $("#add").click(function() {
        $(".spinner img").css("visibility", "visible");
        $.post("/actions/item-modify.php", $("#addform").serialize(),
            function() {
                $(".spinner img").css("visibility", "hidden");
                alert("Success!");
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
