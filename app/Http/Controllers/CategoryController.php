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
        return response()->json([
            'status' => true,
            'message' => 'All category',
            'result' => $category
        ], 200);
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

            return response()->json([
                'status' => true,
                'message' => 'success add category',
                'result' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed',
                'result' => $e
            ], 409);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        try {
            $category = Category::find($id);

            if (!$category) return response()->json([
                'status' => false,
                'message' => 'Data not Found...',
                'result' => null
            ], 404);

            $category->name = $request->name;
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'success edit category',
                'result' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed',
                'result' => $e
            ], 409);
        }
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->id);

        if (!$category) return response()->json([
            'status' => false,
            'message' => 'Data not Found...',
            'result' => null
        ], 404);

        try {
            $category->delete();
            return response()->json([
                'status' => true,
                'message' => 'Delete category successfully',
                'result' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'failed',
                'result' => $e
            ], 409);
        }
    }
}
