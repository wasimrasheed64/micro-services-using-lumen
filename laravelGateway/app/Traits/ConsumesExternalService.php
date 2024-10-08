<?php

namespace  App\Traits;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait ConsumesExternalService
{

    /**
     * @throws GuzzleException
     */
    public function performRequest($method, $url, $payload = [], $headers = []): string
    {

        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if(isset($this->secret)){
            $headers['Authorization'] = $this->hashedSalt;
        }

        $response = $client->request($method, $url, [
            'headers' => $headers,
            'form_params' => $payload,
        ]);

        return $response->getBody()->getContents();
    }
}
