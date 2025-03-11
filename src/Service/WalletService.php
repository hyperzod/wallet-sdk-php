<?php

namespace Hyperzod\WalletSdkPhp\Service;

use Hyperzod\WalletSdkPhp\Enums\HttpMethodEnum;

class WalletService extends AbstractService
{
   /**
    * List all task on Wallet
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function fetchWallet(array $params)
   {
      return $this->request(HttpMethodEnum::GET, '/task/list', $params);
   }

   /**
    * Create a task on Wallet
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function create(array $params)
   {
      return $this->request(HttpMethodEnum::POST, '/task/create', $params);
   }

   /**
    * Update status of a task on Wallet
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function updateStatus(array $params)
   {
      return $this->request(HttpMethodEnum::POST, '/task/update/status', $params);
   }

   /**
    * Send notification for a task
    *
    * @param array $params
    *
    * @throws \Hyperzod\WalletSdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function sendNotification(array $params)
   {
      return $this->request(HttpMethodEnum::POST, '/task/sendNotification', $params);
   }
}
