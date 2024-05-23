<?php

namespace App\Models\List;

use App\Models\Atlet;
use App\Models\Kelas;
use App\Models\Tim;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTim extends Model
{
    use HasFactory;

    protected $table = 'list_tim';

    protected $guarded = [];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id');
    }

    public function atlet()
    {
        return $this->belongsTo(Atlet::class, 'atlet_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
