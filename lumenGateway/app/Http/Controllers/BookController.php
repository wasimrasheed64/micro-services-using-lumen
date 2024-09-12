<?php

namespace App\Http\Controllers;

use app\Services\AuthorService;
use app\Services\BookService;
use Illuminate\Http\Request;
use Traits\ApiResponse;

class BookController extends Controller
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly  BookService $service,
    private readonly  AuthorService $authorService)
    {}

    //

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->validResponse($this->service->obtainBooks());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->validResponse($this->service->obtainBook($id));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->get('author_id'));
        return $this->validResponse($this->service->createBook($request->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->validResponse($this->service->editBook($id, $request->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->validResponse($this->service->deleteBook($id));
    }
}
