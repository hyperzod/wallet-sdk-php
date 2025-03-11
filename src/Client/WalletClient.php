<?php

namespace Hyperzod\WalletSdkPhp\Client;

use Hyperzod\WalletSdkPhp\Service\CoreServiceFactory;

class WalletClient extends BaseWalletClient
{
    /**
     * @var CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
