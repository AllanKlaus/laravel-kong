<?php

namespace DouglasDC3\Kong\Http;

use GuzzleHttp\Client;

class HttpClient
{
    /**
     * Request options.
     *
     * @var array
     */
    private $options;

    /**
     * HttpClient constructor.
     *
     * @param string $baseUrl Protocol, Port and base path.
     * @param array  $options Guzzle options array
     */
    public function __construct(string $baseUrl, array $options = [])
    {
        $this->options = $options;

        $this->client = new Client(array_merge($options, [
            'base_uri' => $baseUrl
        ]));
    }

    /**
     * Get resource.
     *
     * @param string $url The resource path.
     * @param array  $query Optional query params.
     * @param array  $headers Optional headers.
     *
     * @return array Json response.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, $query = [], $headers = [])
    {
        return $this->request('GET', $url, $query, [], $headers);
    }

    /**
     * Post Resource.
     *
     * @param string $url The resource path.
     * @param array  $body Post parameters.
     * @param array  $query Optional query params.
     * @param array  $headers Optional headers.
     *
     * @return array Json response.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, $body = [], $query = [], $headers = [])
    {
        return $this->request('POST', $url, $query, $body, $headers);
    }

    /**
     * Put resource.
     *
     * @param string $url The resource path.
     * @param array  $body Post parameters.
     * @param array  $query Optional query params.
     * @param array  $headers Optional headers.
     *
     * @return array Json response.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($url, $body = [], $query = [], $headers = [])
    {
        return $this->request('PUT', $url, $query, $body, $headers);
    }

    /**
     * Patch resource.
     *
     * @param string $url The resource path.
     * @param array  $body Post parameters.
     * @param array  $query Optional query params.
     * @param array  $headers Optional headers.
     *
     * @return array Json response.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch($url, $body = [], $query = [], $headers = [])
    {
        return $this->request('PATCH', $url, $query, $body, $headers);
    }

    /**
     * Delete resource.
     *
     * @param string $url The resource path.
     * @param array  $body Post parameters.
     * @param array  $query Optional query params.
     * @param array  $headers Optional headers.
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($url, $body = [], $query = [], $headers = [])
    {
        return $this->request('DELETE', $url, $query, $body, $headers, false);
    }

    private function request($verb, $url, $query = [], $body = [], $headers = [], $json = true)
    {
        if (! empty($body)) {
            $headers['Content-Type'] = 'application/json';
        }

        $response = $this->client->request($verb, $url, [
            'query' => array_merge($this->options['query'] ?? [], $query),
            'headers' => array_merge($this->options['headers'] ?? [], $headers),
            'json' => $body
        ]);

        return $json ? json_decode($response->getBody()->getContents(), true) : $response;
    }
}
