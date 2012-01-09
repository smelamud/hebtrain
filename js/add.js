function addItem() {
    $(".spinner img").css("visibility", "visible");
    $.post("/actions/item-modify.php", $("#addform").serialize(),
        function(data) {
            $(".spinner img").css("visibility", "hidden");
            var newLine = $(".template").clone();
            newLine.removeClass();
            newLine.data("id", data.id);
            newLine.find(".hebrew").text(data.hebrew);
            newLine.find(".russian").text(data.russian);
            newLine.click(recallItem);
            $(".template").before(newLine);
            resetAdder();
        }
    ).error(
        function() {
            $(".spinner img").css("visibility", "hidden");
            alert("Error!");
        }
    );
    return false;
}

function recallItem() {
    self = $(this);
    $("#adder input[name='id']").val(self.data("id"));
    $("#adder input[name='hebrew']").val(self.find(".hebrew").text()).focus();
    $("#adder input[name='russian']").val(self.find(".russian").text());
    $("#add").hide();
    $("#modify").show();
    $("#delete").show();
    $("#reset").show();
}

function deleteItem() {
    $(".spinner img").css("visibility", "visible");
    $.post("/actions/item-delete.php",
        { "id": $("#adder input[name='id']").val() },
        function(data) {
            $(".spinner img").css("visibility", "hidden");
            $("#adder tr").filter(function() {
                return $(this).data("id") == data.id;
            }).remove();
            resetAdder();
        }
    ).error(
        function() {
            $(".spinner img").css("visibility", "hidden");
            alert("Error!");
        }
    );
    return false;
}

function resetAdder() {
    $("#add").show();
    $("#modify").hide();
    $("#delete").hide();
    $("#reset").hide();
    $("#adder input").val("");
    $("#adder input[name='hebrew']").focus();
}

$(function() {
    $("#add").click(addItem);
    $("#delete").click(deleteItem);
    $("#reset").click(resetAdder);
});
