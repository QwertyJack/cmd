# Colored Markdown
Based on [cebe/markdown](https://github.com/cebe/markdown),
add color and MathJax support.

### Requirements
* [PHP 5.4 or higher](https://github.com/cebe/markdown#installation-)

### Installation
```
# checkout src
git clone https://github.com/QwertyJack/cmd.git

# install composer
curl -sS https://getcomposer.org/installer | php
# or
#php -r "readfile('https://getcomposer.org/installer');" | php

# install dependencies
php composer.phar update
```

### Usage
* http (use `curl` for example)
```
curl <url/to/parser.php> -d text='{red **Hello World**}'
```
See also [index.html](index.html) and [static/my.js](static/my.js)

* cli
```
cat demo.md | php parser.php
```

A playground is [HERE](http://cyp.davidandjack.cn/test/r/).

**HAVE FUN !!!**
