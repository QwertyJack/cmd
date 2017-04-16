<?php

namespace jack\cmd;

function color($text, $modifier = Array(), $forecolor = null, $backcolor = null) {
    $mode = (count($modifier) === 0) ? '' : implode("_and_", $modifier);
    $fore = (strlen($forecolor) === 0) ? '' : '_' . $forecolor;
    $back = (strlen($backcolor) === 0) ? '' : '_on_' . $backcolor;
    $methodname = strtolower(ltrim($mode . $fore . $back, '_'));
    return call_user_func_array('jack\cmd\Colorful::' . $methodname, array($text));
}

function color_test() {
    foreach (Colorful::$modifiers as $k => $v)
        print color($k, Array($k)) . PHP_EOL;
}

class Colorful {
  // Ansi Modifiers
  public static $modifiers = Array(
    'default'       => 0,
    'none'          => 0,
    'bold'          => 1,
    'faint'         => 2,
    'italic'        => 3,
    'standout'      => 3,
    'underline'     => 4,
    'blink'         => 5,
    //'fast-blink'    => 6,
    'reverse'       => 7,
    'conceal'       => 8,
    'strikethrough' => 9,
    'normal'        => 22,
  );

  // Ansi foreground colors
  protected static $forecolors = Array(
    'black'    => 30,
    'red'      => 31,
    'green'    => 32,
    'yellow'   => 33,
    'blue'     => 34,
    'magenta'  => 35,
    'cyan'     => 36,
    'white'    => 37,
    'default'  => 39,
  );

  // Ansi background colors
  protected static $backcolors = Array(
    'black'    => 40,
    'red'      => 41,
    'green'    => 42,
    'yellow'   => 43,
    'blue'     => 44,
    'magenta'  => 45,
    'cyan'     => 46,
    'white'    => 47,
    'default'  => 49,
  );

  const MODIFIER_SPLITTER = "and";
  const BACKCOLOR_SPLITTER = "on";

  protected static function isModifier($modifier) {
    return array_key_exists($modifier, self::$modifiers);
  }

  protected static function getANSIDecorator($mode) {
    return sprintf("\033[%sm", $mode);
  }

  protected static function translateToANSIDecorator($modetype, $name) {
    if(array_key_exists($name, $modetype)) {
      return self::getANSIDecorator($modetype[$name]);
    } else {
      return self::getANSIDecorator($modetype['default']);
      //throw new ANSISequenceNotFoundException("ANSI Sequence `$name` could not be found");
    }
  }

  protected static function parseAttr($attr) {
    $parts = explode("_", $attr);

    $modifiers = "";
    $forecolor = "";
    $backcolor = "";

    do {
      if(self::isModifier($parts[0])) {
        $modifiers .= self::translateToANSIDecorator(self::$modifiers, array_shift($parts));
      }
    } while(isset($parts[0]) && $parts[0] === self::MODIFIER_SPLITTER && array_shift($parts));

    if(in_array(self::BACKCOLOR_SPLITTER, $parts)) {
      $backcolor = self::translateToANSIDecorator(self::$backcolors, $parts[array_search(self::BACKCOLOR_SPLITTER, $parts) + 1]);
      $parts = array_slice($parts, 0, -2);
    }

    if(count($parts) > 0) {
      $forecolor = self::translateToANSIDecorator(self::$forecolors, $parts[0]);
    }

    return $modifiers . $forecolor . $backcolor . "%s" . self::translateToANSIDecorator(self::$modifiers, "default");
  }

  public static function __callStatic($methodname, $arguments) {
    $text = implode("", $arguments);
    return sprintf(self::parseAttr($methodname), $text);
  }
}
