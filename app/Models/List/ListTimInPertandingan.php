<?php

namespace App\Models\List;

use App\Models\Pertandingan;
use App\Models\Tim;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTimInPertandingan extends Model
{
    use HasFactory;

    protected $table = 'list_atlet_in_pertandingan';

    protected $guarded = [];

    public function pertandingan()
    {
        return $this->belongsTo(Pertandingan::class, 'list_atlet_in_team_id', 'id')->with('team', 'atlet');
    }

    public function team()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id')->with('user');
    }
}
