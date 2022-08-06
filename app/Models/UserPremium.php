<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPremium extends Model
{
    use HasFactory;

    protected $table = 'user_premiums';

    protected $guard = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function premium()
    {
        return $this->belongsTo(Premium::class);
    }
}
