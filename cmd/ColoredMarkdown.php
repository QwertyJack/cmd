<?php
/**
 * Short description for ColoredMarkdown.php
 *
 * @package ColoredMarkdown
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

class ColoredMarkdown extends \cebe\markdown\GithubMarkdown
{
    protected $escapeCharacters = [
        // from Markdown
        '\\', // backslash
        '`', // backtick
        '*', // asterisk
        '_', // underscore
        '{', '}', // curly braces
        '[', ']', // square brackets
        '(', ')', // parentheses
        '#', // hash mark
        '+', // plus sign
        '-', // minus sign (hyphen)
        '.', // dot
        '!', // exclamation mark
        '<', '>',
        // added by GithubMarkdown
        ':', // colon
        '|', // pipe
		// added by ColoredMarkdown
		'$',
    ];

    use ColorBlockTrait;
    use InlineColorTrait_dev;
    use MathJaxBlockTrait;
    use InlineMathJaxTrait;
}

