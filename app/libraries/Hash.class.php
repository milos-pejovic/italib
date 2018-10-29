<?php

/**
 * Used for encoding data.
 * This class is used in models for encoding passwords before sending
 * them to database.
 */

class Hash {

    /**
     * create - Encodes a string.
     * 
     * @param string $alg - Algorhythm to use for encoding.
     * @param string $data - String to encode.
     * @param constant $salt - String to be added to the string which is being encoded.
     *                         This makes it more difficult/impossible for the encoded string to be decoded.
     * @return string - Encoded string.
     */
    
    public static function create($alg, $data, $salt) {
        $context = hash_init($alg, HASH_HMAC, $salt);
        hash_update($context, $data);
        return hash_final($context);
    }
}