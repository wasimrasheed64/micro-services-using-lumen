<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Contracts\ControllerInterface;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller implements ControllerInterface
{
    use ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private readonly Book $model)
    {}

    //

    public function index(){
        $records = $this->model->paginate(50);
        return $this->successDataResponse($records);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $record = $this->model::findOrFail($id);
        return $this->successDataResponse($record);
    }

    /**
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ]);
        try {
            $this->model::create($request->only('title', 'description', 'price', 'author_id'));
            return $this->successMessageResponse('Book created successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    /**
     * @return mixed
     * @throws ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ]);
        try {
            $record = $this->model::findOrFail($id);
            $record->update($request->only('name','gender','country'));
            return $this->successMessageResponse('Book updated successfully',Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            return $this->errorResponse([$exception->getMessage()]);
        }
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        $record = $this->model::findOrFail($id);
        $record->delete();
        return $this->successMessageResponse('Book deleted');

    }
}
