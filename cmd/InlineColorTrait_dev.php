<?php
/**
 * Short description for InlineColorTrait_dev.php
 *
 * @package InlineColorTrait_dev
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

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
