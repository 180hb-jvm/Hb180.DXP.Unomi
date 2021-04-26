<?php namespace Hb180\DXP\Unomi\Eel\Helper;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;

 class TrackingValuesHelper implements ProtectedContextAwareInterface
 {

     /**
      * @param NodeInterface $node
      * @return array
      */
     public function getTags($node) : array
     {
         return array_filter($this->get($node, 'dxpUnomiTags'));

     }

     /**
      * @param NodeInterface $node
      * @return array
      */
     public function getCategories($node) : array
     {
         return array_filter($this->get($node, 'dxpUnomiCategories'));
     }

     /**
      * @param NodeInterface $node
      * @return array
      */
     public function getIntrests($node) : array
     {

         $interests = $this->get($node, 'dxpUnomiInterests', PHP_EOL)??[];

         foreach ( $interests as $interest ) {
             $interest = explode(':', $interest);
             $values[ current($interest) ] =  (int) end($interest);
         }

         return array_filter($values);

     }

     /**
      * @param NodeInterface $node
      * @param string $property
      * @param string $separator
      * @return array
      */
     private function get($node, $property, $separator = ',') : array
     {

         $values = [];

         $disallowParentProperty = $property . 'DisallowParents';

         if ( !$node->getProperty($disallowParentProperty) ) {

             $parents = (new FlowQuery([$node]))->parents()->get();

             /** @var NodeInterface $parent */
             foreach ($parents as $parent) {

                 if ( $parent->getNodeType()->isOfType('Hb180.DXP.Unomi:Mixin.Properties') && !$parent->getProperty($disallowParentProperty)  ) {

                     $items = $parent->getProperty($property);

                     if ( $items ) {
                         $values = array_merge($values, explode($separator, $items)  );
                     }

                     if ( $parent->getProperty($disallowParentProperty) ) {
                         break;
                     }

                 }

             }

             $values = array_reverse($values);

         };

        //  var_dump($node->getProperty($property));
         $values = array_map( 'trim', array_merge( $values, explode($separator, $node->getProperty($property) ) ) );

         return $values;

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
