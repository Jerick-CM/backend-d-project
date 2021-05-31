<?php

namespace App\Helpers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class GraphHelper
{
    protected $api = 'https://graph.microsoft.com';

    protected $version = 'beta';

    protected $authApi = 'https://login.microsoftonline.com';
    
    protected $token;

    public function run($method, $uri, $data = null, $headers = null)
    {
        try {
            // Check if data is an array
            if (! is_null($data) && ! is_array($data)) {
                throw new \Exception("data must be an array!");
            }

            // Check if headers is an array
            if (! is_null($headers) && ! is_array($headers)) {
                throw new \Exception("headers must be an array!");
            }

            // Create new HTTP client
            $client = new HttpClient([
                'base_uri' => $this->api,
            ]);

            // Prep request options
            $options = [];

            // Append data to options if exists
            if (! is_null($data) && strtoupper($method) === 'GET') {
                $options['query'] = $data;
            } elseif (! is_null($data)) {
                $options['json'] = $data;
            }
            
            // Set authorization header
            if (is_null($headers)) {
                $headers = [
                    'Authorization' => $this->getToken(),
                ];
            } elseif (! array_key_exists('Authorization', $headers) && ! array_key_exists('authorization', $headers)) {
                $headers['Authorization'] = $this->getToken();
            }

            // Append headers to options
            $options['headers'] = $headers;

            // Prepend version to uri
            $uri = $this->buildUrl($uri);
    
            // Send request to api
            $response = $client->request($method, $uri, $options);
        } catch (ClientException $e) {
            return new \Exception($e->getMessage(), $e->getCode(), $e);
        } catch (RequestException $e) {
            return new \Exception($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            return $e;
        }
        
        return $response;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function authenticateApp()
    {
        try {
            $client = new HttpClient([
                'base_uri' => $this->authApi,
            ]);
    
            $tenant = config('services.graph.tenant');
    
            $uri = "/$tenant/oauth2/v2.0/token";
    
            $response = $client->request('POST', $uri, [
                'form_params' => [
                    'tenant' => $tenant,
                    'client_id' => config('services.graph.client_id'),
                    'scope' => 'https://graph.microsoft.com/.default',
                    'client_secret' => config('services.graph.client_secret'),
                    'grant_type' => 'client_credentials',
                ]
            ]);

            $result = json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            return $e;
        }

        return $result->access_token;
    }

    protected function getToken()
    {
        return "Bearer " . $this->token;
    }

    protected function buildUrl($uri)
    {
        return "/{$this->version}/$uri";
    }
}
