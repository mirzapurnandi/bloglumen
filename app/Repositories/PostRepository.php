<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Interfaces\PostInterface;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getData()
    {
        $post = Post::with('category:id,name,slug', 'tag:id,name,slug')
            ->select('id', 'title', 'slug', 'description', 'category_id', 'date', 'user_id', 'uuid')
            ->users()
            ->get();
        return $this->successResponse($post, 'All Posts');
    }

    public function insertData(Request $request)
    {
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

    public function updateData(Request $request, $id)
    {
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

    public function deleteData(Request $request)
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
