<?php

namespace Hyperzod\WalletSdkPhp\Client;

/**
 * Interface for a Wallet client.
 */
interface WalletClientInterface extends BaseWalletClientInterface
{
   /**
    * Sends a request to Wallet's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */
   public function request($method, $path, $params);
}
