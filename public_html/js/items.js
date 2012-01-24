function addLine(data) {
    var newLine = $("#found .template").clone();
    newLine.removeClass("template");
    newLine.addClass("item");
    newLine.data("id", data.id);
    newLine.find(".hebrew").text(data.hebrew);
    newLine.find(".hebrew-comment").text(data.hebrew_comment);
    newLine.find(".russian").text(data.russian);
    newLine.find(".russian-comment").text(data.russian_comment);
    newLine.click(recallItem);
    $("#found .template").before(newLine);
}

function findItems(keyword, offset) {
    window.ajaxType = offset == 0 ? "items" : "continue";
    $.getJSON("/actions/items-find.php", { q: keyword, offset: offset },
        function(data) {
            if (offset == 0) {
                $("#found .item").remove();
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
                $("#found .item").remove();
                $("#added-title").show();
                $("#added-total").text("1");
            } else {
                $("#added-total").text(Number($("#added-total").text()) + 1);
            }
            addLine(data);
            resetAdder();
            resolveSimilar(data);
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
            resolveSimilar(data);
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

function search() {
    findItems($("#search-form input").val(), 0);
    return false;
}

function resolveSimilar(data) {
    if (data.similar.length > 0) {
        $("#similar .item").remove();
        similarDialogAddLine(data);
        $.each(data.similar, function(index, item) {
            similarDialogAddLine(item);
        });
        $("#similar-dialog").modal('show');
    }
}

function similarDialogSave() {
    window.ajaxType = "similar";
    $.post("/actions/items-comments-modify.php",
        $("#similar-form").serialize(),
        function(data) {
            $("#similar-dialog").modal('hide');

            var dataMap = {};
            $.each(data, function(index, item) {
                dataMap[item.id] = item;
            });

            $("#found .item").each(function(index) {
                var line = $(this);
                id = line.data("id");
                if (dataMap[id]) {
                    line.find(".hebrew-comment").text(
                        dataMap[id].hebrew_comment);
                    line.find(".russian-comment").text(
                        dataMap[id].russian_comment);
                }
            });
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
    return false;
}

function similarDialogCancel() {
    $("#similar-dialog").modal('hide');
    return false;
}

function similarDialogAddLine(data) {
    var newLine = $("#similar .template").clone();
    newLine.removeClass("template");
    newLine.addClass("item");
    newLine.find("input[type=hidden]").val(data.id);
    newLine.find(".hebrew").text(data.hebrew);
    newLine.find(".hebrew-comment input").val(data.hebrew_comment);
    newLine.find(".russian").text(data.russian);
    newLine.find(".russian-comment input").val(data.russian_comment);
    $("#similar .template").before(newLine);
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
        } else if (window.ajaxType == "similar") {
            $("#spinner-similar").css("visibility", "visible");
        } else {
            $("#spinner").css("visibility", "visible");
        }
    });
    $("#editor").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
        $("#spinner-continue").css("visibility", "hidden");
        $("#spinner-similar").css("visibility", "hidden");
    });
    $("#similar-dialog").modal({
        keyboard: true
    });
    $("#similar-dialog-cancel").click(similarDialogCancel);
    $("#similar-dialog-save").click(similarDialogSave);
    findItems("", 0);
});
