<?php
/**
 * A test framework in a tweet.
 *
 * Usage:
 *   test(1+1==2);
 *   test(1+1==3);
 *
 * Requires PHP 5.4 to use the array dereferencing.
 *
 * @author David Pennington <david@xeoncross.com>
 * @link https://gist.github.com/mathiasverraes/9046427#gistcomment-1173992
 */


function test($p){
    $t=debug_backtrace(0)[0];$m=substr(trim(file($t['file'])[$t['line']-1]),5,-2);
    echo "\033[".($p?"32m✔":"31m✘")." $m\033[0m\n";
    if(!$p)register_shutdown_function(function(){die(1);});
}


// This is the end of file; no closing PHP tag
