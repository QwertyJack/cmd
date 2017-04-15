<?php
/**
 * Short description for ColoredTrait.php
 *
 * @package ColoredTrait
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

function mydb($str) {
    echo '+++: ' . $str . PHP_EOL;
}

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
        if (preg_match('/^{([\(\),#\w]+?) ([^{}]+?)}/', $markdown, $matches)) {
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
    }
}

trait MathJaxBlockTrait
{
    // identify
    protected function identifyMathJaxBlock($line, $lines, $current)
    {
        if (strncmp($line, '$$', 2) === 0) {
            return true;
        }
        return false;
    }

    // consume
    protected function consumeMathJaxBlock($lines, $current)
    {
        // create block array
        $block = [
            'mathJaxBlock',
            'content' => [],
            'after' => '',
        ];
        $pos = strpos($line = $lines[$current], '$$');
        $lines[$current] = substr($line, $pos + 2);

        // consume all lines until next $$
        for($i = $current, $count = count($lines); $i < $count; $i++) {
            if ($pos = strpos($line = $lines[$i], '$$') !== False) {
                // stop codeonsuming when code block is over
                if ($pos !== 1)
                    $block['content'][] = substr($line, 0, $pos - 1);
                $block['after'] = substr($line, $pos + 1);
                break;
            } else {
                $block['content'][] = $line;
            }
        }
        return [$block, $i];
    }

    // render
    protected function renderMathJaxBlock($block)
    {
        $inner = implode("\n", $block['content']);
        return '$$' . $inner . '$$ ' . $this->parse($block['after']);
    }
}

trait InlineMathJaxTrait
{
    /**
     * @marker $
     */
    protected function parseMathJax($markdown)
    {
        // $$ math $$
        if (preg_match('/^\$\$(.+?)\$\$/', $markdown, $matches)) {
            return [
                // return elements inside this tag directly
                ['mathJax', $matches[1], 2],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // $ math $
        if (preg_match('/^\$(.+?)\$/', $markdown, $matches)) {
            return [
                // return elements inside this tag directly
                ['mathJax', $matches[1], 1],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing ~~ we just return the marker and skip 1 characters
        return [['text', '$'], 1];
    }

    // rendering is the same as for block elements, we turn the abstract syntax array into a string.
    protected function renderMathJax($element)
    {
        if ($element[2] === 1)
            return ' $' . ltrim($element[1]) . '$ ';
        if ($element[2] === 2)
            return '$$' . ltrim($element[1]) . '$$';
    }
}

