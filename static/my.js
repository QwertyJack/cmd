$(function() {
    $("#btn").click(function() {
        $.ajax({
            type: "POST",
            url: "parser.php",
            data: {"text": $("#a").val()},
            success: function(data) {
                $("#b").html(data);

                // refresh mathjax in '#b'
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, "b"]);
            }
        });
    });
});
