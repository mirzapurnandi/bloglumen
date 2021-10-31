<?php

namespace App\Http\Controllers;

use App\Interfaces\TagInterface;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tag;
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
        //$this->middleware('auth:api');
    }

    public function index()
    {
        return $this->tag->getData();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:tags,name'
        ]);

        return $this->tag->insertData($request);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        return $this->tag->updateData($request, $id);
    }

    public function destroy(Request $request)
    {
        return $this->tag->deleteData($request);
    }
}
