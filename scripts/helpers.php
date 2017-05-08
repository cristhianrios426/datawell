<?php 
if (! function_exists('dump')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dump(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}