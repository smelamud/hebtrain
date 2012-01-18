function getRandomInt(min, max) {  
    return Math.floor(Math.random() * (max - min)) + min;  
}

function shuffle(arr) {
    for (var i = 0; i < arr.length; i++) {
        j = getRandomInt(0, arr.length);
        k = arr[i];
        arr[i] = arr[j];
        arr[j] = k;
    }
}

function loadTest() {
    $.getJSON("/actions/test-load.php",
        function(data) {
            window.testData = data;
            shuffle(window.testData);
            $("#loading").hide();
            $("#loaded").show();
            $("#buttons-start").show();
        }
    ).error(
        function() {
            alert("Error!");
        }
    );
}

function startTest() {
    alert("Started!");
}

$(function() {
    $("#button-start").click(startTest);
    $("#main").ajaxStart(function() {
        $("#spinner").css("visibility", "visible");
    });
    $("#main").ajaxStop(function() {
        $("#spinner").css("visibility", "hidden");
    });
    loadTest();
});
