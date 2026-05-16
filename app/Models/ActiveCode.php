<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActiveCode extends Model
{
    protected $guarded = [];
    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function returnUser()
    {
        DB::table('users')->where('mobile',$this->mobile)->first();
    }
}
