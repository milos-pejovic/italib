<?php

/**
 * This class contains functionality which handles security
 */

class Security {

    /**
     * cleanString - Cleans a string from potentially harmful content.
     * 
     * @param string $str - String to be cleaned.
     * @return string - Cleaned string.
     */
    
    public static function cleanString($str) {
        $str = strip_tags($str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
     // $str = str_replace('-', '&#8211;', $str);
        $str = str_replace('-', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\/', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('!', '', $str);
        $str = trim($str);
        
        return $str;
    }
}