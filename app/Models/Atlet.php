<?php

namespace App\Models;

use App\Models\List\ListTim;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atlet extends Model
{
    use HasFactory;

    protected $table = 'atlet';

    protected $guarded = [];

    public function ListTim()
    {
        return $this->belongsTo(ListTim::class, 'id', 'atlet_id')->with('Tim');
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
