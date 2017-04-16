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

namespace jack\cmd;

trait ColorBlockTrait
{
    protected function identifyColorBlock($line, $lines, $current)
    {
        // if a line starts with at least 3 { it is identified as a color block
        if (strncmp($line, '{{{', 3) === 0)
            return true;
        return false;
    }

    protected function consumeColorBlock($lines, $current)
    {
        // create block array
        $block = [
            'colorBlock',
            'content' => [],
        ];
        $line = rtrim($lines[$current]);

        // detect color, could be null or anything else
        $fence = substr($line, 0, $pos = strrpos($line, '{') + 1);
        $color = substr($line, $pos);
        if (!empty($color))
            $block['color'] = $color;
        else 
            $block['color'] = '';

        // consume all lines until }}}
        for($i = $current + 1, $count = count($lines); $i < $count; $i++) {
            if (rtrim($line = $lines[$i]) !== '}}}') {
                $block['content'][] = $line;
            } else {
                // stop codeonsuming when color block is over
                break;
            }
        }
        return [$block, $i];
    }

    // render
    protected function renderColorBlock($block)
    {
        //$class = isset($block['color']) ? ' class="color-' . $block['color'] . '"' : '';
        $inner = $this->parse(implode("\n", $block['content']));
        return "<div style='color:" . ltrim($block['color']) . "'>" . $inner . '</div>';
    }
}

trait InlineColorTrait_nonested
{
    /**
     * @marker {
     */
    protected function parseColor($markdown)
    {
        // greedy match
        if (preg_match('/^{([\(\),#\w]+?) ([\s\S]+?)}/', $markdown, $matches))
        {
            return [
                // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                // other inline markdown elements inside this tag
                ['color', $this->parseInline($matches[2]), $matches[1]],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing { we just return the marker and skip 1 characters
        return [['text', '{'], 1];
    }

    // rendering is the same as for block elements, we turn the abstract syntax array into a string.
    protected function renderColor($element)
    {
        return '<span style="color:' . $element[2] . '">' . $this->renderAbsy($element[1]) . '</span>';
    }
}

trait InlineColorTrait_dev
{
    /**
     * @marker {
     */
    protected function parseColor($markdown)
    {
        // greedy match
        if (preg_match('/^{([\(\),#\w]+?) ([\s\S]+)}/', $markdown, $matches))
        {
            // if matched contains inner '}.*{'
            if (preg_match('/}.*{/', $matches[2]))
            {
                // then re-match non-greedyly
                preg_match('/^{([\(\),#\w]+?) ([\s\S]+?)}/', $markdown, $matches2);
                return [
                    ['color', $this->parseInline($matches2[2]), $matches2[1]],
                    strlen($matches2[0])
                ];
            }
            else
            {
                return [
                    // return the parsed tag as an element of the abstract syntax tree and call `parseInline()` to allow
                    // other inline markdown elements inside this tag
                    ['color', $this->parseInline($matches[2]), $matches[1]],
                    // return the offset of the parsed text
                    strlen($matches[0])
                ];
            }
        }
        // in case we did not find a closing { we just return the marker and skip 1 characters
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
        if (strncmp($line, '$$', 2) === 0)
            return true;
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
        if (strlen($lines[$current]) === 0 )
            $current += 1;

        // consume all lines until next $$
        for($i = $current, $count = count($lines); $i < $count; $i++) {
            if ($pos = strpos($line = ltrim($lines[$i]), '$$') !== False) {
                $pos = strpos($line, '$$');
                // stop codeonsuming when another $$ appears
                if ($pos !== 0)
                    $block['content'][] = substr($line, 0, $pos - 1);
                $block['after'] = ltrim(substr($line, $pos + 2));
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
        if (preg_match('/^\$\$(.+?)\$\$/', $markdown, $matches))
        {
            return [
                // return elements inside this tag directly
                ['mathJax', $matches[1], 2],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // $ math $
        if (preg_match('/^\$(.+?)\$/', $markdown, $matches))
        {
            return [
                // return elements inside this tag directly
                ['mathJax', $matches[1], 1],
                // return the offset of the parsed text
                strlen($matches[0])
            ];
        }
        // in case we did not find a closing $ we just return the marker and skip 1 characters
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

