<?php
/**
 * Short description for ColoredMarkdownCLI.php
 *
 * @package ColoredMarkdownCLI
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

namespace jack\cmd;

class ColoredMarkdownCLI extends \cebe\markdown\Parser
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
    //ColoredTrait.php:    protected function renderColorBlock($block)
    protected function renderColorBlock($block)
    {
        $inner = $this->parse(implode("\n", $block['content']));
        return Colorful::color($inner, Array(), ltrim($block['color']));
    }

    use InlineColorTrait_nonested;
    //ColoredTrait.php:    protected function renderColor($element)
    protected function renderColor($element)
    {
        return Colorful::color($this->renderAbsy($element[1]), Array(), $element[2]);
    }

    use MathJaxBlockTrait;
    //ColoredTrait.php:    protected function renderMathJaxBlock($block)
    protected function renderMathJaxBlock($block)
    {
        $inner = implode("\n", $block['content']);
        return '$$' . PHP_EOL . $inner . PHP_EOL . '$$' . PHP_EOL . $this->parse($block['after']);
    }

    use InlineMathJaxTrait;
    //ColoredTrait.php:    protected function renderMathJax($element)
    protected function renderMathJax($element)
    {
        $inner = rtrim(ltrim($element[1]));
        if ($element[2] === 1)
            return '$ ' . $inner . ' $';
        if ($element[2] === 2)
            return PHP_EOL . '$$' . PHP_EOL . $inner . PHP_EOL . '$$' . PHP_EOL;
    }

    //vendor/cebe/markdown/Parser.php:	protected function renderParagraph($block)
	protected function renderParagraph($block)
	{
		return PHP_EOL . $this->renderAbsy($block['content']) . PHP_EOL;
	}

    use \cebe\markdown\inline\EmphStrongTrait;
    //vendor/cebe/markdown/inline/EmphStrongTrait.php:	protected function renderStrong($block)
	protected function renderStrong($block)
	{
        return Colorful::color($this->renderAbsy($block[1]), array('bold'));
	}
    //vendor/cebe/markdown/inline/EmphStrongTrait.php:	protected function renderEmph($block)
	protected function renderEmph($block)
	{
        return Colorful::color($this->renderAbsy($block[1]), array('reverse'));
	}

    use \cebe\markdown\block\FencedCodeTrait;
    //vendor/cebe/markdown/block/CodeTrait.php:	protected function renderCode($block)
	protected function renderCode($block)
	{
        $class = isset($block['language']) ? $block['language'] : '';
        return "```" . $class . "\n" . $block['content'] . "\n" . "```\n";
	}
    use \cebe\markdown\inline\CodeTrait;
    //vendor/cebe/markdown/inline/CodeTrait.php:	protected function renderInlineCode($block)
	protected function renderInlineCode($block)
	{
        return '`' . $block[1] . '`';
		//return '<code>' . htmlspecialchars($block[1], ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</code>';
	}

    //use \cebe\markdown\block\ListTrait;
    //vendor/cebe/markdown/block/ListTrait.php:	protected function renderList($block)

    //vendor/cebe/markdown/block/RuleTrait.php:	protected function renderHr($block)
    //vendor/cebe/markdown/block/QuoteTrait.php:	protected function renderQuote($block)
    //vendor/cebe/markdown/block/QuoteTrait.php:	abstract protected function renderAbsy($absy);
    //vendor/cebe/markdown/block/HtmlTrait.php:	protected function renderHtml($block)
    //vendor/cebe/markdown/block/HtmlTrait.php:	protected function renderInlineHtml($block)
    //vendor/cebe/markdown/block/TableTrait.php:	protected function renderTable($block)
    //vendor/cebe/markdown/block/TableTrait.php:	abstract protected function renderAbsy($absy);
    //vendor/cebe/markdown/block/ListTrait.php:	abstract protected function renderAbsy($absy);
    //vendor/cebe/markdown/block/HeadlineTrait.php:	protected function renderHeadline($block)
    //vendor/cebe/markdown/block/HeadlineTrait.php:	abstract protected function renderAbsy($absy);
    //vendor/cebe/markdown/inline/UrlLinkTrait.php:	protected function renderAutoUrl($block)

    //use \cebe\markdown\block\HtmlTrait {
        //parseInlineHtml as private;
    //}
    use \cebe\markdown\inline\LinkTrait;
    protected function prepare()
    {
        $this->references = [];
    }
	protected function parseLt($text) {
		return [['text', '<'], 1];
	}

    //vendor/cebe/markdown/inline/LinkTrait.php:	protected function renderEmail($block)
    //vendor/cebe/markdown/inline/LinkTrait.php:	protected function renderLink($block)
	protected function renderLink($block)
	{
		if (isset($block['refkey'])) {
			if (($ref = $this->lookupReference($block['refkey'])) !== false) {
				$block = array_merge($block, $ref);
			} else {
				return $block['orig'];
			}
		}
		//$attributes = $this->renderAttributes($block);
        return '[' . Colorful::color($this->renderAbsy($block['text']), Array('underline'), 'blue') .
            '](' . Colorful::color($block['url'], Array(), 'green') . ')';
		//return '<a href="' . htmlspecialchars($block['url'], ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
			//. (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
			//. $attributes . '>' . $this->renderAbsy($block['text']) . '</a>';
	}
    //vendor/cebe/markdown/inline/LinkTrait.php:	protected function renderUrl($block)
	protected function renderUrl($block)
	{
		$url = htmlspecialchars($block[1], ENT_COMPAT | ENT_HTML401, 'UTF-8');
		$text = htmlspecialchars(urldecode($block[1]), ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
		return "[" . $text . '](' . $url . ')';
		//return "<a href=\"$url\">$text</a>";
	}
    //vendor/cebe/markdown/inline/LinkTrait.php:	protected function renderImage($block)
    protected function renderImage($block)
    {
        if (isset($block['refkey'])) {
            if (($ref = $this->lookupReference($block['refkey'])) !== false) {
                $block = array_merge($block, $ref);
            } else {
                return $block['orig'];
            }
        }
        return '![' . Colorful::color($block['text'], Array('underline'), 'magenta') . '](' .
			Colorful::color($block['url'], Array(), 'yellow') .
            (empty($block['title']) ? '' : Colorful::color(' "' . $block['title'] . '"', Array('bold'))) . ')';
    }
    //vendor/cebe/markdown/inline/StrikeoutTrait.php:	protected function renderStrike($block)
}

