<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getData()
    {
        $category = Category::select('id', 'name', 'slug')->get();
        return $this->successResponse($category, 'All Category');
    }

    public function insertData(Request $request)
    {
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

    public function updateData(Request $request, $id)
    {
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

    public function deleteData(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) return $this->errorResponse('Data not Found...', 404);

        try {
            $category->delete();
            return $this->successResponse(null, 'Delete Category Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }
}
