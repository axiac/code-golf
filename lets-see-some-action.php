<?php
/**
 * Code Golf: Let's see some action!
 *
 * @link http://codegolf.stackexchange.com/questions/55343/lets-see-some-action
 */

// Check for PHP version
if (PHP_VERSION < '5.4') {
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Hide notices. It can be passed as argument to the CLI:
//   php -d error_reporting=0 lets-see-some-action.php
error_reporting(E_ALL & ~E_NOTICE);


// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';


//
// A partially-golfed test suite fits best a code golf program

it(sprintf('displays after %d seconds.', $steps = 0), action($steps) == <<< E
  __                                                                __
_/  \_                                                            _/  \_
o    o                                                            o    o
E
);

it(sprintf('displays after %d seconds.', $steps = 11), action($steps) == <<< E
             __                               __
           _/  \_                           _/  \_
           o    o                           o    o
E
);

it(sprintf('displays after %d seconds.', $steps = 20), action($steps) == <<< E
                      __    __
                    _/  \/\/  \_
                    o    oo    o
E
);

it(sprintf('displays after %d seconds.', $steps = 21), action($steps) == <<< E
                      __    __
                    _/  \/\/  \_
                    o    oo    o
E
);




/**
 * Test adapter.
 *
 * It emulates the behaviour of the CLI and collects the output to be tested.
 *
 * @param string $steps the input map specifications
 * @return string the output of the program
 */
function action($steps)
{
    ob_start();
    showSomeAction_golfed([1 => $steps]);
    $x = ob_get_clean();

    // Uncomment the next line to visually inspect the output when a test fails
    //echo($x);

    // strip the last "\n" to fit the test case (PHP removes the newline before the heredoc closing marker)
    return rtrim($x);
}



/**
 * The actual code, in a function
 *
 * @param string[] $argv the global variable $argv (the CLI arguments)
 */
function showSomeAction(array $argv)
{
    // The number of seconds, between (and including) 0 and 20
    $sec  = min(max($argv[1], 0), 20);
    $rest = 60 - 3 * $sec;

    $left = str_repeat(' ', $sec);      // left padding
    $mid  = str_repeat(' ', $rest);     // space in the middle
    $c = $rest ? '_'.$mid.'_' : '/\\';

    echo($left.'  __  '.$mid."  __\n");
    echo($left.'_/  \\'. $c ."/  \\_\n");
    echo($left.'o    o'.$mid."o    o\n");
}



/**
 * The golfed version of showSomeAction (160 -> 155 bytes)
 *
 * Some of the tricks used to make it shorter:
 *   * extract the name of the "str_function" into a variable ($f) and use $f to call it instead - only 2 bytes
 *     for 2 calls, 8 more bytes for each call starting with the 3rd one;
 *   * strip quotes or apostrophes from around strings that are allowed to be names of defines in PHP
 *     (function names, for example) - 2 bytes for each string;
 *   * squeezed the initialization of $s and $r ($sec, $rest) into their first uses - only 1 byte for $s
 *     because it requires being enclosed in parentheses here; 3 bytes for $r (parentheses are not required);
 *
 * @param string[] $argv the global variable $argv (the CLI arguments)
 */
function showSomeAction_golfed(array $argv)
{
    // My original version (160 bytes)
//  $f=str_repeat;$m=$f(' ',$r=60-3*($s=min(max($argv[1],0),20)));$l=$f(' ',$s);$c=$r?_.$m._:'/\\';echo"$l  __  $m  __\n{$l}_/  \\$c/  \\_\n{$l}o    o{$m}o    o\n";

    // Suggested by http://codegolf.stackexchange.com/users/14732/ismael-miguel (156 bytes)
//  $f=str_repeat;$m=$f(' ',$r=60-3*($s=min(max($argv[1],0),20)));echo$l=$f(' ',$s),"  __  $m  __\n{$l}_/  \\",$r?_.$m._:'/\\',"/  \\_\n{$l}o    o{$m}o    o\n";

    // Reworked: swapping the initialization of $m and $s allows the removal of one pair of parentheses (155 bytes)
    $f=str_repeat;echo$l=$f(' ',$s=min(max($argv[1],0),20)),"  __  ",$m=$f(' ',$r=60-3*$s),"  __\n{$l}_/  \\",$r?_.$m._:'/\\',"/  \\_\n{$l}o    o{$m}o    o\n";
}



//
// The golfed stand-alone program (160 bytes):
// <?php
// $f=str_repeat;$m=$f(' ',$r=60-3*($s=min(max($argv[1],0),20)));$l=$f(' ',$s);$c=$r?_.$m._:'/\\';echo"$l  __  $m  __\n{$l}_/  \\$c/  \\_\n{$l}o    o{$m}o    o\n";



// This is the end of file; no closing PHP tag
