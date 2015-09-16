<?php
/**
 * Code Golf: Recursive ASCII spirals
 *
 * @link http://codegolf.stackexchange.com/questions/55819/recursive-ascii-spirals
 */

// Check the PHP version
if (PHP_VERSION < '5.4') {
    // This script uses features introduced in PHP 5.4 (short array syntax)
    // PHP 5.4 is dead meat now; it reached its end of life on September 14, 2014
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Hide notices. It can be passed as argument to the CLI:
//   php -d error_reporting=0 recursive-ascii-spirals.php
error_reporting(E_ALL & ~E_NOTICE);


// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';


// This script has 3 running modes:
//  * without arguments it runs the tests and exits; it tests both the detailed and the golfed version of the code;
//  * with exactly 4 arguments it runs the golfed code and displays the ASCII spirals (assuming the argument are correct);
//  * otherwise it outputs the source code of the golfed program, with use directions; the output can be saved
//    in a .php file and run later or it can be piped directly to another instance of PHP to be executed immediately.

if ($argc == 1) {
    // No arguments => display the help
    usage();

    // ... then run the tests and exit
    echo("\n");
    echo("Running the tests...\n");


    /////////////////////////////////////////////////////////////////////////
    // Test the helper functions
    //

    // 1x1
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 1, $dir = 'u', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 1, $dir = 'r', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 1, $dir = 'd', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 1, $dir = 'l', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&
E
    );


    // 2x2
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'u', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
>v
@&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'r', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
@v
&<
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'd', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&@
^<
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'l', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
>&
^@
E
    );


    // 2x2 counter-clockwise
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'u', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
v<
&@
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'r', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
&<
@^
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'd', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
@&
>^
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 2, $dir = 'l', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
v@
>&
E
    );


    // 3x3
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'u', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&>v
|@|
^-<
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'r', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
>-&
|@v
^-<
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'd', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
>-v
|@|
^<&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'l', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
>-v
^@|
&-<
E
    );


    // 3x3 counter-clockwise
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'u', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
v<&
|@|
>-^
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'r', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
v-<
|@^
>-&
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'd', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
v-<
|@|
&>^
E
    );
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 3, $dir = 'l', $c = 'c'),
        drawSquare($size, $dir, $c) === <<< E
&-<
v@|
>-^
E
    );


    // 7x7 counter-clockwise
    it(
        sprintf('generates a square of size: %d, direction: %s', $size = 7, $dir = 'u', $c = ''),
        drawSquare($size, $dir, $c) === <<< E
&>----v
||>--v|
|||>v||
|||@|||
||^-<||
|^---<|
^-----<
E
    );


    /////////////////////////////////////////////////////////////////////////
    // Test cases provided in the question
    //

    testSpiral(
        '2d4', <<< E
&@@@@
^<<<<
E
    );

    testSpiral(
        '4rc3', <<< E
&--<
v-<|
|@^|<
>--^|
 |@^|<
 >--^|
  |@^|
  >--^
E
    );

    testSpiral(
        '7u1', <<< E
&>----v
||>--v|
|||>v||
|||@|||
||^-<||
|^---<|
^-----<
E
    );


    /////////////////////////////////////////////////////////////////////////
    // More test cases provided in other answers
    //

    testSpiral(
        '8r3', <<< E
      >------v
      |>----v|
      ||>--v||
      |||@v|||
   >------v|||
   |>----v|<||
   ||>--v||-<|
   |||@v|||--<
>------v|||
|>----v|<||
||>--v||-<|
|||@v|||--<
||^-<|||
|^---<||
^-----<|
&------<
E
    );

    testSpiral(
        '8rc3', <<< E
&------<
v-----<|
|v---<||
||v-<|||
|||@^|||--<
||>--^||-<|
|>----^|<||
>------^|||
   |||@^|||--<
   ||>--^||-<|
   |>----^|<||
   >------^|||
      |||@^|||
      ||>--^||
      |>----^|
      >------^
E
    );

    testSpiral(
        '20lc10', <<< E
v------------------<
|v----------------<|
||v--------------<||
|||v------------<|||
||||v----------<||||
|||||v--------<|||||
||||||v------<||||||
|||||||v----<|||||||
||||||||v--<||||||||
|||||||||v@|||||||||
|||||||||v------------------<
||||||||>|v----------------<|
|||||||>-||v--------------<||
||||||>--|||v------------<|||
|||||>---||||v----------<||||
||||>----|||||v--------<|||||
|||>-----||||||v------<||||||
||>------|||||||v----<|||||||
|>-------||||||||v--<||||||||
>--------|||||||||v@|||||||||
         |||||||||v------------------<
         ||||||||>|v----------------<|
         |||||||>-||v--------------<||
         ||||||>--|||v------------<|||
         |||||>---||||v----------<||||
         ||||>----|||||v--------<|||||
         |||>-----||||||v------<||||||
         ||>------|||||||v----<|||||||
         |>-------||||||||v--<||||||||
         >--------|||||||||v@|||||||||
                  |||||||||v------------------<
                  ||||||||>|v----------------<|
                  |||||||>-||v--------------<||
                  ||||||>--|||v------------<|||
                  |||||>---||||v----------<||||
                  ||||>----|||||v--------<|||||
                  |||>-----||||||v------<||||||
                  ||>------|||||||v----<|||||||
                  |>-------||||||||v--<||||||||
                  >--------|||||||||v@|||||||||
                           |||||||||v------------------<
                           ||||||||>|v----------------<|
                           |||||||>-||v--------------<||
                           ||||||>--|||v------------<|||
                           |||||>---||||v----------<||||
                           ||||>----|||||v--------<|||||
                           |||>-----||||||v------<||||||
                           ||>------|||||||v----<|||||||
                           |>-------||||||||v--<||||||||
                           >--------|||||||||v@|||||||||
                                    |||||||||v------------------<
                                    ||||||||>|v----------------<|
                                    |||||||>-||v--------------<||
                                    ||||||>--|||v------------<|||
                                    |||||>---||||v----------<||||
                                    ||||>----|||||v--------<|||||
                                    |||>-----||||||v------<||||||
                                    ||>------|||||||v----<|||||||
                                    |>-------||||||||v--<||||||||
                                    >--------|||||||||v@|||||||||
                                             |||||||||v------------------<
                                             ||||||||>|v----------------<|
                                             |||||||>-||v--------------<||
                                             ||||||>--|||v------------<|||
                                             |||||>---||||v----------<||||
                                             ||||>----|||||v--------<|||||
                                             |||>-----||||||v------<||||||
                                             ||>------|||||||v----<|||||||
                                             |>-------||||||||v--<||||||||
                                             >--------|||||||||v@|||||||||
                                                      |||||||||v------------------<
                                                      ||||||||>|v----------------<|
                                                      |||||||>-||v--------------<||
                                                      ||||||>--|||v------------<|||
                                                      |||||>---||||v----------<||||
                                                      ||||>----|||||v--------<|||||
                                                      |||>-----||||||v------<||||||
                                                      ||>------|||||||v----<|||||||
                                                      |>-------||||||||v--<||||||||
                                                      >--------|||||||||v@|||||||||
                                                               |||||||||v------------------<
                                                               ||||||||>|v----------------<|
                                                               |||||||>-||v--------------<||
                                                               ||||||>--|||v------------<|||
                                                               |||||>---||||v----------<||||
                                                               ||||>----|||||v--------<|||||
                                                               |||>-----||||||v------<||||||
                                                               ||>------|||||||v----<|||||||
                                                               |>-------||||||||v--<||||||||
                                                               >--------|||||||||v@|||||||||
                                                                        |||||||||v------------------<
                                                                        ||||||||>|v----------------<|
                                                                        |||||||>-||v--------------<||
                                                                        ||||||>--|||v------------<|||
                                                                        |||||>---||||v----------<||||
                                                                        ||||>----|||||v--------<|||||
                                                                        |||>-----||||||v------<||||||
                                                                        ||>------|||||||v----<|||||||
                                                                        |>-------||||||||v--<||||||||
                                                                        >--------|||||||||v@|||||||||
                                                                                 |||||||||>-^||||||||
                                                                                 ||||||||>---^|||||||
                                                                                 |||||||>-----^||||||
                                                                                 ||||||>-------^|||||
                                                                                 |||||>---------^||||
                                                                                 ||||>-----------^|||
                                                                                 |||>-------------^||
                                                                                 ||>---------------^|
                                                                                 |>-----------------^
                                                                                 >------------------&
E
    );

    // Premature exit with status code 1 if any test failed
    done();

    // If it reaches this point then all the tests were successful
    echo("All the tests completed successfully.\n");

    // Exit
    exit();
} elseif ($argc == 5) {
    // If the program receives exactly 4 arguments then it runs
    // Read the code of the golfed function from the script file and evaluate it
    eval(getSourceCode('s'));
} elseif ($argc == 2 && $argv[1] == 'source') {
    // Otherwise it displays the source code
    // You can put the output into a file or run it directly by piping it to php:
    //   $ php recursive-ascii-spirals.php source | php -d error_reporting=0 4 r c 3
    echo(getStandaloneProgramSourceCode());
} else {
    // Invalid arguments
    usage();
    exit(2);
}


// That's all the code in the main program; everything below are functions



/////////////////////////////////////////////////////////////////////////
// Utility UI functions
//

/**
 * Displays a message about how to use this script
 */
function usage()
{
    $filename = basename(__FILE__);

    // Display the usage
    echo <<< E
This script has 3 running modes:
  * without arguments it displays this message, runs the tests and exits; it tests both the detailed
    and the golfed version of the code;
  * with 'source' as its only argument it outputs the source code of the golfed program, with use directions;
    the output can be saved in a .php file and executed later or it can be piped directly to another instance
    of PHP to be executed immediately; for example:
       $ php {$filename} source | php -d error_reporting=0 -- 4 r c 3
  * with exactly 4 arguments it runs the golfed code and displays the ASCII spirals (assuming the
    argument are correct); for example:
       $ php -d error_reporting=0 {$filename} 8 r '' 3
    or
       $ php -d error_reporting=0 {$filename} 4 r c 3

E;
}



/**
 * Get the body of a function.
 *
 * This function cheats: it uses reflection and reads the script file from disk.
 *
 * @param string $fnName
 * @return string
 */
function getSourceCode($fnName)
{
    // Use reflection to find the location of the function in the file and extract its code
    $f = new ReflectionFunction($fnName);
    $text = implode('', array_slice(file(__FILE__), $f->getStartLine() - 1, $f->getEndLine() - $f->getStartLine() + 1));
    // Remove the function header and the curly braces from around the function body
    $text = preg_replace('/^\s*function '.$fnName.'\s*\([^)]*\)\s*{/', '', $text);
    $text = preg_replace('/}\s*$/', '', $text);
    // Trim the newlines from around the function body
    return trim($text);
}



/**
 * Generate and return the text to put in a .php file as the standalone program
 *
 * @return string
 */
function getStandaloneProgramSourceCode()
{
    $filename = basename(__FILE__);
    $code     = getSourceCode('s');
    $size     = strlen($code);

    // Parse the source of this script, get all its docblock comments
    $comments = array_filter(
        token_get_all(file_get_contents(__FILE__)),
        function ($token) {
            return is_array($token) && $token[0] == T_DOC_COMMENT;
        }
    );
    // Keep only the first docblock
    $comment  = reset($comments)[1];

    return <<< E
<?php
{$comment}

//
// This is the standalone program ({$size} bytes)
// Run it using:
//   $ php -d error_reporting=0 {$filename} 8 r '' 3
// or
//   $ php -d error_reporting=0 {$filename} 4 r c 3


{$code}


// That's all, folks!

E;
}



/////////////////////////////////////////////////////////////////////////
// Testing functions
//

/**
 * Test adapter.
 *
 * It emulates the behaviour of the CLI and collects the output to be tested.
 * It tests both the normal and the golfed versions of the function.
 *
 * @param string $input    the input string
 * @param string $expected the expected output
 */
function testSpiral($input, $expected)
{
    //
    // Convert the input string to a list of command line arguments
    $matches = [];
    if (! preg_match('/(\d+)([durl])(c?)(\d+)/', $input, $matches)) {
        it('does not work for invalid input', TRUE);
        return;
    }
    // This statement is not really needed
    $matches[0] = __FILE__;


    //
    // Test the detailed version of the function
    ob_start();
    spiral($matches);
    $actual = rtrim(ob_get_clean());
    it(sprintf('works for input: %s (detailed version)', $input), $expected == $actual);

    // Uncomment the next line to visually inspect the output when a test fails
    //echo($actual);


    //
    // Test the golfed version of the function
    ob_start();
    s($matches);
    $actual = rtrim(ob_get_clean());
    it(sprintf('works for input: %s (golfed version)', $input), $expected == $actual);

    // Uncomment the next line to visually inspect the output when a test fails
    //echo($actual);
}



/**
 * Helper function to test the drawing of a single square
 *
 * @param integer $size square size
 * @param string  $dir  direction; one of 'u', 'd', 'l' or 'r'
 * @param string  $c    when 'c' draw the spiral counter-clockwise; otherwise draw it clockwise
 * @return string
 */
function drawSquare($size, $dir, $c)
{
    $map = [];
    $x = $y = 0;
    $minX = $maxX = $minY = $maxY = 0;

    // Draw the spiral square in $map, starting at ($y, $x), update the bounding box in ($minY, $minX, $maxY, $maxX)
    square($size, $dir, $c, $map, $x, $y, $minX, $maxX, $minY, $maxY);

    // Convert the rows of $map to strings and output them
    ob_start();
    output($map, $minX, $maxX, $minY, $maxY);
    $output = ob_get_clean();

    // Remove the trailing new line to match the strings in the test cases
    // (the last newline is removed from the strings using the heredoc syntax)
    return rtrim($output);
}



/////////////////////////////////////////////////////////////////////////
// Helpers of the (detailed) function that implements the task
//

/**
 * Helper function: draw a square into $map starting on ($x, $y).
 * Update ($x, $y) and $(min|max)(X|Y)
 *
 * @param integer $size square size
 * @param string  $dir  direction; one of 'u', 'd', 'l' or 'r'
 * @param string  $c    'c' for counter-clockwise, anything else for clockwise
 * @param array & $map  (out) the map is generated here
 * @param int &   $x    (in/out) the cursor's start/stop position (X)
 * @param int &   $y    (in/out) the cursor's start/stop position (Y)
 * @param int &   $minX (in/out) the minimum value of X during the draw
 * @param int &   $maxX (in/out) the maximum value of X during the draw
 * @param int &   $minY (in/out) the minimum value of Y during the draw
 * @param int &   $maxY (in/out) the maximum value of Y during the draw
 * @return string
 */
function square($size, $dir, $c, array &$map, &$x, &$y, &$minX, &$maxX, &$minY, &$maxY)
{
    $chars = [
        // array body, arrow head, dx, dy
        [ '|', '^',  0, -1 ],      // 'u'p
        [ '-', '>', +1,  0 ],      // 'r'ight
        [ '|', 'v',  0, +1 ],      // 'd'own
        [ '-', '<', -1,  0 ],      // 'l'eft
    ];

    // $d is index in $chars that corresponds to the current direction
    $d = strpos('urdl', $dir);
    // $d + $deltaD is the new direction (mod 4)
    // ($d+1)%4 cycles through 'u', 'r', 'd', 'l' (clockwise)
    // ($d+3)%4 cycles through 'u', 'l', 'd', 'r' (clockwise)
    $deltaD = $c == 'c' ? 3 : 1;
    // $ch is the set of chars to use and the offsets to move for the current direction
    $ch = $chars[$d];

    // Start with '@'
    $map[$y][$x] = '@';

    // The algorithm:
    //   draw the start symbol ('@')
    //   starting with size 1 until $size-1:
    //   |  repeat twice
    //   |  |  draw a line of current size-1 in the current direction
    //   |  |  change direction; turn right if draw clockwise or left if draw counter-clockwise
    //   |  |  draw an arrow head (using the new direction)
    //   |  +---
    //   +---
    //   draw a line of size $size-1 on the current direction
    //   draw the end symbol ('&')

    // $s is the current size; from 1 to $size - 1
    for ($s = 1; $s < $size; $s ++) {
        // repeat twice
        for ($k = 0; $k < 2; $k ++) {
            // draw a line of size $s-1
            for ($i = 1; $i < $s; $i ++) {
                // advance to the next position
                $x += $ch[2];
                $y += $ch[3];
                // draw the line character
                $map[$y][$x] = $ch[0];
            }

            // advance
            $x += $ch[2];
            $y += $ch[3];
            // change direction
            $d = ($d + $deltaD) % 4;
            $ch  = $chars[$d];
            // draw the arrow head
            $map[$y][$x] = $ch[1];
        }
        // update the bounding box
        $minX = min($x, $minX);
        $maxX = max($maxX, $x);
        $minY = min($y, $minY);
        $maxY = max($maxY, $y);
    }

    // The last line (size $size - 1)
    for ($i = 1; $i < $s; $i ++) {
        // advance
        $x += $ch[2];
        $y += $ch[3];
        // draw the line
        $map[$y][$x] = $ch[0];
    }

    // End with '&'
    $map[$y][$x] = '&';
}



/**
 * Output a fragment of the map $map, bounded by ($minY, $minX), ($maxY, $maxX) coordinates
 *
 * @param array   $map   the map of characters
 * @param integer $minX  \
 * @param integer $maxX   \ the bounding box (Y denotes rows, X denotes columns)
 * @param integer $minY   /
 * @param integer $maxY  /
 */
function output(array $map, $minX, $maxX, $minY, $maxY)
{
    // Draw the map, one line at a time
    for ($y = $minY; $y <= $maxY; $y ++) {
        // Start a new line
        $line = '';
        for ($x = $minX; $x <= $maxX; $x ++) {
            // Put a space in place of a value that was not set
            $line .= $map[$y][$x] ?: ' ';
        }
        // strip the extra spaces at the end of line; add a newline character
        echo(rtrim($line)."\n");
    }
}



/////////////////////////////////////////////////////////////////////////
// The actual functions that implement the task
//

/**
 * The detailed function uses the helper functions described above
 *
 * @param array $argv the command line arguments
 */
function spiral(array $argv)
{
    // Extract the input into local variables
    $size  = $argv[1];
    $dir   = $argv[2];
    $c     = $argv[3];
    $times = $argv[4];

    // Working variables
    $map = [];                          // build the map here; start from (0, 0), move in all directions (negative coordinates are OK)
    $x = $y = 0;                        // current position on the map
    $minX = $maxX = $minY = $maxY = 0;  // boundaries of the past positions (minimum and maximum X and Y)

    // Repeat $times times
    for ($t = 0; $t < $times; $t ++) {
        // Draw a square in $map starting on the point where the previous square ended
        // Update the current position ($y, $x) and the bounding box ($minY, $minX, $maxY, $maxX)
        square($size, $dir, $c, $map, $x, $y, $minX, $maxX, $minY, $maxY);
    }

    // Output the piece of map bounded by ($minY, $minX, $maxY, $maxX)
    output($map, $minX, $maxX, $minY, $maxY);
}



/**
 * The golfed function.
 *
 * Shrinking techniques used:
 *   * replaced the calls to square() and output() with their bodies; the local variables in spiral() have
 *     the same names as the arguments of square() and output() on purpose, to streamline the functions inlining.
 *   * inlined the variables that are used only once; replaced the usages of $size, $dir, $c and $times with
 *     the values they used to store ($argv[1] .. $argv[4]);
 *   * shortened the variables' names to 1 letter; $argv cannot be shortened but, because it appears 4 times, it can
 *     be assigned to a new variable ($a) and use $a instead of $argv later (4 bytes saved);
 *   * removed, where possible, the quotes from around strings that contain only letters and digits ('v', 'urdl');
 *     without surrounding quotes they are (undefined) PHP constants (defines); PHP triggers notices about not
 *     finding the defines then it happily converts them to strings (2 bytes saved for each string);
 *   * dropped the initialization $map = [] (it's $m after names shortening); when it reaches $m[$y][$x]='@', PHP
 *     creates $m as array and $m[$y] as array too; (6 bytes saved);
 *   * combined (when possible) the incrementation of the index with the check of the end condition in "for" loops;
 *     changed the loop direction where possible to replace $i>0 with $i in the check for termination; f.e.,
 *       for($k=3;--$k;) is 4 bytes shorter than for($k=0;$k<2;$k++)
 *       for($s=0;++$s<$a[1];) is 2 bytes shorter than for($s=1;$s<$a[1];$s++)
 *     (1 to 3-4 bytes saved each time when this trick is possible);
 *   * squeezed assignments of variables into their first use (1 or 3 bytes saved for each variable);
 *   * as a direct consequence of the previous item, by combining 2 or 3 statements into a single one, removed the
 *     unnecessary curly brackets from around statements in "if" and "for" blocks (2 bytes saved each time);
 *   * an extra byte could be saved by replacing \n (2 bytes) with a real newline in the string (start the string
 *     on a line and end it on the next); PHP allows it and it saves 1 byte but I don't like it.
 *
 * @param array $argv
 * @return string
 */
function s(array $argv)
{
$a=$argv;$b=[['|','^',0,-1],['-','>',1,0],['|',v,0,1],['-','<',-1,$x=$y=$o=$p=$q=$r=0]];for($t=$a[4];$t;$t--){$d=strpos(urdl,$a[2]);$c=$b[$d];$m[$y][$x]='@';for($s=0;++$s<$a[1];){for($k=3;--$k;){for($i=$s;--$i;)$m[$y+=$c[3]][$x+=$c[2]]=$c[0];$x+=$c[2];$y+=$c[3];$c=$b[$d=($d+($a[3]==c?3:1))%4];$m[$y][$x]=$c[1];}$o=min($x,$o);$p=max($p,$x);$q=min($y,$q);$r=max($r,$y);}for($i=$s;--$i;)$m[$y+=$c[3]][$x+=$c[2]]=$c[0];$m[$y][$x]='&';}for($y=$q;$y<=$r;$y++){$l='';for($x=$o;$x<=$p;$x++)$l.=$m[$y][$x]?:' ';echo rtrim($l)."\n";}
}



// This is the end of file; no closing PHP tag
