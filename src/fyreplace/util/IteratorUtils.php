<?php

namespace fyreplace\util;

class IteratorUtils {

    public static function contains(\Iterator $iterator, mixed $value): bool{
        foreach($iterator as $val){
            if($val === $value){
                return true;
            }
        }
        return false;
    }

}