<?php
namespace Hb180\DXP\Unomi\Eel\Helper;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Symfony\Component\Yaml\Yaml;

class YamlHelper implements ProtectedContextAwareInterface
 {
     /**
      * @return array
      */
     public function parse($value){
         $yaml = new Yaml();

//         \Neos\Flow\var_dump($value);
//         \Neos\Flow\var_dump($yaml->parse($value));

         return is_string($value)?$yaml->parse($value):null;
     }

     /**
      * @param string $methodName
      * @return boolean
      */
     public function allowsCallOfMethod($methodName)
     {
         return true;
     }

 }
