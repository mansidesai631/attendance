<?php

if(!function_exists('get_sort_char')) {
    function get_sort_char($string){
        $str_array = explode(" ", $string);
        return strtoupper(substr(@$str_array[0], 0,1).substr(@$str_array[1], 0,1));
    }
}

?>