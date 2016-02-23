<?php

namespace Gladiator\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RestApiClient
{
    protected $client;

    /**
     * @param [type]
     * @param array
     */
    public function __construct($base_uri, $headers = [])
    {
        $headers += [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $client = new Client([
            'base_uri' => $base_uri,
            'timeout' => 2.0,
            'headers' => $headers,
        ]);

        $this->client = $client;
    }

    /**
     * @return [type]
     */
    public function delete()
    {

    }

    /**
     * @param  [type]
     * @param  array
     * @return [type]
     */
    public function get($path, $query = [])
    {
        $response = $this->send('GET', $path, [
            'query' => $query,
        ]);

        return is_null($response) ? null : $this->getJson($response);
    }

    /**
     * @return [type]
     */
    public function post()
    {

    }

    /**
     * @return [type]
     */
    public function put()
    {

    }

    /**
     * @param  [type]
     * @param  boolean
     * @return [type]
     */
    public function getJson($response, $asArray = false)
    {
        return json_decode($response->getBody(), $asArray)->data;
    }

    /**
     * @return [type]
     */
    public function makeJson()
    {
        // Do the thing. Win the points.
    }

    /**
     * @param  [type]
     * @param  [type]
     * @param  array
     * @return [type]
     */
    protected function send($method, $path, $options = []) {
        try {
            return $this->client->request($method, $path, $options);
        } catch (RequestException $error) {
            if ($error->getCode() === 404) {
                return null;
            }
        }
    }
}
