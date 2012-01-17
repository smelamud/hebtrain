function addLine(data) {
    var newLine = $(".template").clone();
    newLine.removeClass("template");
    newLine.addClass("item");
    newLine.data("id", data.id);
    newLine.find(".hebrew").text(data.hebrew);
    newLine.find(".hebrew-comment").text(data.hebrew_comment);
    newLine.find(".russian").text(data.russian);
    newLine.find(".russian-comment").text(data.russian_comment);
    newLine.click(recallItem);
    $(".template").before(newLine);
}

function findItems(keyword, offset) {
    window.ajaxType = offset == 0 ? "items" : "continue";
    $.getJSON("/actions/items-find.php", { q: keyword, offset: offset },
        function(data) {
            if (offset == 0) {
                $(".item").remove();
            }
            $("#added-title").hide();
            $("#found-title").show();
            $("#found-loaded").text(data.offset + data.count);
            $("#found-total").text(data.total);
            $.each(data.items, function(index, item) {
                addLine(item);
            });
            if (data.offset + data.count == data.total) {
                $("#continue").hide();
            } else {
                $("#continue").show();
            }
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
}

function continueFind() {
    findItems($("#search-form input").val(), Number($("#found-loaded").text()));
}

function addItem() {
    window.ajaxType = "items";
    $.post("/actions/item-modify.php", $("#items-form").serialize(),
        function(data) {
            if ($("#added-title").css("display") == "none") {
                $("#found-title").hide();
                $("#continue").hide();
                $(".item").remove();
                $("#added-title").show();
                $("#added-total").text("1");
            } else {
                $("#added-total").text(Number($("#added-total").text()) + 1);
            }
            addLine(data);
            resetAdder();
            resolveSimilar(data.similar);
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
    $("#editor input[name='id']").val(self.data("id"));
    $("#editor input[name='hebrew']").val(self.find(".hebrew").text()).focus();
    $("#editor input[name='russian']").val(self.find(".russian").text());
    $("#add").hide();
    $("#modify").show();
    $("#delete").show();
    $("#reset").show();
}

function modifyItem() {
    window.ajaxType = "items";
    $.post("/actions/item-modify.php", $("#items-form").serialize(),
        function(data) {
            var line = $("#found tr").filter(function() {
                return $(this).data("id") == data.id;
            });
            line.find(".hebrew").text(data.hebrew);
            line.find(".russian").text(data.russian);
            resetAdder();
            resolveSimilar(data.similar);
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
    return false;
}

function deleteItem() {
    window.ajaxType = "items";
    $.post("/actions/item-delete.php",
        { "id": $("#editor input[name='id']").val() },
        function(data) {
            $("#found tr").filter(function() {
                return $(this).data("id") == data.id;
            }).remove();
            var loaded = Number($("#found-loaded").text());
            var total = Number($("#found-total").text());
            $("#found-loaded").text(loaded - 1);
            $("#found-total").text(total - 1);
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
    $("#editor input").val("");
    $("#editor input[name='russian']").focus();
}

function resolveSimilar(similar) {
    if (similar.length > 0) {
        $("#similar-dialog").dialog();
    }
}

function search() {
    findItems($("#search-form input").val(), 0);
    return false;
}

$(function() {
    $("#add").click(addItem);
    $("#modify").click(modifyItem);
    $("#delete").click(deleteItem);
    $("#reset").click(resetAdder);
    $("#continue").click(continueFind);
    $("#search-form").submit(search);
    $("#editor").ajaxStart(function() {
        if (window.ajaxType == "continue") {
            $("#spinner-continue").css("visibility", "visible");
        } else {
            $("#spinner").css("visibility", "visible");
        }
    });
    $("#editor").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
        $("#spinner-continue").css("visibility", "hidden");
    });
    findItems("", 0);
});
