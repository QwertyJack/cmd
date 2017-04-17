#!/usr/bin/env php
<?php

namespace jack\cmd;

require 'vendor/autoload.php';

$parser = new ColoredMarkdownCLI();

if (php_sapi_name() === 'cli') {
    if ($argc > 1)
        $markdown = file_get_contents($argv[1]);
    else
        $markdown = stream_get_contents(STDIN);
    echo $parser->parse($markdown);
} else {
    die();
}
