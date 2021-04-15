<?php
namespace Hb180\DXP\Unomi\Service;

use Neos\Eel\Utility as EelUtility;
use Neos\Flow\Annotations as Flow;
use Ramsey\Uuid\Uuid;

/**
 * @Flow\Scope("singleton")
 */
class UnomiService {

    public function generateUUID()
    {
        $date = new \DateTime('NOW');
        $time = microtime();
        $unomiSession = str_replace(' ', '', $time . $date->getTimezone()->getName());
        $sessionId = Uuid::uuid5(Uuid::NAMESPACE_DNS, $unomiSession)->toString();
        return $sessionId;
    }

}
