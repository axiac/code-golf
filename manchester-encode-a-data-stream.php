<?php
/**
 * Code Golf: Manchester encode a data stream
 *
 * @link https://codegolf.stackexchange.com/questions/2040/manchester-encode-a-data-stream
 */

// The code-golf framework includes the testing frameworks and handles the command line
require __DIR__.'/a/CodeGolfFramework.php';


/**
 * Class ManchesterEncodeADataStream - the problem at hand
 */
class ManchesterEncodeADataStream extends ACodeGolfProblem
{
    /////////////////////////////////////////////////////////////////////////
    // The public interface
    //
    public function runTests()
    {
        $this->testCase([0x10, 0x02], [0xAA, 0xA9, 0xA6, 0xAA]);
        $this->testCase([0xFF, 0x00, 0xAA, 0x55], [0x55, 0x55, 0xAA, 0xAA, 0x66, 0x66, 0x99, 0x99]);
        $this->testCase([0x12, 0x34, 0x56, 0x78, 0x90], [0xA6, 0xA9, 0x9A, 0xA5, 0x96, 0x99, 0x6A, 0x95, 0xAA, 0x69]);
        $this->testCase([0x01, 0x02, 0x03, 0xF1, 0xF2, 0xF3], [0xA9, 0xAA, 0xA6, 0xAA, 0xA5, 0xAA, 0xA9, 0x55, 0xA6, 0x55, 0xA5, 0x55]);

        // Test the time for 16 KiB of input
        $input  = array_merge(...array_fill(0, 1024, [0x10, 0xFF, 0x00, 0xAA, 0x55, 0x12, 0x34, 0x56, 0x78, 0x90, 0x01, 0x02, 0x03, 0xF1, 0xF2, 0xF3]));
        $output = array_merge(...array_fill(0, 1024, [0xAA, 0xA9, 0x55, 0x55, 0xAA, 0xAA, 0x66, 0x66, 0x99, 0x99, 0xA6, 0xA9, 0x9A, 0xA5, 0x96, 0x99, 0x6A, 0x95, 0xAA, 0x69, 0xA9, 0xAA, 0xA6, 0xAA, 0xA5, 0xAA, 0xA9, 0x55, 0xA6, 0x55, 0xA5, 0x55]));
        printf("Size of input: %d bytes\n", count($input));
        $this->testCase($input, $output);

        // Test the time for 1 Mib of input
        $input  = array_merge(...array_fill(0, 16*4096, [0x10, 0xFF, 0x00, 0xAA, 0x55, 0x12, 0x34, 0x56, 0x78, 0x90, 0x01, 0x02, 0x03, 0xF1, 0xF2, 0xF3]));
        $output = array_merge(...array_fill(0, 16*4096, [0xAA, 0xA9, 0x55, 0x55, 0xAA, 0xAA, 0x66, 0x66, 0x99, 0x99, 0xA6, 0xA9, 0x9A, 0xA5, 0x96, 0x99, 0x6A, 0x95, 0xAA, 0x69, 0xA9, 0xAA, 0xA6, 0xAA, 0xA5, 0xAA, 0xA9, 0x55, 0xA6, 0x55, 0xA5, 0x55]));
        printf("Size of input: %d bytes\n", count($input));
        $this->testCase($input, $output);
    }


    public function getTheGolfedCode()
    {
        // Enclose the code into a function
        return sprintf('function f($i){%s}', parent::getFunctionBody('Mnchstr2', __CLASS__));
    }


    public function runTheGolfedCode($argc, array $argv)
    {
        echo (implode(' ', $this->Mnchstr2(array_slice($argv, 1))))."\n";
    }


    /////////////////////////////////////////////////////////////////////////
    // Test helpers
    //

    /**
     * @param int[]    $input    the string to unscramble
     * @param string[] $expected the expected output (the unscrambled string)
     */
    protected function testCase(array $input, array $expected)
    {
        $ts     = microtime(TRUE);
        $actual = $this->Manchester1($input);
        $time   = microtime(TRUE) - $ts;
        it(sprintf('encodes using the Manchester clear  code #1 (time: %.8f sec)', $time), $actual == $expected);

        $ts     = microtime(TRUE);
        $actual = $this->Mnchstr1($input);
        $time   = microtime(TRUE) - $ts;
        it(sprintf('encodes using the Manchester golfed code #1 (time: %.8f sec)', $time), $actual == $expected);

        $ts     = microtime(TRUE);
        $actual = $this->Manchester2($input);
        $time   = microtime(TRUE) - $ts;
        it(sprintf('encodes using the Manchester clear  code #2 (time: %.8f sec)', $time), $actual == $expected);

        $ts     = microtime(TRUE);
        $actual = $this->Mnchstr2($input);
        $time   = microtime(TRUE) - $ts;
        it(sprintf('encodes using the Manchester golfed code #2 (time: %.8f sec)', $time), $actual == $expected);
    }


    protected function Manchester1(array $input)
    {
        return array_merge(
            ...array_map(
                   function ($number) {
                       return array_reverse(
                           array_map(
                               'bindec',
                               str_split(
                                   str_replace(
                                       ['0', '1', '2'],
                                       ['2', '01', '10'],
                                       str_pad(decbin($number), 8, '0', STR_PAD_LEFT)
                                   ), 8
                               )
                           )
                       );
                   },
                   $input
               )
        );
    }


    protected function Mnchstr1(array $i)
    {
        return array_merge(...array_map(function($number){return array_reverse(array_map(bindec,str_split(str_replace([0,1,2],[2,'01',10],str_pad(decbin($number),8,0,0)),8)));},$i));
    }


    protected function Manchester2(array $input)
    {
        $output = [];
        foreach ($input as $number) {
            $bytes = str_split(
                str_replace(
                    ['0', '1', '2'],
                    ['2', '01', '10'],
                    str_pad(decbin($number), 8, '0', STR_PAD_LEFT)
                ),
                8
            );
            $output[] = bindec($bytes[1]);
            $output[] = bindec($bytes[0]);
        }

        return $output;
    }


    protected function Mnchstr2(array $i)
    {
        foreach($i as$n){$b=str_split(str_replace([0,1,2],[2,'01',10],str_pad(decbin($n),8,0,0)),8);$o[]=bindec($b[1]);$o[]=bindec($b[0]);}return$o;
    }
}


(new ManchesterEncodeADataStream($argc, $argv))->run();


// This is the end of file; no closing PHP tag
