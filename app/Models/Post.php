<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'category_id', 'date', 'user_id', 'uuid'
    ];

    protected $table = 'posts';

    public function scopeUsers($query)
    {
        if (Auth::user()->level != 'admin') {
            return $query->where('user_id', Auth::user()->id);
        }
    }

    public function scopeResult($query)
    {
        $result = $query->addSelect([
            'category_name' => Category::select('name')
                ->whereColumn('category_id', 'categories.id')->limit(1)
        ]);
        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
}
