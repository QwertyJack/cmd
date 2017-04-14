<?php

require 'vendor/autoload.php';

trait ColorBlockTrait
{
    // identify
    protected function identifyColorBlock($line, $lines, $current)
    {
        // if a line starts with at least 3 backticks it is identified as a fenced code block
        if (strncmp($line, '{{{', 3) === 0) {
            return true;
        }
        return false;
    }

    // consume
    protected function consumeColorBlock($lines, $current)
    {
        // create block array
        $block = [
            //'fencedCode',
            'colorBlock',
            'linescontent' => [],
        ];
        $line = rtrim($lines[$current]);

        // detect language and fence length (can be more than 3 backticks)
        $fence = substr($line, 0, $pos = strrpos($line, '{') + 1);
        $language = substr($line, $pos);
        if (!empty($language)) {
            $block['language'] = $language;
        }

        // consume all lines until ```
        for($i = $current + 1, $count = count($lines); $i < $count; $i++) {
            //if (rtrim($line = $lines[$i]) !== $fence) {
            if (rtrim($line = $lines[$i]) !== '}}}') {
                $block['content'][] = $line;
            } else {
                // stop codeonsuming when code block is over
                break;
            }
        }
        return [$block, $i];
    }

    // render
    protected function renderColorBlock($block)
    {
        //$class = isset($block['language']) ? ' class="language-' . $block['language'] . '"' : '';
        $inner = $this->parse(implode("\n", $block['content']));
        return "<div style='color:" . $block['language'] . "'>" . $inner . '</div>';
    }
}

trait InlineColorTrait
{
    /**
     * @marker {
     */
    protected function parseColor($markdown)
    {
        if (preg_match('/^{([\(\),#\w]+?) ([^\$]+?)}/', $markdown, $matches)) {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['color', $this->parseInline($matches[2]), $matches[1]],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 2 characters
        return [['text', '{'], 1];
    }

    // rendering is the same as for block elements, we turn the abstract syntax array into a string.
    protected function renderColor($element)
    {
        return '<span style="color:' . $element[2] . '">' . $this->renderAbsy($element[1]) . '</span>';
        //return '<font color="' . $element[2] . '">' . $this->renderAbsy($element[1]) . '</font>';
    }
}

class ColoredMarkdown extends \cebe\markdown\GithubMarkdown
{
    use ColorBlockTrait;
    use InlineColorTrait;
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
