# Colored Markdown

### Requirements
* PHP
* composer
    - To install [cebe/markdown](https://github.com/cebe/markdown#installation-).

### Usage

* Install cebe/markdown
```
composer require cebe/markdown "~1.0.1"
```

* Install MathJax
```
tar zxf 2.7.0.tar.gz
```

* BOOM !!!
  - use `php-cli`
```
cat demo.md | php parser.php >demo.index
```
  - or via a web server (use `curl` as client for example)
```
curl <url/to/parser.php> -d text='[color red]**Hello World**[/color]'
```

The playground is [HERE](http://cyp.davidandjack.cn/test/r/).

**HAVE FUN !!!**
