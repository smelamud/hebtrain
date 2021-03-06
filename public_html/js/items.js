function addLine(data) {
    var newLine = $("#found .template").clone();
    newLine.removeClass("template");
    newLine.addClass("item");
    newLine.data("id", data.id);
    assignLine(newLine, data);
    newLine.click(editDialogOpenEdit);
    $("#found .template").before(newLine);
}

function assignLine(line, data) {
    line.find(".hebrew").text(data.hebrew);
    line.find(".hebrew-comment").text(data.hebrew_comment);
    line.find(".russian").text(data.russian);
    line.find(".russian-comment").text(data.russian_comment);
    line.data("root", data.root);
    line.data("group", data.group);
    line.data("gender", data.gender);
    line.data("feminine", data.feminine);
    line.data("plural", data.plural);
    line.data("smihut", data.smihut);
    line.data("abbrev", data.abbrev);
    line.data("hard", data.hard);
    if (data.group == 0) {
        line.find(".hebrew").addClass("group-none");
    } else {
        line.find(".hebrew").removeClass("group-none");
    }
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

function search() {
    findItems($("#search-form input").val(), 0);
    return false;
}

function addOrModifyItem() {
    window.ajaxType = "items";
    $.post("/actions/item-modify.php", $("#edit-form").serialize(),
        function(data) {
            editDialogHide();

            var line = $("#found tr").filter(function() {
                return $(this).data("id") == data.id;
            });
            if (line.length > 0) {
                assignLine(line, data);
            } else {
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
            }
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
        { "id": $("#edit-dialog input[name='id']").val() },
        function(data) {
            editDialogHide();

            $("#found tr").filter(function() {
                return $(this).data("id") == data.id;
            }).remove();
            var loaded = Number($("#found-loaded").text());
            var total = Number($("#found-total").text());
            var added = Number($("#added-total").text());
            $("#found-loaded").text(loaded - 1);
            $("#found-total").text(total - 1);
            $("#added-total").text(added - 1);
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
    return false;
}

function editDialogOpenAdd() {
    $("#edit-dialog input:text").val("");
    $("#edit-dialog input:checkbox").val([]);
    $("#edit-dialog input[name='id']").val("");
    $("#edit-dialog-familiar").show();
    $("#edit-dialog-add").show();
    $("#edit-dialog-modify").hide();
    $("#edit-dialog-delete").hide();
    editDialogShow();
    return false;
}

function editDialogOpenEdit() {
    self = $(this);
    $("#edit-dialog input:text").val("");
    $("#edit-dialog input[name='id']").val(self.data("id"));
    $("#edit-dialog input[name='hebrew']").val(self.find(".hebrew").text());
    $("#edit-dialog input[name='hebrew_comment']").val(self.find(".hebrew-comment").text());
    $("#edit-dialog input[name='russian']").val(self.find(".russian").text());
    $("#edit-dialog input[name='russian_comment']").val(self.find(".russian-comment").text());
    $("#edit-dialog input[name='root']").val(self.data("root"));
    $("#edit-dialog input[name='feminine']").val(self.data("feminine"));
    $("#edit-dialog input[name='plural']").val(self.data("plural"));
    $("#edit-dialog input[name='smihut']").val(self.data("smihut"));
    $("#edit-dialog input[name='abbrev']").val(self.data("abbrev"));
    $("#edit-dialog input[name='hard']").val(self.data("hard") ? [1] : []);
    $("#edit-dialog select[name='group']").val(self.data("group"));
    $("#edit-dialog select[name='gender']").val(self.data("gender"));
    $("#edit-dialog-familiar").hide();
    $("#edit-dialog-add").hide();
    $("#edit-dialog-modify").show();
    $("#edit-dialog-delete").show();
    editDialogShow();
}

function editDialogCancel() {
    editDialogHide();
    return false;
}

function editDialogShow() {
    editDialogUpdateOptionalFields();
    $("#edit-dialog").modal({
        keyboard: true
    });
    $("#edit-dialog input[name='hebrew']").focus();
}

function editDialogHide() {
    $("#edit-dialog").modal('hide');
}

editDialogOptionalFields = [
    { // 0
        gender: true,
        feminine: true,
        plural: true,
        smihut: true,
    },
    { // 1
        gender: true,
        feminine: false,
        plural: true,
        smihut: true,
    },
    { // 2
        gender: false,
        feminine: true,
        plural: true,
        smihut: true,
    },
    { // 3
        gender: false,
        feminine: true,
        plural: true,
        smihut: false,
    },
    { // 4
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 5
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 6
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 7
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 8
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 9
        gender: false,
        feminine: true,
        plural: false,
        smihut: false,
    },
    { // 10
        gender: true,
        feminine: true,
        plural: true,
        smihut: true,
    },
    { // 11
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 12
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
    { // 13
        gender: true,
        feminine: true,
        plural: true,
        smihut: true,
    },
    { // 14
        gender: false,
        feminine: false,
        plural: false,
        smihut: false,
    },
];

function editDialogUpdateOptionalFields() {
    var group = parseInt($("#edit-dialog select[name='group']").val());
    for (name in editDialogOptionalFields[group]) {
        $("#" + name + "-section").css("visibility",
            editDialogOptionalFields[group][name] ? "visible" : "hidden");
    }
}

function resolveSimilar(data) {
    if (data.similar.length > 0) {
        $("#similar .item").remove();
        similarDialogAddLine(data);
        $.each(data.similar, function(index, item) {
            similarDialogAddLine(item);
        });
        $("#similar-dialog").modal({
            keyboard: true
        });
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
    $("#add-item").click(editDialogOpenAdd);
    $("#continue").click(continueFind);
    $("#search-form").submit(search);
    $("body").ajaxStart(function() {
        if (window.ajaxType == "continue") {
            $("#spinner-continue").css("visibility", "visible");
        } else if (window.ajaxType == "similar") {
            $("#spinner-similar").css("visibility", "visible");
        } else {
            $("#spinner").css("visibility", "visible");
        }
    }).ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
        $("#spinner-continue").css("visibility", "hidden");
        $("#spinner-similar").css("visibility", "hidden");
    });
    $("#edit-dialog select[name=group]").change(editDialogUpdateOptionalFields);
    $("#edit-dialog .close").click(editDialogCancel);
    $("#edit-dialog-cancel").click(editDialogCancel);
    $('#edit-dialog').on('hide', hideKeyboard);
    $("#edit-dialog-add").click(addOrModifyItem);
    $("#edit-dialog-modify").click(addOrModifyItem);
    $("#edit-dialog-delete").click(deleteItem);
    $("#similar-dialog .close").click(similarDialogCancel);
    $("#similar-dialog-cancel").click(similarDialogCancel);
    $("#similar-dialog-save").click(similarDialogSave);
    findItems("", 0);
});
