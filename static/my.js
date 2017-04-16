$(function() {

    var buffer = '';

    $('#a').on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    function flush() {
        if (buffer == $("#a").val()) {
            console.log('!');
            return;
        }
        buffer = $("#a").val();
        $.ajax({
            type: "POST",
            url: "parser.php",
            data: {"text": buffer},
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
            flush();
        }
    });

    $('#a').focusout(function() {
        flush();
    });

	shortcut.add("F8",function() {
        flush();
	});

	shortcut.add("Ctrl+Enter",function() {
        flush();
	});
});
