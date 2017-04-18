<?php

namespace jack\cmd;

$composerAutoload = [
    __DIR__ . '/vendor/autoload.php',
    __DIR__ . '/../../autoload.php',
];
foreach ($composerAutoload as $autoload) {
    if (file_exists($autoload)) {
        require($autoload);
        break;
    }
}

$parser = new ColoredMarkdown();

if (php_sapi_name() === 'cli') {
    if ($argc > 1)
        $markdown = file_get_contents($argv[1]);
    else
        $markdown = stream_get_contents(STDIN);

    if (isset($debug) && $debug)
    {
        echo $parser->parse($markdown);
        die();
    }
    else
    {
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
        echo $head . $parser->parse($markdown) . '</body>';
        die();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['text']) {
    $markdown = $_POST['text'];
    echo $parser->parse($markdown);
    die();
} else {
    http_response_code(404);
    die();
}
