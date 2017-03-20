$(function() {
    $("#btn").click(function() {
        $.ajax({
            type: "POST",
            url: "parser.php",
            data: {"text": $("#a").val()},
            success: function(data) {
                $("#b").html(data);
            }
        });
    });
});
