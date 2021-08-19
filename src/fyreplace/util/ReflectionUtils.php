<?php

namespace fyreplace\util;

use ReflectionClass;
use ReflectionException;

class ReflectionUtils {

    public static function parseDocComments(string $docComments): array{
        //define the regular expression pattern to use for string matching
        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

        //perform the regular expression on the string provided
        preg_match_all($pattern, $docComments, $matches);

        return $matches;
    }

    public static function hasDocComment(string $commentName, string $comments): bool {
        if(!$comments){
            return false;
        }
        $parsedComments = self::parseDocComments($comments);
        foreach ($parsedComments[0] as $comment){
            if(str_contains($comment, $commentName)){
                return true;
            }
        }
        return false;
    }

    public static function getShortName(string $full_name): string{
        try {
            $reflector = new ReflectionClass($full_name);
        } catch (ReflectionException) {
            return $full_name;
        }
        return $reflector->getShortName();
    }
}