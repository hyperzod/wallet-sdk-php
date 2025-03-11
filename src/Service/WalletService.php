<?php

namespace Hyperzod\WalletSdkPhp\Service;

use Hyperzod\WalletSdkPhp\Enums\HttpMethodEnum;

class WalletService extends AbstractService
{
   /**
    * Fetch Wallet
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function fetch(array $params)
   {
      return $this->request(HttpMethodEnum::GET, '/wallet/fetch', $params);
   }

   /**
    * Deduct Wallet
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function deduct(array $params)
   {
      return $this->request(HttpMethodEnum::POST, '/wallet/deduct', $params);
   }

   /**
    * Get Wallet Setting
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function settings(array $params)
   {
      return $this->request(HttpMethodEnum::GET, '/wallet/settings', $params);
   }
}
