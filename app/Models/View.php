<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function forums()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }
}
