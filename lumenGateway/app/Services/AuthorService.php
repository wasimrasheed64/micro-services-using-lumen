<?php

namespace App\Services;
use Traits\ConsumesExternalService;

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
        $this->baseUri = config('services.author.base_uri');
    }
}
