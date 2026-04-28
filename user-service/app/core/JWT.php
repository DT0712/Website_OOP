<?php

class JWT {

    private static $key = "secret123";

    public static function encode($payload) {
        return base64_encode(json_encode($payload));
    }

    public static function decode($token) {
        return json_decode(base64_decode($token), true);
    }
}