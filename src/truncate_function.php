<?php
    function truncate($text, $length) {
        if(strlen($text) <= $length) {
            return $text . "(...)";
        }
        else {
            return substr($text, 0, $length) . "(...)";
        }
    }