<?php

namespace Hb180\DXP\Unomi\Model\Domain;

use Dropsolid\UnomiSdkPhp\Http\Guzzle\GuzzleApiClientFactory;
use Neos\Flow\Annotations as Flow;
use Neos\Utility\Arrays;

/**
 * @Flow\Scope("singleton")
 */
class Client {

    /**
     * @var array
     * @Flow\InjectConfiguration(path="client")
     */
    protected $configuration;

    public function getClient() {

        return GuzzleApiClientFactory::createBasicAuth(
            [
                'timeout' => Arrays::getValueByPath($this->configuration, 'timeout'),
                'base_uri' => Arrays::getValueByPath($this->configuration, 'baseUri'),
                'auth' => [
                    Arrays::getValueByPath($this->configuration, 'auth.user'),
                    Arrays::getValueByPath($this->configuration, 'auth.password')
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]
        );

    }
}
