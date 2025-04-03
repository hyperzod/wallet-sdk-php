<?php

namespace Hyperzod\WalletSdkPhp\Client;

use Exception;
use GuzzleHttp\Client;
use Hyperzod\WalletSdkPhp\Enums\EnvironmentEnum;
use Hyperzod\WalletSdkPhp\Exception\InvalidArgumentException;

class BaseWalletClient implements WalletClientInterface
{
   /** @var string default base URL for Wallet's API */
   const DEV_API_BASE = 'https://wallet.apps.hyperzod.dev/api/v1';

   const PRODUCTION_API_BASE = 'https://wallet.apps.hyperzod.com/api/v1';

   /** @var array<string, mixed> */
   private $config;

   /**
    * Initializes a new instance of the {@link BaseWalletClient} class.
    *
    * The constructor takes two arguments.
    * @param string $api_key the API key of the client
    * @param string $env the environment
    */

   public function __construct($api_key, $env)
   {
      $config = $this->validateConfig(array(
         "api_key" => $api_key,
         "env" => $env
      ));

      //Set the base URL
      if ($config['env'] == EnvironmentEnum::DEV) {
         $config['api_base'] = self::DEV_API_BASE;
      }

      if ($config['env'] == EnvironmentEnum::PRODUCTION) {
         $config['api_base'] = self::PRODUCTION_API_BASE;
      }

      $this->config = $config;
   }

   /**
    * Gets the API key used by the client to send requests.
    *
    * @return null|string the API key used by the client to send requests
    */
   public function getApiKey()
   {
      return $this->config['api_key'];
   }

   /**
    * Gets the base URL for Wallet's API.
    *
    * @return string the base URL for Wallet's API
    */
   public function getApiBase()
   {
      return $this->config['api_base'];
   }

   /**
    * Gets the env.
    *
    * @return string the env
    */
   public function getEnv()
   {
      return $this->config['env'];
   }

   /**
    * Sends a request to Wallet's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */

   public function request($method, $path, $params)
   {
      if (!isset($params['organization_slug']) || empty($params['organization_slug'])) {
         throw new Exception("Organization slug is required to access hyperzod's api's.");
      }

      if (!isset($params['tenant_id']) || empty($params['tenant_id'])) {
         throw new Exception("Tenant Id is required to access hyperzod's api's.");
      }

      $client = new Client([
         'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-API-KEY' => $this->getApiKey()
         ]
      ]);

      $path = '/' . $params['organization_slug'] . '/' . $params['tenant_id'] . $path;

      $api = $this->getApiBase() . $path;

      $response = $client->request($method, $api, [
         'http_errors' => true,
         'body' => json_encode($params)
      ]);


      return $this->validateResponse($response);
   }

   /**
    * @param array<string, mixed> $config
    *
    * @throws InvalidArgumentException
    */
   private function validateConfig($config)
   {
      // api_key
      if (!isset($config['api_key'])) {
         throw new InvalidArgumentException('api_key field is required');
      }

      if (!is_string($config['api_key'])) {
         throw new InvalidArgumentException('api_key must be a string');
      }

      if ('' === $config['api_key']) {
         throw new InvalidArgumentException('api_key cannot be an empty string');
      }

      if (preg_match('/\s/', $config['api_key'])) {
         throw new InvalidArgumentException('api_key cannot contain whitespace');
      }

      // env
      $all_envs = array_values((new EnvironmentEnum())->getConstants());

      if (!isset($config['env'])) {
         throw new InvalidArgumentException('env field is required');
      }

      if (!is_string($config['env'])) {
         throw new InvalidArgumentException('env must be a string');
      }

      if ('' === $config['env']) {
         throw new InvalidArgumentException('env cannot be an empty string');
      }

      if (!in_array($config['env'], $all_envs)) {
         throw new InvalidArgumentException('Invalid env');
      }

      return [
         "api_key" => $config['api_key'],
         "env" => $config['env'],
      ];
   }

   private function validateResponse($response)
   {
      $status_code = $response->getStatusCode();

      if ($status_code >= 200 && $status_code < 300) {
         $response = json_decode($response->getBody(), true);

         if (isset($response["success"]) && boolval($response["success"]) === true) {
            if (isset($response["data"])) {
               return $response["data"];
            }
            throw new Exception("Data node not set in server response");
         }
         if (isset($response["success"]) && boolval($response["success"]) === false) {
            $message = null;
            if (isset($response["message"])) {
               $message = $response["message"];
            }
            if (isset($response["data"])) {
               $message = $message . json_encode($response["data"]);
            }
            throw new Exception($message);
         }
      }

      throw new Exception("Error Processing Response");
   }
}
