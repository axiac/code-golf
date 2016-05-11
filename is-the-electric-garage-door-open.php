<?php
/**
 * Code Golf: Is the electric garage door open?
 *
 * @link http://codegolf.stackexchange.com/questions/79668/is-the-electric-garage-door-open
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

// Include the code-golf framework; it loads the testing frameworks
require 'a/CodeGolfFramework.php';



/**
 * A class for the problem at hand
 */
class ElectricGarageDoor extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // Actions
    //

    /**
     * Run all the tests; this method is invoked when the program is launched without arguments
     * 
     * @return int
     */
    public function runTests()
    {
        // Run the test cases provided in the problem
        $this->testDoorStatus([], '100% D');
        $this->testDoorStatus([20], '0% U');
        $this->testDoorStatus([10], '0% U');
        $this->testDoorStatus([5], '50% D');
        $this->testDoorStatus([20, 20], '100% D');
        $this->testDoorStatus([10, 10], '100% D');
        $this->testDoorStatus([5, 5], '0% U');
        $this->testDoorStatus([1, 2, 3], '100% D');
        $this->testDoorStatus([8, 9, 10, 11], '0% U');
        $this->testDoorStatus([11, 10, 9, 8, 7], '20% U');

        return 0;
    }



    /**
     * Test helper. Test both scripts (plain and golfed version) using the test framework.
     * Check their actual output against the expected output.
     *
     * @param int[]  $delays  the input argument (the number of seconds to wait before pushing the button)
     * @param string $expected the expected program output
     */
    protected function testDoorStatus(array $delays, $expected)
    {
        // Put the script path in front of the arguments; the real program gets its arguments from the command line
        array_unshift($delays, __FILE__);

        // Test the plain-code function
        it(
            sprintf("handles '%s' correctly: %s  -- clear  version", implode(' ', $delays), $expected),
            $this->getFunctionOutput(function () use ($delays) { $this->handleDoor($delays); }) === $expected
        );

        // Test the golfed function
        it(
            sprintf("handles '%s' correctly: %s  -- golfed version", implode(' ', $delays), $expected),
            $this->getFunctionOutput(function () use ($delays) { $this->hndlDr($delays); }) === $expected
        );
    }



    /////////////////////////////////////////////////////////////////////////
    // Handling of the golfed code
    //

    /**
     * Return the golfed source code.
     *
     * @return string
     */
    public function getTheGolfedCode()
    {
        // It's the code of self::hndlDr() method
        return parent::getFunctionBody('hndlDr', __CLASS__);
    }



    /**
     * Run the golfed code using the arguments provided in the command line.
     * Throw an InvalidArgumentException when this is not possible.
     *
     * @param int   $argc
     * @param array $argv
     * @return int        the exit code
     * @throws InvalidArgumentException
     */
    public function runTheGolfedCode($argc, array $argv)
    {
        // Run the code
        $this->hndlDr($argv);
        echo("\n");

        // Success
        return 0;
    }



    /////////////////////////////////////////////////////////////////////////
    // The solution of the problem
    //

    /**
     * This is the plain code.
     *
     * @param array $listDelays
     * @return int
     */
    private function handleDoor(array $listDelays)
    {
        // The door is down (0% open)
        $pos = 0;          // 0 .. 10
        // It will move up
        $dir = +10;

        // The initial button push starts the door moving up
        $run = 0;

        // Handle each button push
        foreach ($listDelays as $delay) {
            if ($run) {
                $pos = min(max($pos + $delay * $dir, 0), 100);
                if (0 < $pos && $pos < 100) {
                    $run = 0;
                }
                $dir = -$dir;
            } else {
                $run = 1;
            }
        }

        // Complete the last move, if any
        if ($run) {
            $pos = min(max($pos + 10 * $dir, 0), 100);
            $dir = - $dir;
            $run = 0;
        }

        echo $pos . '% ' . ($dir + 10 ? 'U' : 'D');
    }



    /**
     * This is the golfed code.
     *
     * @param array $argv
     * @return string
     */
    private function hndlDr(array $argv)
    {
        $d=$argv[]=10;foreach($argv as$a)if($r){$p=min(max($p+$a*$d,0),100);$r=$p<1||99<$p;$d=-$d;}else$r=1;echo"$p% ".DU[$d>0];
    }
}



/////////////////////////////////////////////////////////////////////////
// Create the problem and let it run
//
exit((new ElectricGarageDoor($argc, $argv))->run());



// This is the end of file; no closing PHP tag
