<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

interface PostInterface
{

    public function getData();

    public function insertData(Request $request);

    public function updateData(Request $request, $id);

    public function deleteData(Request $request);

    public function checkData();
}
