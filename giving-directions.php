<?php
/**
 * Code Golf: Giving Directions
 *
 * @link http://codegolf.stackexchange.com/questions/54583/giving-directions
 */


// Check for PHP version
if (PHP_VERSION < '5.4') {
    exit("PHP 5.4 or newer is required. Dare to progress, don't live in the past!");
}

// Hide notices. It can be passed as argument to the CLI:
//   php -d error_reporting=0 giving-directions.php
error_reporting(E_ALL & ~E_NOTICE);


// Load the test framework appropriate for multi-line tests
include 'a/TestFrameworkInATweet.php';


//
// A partially-golfed test suite fits best a code golf program

it('generates "'.($dir='F R F R F L F L').'"', $dir==directions(<<< E
      |
      /
     |
     /
    |
    \
     |
     \
      D
E
));


it('generates "'.($dir='F F L F R R R').'"', $dir==directions(<<< E
   |
   |
   \
    |
    ^
   / \
  /   |
 D    |
E
));


it('generates "'.($dir='F F L L L F F F L L R F').'"', $dir==directions(<<< E
      |
      |
      \
       \
        ^
       / |
      |  |
      \  |
       \ \
        \ \
         \ /
          Y
          D
E
));


it('generates "'.($dir='L F R F L F R').'"', $dir==directions(<<< E
\
 |
 /
|
\
 |
 /
D
E
));



it('generates "'.($dir='R L R L R L').'"', $dir==directions(<<< E
    /
   \
    /
   \
    ^
   \ \
    D \
E
));



it('generates "'.($dir='F R F F F L F F F').'"', $dir==directions(<<< E
    |
    ^
   | \
   | /
    Y
    ^
   / |
   \ |
    Y
    D
E
));



/**
 * Test adapter.
 *
 * It emulates the behaviour of the CLI and collects the output to be tested.
 *
 * @param string $map the input map specifications
 * @return string the output of the program
 */
function directions($map)
{
    ob_start();
    golfedDirections_v2([1 => $map]);
    $dir = ob_get_clean();
//echo('['.$dir."]\n");
    return $dir;
}




/**
 * The actual code, in a function.
 *
 * This is the first iteration.
 *
 * How it works: it updates two branches alternatively (between a '^' and the next 'Y' received in the input) or a single
 * branch (outside the '^'-'Y' bracket). It also keeps the count of 'F' characters on each branch.
 * On '^' it adds the directions for the current (unique) branch to variable `$dir` then switches to 2 branches and
 * initialize them with 'R' and 'L'
 * On 'Y' it selects the best branch (the one with the most 'F' characters), appends it to the accumulator then
 * switches back to one empty branch.
 *
 * @param string[] $argv the global variable $argv (the CLI arguments)
 */
function echoDirections_v1(array $argv)
{
    $map = $argv[1];

    $dir = '';              // the already computed directions
    $nb = 1;                // the number of branches
    $branches = [ '' ];     // the branches (2 while between '^' and 'Y', 1 otherwise)
    $nbF = [ 0, 0 ];        // the number of 'F's on the branches (used to select the branch)
    $curr = 0;              // the current branch
    foreach (str_split($map) as $char) {
        if ($char == '|') {             // go 'F'orward
            $branches[$curr] .= 'F ';       // put it to the current branch
            $nbF[$curr] ++;                 // count it for the current branch
        } elseif ($char == '/') {       // go 'R'ight
            $branches[$curr] .= 'R ';
        } elseif ($char == '\\') {      // go 'L'eft
            $branches[$curr] .= 'L ';
        } elseif ($char == '^') {       // fork; choose the path ('L' or 'R') that contains the most 'F'orward segments
            $dir .= $branches[0];           // flush the current path (it was stored as the first branch)
            $nb = 2;                        // start two branches
            $branches = [ 'R ', 'L ' ];     // put the correct directions on each branch
            $nbF = [ 0, 0 ];                // no 'F's on any branch yet
            $curr = 1;                      // need this to let it be 0 on the next loop
        } elseif ($char == 'Y') {       // join
            $dir .= $branches[$nbF[0] < $nbF[1]];   // flush; choose the branch having the most 'F's
            $dir .= 'F ';                           // treat it like a "|"
            $branches = [ '' ];                     // back to a single, empty branch
            $nb = 1;
        } elseif ($char == 'D') {       // finish
            $dir .= $branches[$curr];       // flush
            break;                          // and exit; could use 'return' but it's one byte longer; use exit() in the final program and save 5 bytes
        } else {
            continue;
        }
        $curr = ++ $curr % $nb;
    }
    echo rtrim($dir);
}



/*
 * Golfed version of echoDirections_v1, 317 bytes
 */
function golfedDirections_v1(array $argv)
{
$b=0;foreach(str_split($argv[$n=1])as$c){if($c=='|'){$a[$b].='F ';$f[$b]++;}elseif($c=='/'){$a[$b].='R ';}elseif($c=='\\'){$a[$b].='L ';}elseif($c=='^'){$d.=$a[0];$n=2;$a=['R ','L '];$f=[];$b=1;}elseif($c==Y){$d.=$a[$f[0]<$f[$n=1]].'F ';$a=[];}elseif($c==D){$d.=$a[$b];break;}else continue;$b=++$b%$n;}echo rtrim($d);
}



/**
 * Refactored golfedDirections_v1() - use eval() instead of the big list of "if/else" to save more bytes
 *
 * @param array $argv
 */
function refactored_v1(array $argv)
{
    $a=$f=[];       // these assignments are not required (they were suppresed in v2)
    $n=1;           // this assignment can be squeezed into $argv[$n=1]
    $b=0;           // if this assignment is suppressed $b becomes '' and breaks the logic
    $code = [
        '|' => '$a[$b].="F ";$f[$b]++;',
        '/' => '$a[$b].="R ";',
        '\\'=> '$a[$b].="L ";',
        '^' => '$d.=$a[0];$n=2;$a=["R ","L "];$f=[];$b=1;',
        'Y' => '$d.=$a[$f[0]<$f[$n=1]]."F ";$a=[];',
        'D' => '$d.=$a[$b];echo(rtrim($d));',
    ];
    foreach (str_split($argv[1]) as $char) {
        if ($x = $code[$char]) {
            eval($x);
            $b = ++ $b % $n;
        }
    }
}



/**
 * Golfed version of refactored_v1, 281 bytes
 *
 * @param array $argv
 */
function golfedDirections_v2(array $argv)
{
    $b=0;$p=['|'=>'$a[$b].="F ";$f[$b]++;','/'=>'$a[$b].="R ";','\\'=>'$a[$b].="L ";','^'=>'$d.=$a[0];$n=2;$a=["R ","L "];$f=[];$b=1;','Y'=>'$d.=$a[$f[0]<$f[$n=1]]."F ";$a=[];','D'=>'$d.=$a[$b];echo(rtrim($d));'];foreach(str_split($argv[$n=1])as$c){if($x=$p[$c]){eval($x);$b=++$b%$n;}}
}



//
// The golfed stand-alone program v1. (312 bytes):
// It combines the 'break' statement with 'echo(rtrim($d))' into 'exit(rtrim($d))' and gets rid of the echo.
// This way it saves 5 more bytes
// <?php
// $b=0;foreach(str_split($argv[$n=1])as$c){if($c=='|'){$a[$b].='F ';$f[$b]++;}elseif($c=='/'){$a[$b].='R ';}elseif($c=='\\'){$a[$b].='L ';}elseif($c=='^'){$d.=$a[0];$n=2;$a=['R ','L '];$f=[];$b=1;}elseif($c==Y){$d.=$a[$f[0]<$f[$n=1]].'F ';$a=[];}elseif($c==D){$d.=$a[$b];exit(rtrim($d));}else continue;$b=++$b%$n;}



//
// The golfed stand-alone program v2. (281 bytes):
// <?php
// $b=0;$p=['|'=>'$a[$b].="F ";$f[$b]++;','/'=>'$a[$b].="R ";','\\'=>'$a[$b].="L ";','^'=>'$d.=$a[0];$n=2;$a=["R ","L "];$f=[];$b=1;','Y'=>'$d.=$a[$f[0]<$f[$n=1]]."F ";$a=[];','D'=>'$d.=$a[$b];exit(rtrim($d));'];foreach(str_split($argv[$n=1])as$c){if($x=$p[$c]){eval($x);$b=++$b%$n;}}



// This is the end of file; no closing PHP tag
