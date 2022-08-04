<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Uuids, HasFactory;

    protected $table = 'answers';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function forums()
    {
        return $this->belongsTo(Forum::class);
    }

    public function imagesAnswer()
    {
        return $this->hasMany(ImageAnswer::class);
    }
}
