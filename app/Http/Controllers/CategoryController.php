<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function index()
    {
        $category = Category::select('id', 'name', 'slug')->get();
        return $this->successResponse($category, 'All Category');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:categories,name'
        ]);

        try {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->save();

            return $this->successResponse($category, 'Add Category Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        try {
            $category = Category::find($id);

            if (!$category) return $this->errorResponse('Data not Found...', 404);

            $category->name = $request->name;
            $category->save();

            return $this->successResponse($category, 'Successfully Edit Category');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) return $this->errorResponse('Data not Found...', 404);

        try {
            $category->delete();
            return $this->successResponse($category, 'Delete Category Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }
}
