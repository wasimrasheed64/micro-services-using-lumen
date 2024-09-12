<?php

namespace App\Services;
use App\Traits\ConsumesExternalService;
use GuzzleHttp\Exception\GuzzleException;



class AuthorService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the books service
     * @var string
     */
    public  $baseUri;

    public function __construct()
    {
        $this->baseUri = config('app.authors.base_uri');
    }

    /**
     * @throws GuzzleException
     */
    public function obtainAuthors(): string
    {
        return $this->performRequest('GET', '/authors');
    }

    /**
     * @throws GuzzleException
     */
    public function createAuthor($data): string
    {
        return $this->performRequest('POST', '/authors', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function obtainAuthor($id): string
    {
        return $this->performRequest('GET', "/authors/{$id}");
    }

    /**
     * @throws GuzzleException
     */
    public function editAuthor($id, $data): string
    {
        return $this->performRequest('Patch', "/authors/{$id}", $data);
    }

    /**
     * @throws GuzzleException
     */
    public function deleteAuthor($id): string
    {
        return $this->performRequest('DELETE', "/authors/{$id}");
    }
}
