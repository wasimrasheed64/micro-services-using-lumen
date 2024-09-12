<?php

namespace App\Http\Controllers;


use App\Services\AuthorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly  AuthorService $service)
    {}

    //

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->validResponse($this->service->obtainAuthors());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->validResponse($this->service->obtainAuthor($id));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->validResponse($this->service->createAuthor($request->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->validResponse($this->service->editAuthor($id, $request->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->validResponse($this->service->deleteAuthor($id));
    }
}
