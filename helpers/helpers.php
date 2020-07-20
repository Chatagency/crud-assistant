<?php

declare(strict_types=1);

if (!function_exists('dd')) {
    function dd($value)
    {
        print_r($value);
        exit;
    }
}
