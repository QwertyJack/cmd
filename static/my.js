$(function() {

    function flush() {
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
    }

    // init '#a'
    $.ajax({
        type: "GET",
        url: "demo.md",
        success: function(data) {
            $("#a").html(data);
            //flush();
        }
    });

    $('#a').focusout(function() {
        flush();
    });
});
