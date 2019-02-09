<?php
/**
 * Code Golf: Remapping ASCII
 *
 * @link http://codegolf.stackexchange.com/questions/57914/remapping-ascii
 */

// Check the PHP version
if (PHP_VERSION < '5.4') {
    // This script uses features introduced in PHP 5.4 (short array syntax)
    // PHP 5.4 is dead meat now; it reached its end of life on September 14, 2014
    exit("PHP 5.4 or newer is required. Dare to advance, don't live in the past!");
}

// Hide notices. It can be passed as argument to the CLI:
//   php -d error_reporting=0 remapping-ascii.php
error_reporting(E_ALL & ~E_NOTICE);
// Since PHP 7.2 some notices were promoted to warnings
// and this is very good for clean code but not for golfing
if ('7.2' <= PHP_VERSION) {
    error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
}


// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';




/////////////////////////////////////////////////////////////////////////
// A couple of tests of the function that computes the score
// The function not required but it helps me compute my score quickly
//

//
// Test it validates and computes the correct score for answers (in other languages) already provided
it(sprintf('computes score for answer #57916 (CJam) to %d', $score=94), $score === computeScore(
    '"_|`\'~,Y/G>z[ \$&(*.02468:<@BDFHJLNPRTVXZ^bdfhjlnprtvx!#%)+-13579;=?ACEIKMOQSUW]acegikmoqsuwy{}',
    '"_|`\'~,Y/G>z`|"_~'
));

it(sprintf('computes score for answer #57924 (Pyth) to %d', $score=170), $score === computeScore(
    'p~\dr2NC%os- "$&(*,.0468:<>@BDFHJLPRTVXZ^`bfhjlntvxz|!#\')+/13579;=?AEGIKMOQSUWY[]_acegikmquwy{}',
    '-so%CN2rd\~p"p~\dr2NC%os-'
));

it(sprintf('computes score for answer #57937 (Befunge-93) to %d', $score=627), $score === computeScore(
    ' "$&(*,.02468:<>@BDFHJLNPRTVXZ\^`bdfhjlnprtvxz|~!#%\')+-/13579;=?ACEGIKMOQSUWY[]_acegikmoqsuwy{}',
<<< SOURCE
" ":      ^
v"!"  _@#$<
>:,2+:"~"`|
^         <
SOURCE
));

it(sprintf('computes score for answer #57938 (Octave) to %d', $score=628), $score === computeScore(
    ' "$&(*,.02468:<>@BDFHJLNPRTVXZ\^`bdfhjlnprtvxz|~!#%\')+-/13579;=?ACEGIKMOQSUWY[]_acegikmoqsuwy{}',
    '["" 32:2:126 33:2:125]'
));

it(sprintf('computes score for answer #57943 (Brainfuck) to %d', $score=667), $score === computeScore(
    '-+.02468:<>@BDFHJLNPRTVXZ\^`bdfhjlnprtvxz|~{}ywusqomkigeca_][YWUSQOMKIGECA?=;97531/,*(&$" #!%\')',
    '+++++++++++++++++++++++++++++++++++++++++++++.--.+++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.++.---.++.----.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.--.---.--.--.--.--.--.--.+++.--.++++.++.++.'
));


//
// Test the score computing function validates the output rules (no duplicate chars, no missing chars, no neighbours)
it(
    sprintf('detects missing characters in <output>%s</output>', $output='!"#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'),
    "missing in output: [[[ ']]]" === computeScore($output, 'not used here')
);

it(
    sprintf('detects duplicate characters in <output>%s</output>', $output=' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~\'abc'),
    "duplicates in output: [[['abc]]]" === computeScore($output, 'not used here')
);

it(
    sprintf('detects neighbour characters in <output>%s</output>', $output = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'),
    "neighbours in output: [[[ ]]] and [[[!]]]" === computeScore($output, 'not used here')
);




/////////////////////////////////////////////////////////////////////////
// My attempts
//
it(
    sprintf('computes score for my answer r2364 (PHP) to %d', $score = 2364),
    $score === computeScore(getOutput('r2364'), getSourceCode('r2364'))
);

it(
    sprintf('computes score for my answer r1628 (PHP) to %d', $score = 1628),
    $score === computeScore(getOutput('r1628'), getSourceCode('r1628'))
);

it(
    sprintf('computes score for my answer r1362 (PHP) to %d', $score = 1362),
    $score === computeScore(getOutput('r1362'), getSourceCode('r1362'))
);

it(
    sprintf('computes score for my answer r1359 (PHP) to %d', $score = 1359),
    $score === computeScore(getOutput('r1359'), getSourceCode('r1359'))
);

it(
    sprintf('computes score for my answer r1256 (PHP) to %d', $score = 1256),
    $score === computeScore(getOutput('r1256'), getSourceCode('r1256'))
);

it(
    sprintf('computes score for my answer r1231 (PHP) to %d', $score = 1231),
    $score === computeScore(getOutput('r1231'), getSourceCode('r1231'))
);

it(
    sprintf('computes score for my answer r1217 (PHP) to %d', $score = 1217),
    $score === computeScore(getOutput('r1217'), getSourceCode('r1217'))
);

it(
    sprintf('computes score for my answer r1081 (PHP) to %d', $score = 1081),
    $score === computeScore(getOutput('r1081'), getSourceCode('r1081'))
);


// Exit with status code 1 if any test failed
done();

// That's all the code in the main program; everything below are functions
exit();




/////////////////////////////////////////////////////////////////////////
// Testing functions
//




/**
 * Helper function to compute the score of a solution.
 * It is not required or needed by it helps me evaluate my solution faster
 *
 * @param string  $output
 * @param string  $sourceCode
 * @return integer|string
 */
function computeScore($output, $sourceCode)
{
    $usedChars = count_chars($output, 1);
    $missing = array_diff(range(32, 126), array_keys($usedChars));
    if (count($missing) > 0) {
        return 'missing in output: [[['.implode('', array_map('chr', $missing)).']]]';               // not all chars are used in the output
    }
    $duplicates = array_filter($usedChars, function ($count) { return $count > 1; });
    if (! empty($duplicates)) {
        return 'duplicates in output: [[['.implode('', array_map('chr', array_keys($duplicates))).']]]';             // some characters appear in the output more than once
    }
    $chars = str_split($output);
    for ($i = 1; $i < count($chars); $i ++) {
        if (abs(ord($chars[$i]) - ord($chars[$i-1])) == 1) {
            return 'neighbours in output: [[['.$chars[$i-1].']]] and [[['.$chars[$i].']]]';
        }

    }

    $score = 0;
    foreach (str_split($sourceCode) as $ch) {
        if ($ch == "\n") {
            $score += 1;
        } else {
            $pos = strpos($output, $ch);
            if ($pos === FALSE) {
                return 'non-printable in source: '.$ch;
            }
            $score += 1 + $pos;
        }
    }

    return $score;
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
 * Invoke the provided callable, capture and return its output
 *
 * @param callable $fnName
 * @return string
 */
function getOutput(callable $fnName)
{
    ob_start();
    $fnName();
    $output = ob_get_clean();

    return $output;
}



/////////////////////////////////////////////////////////////////////////
// Possible solutions (worse first, better last)
//

// This is a failed attempt to compose a string that contains the most used characters in the code of this function in front
// It turned out to be 3-4 times longer than other solutions and this, in turn, doubled the score
function r2364()
{
    echo$o='$rca)e(oh;=_yfns1+u,\'2tkvil]630%7<d [g';$h=array_values(array_diff(range(32,126),array_keys(count_chars($o,1))));$c=count($h);for($e=0;$r++<$c;$e=($e+17)%$c)echo chr($h[$e]);
}

// A first attempt, not very golfed
function r1628()
{
    for($i=$j=0;++$i<96;$j=($j+52)%95)echo chr(32+$j);
}

// r1628 without initialization of $i and $j (they default to 0 when used in expressions)
// try a different approach on modification of $j
function r1362()
{
    for(;++$i<96;)echo chr(32+$j=($j+52)%95);
}

// r1362, moved the modification of $j back into the "for"
function r1359()
{
    for(;++$i<96;$j=($j+52)%95)echo chr(32+$j);
}

// r1362 with better names for variables (use letters that appear at the beginning of the code: 'f' and 'o')
function r1256()
{
    for(;++$o<96;)echo chr(32+$f=($f+52)%95);
}

// r1359 with better names for variables (uses chars that exist in the rest of the code)
function r1231()
{
    for(;++$o<96;$f=($f+52)%95)echo chr(32+$f);
}

// r1231 with names for variables using the first letters from the output
function r1217()
{
    for(;++$f<96;$T=($T+52)%95)echo chr(32+$T);
}

// r1217 without counter ($f)
// The stop condition is $T!=0 but it cannot be expressed this way because it will exit the loop on the first iteration
// Instead, $T is compared to a string; on the first iteration $T is undefined and defaults to '' (due the comparison
// with a string). On subsequent iterations $T is a number and the string is forcibly converted to the number zero.
// The loop ends when $T becomes zero again (it starts with a default zero on the first iteration).
// The letter used to represent the comparison string is the first letter in the output (to minimize the score)
function r1081()
{
    for(;$T!=T;$T=($T+52)%95)echo chr(32+$T);
}




/////////////////////////////////////////////////////////////////////////
// Helper functions
//


/**
 * Compute and display the frequencies of the letters that appear in the provided string (in descending order)
 *
 * @param string $rawCode
 */
function echoFrequencies($rawCode)
{
    $chars = count_chars($rawCode, 1);
    arsort($chars);
    foreach ($chars as $code => $nb) {
        echo(chr($code).' => '.$nb."\n");
    }
}



/**
 * Given a piece of code that runs through all the printable characters using different steps (and wrapping),
 * compute the best value for the step (to match all the output conditions and minimize the score.
 * Display the value it founds as best, the score and the output of the program.
 *
 * Usage:
 * <code>
 *     findBestOffset('for(;++$f<96;$T=($T+&)%95)echo chr(32+$T);')
 * </code>
 *
 * @param string $rawCode
 */
function findBestOffset($rawCode)
{
    $solutions = [];
    $outputs   = [];
    $count = 96;
    for ($k = 1; $k < $count; $k ++) {
        if ($count % $k) {
            $code   = str_replace('&', $k, $rawCode);
            $output = getOutput(function () use ($code) { eval($code); });
            $score  = computeScore($output, $code);
            if (is_integer($score)) {
                $solutions[$code] = $score;
                $outputs[$code] = $output;
            }
            echo('.');
        }
    }
    echo("\n");

    asort($solutions);

    $bestK = array_keys($solutions)[0];
    $score = $solutions[$bestK];
    echo('Best solution: <code>'.$bestK.'</code>, score='.$score."\n");
    echo('Output: <output>'.$outputs[$bestK]."</output>\n");
}


// This is the end of file; no closing PHP tag
