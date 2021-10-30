<?php

namespace App\Http\Controllers;

use App\Interfaces\PostInterface;
use Illuminate\Http\Request;

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
        $status = $this->post->checkData();
        if ($status) return $status;

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
