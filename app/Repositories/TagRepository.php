<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Interfaces\TagInterface;

class TagRepository implements TagInterface
{
    // Use ResponseAPI Trait in this repository
    use ApiResponser;

    public function getData()
    {
        $tag = Tag::select('id', 'name', 'slug')->get();
        return $this->successResponse($tag, 'All Tags');
    }

    public function insertData(Request $request)
    {
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

    public function updateData(Request $request, $id)
    {
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

    public function deleteData(Request $request)
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
