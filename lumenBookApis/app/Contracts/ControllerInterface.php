<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ControllerInterface
{
    public function index();
    public function show($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
