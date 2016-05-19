<?php
/**
 * Code Golf: How should you arrange your chairs?
 *
 * @link http://codegolf.stackexchange.com/questions/80106/how-should-you-arrange-your-chairs
 */


// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';



/**
 * Class ArrangeTheChairs - the problem at hand
 */
class ArrangeTheChairs extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // The public interface
    //
    public function runTests()
    {
         $this->testCase(1, array (1, 1));
         $this->testCase(2, array (1, 2));
         $this->testCase(3, array (2, 2));
         $this->testCase(4, array (2, 2));
         $this->testCase(5, array (2, 3));
         $this->testCase(6, array (2, 3));
         $this->testCase(7, array (3, 3));
         $this->testCase(8, array (3, 3));
         $this->testCase(9, array (3, 3));
         $this->testCase(10, array(2, 5));
         $this->testCase(11, array(3, 4));
         $this->testCase(12, array(3, 4));
         $this->testCase(13, array(4, 4));
         $this->testCase(14, array(4, 4));
         $this->testCase(15, array(4, 4));
         $this->testCase(16, array(4, 4));
         $this->testCase(17, array(3, 6));
         $this->testCase(18, array(3, 6));
         $this->testCase(19, array(4, 5));
         $this->testCase(20, array(4, 5));
         $this->testCase(21, array(3, 7));
         $this->testCase(22, array(5, 5));
         $this->testCase(23, array(5, 5));
         $this->testCase(24, array(5, 5));
         $this->testCase(25, array(5, 5));
         $this->testCase(26, array(4, 7));
         $this->testCase(27, array(4, 7));
         $this->testCase(28, array(4, 7));
         $this->testCase(29, array(5, 6));
         $this->testCase(30, array(5, 6));
         $this->testCase(31, array(4, 8));
         $this->testCase(32, array(4, 8));
         $this->testCase(33, array(6, 6));
         $this->testCase(34, array(6, 6));
         $this->testCase(35, array(6, 6));
         $this->testCase(36, array(6, 6));
         $this->testCase(37, array(5, 8));
         $this->testCase(38, array(5, 8));
         $this->testCase(39, array(5, 8));
         $this->testCase(40, array(5, 8));
         $this->testCase(41, array(6, 7));
         $this->testCase(42, array(6, 7));
         $this->testCase(43, array(5, 9));
         $this->testCase(44, array(5, 9));
         $this->testCase(45, array(5, 9));
         $this->testCase(46, array(7, 7));
         $this->testCase(47, array(7, 7));
         $this->testCase(48, array(7, 7));
         $this->testCase(49, array(7, 7));
         $this->testCase(50, array(5, 10));
         $this->testCase(51, array(6, 9));
         $this->testCase(52, array(6, 9));
         $this->testCase(53, array(6, 9));
         $this->testCase(54, array(6, 9));
         $this->testCase(55, array(7, 8));
         $this->testCase(56, array(7, 8));
         $this->testCase(57, array(6, 10));
         $this->testCase(58, array(6, 10));
         $this->testCase(59, array(6, 10));
         $this->testCase(60, array(6, 10));
         $this->testCase(61, array(8, 8));
         $this->testCase(62, array(8, 8));
         $this->testCase(63, array(8, 8));
         $this->testCase(64, array(8, 8));
         $this->testCase(65, array(6, 11));
         $this->testCase(66, array(6, 11));
         $this->testCase(67, array(7, 10));
         $this->testCase(68, array(7, 10));
         $this->testCase(69, array(7, 10));
         $this->testCase(70, array(7, 10));
         $this->testCase(71, array(8, 9));
         $this->testCase(72, array(8, 9));
         $this->testCase(73, array(7, 11));
         $this->testCase(74, array(7, 11));
         $this->testCase(75, array(7, 11));
         $this->testCase(76, array(7, 11));
         $this->testCase(77, array(7, 11));
         $this->testCase(78, array(9, 9));
         $this->testCase(79, array(9, 9));
         $this->testCase(80, array(9, 9));
         $this->testCase(81, array(9, 9));
         $this->testCase(82, array(7, 12));
         $this->testCase(83, array(7, 12));
         $this->testCase(84, array(7, 12));
         $this->testCase(85, array(8, 11));
         $this->testCase(86, array(8, 11));
         $this->testCase(87, array(8, 11));
         $this->testCase(88, array(8, 11));
         $this->testCase(89, array(9, 10));
         $this->testCase(90, array(9, 10));
         $this->testCase(91, array(7, 13));
         $this->testCase(92, array(8, 12));
         $this->testCase(93, array(8, 12));
         $this->testCase(94, array(8, 12));
         $this->testCase(95, array(8, 12));
         $this->testCase(96, array(8, 12));
         $this->testCase(97, array(10, 10));
         $this->testCase(98, array(10, 10));
         $this->testCase(99, array(10, 10));
         $this->testCase(100, array(10, 10));
    }



    public function getTheGolfedCode()
    {
        return $this->getFunctionBody('arrngChrs4', __CLASS__);
    }



    public function runTheGolfedCode($argc, array $argv)
    {
        $this->arrngChrs4($argc, $argv);
        return 0;
    }





    /////////////////////////////////////////////////////////////////////////
    // Test helpers
    //

    /**
     * @param int   $input     the number of chairs
     * @param array $expected  the expected output: an array of two numbers
     */
    protected function testCase($input, array $expected)
    {
        // The functions echo two numbers separated by comma; let's put the expected values in the same format
        $expected = implode(',', $expected);


        //
        // The first version: implement all the conditions, don't cut the corners
        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrangeChairs1(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - clear  code #1', $input, $actual, $score),
            $actual == $expected
        );

        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrngChrs1(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - golfed code #1', $input, $actual, $score),
            $actual == $expected
        );


        //
        // Version 2: put all possible solutions into a list and sort it
        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrangeChairs2(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - clear  code #2', $input, $actual, $score),
            $actual == $expected
        );

        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrngChrs2(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - golfed code #2', $input, $actual, $score),
            $actual == $expected
        );


        //
        // Version 3: converted JS code to PHP code
        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrangeChairs3(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - clear  code #3', $input, $actual, $score),
            $actual == $expected
        );

        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrngChrs3(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - golfed code #3', $input, $actual, $score),
            $actual == $expected
        );


        //
        // Version 4: complete refactor after mathematical remarks
        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrangeChairs4(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - clear  code #4', $input, $actual, $score),
            $actual == $expected
        );

        $actual = $this->getFunctionOutput(function () use ($input) { $this->arrngChrs4(2, array(__FILE__, (string)$input)); });
        list($width, $height) = explode(',', $actual);
        $score  = $this->computeScore($input, (int)$width, (int)$height);
        it(
            sprintf('arranges %d chairs as %s (score %d) - golfed code #4', $input, $actual, $score),
            $actual == $expected
        );
    }



    /**
     * This method is used by the test suite in order to be able to display
     * the score of each solution.
     *
     * It is not used by the functions that compute the solutions. In fact, some of
     * them take advantage of additional information they handle ($width <= $height)
     * and replace the call to abs() with its actual result ($height-$width) or
     * skip the usage of $input when they compute the score because its presence
     * doesn't influence the comparison results. These insights make the functions
     * use shorter code to compute the score they need (the score is not an explicit
     * part of the solution).
     *
     * @param int $chairs
     * @param int $width
     * @param int $height
     * @return int
     */
    protected function computeScore($chairs, $width, $height)
    {
        return abs($width - $height) + ($width * $height - $chairs);
    }



    /////////////////////////////////////////////////////////////////////////
    // The solutions
    //

    /**
     * My first attempt. It follows all the rules displayed in the question
     * (regarding the score computation and ties) and doesn't try very hard
     * to cut the corners in order to get shorter (and faster) code.
     *
     * The algorithm: starting with rectangle (1,$n) increase width and compute
     * the minimum height for it while the width is smaller than or equal to the height.
     * Compute the score for each combination, compare the score with the previous best
     * score; when they are equal then check the areas (don't bother subtracting the
     * number of used chairs, it doesn't change).
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrangeChairs1($argc, array $argv)
    {
        $n = $argv[1];
        $w = 1;
        $h = $n;
        $s = $n - 1;

        for ($i = 1, $j = $n; $i <= $j; $i ++, $j = ceil($n / $i)) {
            $c = abs($i - $j) + ($i * $j - $n);
            if ($c < $s || $c == $s && $i * $j < $w * $h) {
                $w = $i;
                $h = $j;
                $s = $c;
            }
        }

        echo("$w,$h");
    }

    /**
     * The golfed version of arrangeChairs1()
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrngChrs1($argc, array $argv)
    {
        for($s=$h=$j=$n=$argv[$w=$i=1];$i<=$j;$j=ceil($n/++$i)){$c=$j-$i+$i*$j-$n;if($c<$s||$c==$s&&$i*$j<$w*$h){$w=$i;$h=$j;$s=$c;}}echo"$w,$h";
    }



    /**
     * Another attempt, using a different approach regarding the score comparison.
     *
     * Generate all possible combinations of width and height between 1 and $n
     * having width smaller than or equal to height. If the number of chairs of
     * the rectangle is large enough for our needs then compute its score and add it to
     * a list (indexed by the string to output). Sort the list by value, get the
     * key of the first entry; the key contains the rectangle dimensions ready to
     * be printed.
     *
     * The values used for sorting is a combination of score (multiplied by $n) and
     * the rectangle area (subtracting the number of used chairs is not needed
     * because it doesn't change).
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrangeChairs2($argc, array $argv)
    {
        $n = $argv[1];
        $a = [];
        for ($i = 1; $i <= $n; $i ++) {
            for ($j = 1; $j <= $i; $j ++) {
                if ($i * $j >= $n) {
                    $score = $i - $j + ($i * $j - $n);
                    $a["$j,$i"] = $score * $n + $i * $j;
                }
            }
        }
        asort($a);
        echo(key($a));
    }

    /**
     * The golfed version of arrangeChairs2()
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrngChrs2($argc, array $argv)
    {
        for($n=$argv[1];++$i<=$n;)for($j=0;++$j<=$i;)if($n<=$k=$i*$j)$a["$j,$i"]=($i-$j+$k-$n)*$n+$k;asort($a);echo key($a);
    }



    /**
     * This is my PHP translation of the following Javascript code (after it was partially ungolfed):
     *
     * <code>
     *   n=>[...Array(m=n)].map((_,i)=>(d=(n+i++)/i|0)>i||(s=i*d-n+i-d)>m||(m=s,r=[d,i]))&&r
     * </code>
     * The JS code was provided by user @Neil as a solution to the problem
     * @link http://codegolf.stackexchange.com/a/80117/40534
     *
     * Remarks:
     *  * in Javascript, the values of "i" are: 0..n-1; in this PHP version, the values of $i are 1..n;
     *    there is no need for $i++;
     *  * the JS version computes (n+i)/i to upper round n/i. The "|0" part forces the result to integer.
     *    PHP uses ceil($n/$i) to sum all these.
     *  * the a||b||c JS construct (shortcut on evaluation) is not possible in PHP because of the
     *    statements in the last part; it was converted to if(!a&&!b){c}
     */
    protected function arrangeChairs3($argc, array $argv)
    {
        $n = $argv[1];
        $m = $n;
        $r = [1,$n];
        foreach (range(1, $n) as $i) {
            $a = ($d = ceil($n/$i)) > $i;
            $b = ($s = $i * $d - $n + $i - $d) > $m;
            if (! $a && ! $b) {
                $m = $s;
                $r = [$d, $i];
            }
        }

        echo(implode(',', $r));
    }

    /**
     * The golfed version of arrangeChairs3()
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrngChrs3($argc, array $argv)
    {
        foreach(range(1,$m=$n=$argv[1])as$i)if(($d=ceil($n/$i))<=$i&&$m>=$s=$i*$d-$n+$i-$d){$m=$s;$w=$d;$h=$i;}echo"$w,$h";
    }



    /**
     * The fourth attempt: a algorithm that removes unnecessary checks.
     *
     * Refining the idea implemented by arrangeChairs1() and arrangeChairs3():
     *   * start with rectangle (1,$n); increase the width, compute the minimum height, compute score etc
     *     while the width is smaller than or equal to the height;
     *   * the height is always greater than (or equal to) the width; the distance between width and height
     *     required to compute the score is always height-width;
     *   * the above mentioned difference decreases on each step; the width and height start on extremes (1 and $n)
     *     and they get closer and closer on each step until they become equal (or height is width+1);
     *   * because the difference always decreases, when the score for the current rectangle is the same
     *     as the previous best score, the current rectangle is worse than the previous best rectangle (it has
     *     more empty seats); the current rectangle can be ignored;
     *   * the score comparison can go only with "current score" is less than "previous score"; on ties, the
     *     previous score is always better;
     *   * the number of occupied chairs ($n) is not needed for score computation because it doesn't change
     *     and the actual score is not actually needed; the scores are used only for comparison and applying
     *     the same offset to all of them (+$n) doesn't change their relative order.
     *
     * The algorithm, taking care of the remarks above:
     *   * start with width 1, score 2*$n; it is greater than the first real score;
     *     the first rectangle is (1,$n), with score $n-1+1*$n; (the (-$n) part used to compute the empty seats
     *     is not used in the score computation);
     *   * compute the minimum height needed to cover all the seats as "ceil($n/width)";
     *   * compute the score as height-width+width*height; don't subtract $n;
     *   * compare with previous score; if lower (but not equal) then this is the new best rectangle;
     *     remember it and its score;
     *   * increase width, compute minimum height, repeat; exit when width is not less than or equal to minimum height.
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrangeChairs4($argc, array $argv)
    {
        $n = $argv[1];
        $w = 1;
        $h = $n;
        $s = 2 * $n;                        // current best score (fake for now)
        for ($i = 1, $j = $n; $i <= $j; $i ++) {
            $j = ceil($n / $i);             // minimum height
            $c = $j - $i + $i * $j;         // current score
            if ($i <= $j && $c < $s) {
                $w = $i;
                $h = $j;
                $s = $c;
            }
        }

        echo("$w,$h");
    }

    /**
     * The golfed version of arrangeChairs4()
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function arrngChrs4($argc, array $argv)
    {
        for($s=2*$j=$n=$argv[$i=1];$i<=$j;$j=ceil($n/++$i))if($s>$c=$j-$i+$i*$j){$w=$i;$h=$j;$s=$c;}echo"$w,$h";
    }
}


// Instantiate the problem and run it
exit((new ArrangeTheChairs($argc, $argv))->run());


// This is the end of file; no closing PHP tag
