<?php

require 'vendor/autoload.php';

class ColoredMarkdown extends \cebe\markdown\GithubMarkdown
{
    /**
     * @marker [color
     */
    protected function parseColor($markdown)
    {
        if (preg_match('/^\[color ([\(\),#\w]+?)\](.+?)\[\/color\]/', $markdown, $matches)) {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['color', $this->parseInline($matches[2]), $matches[1]],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 2 characters
        return [['text', '[color'], 6];
    }

    // rendering is the same as for block elements, we turn the abstract syntax array into a string.
    protected function renderColor($element)
    {
        return '<span style="color:' . $element[2] . '">' . $this->renderAbsy($element[1]) . '</span>';
        //return '<font color="' . $element[2] . '">' . $this->renderAbsy($element[1]) . '</font>';
    }
}

$parser = new ColoredMarkdown();

if (php_sapi_name() === 'cli') {
    //$markdown = file_get_contents('demo.md');
    $markdown = stream_get_contents(STDIN);
    $head = <<<EOF
<head>
<title>Colored Markdown Demo</title>
<script type="text/x-mathjax-config">
MathJax.Hub.Config({
    extensions: ["tex2jax.js"],
    jax: ["input/TeX","output/HTML-CSS"],
    tex2jax: {inlineMath: [["$","$"]]}
  });
</script>
<script type="text/javascript" src="MathJax-2.7.0/MathJax.js"></script>
<link rel="stylesheet" href="static/my.css" type="text/css" />
</head>
<body>
EOF;
    echo $head . $parser->parse($markdown) . '</body>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['text']) {
    $markdown = $_POST['text'];
    echo $parser->parse($markdown);
} else {
    http_response_code(404);
    die();
}
