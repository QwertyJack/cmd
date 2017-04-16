<?php
/**
 * Short description for ColorBlockTrait.php
 *
 * @package ColorBlockTrait
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
