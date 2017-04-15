<?php

require 'vendor/autoload.php';
require 'ColoredTrait.php';

$debug = True;

class ColoredMarkdown extends \cebe\markdown\GithubMarkdown
{
    use ColorBlockTrait;
    use InlineColorTrait;
    use MathJaxBlockTrait;
    use InlineMathJaxTrait;
}

$parser = new ColoredMarkdown();

if (php_sapi_name() === 'cli') {
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
<script type="text/javascript" src="MathJax/MathJax.js"></script>
<link rel="stylesheet" href="static/my.css" type="text/css" />
</head>
<body>
EOF;
    if ($debug)
        echo $parser->parse($markdown);
    else
        echo $head . $parser->parse($markdown) . '</body>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['text']) {
    $markdown = $_POST['text'];
    echo $parser->parse($markdown);
} else {
    http_response_code(404);
    die();
}
