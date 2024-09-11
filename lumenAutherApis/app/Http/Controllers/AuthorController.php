<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerInterface;
use App\Models\Author;

class AuthorController extends Controller implements ControllerInterface
{
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

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO: Implement show() method.
    }

    /**
     * @return mixed
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     * @return mixed
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
        // TODO: Implement destroy() method.
    }
}
