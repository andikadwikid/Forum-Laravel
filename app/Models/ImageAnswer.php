<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageAnswer extends Model
{
    use Uuids, HasFactory;

    protected $guarded = [];

    // public function answers()
    // {
    //     return $this->belongsTo(Answer::class, 'answer_id');
    // }
}
