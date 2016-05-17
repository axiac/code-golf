<?php
/**
 * Code Golf: Is it a pangram?
 *
 * @link http://codegolf.stackexchange.com/questions/66197/is-it-a-pangram
 */


// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';


/**
 * Class IsItAPangram - the problem to solve
 */
class IsItAPangram extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // The public interface
    //
    public function runTests()
    {
        $this->testBothMethods('', FALSE);
        $this->testBothMethods('123abcdefghijklm NOPQRSTUVWXYZ321', TRUE);
        $this->testBothMethods('AbCdEfGhIjKlMnOpQrStUvWxYz', TRUE);
        $this->testBothMethods("ACEGIKMOQSUWY\nBDFHJLNPRTVXZ", TRUE);
        $this->testBothMethods('public static void main(String[] args)', FALSE);
        $this->testBothMethods('The quick brown fox jumped over the lazy dogs. BOING BOING BOING', TRUE);
    }


    public function getTheGolfedCode()
    {
        return $this->getFunctionBody('chkPngrm', __CLASS__);
    }


    public function runTheGolfedCode($argc, array $argv)
    {
        $this->chkPngrm($argc, $argv);
    }



    /////////////////////////////////////////////////////////////////////////
    // Implementation
    //
    protected function testBothMethods($input, $expected)
    {
        // The clean code
        $actual = $this->checkIfPangram($input);
        it(sprintf("thinks '%s' %s a pangram (clear  code).", $input, $actual ? 'is' : 'is not'), $actual == $expected);

        // The golfed code
        $actual = $this->getFunctionOutput(function() use($input) { $this->chkPngrm(2, array(__FILE__, $input)); });
        it(sprintf("thinks '%s' %s a pangram (golfed code).", $input, $actual ? 'is' : 'is not'), $actual == $expected);
    }


    protected function checkIfPangram($input)
    {
        return array_diff(range('a', 'z'), array_keys(array_count_values(str_split(strtolower($input))))) == [];
    }


    protected function chkPngrm($argc, array $argv)
    {
        echo+!array_diff(range(a,z),array_keys(array_count_values(str_split(strtolower($argv[1])))));
    }
}


// Instantiate the problem and run it
exit((new IsItAPangram($argc, $argv))->run());


// This is the end of file; no closing PHP tag
