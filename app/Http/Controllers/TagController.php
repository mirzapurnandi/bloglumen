<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
        $this->middleware('auth:api');
    }

    public function index()
    {
        $tag = Tag::select('id', 'name')->get();
        return response()->json([
            'status' => true,
            'message' => 'All Tags',
            'result' => $tag
        ], 200);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:tags,name'
        ]);

        try {
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->save();

            return response()->json([
                'status' => true,
                'message' => 'success add Tag',
                'result' => $tag
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
            $tag = Tag::find($id);

            if (!$tag) return response()->json([
                'status' => false,
                'message' => 'Data not Found...',
                'result' => null
            ], 404);

            $tag->name = $request->name;
            $tag->save();

            return response()->json([
                'status' => true,
                'message' => 'success edit Tag',
                'result' => $tag
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
        $tag = Tag::find($request->id);

        if (!$tag) return response()->json([
            'status' => false,
            'message' => 'Data not Found...',
            'result' => null
        ], 404);

        try {
            $tag->delete();
            return response()->json([
                'status' => true,
                'message' => 'Delete Tag successfully',
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
