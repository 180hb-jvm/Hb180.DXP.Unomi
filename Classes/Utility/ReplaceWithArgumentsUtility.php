<?php namespace Hb180\DXP\Unomi\Utility;

use Neos\Utility\Arrays;

class ReplaceWithArgumentsUtility{

    /**
     * @param array|string $content
     * @param array $arguments
     * @return array|mixed|string|string[]|null
     */
    static function build($content, $arguments){
        if( is_array($content) ){
            return self::array($content, $arguments);
        }else{
            return self::text($content, $arguments);
        }
    }

    static function array($array, $arguments){
        if( !$array ){
            return [];
        }
        array_walk_recursive($array, function(&$value, $key) use($arguments){
            if( !is_array($value) && is_string($value)){
                $value = self::text($value, $arguments);
            }
        });
        return $array;
    }

    static function text($string, $arguments){
        $json = false;
        $string = preg_replace_callback(
            '|{{([^}]*)}}|',
            function ($matches) use($arguments, &$json) {
                $value = Arrays::getValueByPath($arguments, $matches[1]);
                if( is_array($value) ){
                    $json = true;
                    $value = json_encode($value);
                }
                return $value??$matches[0];
            },
            $string
        );
        if( $json ) {
            $string = json_decode($string, 1);
        }
        return $string;
    }
}
