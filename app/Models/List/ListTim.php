<?php

namespace App\Models\List;

use App\Models\Kelas;
use App\Models\Tim;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTim extends Model
{
    use HasFactory;

    protected $table = 'list_tim';

    protected $guarded = [];

    public function Tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id');
    }

    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
