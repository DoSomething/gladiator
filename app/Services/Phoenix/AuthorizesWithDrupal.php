<?php

namespace Gladiator\Services\Phoenix;

use GuzzleHttp\Cookie\CookieJar;

/**
 * The AuthorizesWithDrupal adds Drupal API auth to a
 * RestApiClient instance.
 *
 * @property \GuzzleHttp\Client $client
 */
trait AuthorizesWithDrupal
{
    /**
     * Run custom tasks before making a request.
     *
     * @see RestApiClient@raw
     */
    protected function runAuthorizesWithDrupalTasks($method, &$path, &$options, &$withAuthorization)
    {
        if ($withAuthorization) {
            $options['cookies'] = $this->getAuthenticationCookie();
            $options['headers']['X-CSRF-Token'] = $this->getAuthenticationToken();
        }
    }

    /**
     * Returns a token for making authenticated requests to the Drupal API.
     *
     * @return array - Cookie & token for authenticated requests
     */
    private function authenticate()
    {
        $authentication = app('cache')->remember('drupal.authentication', 30, function () {
            $response = $this->post('v1/auth/login', [
                'username' => config('services.phoenix.username'),
                'password' => config('services.phoenix.password'),
            ], false);

            $session_name = $response['session_name'];
            $session_value = $response['sessid'];

            return [
                'cookie' => [$session_name => $session_value],
                'token' => $response['token'],
            ];
        });

        return $authentication;
    }

    /**
     * Get the CSRF token for the authenticated API session.
     *
     * @return string - token
     */
    private function getAuthenticationToken()
    {
        return $this->authenticate()['token'];
    }

    /**
     * Get the cookie for the authenticated API session.
     *
     * @return CookieJar
     */
    private function getAuthenticationCookie()
    {
        $cookieDomain = parse_url(config('services.phoenix.uri'))['host'];

        return CookieJar::fromArray($this->authenticate()['cookie'], $cookieDomain);
    }
}
