<?php

namespace App\Models\List;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAtletWithKelas extends Model
{
    use HasFactory;

    protected $table = 'list_atlet_with_kelas';

    protected $guarded = [];

    public function listAtletInTeam()
    {
        return $this->belongsTo(ListAtletInTeam::class, 'list_atlet_in_team_id')->with('team', 'atlet');
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
