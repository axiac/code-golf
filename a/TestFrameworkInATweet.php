<?php
/**
 * A test framework in a tweet.
 *
 * Usage:
 *    require_once 'TestFrameworkInATweet.php';
 *    it("should sum two numbers", 1+1==2);
 *    it("should display an X for a failing test", 1+1==3);
 *    done();
 *
 * @author Mathias Verraes <mathias@verraes.net>
 * @link https://gist.github.com/mathiasverraes/9046427
 */


function it($m,$p){echo ($p?'✔︎':'✘')." It $m\n"; if(!$p){$GLOBALS['f']=1;}}function done(){if(@$GLOBALS['f'])die(1);}


// This is the end of file; no closing PHP tag
