<?php
/**
 * Short description for MathJaxBlockTrait.php
 *
 * @package MathJaxBlockTrait
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

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
