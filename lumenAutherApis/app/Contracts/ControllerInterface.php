<?php

namespace App\Contracts;

interface ControllerInterface
{
    public function index();
    public function show($id);
    public function store();
    public function update();
    public function destroy();
}
