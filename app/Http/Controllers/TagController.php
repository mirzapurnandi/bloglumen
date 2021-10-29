<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TagController extends Controller
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
        $tag = Tag::select('id', 'name', 'slug')->get();
        return $this->successResponse($tag, 'All Tags');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:tags,name'
        ]);

        try {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->slug = Str::slug($request->name);
            $tag->save();

            return $this->successResponse($tag, 'Add Tag Successfully', 201);
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
            $tag = Tag::find($id);

            if (!$tag) return $this->errorResponse('Data not Found...', 404);

            $tag->name = $request->name;
            $tag->save();

            return $this->successResponse($tag, 'Successfully Edit Tag');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function destroy(Request $request)
    {
        $tag = Tag::find($request->id);

        if (!$tag) return $this->errorResponse('Data not Found...', 404);

        try {
            $tag->delete();
            return $this->successResponse(null, 'Delete Tag Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }
}
