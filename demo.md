## **{orange Hello}** {green *Colored*} {rgb(250,00,0) World} {#0000ff ***!!!***}
***单击右侧刷新***

### {red Inline Color}
* Syntax: `{[color] text}` (notice there is a __space__ between color and text)
* `{Aqua foo}` rendered as {Aqua foo}
* Compatible with other markdown inline element
    - {green _inner em_}
    - __{maroon outer strong}__
    - {orange `inner code`}
    - *{blue italic}*
* Nested color is supported, but at your own risk.
    - `{red red {blue blue}}` rendered as {red red {blue blue}}
    - `{red red} {blue blue}` more recommended; the same effect: {red red} {blue blue}
    - {red or {orange even {green more {blue and {purple more {maroon crazy}}}}}}

### {purple Color Block}
- Use color as an 'outer block', eg.

```
{{{ blue
This is a paragraph with __color__ !

*Color block* works properly with {red **inlined color**} !!!
}}}
```
- rendered as

{{{ blue
This is a paragraph with __color__ !

*Color block* works properly with {red **inlined color**} !!!
}}}

- another example: colored list

{{{ red
* item {green green}
* item {black __em__}
* item {blue *italic*}
    - subitem {lime `pre`}
    - subitem $ \color{navy}{x^2 + y^2 = z^2} $
}}}

- and more: colored code

{{{ maroon
```
int a = 1;
return 0;
```
}}}

- nested colored block

```
{{{red
red text

{{{green
green text

{{{ blue
blue text
}}}
normal
```
rendered as (notice: *only one `}}}` is required* because Color Block will closes
itself once entering in another Color Block)

{{{red
red text

{{{green
green text

{{{ blue
blue text
}}}
normal

### {green MathJax Compatible}
MathJax supports color, so use it directly, eg.

* Inline: `$\color{Fuchsia}{e^{i\pi} + 1 = 0}$`  rendered as  $\color{Fuchsia}{e^{i\pi} + 1 = 0}$
* Block:
```tex
$$
\color{orange}{
    e^{i\pi} + 1 = 0
} \\
\color{green}{
    F_n = F_{n-1} + F_{n-2}
}
$$
```
rendered as

$$
\color{orange}{
    e^{i\pi} + 1 = 0
} \\
\color{green}{
    F_n = F_{n-1} + F_{n-2}
}
$$

* You can mix inline or block formulae with other markdown inline or block
elements in most cases. However the only exception appears when using formulae
begin with 4 spaces or a tab in a paragraph <sup>{red bug}</sup>, eg.

```
Here is a paragraph and goes the formula $$
    x = 1;
$$ note there is 4 spaces in front of the formula.
```
This snippet will be parsed as a `code` block thus the 1st '$$' is consumed.

### {red Source Code}
* {maroon See} [{pink demo.md}](demo.md)

### {blue Known Bugs}
* ~~Nested inlined Color~~ <sup>{green fixed}</sup>
* ~~Formulae begin with 4 spaces or a tab inside a paragraph may parsed into a code block.~~ <sup>{blue partial fixed}</sup>
    - Solution: do not add extra white space before formulae inside paragraph.
* ~~Table after a Color Black may not be parsed correctly.~~ <sup>{green hacked}</sup>
    - Solution: surround the table with an empty Color Block.

### Colors Table
{{{
color | hex | red | green | blue | CGA(alias)
----- | --- | --- | ----- | ---- | ---
{White White}  | #FFFFFF | 255 | 255 | 255 | 15 (white)
{Silver Silver}  | #C0C0C0 | 192 | 192 | 192 | 7 (light gray)
{Gray Gray}  | #808080 | 128 | 128 | 128 | 8 (dark gray)
{Black Black}  | #000000 | 0 | 0 | 0 | 0 (black)
{Red Red}  | #FF0000 | 255 | 0 | 0 | 12 (high red)
{Maroon Maroon}  | #800000 | 128 | 0 | 0 | 4 (low red)
{Yellow Yellow}  | #FFFF00 | 255 | 255 | 0 | 14 (yellow)
{Olive Olive}  | #808000 | 128 | 128 | 0 | 6 (brown)
{Lime Lime}  | #00FF00 | 0 | 255 | 0 | 10 (high green); green
{Green Green}  | #008000 | 0 | 128 | 0 | 2 (low green)
{Aqua Aqua}  | #00FFFF | 0 | 255 | 255 | 11 (high cyan); cyan
{Teal Teal}  | #008080 | 0 | 128 | 128 | 3 (low cyan)
{Blue Blue}  | #0000FF | 0 | 0 | 255 | 9 (high blue)
{Navy Navy}  | #000080 | 0 | 0 | 128 | 1 (low blue)
{Fuchsia Fuchsia}  | #FF00FF | 255 | 0 | 255 | 13 (high magenta); magenta
{Purple Purple}  | #800080 | 128 | 0 | 128 | 5 (low magenta)
}}}
