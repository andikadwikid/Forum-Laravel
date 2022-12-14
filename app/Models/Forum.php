<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use Uuids, HasFactory;

    protected $table = 'forums';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->latest();
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function ImageForum()
    {
        return $this->hasMany(ImageForum::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('forum_title', 'LIKE', "%$search%")->orWhere('forum_content', 'LIKE', "%$search%");
    }
}
