<?php
/**
 * Short description for InlineColorTrait_nonested.php
 *
 * @package InlineColorTrait_nonested
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

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
