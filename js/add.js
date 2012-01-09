function addItem() {
    $.post("/actions/item-modify.php", $("#addform").serialize(),
        function(data) {
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

function modifyItem() {
    $.post("/actions/item-modify.php", $("#addform").serialize(),
        function(data) {
            var line = $("#adder tr").filter(function() {
                return $(this).data("id") == data.id;
            });
            line.find(".hebrew").text(data.hebrew);
            line.find(".russian").text(data.russian);
            resetAdder();
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
    return false;
}

function deleteItem() {
    $.post("/actions/item-delete.php",
        { "id": $("#adder input[name='id']").val() },
        function(data) {
            $("#adder tr").filter(function() {
                return $(this).data("id") == data.id;
            }).remove();
            resetAdder();
        }
    ).error(
        function() {
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
    $("#modify").click(modifyItem);
    $("#delete").click(deleteItem);
    $("#reset").click(resetAdder);
    $("#adder").ajaxStart(function() {
        $(".spinner img").css("visibility", "visible");
    });
    $("#adder").ajaxStop(function() {
        $(".spinner img").css("visibility", "hidden");
    });
});
