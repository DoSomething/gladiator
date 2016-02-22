<?php

namespace Gladiator\Services;

use GuzzleHttp\Client;

class RestApiClient
{
    protected $client;

    public function __construct()
    {
      $base_uri = 'https://northstar.dosomething.org/v1/';

      $client = new Client([
        'base_uri' => $base_uri,
        'timeout' => 2.0,
        'headers' => [
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
        ],
      ]);

      $this->client = $client;
    }
}
