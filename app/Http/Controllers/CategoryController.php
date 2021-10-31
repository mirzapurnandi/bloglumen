<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
        //$this->middleware('auth:api');
    }

    public function index()
    {
        return $this->category->getData();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:categories,name'
        ]);

        return $this->category->insertData($request);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->category->updateData($request, $id);
    }

    public function destroy(Request $request)
    {
        return $this->category->deleteData($request);
    }
}
