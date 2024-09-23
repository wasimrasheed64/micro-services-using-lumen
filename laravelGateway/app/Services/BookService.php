<?php

namespace App\Services;
use App\Traits\ConsumesExternalService;
use GuzzleHttp\Exception\GuzzleException;


class BookService
{
    use ConsumesExternalService;

    /**
     * The base uri to consume the books service
     * @var string
     */
    public $baseUri;
    public $secret;
    public $salt = "Alpha";
    public  $hashedSalt ;

    public function __construct()
    {
        $this->baseUri = config('app.books.base_uri');
        $this->secret = config('app.books.secret');
        $this->hashedSalt = hash_hmac('sha256', $this->salt, $this->secret);
    }
    /**
     * @throws GuzzleException
     */
    public function obtainBooks(): string
    {
        return $this->performRequest('GET', '/books');
    }

    /**
     * @throws GuzzleException
     */
    public function createBook($data): string
    {
        return $this->performRequest('POST', '/books', $data);
    }

    /**
     * @throws GuzzleException
     */
    public function obtainBook($id): string
    {
        return $this->performRequest('GET', "/books/{$id}");
    }

    /**
     * @throws GuzzleException
     */
    public function editBook($id, $data): string
    {
        return $this->performRequest('Patch', "/books/{$id}", $data);
    }

    /**
     * @throws GuzzleException
     */
    public function deleteBook($id): string
    {
        return $this->performRequest('DELETE', "/books/{$id}");
    }
}
