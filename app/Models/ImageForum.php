<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageForum extends Model
{
    use Uuids, HasFactory;

    protected $guarded = [];

    public function forums()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }
}
