<?php
/**
 * Code Golf: ASCII piano keyboard
 *
 * @link http://codegolf.stackexchange.com/questions/79333/ascii-piano-keyboard
 */

// Check the PHP version
if (PHP_VERSION < '5.4') {
    // This script uses features introduced in PHP 5.4 (short array syntax)
    // PHP 5.4 is dead meat now; it reached its end of life on September 14, 2014
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Hide notices. It can be passed as argument to the CLI:
//   php -d error_reporting=0 ascii-piano-keyboard.php
error_reporting(E_ALL & ~E_NOTICE);

// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';



// This script has 3 running modes:
//  * without arguments it displays its usage, runs the tests and exits; it tests both the detailed and the golfed version of the code;
//  * with exactly 1 positive integer as argument it runs the golfed code and displays the ASCII piano keyboard;
//  * with 'source' as its only argument it displays the golfed source code.
if ($argc == 1) {
    // No arguments => display the help
    usage();

    // ... then run the tests and exit
    echo("\n");
    echo("Running the tests...\n");

    testKeys(
        1, <<< E
____
|  |
|  |
|  |
|  |
|   |
|   |
|___|
E
    );

    testKeys(
        2, <<< E
________
|  | | |
|  | | |
|  | | |
|  | | |
|   |   |
|   |   |
|___|___|
E
    );


    testKeys(
        3, <<< E
_____________
|  | | | |  |
|  | | | |  |
|  | | | |  |
|  | | | |  |
|   |   |   |
|   |   |   |
|___|___|___|
E
    );

    testKeys(
        4, <<< E
________________
|  | | | |  |  |
|  | | | |  |  |
|  | | | |  |  |
|  | | | |  |  |
|   |   |   |   |
|   |   |   |   |
|___|___|___|___|
E
    );

    testKeys(
        5, <<< E
____________________
|  | | | |  |  | | |
|  | | | |  |  | | |
|  | | | |  |  | | |
|  | | | |  |  | | |
|   |   |   |   |   |
|   |   |   |   |   |
|___|___|___|___|___|
E
    );

    testKeys(
        6, <<< E
________________________
|  | | | |  |  | | | | |
|  | | | |  |  | | | | |
|  | | | |  |  | | | | |
|  | | | |  |  | | | | |
|   |   |   |   |   |   |
|   |   |   |   |   |   |
|___|___|___|___|___|___|
E
    );

    testKeys(
        7, <<< E
_____________________________
|  | | | |  |  | | | | | |  |
|  | | | |  |  | | | | | |  |
|  | | | |  |  | | | | | |  |
|  | | | |  |  | | | | | |  |
|   |   |   |   |   |   |   |
|   |   |   |   |   |   |   |
|___|___|___|___|___|___|___|
E
    );

    testKeys(
        8, <<< E
________________________________
|  | | | |  |  | | | | | |  |  |
|  | | | |  |  | | | | | |  |  |
|  | | | |  |  | | | | | |  |  |
|  | | | |  |  | | | | | |  |  |
|   |   |   |   |   |   |   |   |
|   |   |   |   |   |   |   |   |
|___|___|___|___|___|___|___|___|
E
    );

    testKeys(
        55, <<< E
____________________________________________________________________________________________________________________________________________________________________________________________________________________________
|  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | |
|  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | |
|  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | |
|  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | | |  |  | | | |  |  | | | | |
|   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |
|   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |   |
|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|___|
E
    );


    // Premature exit with status code 1 if any test failed
    done();

    // If it reaches this point then all the tests were successful
    echo("All the tests completed successfully.\n");

    // The test suite completed; that's all for now.
    exit();
} elseif ($argc == 2 && $argv[1] == 'source') {
    // If there is only one argument and it is 'source' then display the code
    // You can put the output into a file or run it directly by piping it to php:
    //   $ php recursive-ascii-spirals.php source | php -d error_reporting=0 4 r c 3
    echo("<?php\n");
    echo(getSourceCode('keys_golfed'));
    echo("\n");
} elseif ($argc == 2 && 1 <= (int)$argv[1]) {
    // If the program receives exactly 1 positive integer argument then it runs
    // Read the code of the golfed function from the script file and evaluate it
    eval(getSourceCode('keys_golfed'));
} else {
    // Invalid arguments
    usage();
    exit(2);
}


exit(0);

// That's all the code; below are just functions
///////////////////////////////////////////////////////////////////////////



/**
 * This is the plain code
 *
 * @param int   $argc
 * @param array $argv
 */
function keys_plain($argc, array $argv)
{
    $n = $argv[1];
    // Top line (a set of 7 white keys)
    $a = str_repeat('_', 28);
    // Next 4 lines (white and black keys)
    $b = '  | | | |  |  | | | | | |  |';

    // The number of complete sets of 7 white keys
    $r = $n % 7;
    $m=($n-$r)/7;       // The number of white keys in last (incomplete) set

    // The number of chars to draw from $a and $b for the last set of keys
    $k = 4 * $r - ($r && $r != 3);

    // Draw everything
    echo'_'.str_repeat($a, $m).substr($a, 0, $k)."\n",
    $g='|'.str_repeat($b, $m).substr($b, 0, $k)."\n",$g,$g,$g,      // draw one line, store in in $g, draw it again 3 times
    $h='|'.str_repeat('   |', $n)."\n",$h,              // draw one line, store it in $h, draw it again
        '|'.str_repeat('___|', $n)."\n";                // white keys only; all of them have the same width
}



/**
 * This is the golfed code
 *
 * @param int   $argc
 * @param array $argv
 */
function keys_golfed($argc, array $argv)
{
    $n=$argv[1];$s=str_repeat;echo'_'.$s($a=$s('_',28),$m=($n-$r=$n%7)/7).substr($a,0,$k=4*$r-($r&&$r!=3))."\n",$g='|'.$s($b='  | | | |  |  | | | | | |  |',$m).substr($b,0,$k)."\n",$g,$g,$g,$h='|'.$s('   |',$n)."\n",$h,'|'.$s('___|',$n)."\n";
}


/**
 * Test both scripts (plain and golfed version) using the test framework
 * Check their output against the expected output
 *
 * @param int    $nb       the input argument (the number of keys)
 * @param string $expected the expected program output
 */
function testKeys($nb, $expected)
{
    // Test the plain-code function
    it(sprintf('displays %d keys (plain  version)', $nb), getOutput(function() use ($nb) { keys_plain(2, [__FILE__, $nb]); }) === $expected);

    // Test the golfed function
    it(sprintf('displays %d keys (golfed version)', $nb), getOutput(function() use ($nb) { keys_golfed(2, [__FILE__, $nb]); }) === $expected);
}



/////////////////////////////////////////////////////////////////////////
// Helper functions
//

/**
 * Run a function, capture and return its output
 *
 * @param callable $fnName
 * @return string
 */
function getOutput(callable $fnName)
{
    ob_start();
    $fnName();
    $output = ob_get_clean();

    return trim($output);
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
       $ php {$filename} source | php -d error_reporting=0 -- 55
  * with exactly 1 positive integer number as argument it runs the golfed code and displays the ASCII piano
    keyboard; for example:
       $ php -d error_reporting=0 {$filename} 55

E;
}


// This is the end of file; no closing PHP tag
