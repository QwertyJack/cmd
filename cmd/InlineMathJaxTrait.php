<?php
/**
 * Short description for InlineMathJaxTrait.php
 *
 * @package InlineMathJaxTrait
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

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
