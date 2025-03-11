<?php

namespace Hyperzod\WalletSdkPhp\Client;

/**
 * Interface for a Wallet client.
 */
interface BaseWalletClientInterface
{
   /**
    * Gets the API key used by the client to send requests.
    *
    * @return null|string the API key used by the client to send requests
    */
   public function getApiKey();

   /**
    * Gets the base URL for Wallet's API.
    *
    * @return string the base URL for Wallet's API
    */
   public function getApiBase();
}
