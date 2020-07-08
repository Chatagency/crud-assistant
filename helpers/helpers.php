<?php

if(!function_exists('dd')) {
    function dd($value)
    {
        print_r($value);
        exit;
    }
}