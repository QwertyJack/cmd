# Colored Markdown
Based on [cebe/markdown](https://github.com/cebe/markdown),
add color and MathJax support.

### Requirements
* [PHP 5.4 or higher](https://github.com/cebe/markdown#installation-)

### Installation
```
# checkout src
git clone https://github.com/QwertyJack/cmd.git

# install dependencies
php composer.phar update
```

### Usage
* http (use `curl` for example)
```
curl <url/to/parser.php> -d text='{red **Hello World**}'
```
This will generate **{red Hello World}**.

See also [index.html](index.html) and [static/my.js](static/my.js)

* cli
```
cat demo.md | php parser.php
```
or
```
php parser.php demo.md
```

* parser for terminal
```
cat demo.md | php cli.php
```
or
```
php cli.php demo.php
```

A playground is [HERE](http://cyp.davidandjack.cn/test/r/).

### Known Bugs
+ The terminal parser fail to parse list begin with `*`.
+ Nested inline color make a mess.
+ Color blocks make the following table cells not parsed correctly.

### TODO
- Sanitizing; maybe [ircmaxell/Stauros](https://github.com/ircmaxell/Stauros).
- Beautify tables in terminal.
- Find a nearest color for unknown ones in terminal instead of just ignore it.

### Acknowledgement
+ [cebe/markdown](https://github.com/cebe/markdown)
+ [mathjax/MathJax](https://github.com/mathjax/MathJax)
+ [composer/composer](https://github.com/composer/composer)
+ [mogria/colorful.php](https://github.com/mogria/colorful.php)
+ [XSS vulnerability by @showdownjs](https://github.com/showdownjs/showdown/wiki/Markdown's-XSS-Vulnerability-(and-how-to-mitigate-it))

**HAVE FUN !!!**
