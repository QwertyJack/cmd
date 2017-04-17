#!/usr/bin/env php

<?php
/**
 * Short description for block.php
 *
 * @package block
 * @author jack <jack@cyp>
 * @version 0.1
 * @copyright (C) 2017 jack <jack@cyp>
 * @license MIT
 */

require 'vendor/autoload.php';

class MyMarkdown extends \cebe\markdown\Markdown
{
    // identify
    protected function identifyFencedCode($line, $lines, $current)
    {
        // if a line starts with at least 3 backticks it is identified as a fenced code block
        if (strncmp($line, '```', 3) === 0) {
            return true;
        }
        return false;
    }

    // consume
    protected function consumeFencedCode($lines, $current)
    {
        // create block array
        $block = [
            'fencedCode',
            'linescontent' => [],
        ];
        $line = rtrim($lines[$current]);

        // detect language and fence length (can be more than 3 backticks)
        $fence = substr($line, 0, $pos = strrpos($line, '`') + 1);
        $language = substr($line, $pos);
        if (!empty($language)) {
            $block['language'] = $language;
        }

        // consume all lines until ```
        for($i = $current + 1, $count = count($lines); $i < $count; $i++) {
            if (rtrim($line = $lines[$i]) !== $fence) {
                $block['content'][] = $line;
            } else {
                // stop codeonsuming when code block is over
                break;
            }
        }
        return [$block, $i];
    }

    // render
    protected function renderFencedCode($block)
    {
        $class = isset($block['language']) ? ' classass="language-' . $block['language'] . '"' : '';
        return "<pre><code$class>" . htmlspecialchars(implode("\n", $block['content']) . "\n", ENT_NOQUOTES, 'UTF-8') . '</code></pre>';
    }
}

$markdown = <<<EOF
```
// '**Hello** ~~World~~ !!!~~';
int a = 1;
return a + 1;
```
EOF;

$parser = new MyMarkdown();
echo $parser->parse($markdown);
