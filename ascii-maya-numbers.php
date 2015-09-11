<?php
/**
 * ASCII Maya Numbers
 *
 * @link http://codegolf.stackexchange.com/questions/54240/ascii-maya-numbers
 */

// Check the PHP version
if (PHP_VERSION < '5.4') {
    // Even PHP 5.4 is dead meat; it reached its end of life on September 14, 2014
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Show all the errors, including the notices; this code doesn't trigger any
error_reporting(E_ALL/* & ~E_NOTICE*/);

// Load the test micro-frameworks
// This test framework works fine with one-line assertions; it displays the entire assertion in green
include 'a/TestFwInATweet-Xeoncross.php';
// This test framework is appropriate for multi-line assertions
include 'a/TestFrameworkInATweet.php';



//
// One-line assertions using a test framework that displays the code of the assertion in the output
test(maya(0) == '<  >');
test(maya(1) == ' .  ');
test(maya(2) == ' .. ');
test(maya(3) == '... ');
test(maya(4) == '....');
test(maya(5) == '----');

//
// Multi-line assertions need a different test framework; it gets the message to display as its first argument

// '#' replaces a trailing white space; it is needed to avoid the editor strip
// the white spaces at the end of line
it('correcty displays '.$i=6, maya($i) == str_replace('#', ' ', <<< END
 .##
----
END
));
it('correcty displays '.$i=7, maya($i) == str_replace('#', ' ', <<< END
 ..#
----
END
));
it('correcty displays '.$i=8, maya($i) == str_replace('#', ' ', <<< END
...#
----
END
));
it('correcty displays '.$i=9, maya($i) == str_replace('#', ' ', <<< END
....
----
END
));
it('correcty displays '.$i=10, maya($i) == str_replace('#', ' ', <<< END
----
----
END
));

it('correcty displays '.$i=11, maya($i) == str_replace('#', ' ', <<< END
 .##
----
----
END
));
it('correcty displays '.$i=12, maya($i) == str_replace('#', ' ', <<< END
 ..#
----
----
END
));
it('correcty displays '.$i=13, maya($i) == str_replace('#', ' ', <<< END
...#
----
----
END
));
it('correcty displays '.$i=14, maya($i) == str_replace('#', ' ', <<< END
....
----
----
END
));
it('correcty displays '.$i=15, maya($i) == str_replace('#', ' ', <<< END
----
----
----
END
));
it('correcty displays '.$i=16, maya($i) == str_replace('#', ' ', <<< END
 .##
----
----
----
END
));
it('correcty displays '.$i=17, maya($i) == str_replace('#', ' ', <<< END
 ..#
----
----
----
END
));
it('correcty displays '.$i=18, maya($i) == str_replace('#', ' ', <<< END
...#
----
----
----
END
));
it('correcty displays '.$i=19, maya($i) == str_replace('#', ' ', <<< END
....
----
----
----
END
));
it('correcty displays '.$i=20, maya($i) == str_replace('#', ' ', <<< END
 .##

<  >
END
));


it('correcty displays '.$i=42, maya($i) == str_replace('#', ' ', <<< END
 ..#

 ..#
END
));

it('correcty displays '.$i=8000, maya($i) == str_replace('#', ' ', <<< END
 .##

<  >

<  >

<  >
END
));

it('correcty displays '.$i=8080, maya($i) == str_replace('#', ' ', <<< END
 .##

<  >

....

<  >
END
));

it('correcty displays '.$i=123456789, maya($i) == str_replace('#', ' ', <<< END
 .##

...#
----
----
----

 .##
----
----

 ..#
----
----

 .##

....
----
----
----

....
----
END
));

it('correcty displays '.$i=31415, maya($i) == str_replace('#', ' ', <<< END
...#

...#
----
----
----

----
----

----
----
----
END
));

it('correcty displays '.$i=2147483647, maya($i) == str_replace('#', ' ', <<< END
 .##

...#
----
----

 .##
----
----

 .##

----
----
----

....
----

 ..#

 ..#
----
END
));




/**
 * The test adapter.
 *
 * It emulates the behaviour of the CLI and collects the output to be tested.
 *
 * @param int $nb the number to represent using the Maya numerals
 * @return string the output of the program
 */
function maya($nb)
{
    $argv = array(1 => $nb);
    ob_start();
    echo rtrim(m($argv[1]), "\n");
    return ob_get_clean();
}


/**
 * The function that returns the Maya representation of the number. It calls itself recursively.
 *
 * @param integer $number the number to represent
 * @return string the Maya representation of $number (the last line ends with a new line character too)
 */
function mayaNumber($number)
{
    // Build the representation here
    $output = '';

    // Extract the last Maya digit (it is the remainder when the number is divided by 20)
    $last = $number % 20;                       // the remainder is the last Maya digit
    $quotient = ($number - $last) / 20;         // the quotient is the number without the last Maya digit

    // Call the function recursively to generate the Maya representation of the quotient and add an empty line after it
    if ($quotient > 0) {
        // ... but only if there is any quotient
        $output = mayaNumber($quotient)."\n";   // put an empty line after it; it separates the groups
    }

    // Generate the Maya representation of the last digit and append it to the rest
    if ($last > 0) {
        // The Maya representation of a non-zero digit (1..19) starts with 1 to 4 points on the first line
        // The number of points is the remainder when the digit is divided by 5
        $rem = $last % 5;                       // the remainder
        if ($rem > 0) {
            // No remainder => no first line of points
            $output .= substr(" .   .. ... ....", $rem * 4 - 4, 4)."\n";
            // Another way to get the same outcome is:
            // $output .= [ ' .  ', ' .. ', '... ', '....' ][$rem - 1]."\n";
            // It requires PHP 5.5 but in the end both of them get squeezed to the same size.
        }

        // Add 1 to 3 lines of dashes
        $dashes  = ($last - $rem) / 5;          // the number of lines of dashes is how many times 5 can fit in $last
        $output .= str_repeat("----\n", $dashes);
    } else {
        // Zero
        $output .= "<  >\n";
    }

    // Return the generated Maya number
    return $output;
}



/**
 * The golfed version of the function mayaNumber()
 *
 * @param integer $n the number to represent
 * @return string the Maya representation of $n
 */
function m($n){return(($c=($n-($r=$n%20))/20)?m($c)."\n":"").($r?(($q=$r%5)?substr(" .   .. ... ....",$q*4-4,4)."\n":"").str_repeat("----\n",($r-$q)/5):"<  >\n");}



//
// The golfed complete program (192 bytes):
// <?php
// function m($n){return(($c=($n-($r=$n%20))/20)?m($c)."\n":"").($r?(($q=$r%5)?substr(" .   .. ... ....",$q*4-4,4)."\n":"").str_repeat("----\n",($r-$q)/5):"<  >\n");}echo rtrim(m($argv[1]),"\n");







////////////////////////////////////////////////////////////////////////////////////////////////
// Another (longer) implementation that doesn't return a string but generates an array of lines
//
/**
 * The test adapter
 *
 * @param integer $nb
 * @return string
 */
function mayaX($nb)
{
    $z = array();
    u($nb,$z);
    return implode("\n",$z);
}



/**
 * The recursive function that produces the Maya representation of the number.
 * It doesn't return the complete string but puts its lines into its second argument.
 *
 * @param integer $n
 * @param array $z by reference
 */
function u($n,&$z){if($n){if($c=($n-($r=$n%20))/20){u($c,$z);$z[]='';}if($r){if($q=$r%5)$z[]=substr(' .   .. ... ....',4*$q-4,4);for($r=($r-$q)/5;$r--;)$z[]='----';}else$z[]='<  >';}else$z[]='<  >';}


// This is the end of file; no closing PHP tag
