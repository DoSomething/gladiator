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
        // delete request
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
    public function post($path, $body = [])
    {
        $response = $this->send('POST', $path, [
            'body' => $this->makeJson($body),
        ]);

        return is_null($response) ? false : $this->getJson($response);
    }

    /**
     * @return [type]
     */
    public function put()
    {
        // put request
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
     * @param  [type]
     * @return [type]
     */
    public function makeJson($data)
    {
        return json_encode($data);
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
                // fill out error bag for showing errors to user
                return null;
            }

            if ($error->getCode() === 401) {
                // fill out error bag for showing errors to user
                return null;
            }
        }
    }
}
