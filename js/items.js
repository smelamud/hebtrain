function addItem() {
    $.post("/actions/item-modify.php", $("#items-form").serialize(),
        function(data) {
            var newLine = $(".template").clone();
            newLine.removeClass("template");
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
    $("#items input[name='id']").val(self.data("id"));
    $("#items input[name='hebrew']").val(self.find(".hebrew").text()).focus();
    $("#items input[name='russian']").val(self.find(".russian").text());
    $("#add").hide();
    $("#modify").show();
    $("#delete").show();
    $("#reset").show();
}

function modifyItem() {
    $.post("/actions/item-modify.php", $("#items-form").serialize(),
        function(data) {
            var line = $("#items tr").filter(function() {
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
        { "id": $("#items input[name='id']").val() },
        function(data) {
            $("#items tr").filter(function() {
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
    $("#items input").val("");
    $("#items input[name='russian']").focus();
}

$(function() {
    $("#add").click(addItem);
    $("#modify").click(modifyItem);
    $("#delete").click(deleteItem);
    $("#reset").click(resetAdder);
    $("#items").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    });
    $("#items").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
});
