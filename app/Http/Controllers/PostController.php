<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PostController extends Controller
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
        $post = Post::users()->get();
        return $this->successResponse($post, 'All Posts');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|unique:posts,title',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        try {
            $post = new Post;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->description = $request->description;
            $post->category_id = $request->category_id;
            $post->date = Carbon::now();
            $post->user_id = Auth::user()->id;
            $post->uuid = Str::uuid();
            $post->save();

            $post->tag()->sync($request->tags);

            return $this->successResponse($post, 'Add Blog Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required',
            'category_id' => 'required'
        ]);

        try {
            $post = Post::where('uuid', $id)->first();

            if (!$post) return $this->errorResponse('Data not Found...', 404);

            $post->title = $request->title;
            $post->description = $request->description;
            $post->category_id = $request->category_id;
            $post->save();

            $post->tag()->sync($request->tags);

            return $this->successResponse($post, 'Successfully Edit Post');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }

    public function destroy(Request $request)
    {
        $post = Post::where('uuid', $request->id)->first();

        if (!$post) return $this->errorResponse('Data not Found...', 404);

        try {
            $post->delete();
            return $this->successResponse(null, 'Delete Category Successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('failed', 409);
        }
    }
}
