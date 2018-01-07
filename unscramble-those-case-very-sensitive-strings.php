<?php
/**
 * Code Golf: Unscramble those case-(very)-sensitive strings
 *
 * @link http://codegolf.stackexchange.com/questions/109117/unscramble-those-case-very-sensitive-strings
 */

// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';


/**
 * Class UnscrambleThoseStrings - the problem at hand
 */
class UnscrambleThoseStrings extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // The public interface
    //
    public function runTests()
    {
        $this->testCase('EdoC!', 'CodE!');
        $this->testCase('lLEhW OroLd!', 'hELlO WorLd!');
        $this->testCase('rpGOZmaimgn uplRzse naC DEoO LdGf', 'prOGRamming puzZles anD COdE GoLf');
        $this->testCase('eIt uqHKC RBWOO xNf ujPMO SzRE HTL EOvd yAg', 'tHe quICK BROWN fOx juMPS OvER THE LAzy dOg');
        $this->testCase('NraWgCi: Nsas-eNEiTIsev rNsiTG!!', 'WarNiNg: Case-sENsITive sTriNG!!');
    }



    public function getTheGolfedCode()
    {
        return $this->getFunctionBody('unscrmbl3', __CLASS__);
    }



    public function runTheGolfedCode($argc, array $argv)
    {
        $this->unscrmbl3($argc, $argv);

        return 0;
    }


    /////////////////////////////////////////////////////////////////////////
    // Test helpers
    //

    /**
     * @param string $input    the string to unscramble
     * @param string $expected the expected output (the unscrambled string)
     */
    protected function testCase($input, $expected)
    {
        //
        // The first version: implement all the conditions, don't cut the corners
        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscramble1(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - clear  code #1", $input, $actual),
            $actual === $expected
        );

        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscrmbl1(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - golfed code #1", $input, $actual),
            $actual === $expected
        );

        if ('7' <= PHP_VERSION) {
            $actual = $this->getFunctionOutput(
                function () use ($input) { $this->unscrmbl1php7(2, array(__FILE__, (string)$input)); }
            );
            it(
                sprintf("unscrambles '%s' as '%s' - golfed code #1, PHP7 version", $input, $actual),
                $actual === $expected
            );
        }


        //
        // The second version: the arguments of preg_replace() can be arrays
        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscramble2(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - clear  code #2", $input, $actual),
            $actual === $expected
        );

        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscrmbl2(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - golfed code #2", $input, $actual),
            $actual === $expected
        );


        //
        // The third version: compute the uppercase search string from the lowercase one
        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscramble3(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - clear  code #3", $input, $actual),
            $actual === $expected
        );

        $actual = $this->getFunctionOutput(
            function () use ($input) { $this->unscrmbl3(2, array(__FILE__, (string)$input)); }
        );
        it(
            sprintf("unscrambles '%s' as '%s' - golfed code #3", $input, $actual),
            $actual === $expected
        );
    }



    /**
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscramble1($argc, array $argv)
    {
        echo preg_replace(
            '/([a-z])([^a-z]*)([a-z])/', '$3$2$1',
            preg_replace(
                '/([A-Z])([^A-Z]*)([A-Z])/', '$3$2$1',
                $argv[1]
            )
        );
    }

    /**
     * The golfed version of unscramble1()
     *
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscrmbl1($argc, array $argv)
    {
        $f=preg_replace;echo$f("/([a-z])([^a-z]*)([a-z])/",$r="$3$2$1",$f("/([A-Z])([^A-Z]*)([A-Z])/",$r,$argv[1]));
    }

    /**
     * This function works only on PHP 7 and newer. It doesn't compile on PHP 5
     *
     * @param int   $argc
     * @param array $argv
     */
    protected function unscrmbl1php7($argc, array $argv)
    {
        // The eval() is here to let PHP 5.6 compile the function. On PHP 7 there is no need for eval()
        eval('              // This line is not needed on PHP 7
echo($f=preg_replace)("/([a-z])([^a-z]*)([a-z])/",$r="$3$2$1",$f("/([A-Z])([^A-Z]*)([A-Z])/",$r,$argv[1]));
        ');                // This line is not needed on PHP 7
    }



    /**
     * Version #2, after a suggestion on the initial answer (preg_replace can use arrays)
     * http://codegolf.stackexchange.com/questions/109117/unscramble-those-case-very-sensitive-strings/109161?noredirect=1#comment265979_109161
     *
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscramble2($argc, array $argv)
    {
        echo preg_replace([
                '/([a-z])([^a-z]*)([a-z])/',
                '/([A-Z])([^A-Z]*)([A-Z])/',
            ],
            '$3$2$1',
            $argv[1]
        );
    }

    /**
     * The golfed version of unscramble2()
     *
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscrmbl2($argc, array $argv)
    {
        echo preg_replace(["/([a-z])([^a-z]*)([a-z])/","/([A-Z])([^A-Z]*)([A-Z])/"],"$3$2$1",$argv[1]);
    }



    /**
     * Version #3, squeeze several bytes more
     *
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscramble3($argc, array $argv)
    {
        echo preg_replace([
                $a='/([a-z])([^a-z]*)([a-z])/',
                strtoupper($a),
            ],
            '$3$2$1',
            $argv[1]
        );
    }

    /**
     * The golfed version of unscramble3()
     *
     * @param int      $argc
     * @param string[] $argv
     */
    protected function unscrmbl3($argc, array $argv)
    {
        echo preg_replace([$a="/([a-z])([^a-z]*)([a-z])/",strtoupper($a)],"$3$2$1",$argv[1]);
    }
}


// Instantiate the problem and run it
exit((new UnscrambleThoseStrings($argc, $argv))->run());


// This is the end of file; no closing PHP tag
