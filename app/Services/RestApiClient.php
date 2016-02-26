<?php

namespace Gladiator\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Validation\ValidationException;

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

        return is_null($response) ? null : $this->getJson($response)->data;
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

        return is_null($response) ? false : $this->getJson($response)->data;
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
        return json_decode($response->getBody(), $asArray);
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
    protected function send($method, $path, $options = [])
    {
        try {
            return $this->client->request($method, $path, $options);
        } catch (RequestException $error) {
            $response = $this->getJson($error->getResponse());

            if ($error->getCode() === 404) {
                $messages = $this->setMessages($response->error);

                // @TODO: maybe abort to 404 page?
                return;
            }

            if ($error->getCode() === 401) {
                $messages = $this->setMessages($response->error);

                throw new ValidationException($messages);
            }

            throw new HttpException(500, 'Northstar returned an error for that request.');
        }
    }

    /**
     * Set any erorr message within a MessageBag.
     *
     * @param object  $error
     */
    protected function setMessages($error)
    {
        // @TODO: may eventually need to handle an array of errors.
        return (new MessageBag)->add($error->code, $error->message);
    }
}
