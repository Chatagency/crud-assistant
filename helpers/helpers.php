<?php

declare(strict_types=1);

if (!function_exists('dumpIt')) {
    function dumpIt($value)
    {
        print_r($value);
        exit;
    }
}
