<?php
/**
 * A framework to test and output my golfed code.
 */


// Include both
require __DIR__.'/TestFrameworkInATweet.php';
include __DIR__.'/TestFwInATweet-Xeoncross.php';


/**
 * Class ACodeGolfProblem - the base class for a Code-Golf problem.
 *
 * Usage:
 * <code>
 * class SomeProblem extends ACodeGolfProblem
 * {
 *     // required methods
 *     public function runTests() { <!-- write your tests here using the test cases provided in the question --> }
 *     public function getTheGolfedCode() { return parent::getFunctionBody('fnGolfedCode', __CLASS__); }
 *     public function runTheGolfedCode($argc, array $argv) { <!-- call the golfed code method with the command line arguments --> }
 *     // optional method (usually you don't need to implement it)
 *     public function getUsage() { return 'This is how you can run this program (blah, blah, blah).'; }
 * }
 *
 * exit(new SomeProblem($argc, $argv))->run());
 * </code>
 */
abstract class ACodeGolfProblem
{
    /** @var int $argc */
    protected $argc;
    /** @var string[] $argv */
    protected $argv;



    /**
     * @param int   $argc
     * @param array $argv
     */
    public function __construct($argc, array $argv)
    {
        $this->argc = $argc;
        $this->argv = $argv;
    }



    /**
     * The main function. It checks the command line arguments and calls different class behaviours.
     *
     * @return integer the exit code
     */
    public function run()
    {
        // No arguments; display the help
        if ($this->argc == 1) {
            // Show the usage
            echo($this->getUsage());
            echo("\n");
            return 0;
        }

        // Exactly one argument with value 'test'; run the tests
        if ($this->argc == 2 && $this->argv[1] === 'test') {
            echo("Running the tests...\n");
            $result = $this->runTests();
            // Forcibly call die(1) when any of the tests using function it() (file: TestFrameworkInATweet.php) fails
            done();

            // No problem. Continue
            echo("All tests completed successfully.\n");
            return $result;
        }

        // Exactly one argument with value 'source'; display the golfed code source
        if ($this->argc == 2 && $this->argv[1] === 'source') {
            $code = $this->getTheGolfedCode();
            printf("<?php // %d bytes\n", strlen($code));
            echo($code);
            echo("\n");
            return 0;
        }

        // Exactly one argument with value 'help'; display the program's usage
        if ($this->argc == 2 && $this->argv[1] === 'help') {
            echo($this->getUsage());
            return 2;
        }

        // Everything else: run the golfed code with the provided command line
        try {
            return $this->runTheGolfedCode($this->argc, $this->argv);
        } catch (InvalidArgumentException $e) {
            // The code cannot handle the arguments provided in the command line
            // Either their values are invalid or the number of arguments doesn't match
            echo($e->getMessage()."\n");
            echo("\n");
            // Show the help again and exit
            echo($this->getUsage());
            return 3;
        } catch (Exception $e) {
            // Generic exception; this is a problem in the code.
            // There is nothing the user can do
            printf("Unhandled exception '%s' with message: %s.\nCannot continue.\n", get_class($e), $e->getMessage());
            return 4;
        }
    }



    /////////////////////////////////////////////////////////////////////////
    // Methods that shape the behaviour of the class
    //

    /**
     * Run the test suite.
     *
     * @return int the exit code (0 == success, 1 == failure)
     */
    public function runTests()
    {
        throw new LogicException(sprintf("*** You must implement the method %s::%s(), you know?", get_called_class(), __FUNCTION__));
    }



    /**
     * Produce the golfed source code, to be displayed in the Puzzles & Code Golf answer.
     *
     * Use the getFunctionBody() method, providing it the appropriate method name as argument.
     *
     * @return string
     */
    public function getTheGolfedCode()
    {
        throw new LogicException(sprintf("*** You must implement the method %s::%s(), you know?", get_called_class(), __FUNCTION__));
    }



    /**
     * Run the golfed code using the arguments provided in the command line
     *
     * @param int   $argc
     * @param array $argv
     * @return int the exit code, if any
     */
    public function runTheGolfedCode($argc, array $argv)
    {
        throw new LogicException(sprintf("*** You must implement the method %s::%s(), you know?", get_called_class(), __FUNCTION__));
    }



    /**
     * Return the help about command line.
     *
     * The help provided by this default implementation is very generic.
     * The derived classes can re-implement this method and improve the message, if needed.
     *
     * @return string
     */
    public function getUsage()
    {
        // Use debug backtrace to get the name of the main script
        $stack = debug_backtrace(0);
        $main  = array_pop($stack);

        $filename = basename($main['file']);

        // Return the usage
        return <<< E
Usage: $filename [arguments]

Without arguments, the program displays this message and exits.
Arguments:
  test   - run the tests and exit; test both the detailed and the golfed version
           of the code using the test cases provided in the question;
  source - display the source code of the golfed program in the format required
           by the code-golf question; the output can be saved in a .php file and
           executed later or it can be piped directly to another instance
           of PHP to be executed immediately; for example:
               $ php {$filename} source | php -d error_reporting=0 -- [arguments]
  help   - display this message and exit;

With any other argument, the program tries to run the golfed version of the code
using the arguments provided in the command line; if the command line arguments
are not valid (or in the correct number) then the program's behaviour is undefined.

E;
    }



    /////////////////////////////////////////////////////////////////////////
    // Utilities
    //


    /**
     * Run a callable without arguments, capture and return its output.
     *
     * A function with arguments can be used by enclosing the call into a closure
     * then pass the closure as $fnName
     *
     * @param callable $fnName
     * @return string
     */
    protected function getFunctionOutput(callable $fnName)
    {
        ob_start();
        $fnName();

        return ob_get_clean();
    }



    /**
     * Simulate running a command line program. The code is enclosed in a function
     *
     * @param callable $fnName
     * @param int      $argc
     * @param string[] $argv
     * @return string
     */
    protected function getCommandLineOutput(callable $fnName, $argc, array $argv)
    {
        ob_start();
        $fnName($argc, $argv);

        return ob_get_clean();
    }



    /**
     * Get the body of a function by reading it from the source file.
     *
     * This function uses reflection to get the start and end line of the function,
     * reads the lines from disk, strips the function's header and closing parenthesis
     * then trims and returns the function's body. It doesn't strip the comments.
     *
     * @param string      $fnName
     * @param string|null $class  use NULL for global functions
     * @return string
     */
    protected function getFunctionBody($fnName, $class = NULL)
    {
        // Use reflection to find the location of the function in the file and extract its code
        $f = isset($class) ? new ReflectionMethod($class, $fnName): new ReflectionFunction($fnName);
        $text = implode(
            '', array_slice(
            file($f->getFileName()), $f->getStartLine() - 1, $f->getEndLine() - $f->getStartLine() + 1
        )
        );
        // Remove the function header and the curly braces from around the function body
        $text = preg_replace('/^.*function '.$fnName.'\s*\([^)]*\)\s*{/', '', $text);
        $text = preg_replace('/}\s*$/', '', $text);

        // Trim the newlines from around the function body
        return trim($text);
    }
}


// This is the end of file; no closing PHP tag
