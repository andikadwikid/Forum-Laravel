<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    protected $table = 'premiums';

    protected $guard = [];

    public function user_premium()
    {
        return $this->hasOne(UserPremium::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
