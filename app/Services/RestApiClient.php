<?php

namespace Gladiator\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RestApiClient
{
    protected $client;

    /**
     * RestApiClient constructor.
     *
     * @param string  $base_uri
     * @param array  $headers
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
     * Send a DELETE request to the given path URI.
     *
     * @param  string  $path
     * @return bool
     */
    public function delete($path)
    {
        // delete request
        // return bool
    }

    /**
     * Send a GET request to the given path URI.
     *
     * @param  string  $path
     * @param  array  $query
     * @return object|null
     */
    public function get($path, $query = [])
    {
        $response = $this->send('GET', $path, [
            'query' => $query,
        ]);

        return is_null($response) ? null : $this->getJson($response);
    }

    /**
     * Send a POST request to the given path URI.
     *
     * @param  string  $path
     * @param  array  $body
     * @return object|false
     */
    public function post($path, $body = [])
    {
        $response = $this->send('POST', $path, [
            'body' => $this->makeJson($body),
        ]);

        return is_null($response) ? false : $this->getJson($response);
    }

    /**
     * Send a PUT request to the given path URI.
     *
     * @param  string  $path
     * @param  array  $body
     * @return object
     */
    public function put($path, $body = [])
    {
        // put request
        // return object
    }

    /**
     * Get JSON object from the response.
     *
     * @param  object  $response
     * @param  bool  $asArray
     * @return object
     */
    public function getJson($response, $asArray = false)
    {
        return json_decode($response->getBody(), $asArray)->data;
    }

    /**
     * Make JSON object string from the supplied data.
     *
     * @param  object  $data
     * @return string
     */
    public function makeJson($data)
    {
        return json_encode($data);
    }

    /**
     * Send an API request and parse any returned errors or status codes.
     *
     * @param  string  $method
     * @param  string  $path
     * @param  array  $options
     * @return Response|null
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
