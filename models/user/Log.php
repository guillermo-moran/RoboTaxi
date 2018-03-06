<?php

/**
 * Created by IntelliJ IDEA.
 * Staff: tchallst
 * Date: 05-May-17
 * Time: 9:11 PM
 */
class Log
{
    public static function info($errorMessage, $line = 0)
    {
        $trace = debug_backtrace();
        $caller = $trace[1];
        $caller = $caller['function'];
        $caller .= isset($caller['class']) ? ' in ' . $caller['class'] : '';
        //$caller['function'] holds function, $caller['class'] might hold class

        $now = date('Y-m-d H:i:s');
        file_put_contents(__dir__ . "/log/info.log", "NOTICE($now): $errorMessage FROM $caller!;\n", FILE_APPEND);
    }

    public static function warn($errorMessage, $line = 0)
    {
        $trace = debug_backtrace();
        $caller = $trace[1];
        $caller = $caller['function'];
        $caller .= isset($caller['class']) ? ' in ' . $caller['class'] : '';
        //$caller['function'] holds function, $caller['class'] might hold class

        $now = date('Y-m-d H:i:s');
        file_put_contents(__dir__ . "/log/warn.log", "WARNING($now): $errorMessage FROM $caller!;\n", FILE_APPEND);
    }

    public static function error($errorMessage, $line = 0)
    {
        $trace = debug_backtrace();
        $caller = $trace[1];
        $caller = $caller['function'];
        $caller .= isset($caller['class']) ? ' in ' . $caller['class'] : '';
        //$caller['function'] holds function, $caller['class'] might hold class

        $now = date('Y-m-d H:i:s');
        file_put_contents(__dir__ . "/log/error.log", "ERROR($now): $errorMessage FROM $caller!;\n", FILE_APPEND);
    }

    public static function fatal($errorMessage, $line = 0)
    {
        $trace = debug_backtrace();
        $caller = $trace[1];
        $caller = $caller['function'];
        $caller .= isset($caller['class']) ? ' in ' . $caller['class'] : '';
        //$caller['function'] holds function, $caller['class'] might hold class

        $now = date('Y-m-d H:i:s');
        file_put_contents(__dir__ . "/log/fatal.log", "CRITICAL($now): $errorMessage FROM $caller!;\n", FILE_APPEND);
    }
}