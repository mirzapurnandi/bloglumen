<?php

namespace App\Http\Controllers;

use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    protected $post;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        return $this->post->getData();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|unique:posts,title',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        return $this->post->insertData($request);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        return $this->post->updateData($request, $id);
    }

    public function destroy(Request $request)
    {
        return $this->post->deleteData($request);
    }
}
