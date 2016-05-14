<?php
/**
 * Code Golf: Yarr! A map to the hidden treasure!
 *
 * @link http://codegolf.stackexchange.com/questions/54301/yarr-a-map-to-the-hidden-treasure
 */

// Check for PHP version
if (PHP_VERSION < '5.4') {
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Change this to TRUE to run the test suite against the golfed code (default: test the expanded code)
define('TEST_GOLFED_CODE', FALSE);


// Hide notices. Could suppress them by using '@' in the line:
//   $line .= $map[$y][$x] ?: ' ';
// error_reporting() is better because it can be passed as argument to the CLI:
//   php -d error_reporting=0 yarr-a-map-to-the-hidden-treasure.php
// This saves one byte.
error_reporting(E_ALL & ~E_NOTICE);


// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';


//
// A partially-golfed test suite fits best a code golf program

it('converts '.$trace='E2,N4,E5,S2,W1,S3', map($trace) == <<< E
  >>>>>v
  ^    v
  ^   v<
  ^   v
>>^   X
E
);

it('converts '.$trace='S5,W2', map($trace) == <<< E
 v
 v
 v
 v
 v
X<
E
);

it('converts '.$trace='N1,E1,S1,E1,N1,E1,S2', map($trace) == <<< E
>v>v
^>^X
E
);

it('converts '.$trace='N1', map($trace) == <<< E
X
E
);

it('converts '.$trace='N6,E6,S6,W5,N5,E4,S4,W3,N3,E2,S2,W1,N2', map($trace) == <<< E
>>>>>>v
^>>>>vv
^^>>vvv
^^^Xvvv
^^^^<vv
^^^<<<v
^^<<<<<
E
);

it('converts '.$trace='E21,S2', map($trace) == <<< E
>>>>>>>>>>>>>>>>>>>>>v
                     X
E
);

it('converts '.$trace='N12,E11,S12,W2,N4', map($trace) == <<< E
>>>>>>>>>>>v
^          v
^          v
^          v
^          v
^          v
^          v
^          v
^          v
^        X v
^        ^ v
^        ^ v
^        ^<<
E
);



/**
 * Test adapter.
 *
 * It emulates the behaviour of the CLI and collects the output to be tested.
 * Depending on the value of constant TEST_GOLFED_CODE it tests the expanded or the obfuscated code.
 *
 * @param string $trace the input map specifications
 * @return string the output of the program
 */
function map($trace)
{
    ob_start();
    if (TEST_GOLFED_CODE) {
        golfed([1 => $trace]);
    } else {
        echoMap([1 => $trace]);
    }
    $x = ob_get_clean();
    // strip the last "\n" to fit the test case (PHP removes the newline before the heredoc closing marker)
    return rtrim($x);
}



/**
 * The actual code, in a function
 *
 * @param string[] $argv the global variable $argv (the CLI arguments)
 */
function echoMap(array $argv)
{
    // Map directions
    $data = [
        // delta Y, delta X, character to put on map
        'N' => [-1,  0, '^'],
        'E' => [ 0,  1, '>'],
        'S' => [ 1,  0, 'v'],
        'W' => [ 0, -1, '<'],
    ];

    // Split the specification into legs
    $legs = explode(',', $argv[1]);

    // Working variables
    $map = [];                          // build the map here; start from (0, 0), move in any direction (negative coordinates are OK)
    $x = $y = 0;                        // current position on the map
    $oldX = $oldY = 0;                  // previous position on the map (needed because of the constraint on the last move)
    $minX = $maxX = $minY = $maxY = 0;  // boundaries of the past positions (minimum and maximum X and Y)

    // Let's start
    foreach ($legs as $i => $leg) {
        // Split the leg definition
        $dir   = $leg[0];               // the first char is the direction
        $steps = substr($leg, 1);       // the rest of the leg tells how many steps to go

        // Get information about the direction: move offset for each step and character to put on the map
        list($dY, $dX, $char) = $data[$dir];

        // Draw the steps
        while ($steps --) {
            // Remember the current position (for the very last step)
            $oldY = $y;
            $oldX = $x;
            // Put the character on the map on the current position; it shows the direction to go
            $map[$y][$x] = $char;
            // Step it
            $y += $dY;
            $x += $dX;
        }

        // After the last step of the last leg step back to the previous position
        // ("Notice that we've replaced the last step to the south with an X instead.")
        if ($i == count($legs) - 1) {
            // We didn't draw anything at ($y, $x) yet (and if this is the last leg then we'll never draw)
            $x = $oldX;
            $y = $oldY;
        }

        // Update the boundaries of the drawn area (use them to get the minimum area to output)
        $minX = min($minX, $x);
        $maxX = max($maxX, $x);
        $minY = min($minY, $y);
        $maxY = max($maxY, $y);
    }

    // Put 'X' over the last step of the last leg
    $map[$y][$x] = 'X';

    // Draw the map, one line at a time
    for ($y = $minY; $y <= $maxY; $y ++) {
        // Start with a new line
        $line = '';
        for ($x = $minX; $x <= $maxX; $x ++) {
            // Put a space in place of a not set value
            $line .= $map[$y][$x] ?: ' ';
        }
        // strip the extra spaces at the end of line; add a newline character
        echo(rtrim($line)."\n");
    }
}



/**
 * The golfed version of function echoMap()
 *
 * This version is formatted to fit in a response on http://codegolf.stackexchange.com
 * Remove the indentation, join the lines, put only the body of the function in a file (treasure.php)
 * and run it like:
 *
 *     $ php -d error_reporting=0 treasure.php E2,N4,E5,S2,W1,S3
 *
 * (Some of) the changes applied during golfing:
 *   * stripped whitespaces; note "foreach($g as$i=>$h)" - "$g as$i" is correctly parsed as "$g as $i"
 *   * renamed variables to 1-letter names (lowercase);
 *   * inlined variables that appear only once ($data, $dir);
 *   * removed initialization whenever is possible ($map = [] - PHP does it for you if $map is not set);
 *   * merge assignments into the next expression that uses the variable, if possible - the assignment
 *     operator returns the value of its second operand and, as a side-effect, stores it in the variable
 *     passed as its first operand;
 *   * replaced "while()" with "for()" (or viceversa), if the other language construct allows squeezing
 *     an assignment;
 *   * "echo()" can be used like a function (I like it this way) but also like an operand (echo "text");
 *     the latter form uses one byte less;
 *
 * @param array $argv the CLI arguments
 */
function golfed(array $argv) {
    $g=explode(',',$argv[1]);$x=$y=$a=$b=$c=$d=$e=$f=0;
    foreach($g as$i=>$h){list($k,$l,$m)=
        ['N'=>[-1,0,'^'],'E'=>[0,1,'>'],'S'=>[1,0,'v'],'W'=>[0,-1,'<']][$h[0]];
        for($s=substr($h,1);$s--;){$z[$f=$y][$e=$x]=$m;$y+=$k;$x+=$l;}
        if($i==count($g)-1){$x=$e;$y=$f;}
        $a=min($a,$x);$b=max($b,$x);$c=min($c,$y);$d=max($d,$y);
    }$z[$y][$x]='X';for($y=$c;$y<=$d;$y++)
    {$o='';for($x=$a;$x<=$b;$x++)$o.=$z[$y][$x]?:' ';echo rtrim($o)."\n";}
}

// This is the end of file; no closing PHP tag
