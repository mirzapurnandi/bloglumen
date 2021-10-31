<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface TagInterface
{
    public function getData();

    public function insertData(Request $request);

    public function updateData(Request $request, $id);

    public function deleteData(Request $request);
}
