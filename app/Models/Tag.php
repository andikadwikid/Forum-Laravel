<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Uuids, HasFactory;

    protected $table = 'tags';
    protected $guarded = [];

    public function forums()
    {
        return $this->belongsToMany(Forum::class);
    }
}
