## **{orange Hello}** {green *Colored*} {rgb(250,00,0) World} {#0000ff ***!!!***}

### {red Inline Color}
- `{Aqua foo}` rendered as {Aqua foo}
- nested color seems not work properly, i.e.
    * `{red red {blue blue}}`
    * {red red {blue blue}}

### {purple Color Block}
- Use color as an 'outer block'

```
{{{ blue
This is a paragraph with __color__ !

*Color block* works properly with {red **inlined color**} !!!
}}}
```
- rendered

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

- or colored code

{{{ maroon
```
int a = 1;
return 0;
```
}}}

### {green MathJax Compatible}
MathJax supports color, so use it directly, i.e.:

* Inline: `$\color{Fuchsia}{e^{i\pi} + 1 = 0}$`  rendered as  $\color{Fuchsia}{e^{i\pi} + 1 = 0}$
* Block: 
```tex
$$
\color{orange}{
    e^{i\pi} + 1 = 0
}
$$
```
- rendered as
$$
\color{orange}{
    e^{i\pi} + 1 = 0
}
$$

### {red Source Code}
* {maroon See} [{pink demo.md}](demo.md)

### {blue Notes}
There is a bug when using Color Block before a table: the cell may not parsed correctly.
This is caused by nested parsing inside a Color Block.

To solve the problem just surround the table with an empty Color Block.

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
