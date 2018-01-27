# code-golf

My solutions for problems posted on [https://codegolf.stackexchange.com/questions/tagged/code-golf][7]


## Techniques for shortening the PHP source code for [code golf][7]:

* use short names (1 letter) for variables, function names and function arguments;
* use [short syntax for arrays][3]; it requires PHP 5.4 or newer (saves 5 bytes for each array);
* combine initialization of many variables with the same value into a [chained assignment][4];
  (saves at least 2 bytes for each variable);
* remove the initialization with `0`, `''` or `array()` completely when the first use of the variable
  is in the correct context; PHP triggers a notice and uses `0`, `''` or `array()` as default value 
  when an undefined variable is used in a numeric, string or array operation; (saves 5-6 bytes
  for each variable);
* squeeze the initialization of variables, if possible, into the initialization expression
  of the [`for` statement][5]; (saves 1 byte);
* squeeze as much statements as possible from the `for` block inside the last expression of
  the [`for` statement][5]; (saves 1-2 bytes);
* squeeze, when possible, variable assignments inside their first usage (comparisons, when
  used as index etc); (saves at least 3 bytes);
* strip the quotes or apostrophes from around strings that can be used as constant names; when
  PHP encounters an identifier that looks like a constant name but no constant with that name
  is defined, [it triggers a notice and converts the name into a string][1]; (saves 2 bytes);
* strip the whitespace between a PHP keyword (`as`, `return`, `else`, `echo` etc) and the variable
  that follows it (saves 1 byte);
* strip the [block markers (`{` and `}`)][6] when they enclose a single statement; (saves 2 bytes);
* combine multiple expression statements, if possible, into a single expression using the comma
  operator (`,`); it doesn't save any byte but allows removing the block markers when its outcome
  is a single expression inside a block (see above); 
* extract duplicate string fragments into variables and use the [variables inside double-quoted 
  strings][2];
* extract into variables the names of functions that are invoked two or more times; don't quote
  the names (see above);


   [1]: https://php.net/manual/en/language.types.array.php#language.types.array.foo-bar
   [2]: https://php.net/manual/en/language.types.string.php#language.types.string.parsing
   [3]: https://php.net/manual/en/language.types.array.php#language.types.array.syntax.array-func
   [4]: https://php.net/manual/en/language.operators.assignment.php#language.operators.assignment
   [5]: https://php.net/manual/en/control-structures.for.php
   [6]: https://php.net/manual/en/control-structures.intro.php
   [7]: https://codegolf.stackexchange.com/questions/tagged/code-golf
