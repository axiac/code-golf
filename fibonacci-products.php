<?php
/**
 * Code Golf: Fibonacci products
 *
 * @link http://codegolf.stackexchange.com/questions/79854/fibonacci-products
 */

// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';



/**
 * Class FibonacciProducts - the problem at hand
 */
class FibonacciProducts extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // Public interface
    //
    public function runTests()
    {
        $this->testBothFunctions(1, 1);
        $this->testBothFunctions(2, 2);
        $this->testBothFunctions(3, 3);
        $this->testBothFunctions(4, 3);
        $this->testBothFunctions(5, 5);
        $this->testBothFunctions(6, 5);
        $this->testBothFunctions(7, 10);
        $this->testBothFunctions(8, 8);
        $this->testBothFunctions(9, 8);
        $this->testBothFunctions(12, 24);
        $this->testBothFunctions(13, 13);
        $this->testBothFunctions(42, 272);
        $this->testBothFunctions(100, 2136);
        $this->testBothFunctions(1000, 12831);
        $this->testBothFunctions(12345, 138481852236);
    }


    public function getTheGolfedCode()
    {
        return $this->getFunctionBody('fbnccPrdct', __CLASS__);
    }


    public function runTheGolfedCode($argc, array $argv)
    {
        echo($this->fbnccPrdct($argc, $argv));
        echo("\n");
        return 0;
    }



    /////////////////////////////////////////////////////////////////////////
    // Implementation
    //
    protected function testBothFunctions($input, $expected)
    {
        $actual = $this->fibonacciProduct($input);
        it(sprintf('computes Fibonacci product for %d as %d -- clear  code', $input, $actual), $actual === $expected);


        $actual = $this->getFunctionOutput(function() use($input) { return $this->fbnccPrdct(2, array(__FILE__, $input)); });
        it(sprintf('computes Fibonacci product for %d as %d -- golfed code', $input, $actual), $actual == $expected);
    }



    /**
     * Compute Fibonacci product - the clear code
     *
     * @param int $input
     * @return int
     */
    protected function fibonacciProduct($input)
    {
        // Compute Fibonacci numbers smaller than $input, put them in a list
        $a = 1;
        $b = 1;
        $fibo = array($a, $b);
        $c = $a + $b;
        while ($c <= $input) {
            $fibo[] = $c;
            $a = $b;
            $b = $c;
            // Compute the next Fibonacci number
            $c = $a + $b;
        }

        // Get the Fibonacci decomposition of $input, compute $output on the fly
        $output = 1;
        for ($i = count($fibo) - 1; $i; $i --) {
            while ($fibo[$i] <= $input) {
                $input -= $fibo[$i];
                $output *= $fibo[$i];
            }
        }

        return $output;
    }

    
    
    /**
     * Compute Fibonacci product - the golfed code.
     *
     * @param int      $argc
     * @param string[] $argv
     * @return int
     */
    protected function fbnccPrdct($argc, array $argv)
    {
        for($o=$c=1;$c<=$n=$argv[1];$f[++$k]=$c,$a=$b,$b=$c,$c+=$a);for($i=$k;$i;$i--)for(;$n>=$d=$f[$i];$n-=$d,$o*=$d);echo$o;
    }
}


// Instantiate the problem and run it
exit((new FibonacciProducts($argc, $argv))->run());


// This is the end of file; no closing PHP tag
