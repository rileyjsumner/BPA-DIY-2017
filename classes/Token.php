<?php
Class Token {
    
    public static function generate() {
        return Verify::put(Check::get('session/token_name'), md5(uniqid()));
    }
    
    public static function check($token) {
        $token_name = Check::get('session/token_name');
        
        if(Verify::exists($token_name) && $token === Verify::get($token_name)){
            return true;
        }
        return false;
    }
}