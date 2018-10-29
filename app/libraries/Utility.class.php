<?php

/**
 * Contains useful functionalities.
 */

class Utility {
    
    /**
     * splitAssocArr - Extracts values of an associative array and makes a new array from them. 
     * 
     * @param array $arr - Original array.
     * @param array $keys - Keys of original array for the values to extract.
     * @return array - Return array contains original array without extracted values 
     *                 and the new array with those values
     */
    
    public static function splitAssocArr($arr, $keys) {
        $arr2 = [];
        foreach ($keys as $k) {
            $arr2[$k] = $arr[$k];
            unset($arr[$k]);
        }
        
        $res = array($arr, $arr2);
        return $res;
    }
    
    /**
     * 
     * @param type $array
     * @return boolean
     */
    
    public static function isArrayOfEmptyValues($array) {
        $empty = true;
        foreach ($array as $value) {
            if ($value) {
                $empty = false;
                break;
            }
        }
        return $empty;
    }

    /**
     * 
     * @param type $array
     * @return type
     */
    
    public static function unsetEmptyArrayVals(&$array) {
        foreach ($array as $key => $value) {
            if (!$value) {
                unset($array[$key]);
            }
        }
        return $array;
    }
}