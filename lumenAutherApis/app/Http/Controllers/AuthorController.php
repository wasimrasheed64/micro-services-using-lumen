<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Contracts\ControllerInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller implements ControllerInterface
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly Author $model)
    {
        //
    }

    public function index(){
        $authors = $this->model->paginate(50);
        return $this->successDataResponse($authors);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $author = $this->model::findOrFail($id);
        return $this->successDataResponse($author);
    }

    /**
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'gender' => 'required|in:male,females',
            'country' => 'required|max:120',
        ]);
        try {
            $this->model::create($request->only('name','gender','country'));
            return $this->successMessageResponse('Author created successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'gender' => 'required|in:male,females',
            'country' => 'required|max:120',
        ]);
        try {
            $author = $this->model::findOrFail($id);
            $author->update($request->only('name','gender','country'));
            return $this->successMessageResponse('Author updated successfully',Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
       $author = $this->model::findOrFail($id);
       $author->delete();
       return $this->successMessageResponse('Author deleted');

    }
}
