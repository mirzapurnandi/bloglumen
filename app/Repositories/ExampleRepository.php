<?php

namespace App\Repositories;

use App\Traits\ApiResponser;
use App\Interfaces\ExampleInterface;
use Illuminate\Http\Request;

class ExampleRepository implements ExampleInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getData()
    {
        //
    }

    public function insertData(Request $request)
    {
        //
    }

    public function updateData(Request $request, $id)
    {
        //
    }

    public function deleteData(Request $request)
    {
        //
    }
}
