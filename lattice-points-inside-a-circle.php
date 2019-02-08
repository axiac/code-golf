<?php
/**
 * Code Golf: Lattice Points inside a Circle
 *
 * @link http://codegolf.stackexchange.com/questions/1938/code-golf-lattice-points-inside-a-circle
 */

// Load the code-golf framework
include 'a/CodeGolfFramework.php';



/**
 * A class for the problem at hand
 */
class LatticePointsInsideACircle extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // Public interface
    //

    public function runTests()
    {
        $this->testAllFunctions(1, 5);
        $this->testAllFunctions(2, 13);
        $this->testAllFunctions(3, 29);
        $this->testAllFunctions(10, 317);
        $this->testAllFunctions(1000, 3141549);
        $this->testAllFunctions(2000, 12566345);

        return 0;
    }



    public function getTheGolfedCode()
    {
        // Enclose the code into a function
        return sprintf('function f($n){%s}', parent::getFunctionBody('cntLttcPnts2', __CLASS__));
    }



    public function runTheGolfedCode($argc, array $argv)
    {
        $n       = (int)$argv[1];
        $start   = microtime(TRUE);
        $result  = $this->cntLttcPnts2($n);
        $runTime = microtime(TRUE) - $start;

        printf("f(%d)=%d\n", $n, $result);
        printf("time=%f seconds\n", $runTime);

        return 0;
    }




    /////////////////////////////////////////////////////////////////////////
    // Implementation
    //


    /**
     * The tester for both methods, the clean code and the golfed code
     *
     * @param int $n
     * @param int $expected
     */
    protected function testAllFunctions($n, $expected)
    {
        // The clean code method 1
        $startTime = microtime(TRUE);
        $result = ($this->countLatticePoints1($n) === $expected);
        $runTime = microtime(TRUE) - $startTime;
        it(sprintf('it computes f(%d)=%d -- clean  code #1; time=%f s', $n, $expected, $runTime), $result);

        // The golfed code method 1
        $startTime = microtime(TRUE);
        $result = ($this->cntLttcPnts1($n) === $expected);
        $runTime = microtime(TRUE) - $startTime;
        it(sprintf('it computes f(%d)=%d -- golfed code #1; time=%f s', $n, $expected, $runTime), $result);

        // The clean code method 2
        $startTime = microtime(TRUE);
        $result = ($this->countLatticePoints2($n) === $expected);
        $runTime = microtime(TRUE) - $startTime;
        it(sprintf('it computes f(%d)=%d -- clean  code #2; time=%f s', $n, $expected, $runTime), $result);

        // The golfed code method 2
        $startTime = microtime(TRUE);
        $result = ($this->cntLttcPnts2($n) === $expected);
        $runTime = microtime(TRUE) - $startTime;
        it(sprintf('it computes f(%d)=%d -- golfed code #2; time=%f s', $n, $expected, $runTime), $result);
    }



    /**
     * The clean code, version 1
     *
     * Count (row by row) all the points having $x > 0, $y >= 0 (a quarter of the circle)
     * then multiply by 4 and add the origin.
     *
     * @param int $n
     * @return int
     */
    protected function countLatticePoints1($n)
    {
        $count = 0;
        for ($x = 1; $x <= $n; $x ++) {
            for ($y = 0; $y <= $n; $y ++) {
                if ($x * $x + $y * $y <= $n * $n) {
                    $count ++;
                } else {
                    break;
                }
            }
        }

        return 4 * $count + 1;
    }



    /**
     * The golfed code, version 1.
     *
     * List all the points (row by row) inside a quarter of the surrounding square.
     * Count only those inside the quarter of the circle.
     *
     * @param int $n
     * @return int
     */
    protected function cntLttcPnts1($n)
    {
        for(;$y<=$n;$y++)for($x=1;$x<=$n;$x++)$c+=$x*$x+$y*$y<=$n*$n;return$c*4+1;
    }



    /**
     * The clean code, version 2. Much faster code and shorter golfed code (also faster).
     *
     * Count all the points having x > 0, y >= 0 (a quarter of the circle)
     * then multiply by 4 and add the origin.
     *
     * Walk the lattice points in zig-zag starting at ($n,0) towards (0,$n), in the
     * neighbourhood of the circle. While outside the circle, go left. Go on line up
     * and repeat until $x == 0.
     *
     * @param int $n
     * @return int
     */
    protected function countLatticePoints2($n)
    {
        $count = 0;
        // Start on the topmost right point of the circle ($n,0), go towards the topmost point (0,$n)
        // Stop when reach it (but don't count it)
        for ($y = 0, $x = $n; $x > 0; $y ++) {
            // While outside the circle, go left;
            for (; $n * $n < $x * $x + $y * $y; $x --) {
                // Nothing here
            }
            // ($x,$y) is the rightmost lattice point on row $y that is inside the circle
            // There are exactly $x lattice points on the row $y that have x > 0
            $count += $x;
        }

        // Four quarters plus the center
        return 4 * $count + 1;
    }


    /**
     * The golfed code, version 2
     *
     * Walk the lattice points in zig-zag starting at ($n,0) towards (but not reaching) (0,$n).
     * Multiply by 4, add the origin.
     *
     * Apart from shortening the variable names and stripping the whitespaces (obvious!),
     * there are only two code golfing techniques used here:
     *   * skipped the initialization of $y and $c with 0; the contexts where they are used
     *     make the interpreter initialize them with 0 on their first use;
     *   * swapped '4*$c' to '$c*4' on the 'return' statement; this way the whitespace between
     *     'return' and '$c' can be eliminated;
     *   * moved '$c+=$x' inside the third expression of the outer 'for' statement; saved 2 bytes
     *     (the curly braces of the outer 'for' statement)
     *
     * @param int $n
     * @return int
     */
    protected function cntLttcPnts2($n)
    {
        for($x=$n;$x;$c+=$x,$y++)for(;$n*$n<$x*$x+$y*$y;$x--);return$c*4+1;
    }
}



/////////////////////////////////////////////////////////////////////////
// Create the problem and let it run
//
exit((new LatticePointsInsideACircle($argc, $argv))->run());


// This is the end of file; no closing PHP tag
