<?php

namespace App\Helpers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class AzureHelper
{
    private $root = 'https://login.microsoftonline.com';
    private $url;

    private $client;

    public function __construct()
    {
        $this->client = new HttpClient([
            'base_uri' => $this->root,
        ]);

        $this->url  = '/' . config('services.graph.tenant') . '/oauth2/v2.0/token';
    }

    public function login($request)
    {
        try {
            $payload = $request->only('code', 'session_state');

            if ($request->has('session_state')) {
                $payload['state'] = $request->session_state;
            }

            $payload['scope'] = implode('%20', config('services.graph.scopes'));
            $payload['client_id'] = config('services.graph.client_id');
            $payload['grant_type'] = 'authorization_code';
            $payload['redirect_uri'] = config('services.graph.redirect');
            $payload['client_secret'] = config('services.graph.client_secret');

            $response = $this->client->request('POST', $this->url, [
                'form_params' => $payload
            ]);

            $result = json_decode($response->getBody()->getContents());
        } catch (BadResponseException $e) {
            \Log::info('[AzureHelper] BadResponseException:');
            return $e;
        } catch (ClientException $e) {
            \Log::error('[AzureHelper] ClientException:');
            return $e;
        } catch (RequestException $e) {
            \Log::error('[AzureHelper] RequestException');
            return $e;
        }

        return $result;
    }
}
