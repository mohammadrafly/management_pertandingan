<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tim';

    protected $guarded = [];

    public function atlets()
    {
        return $this->hasMany(Atlet::class);
    }
}
