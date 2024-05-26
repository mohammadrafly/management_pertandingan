<?php

namespace App\Models\List;

use App\Models\Atlet;
use App\Models\Tim;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAtletInTeam extends Model
{
    use HasFactory;

    protected $table = 'list_atlet_in_team';

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id')->with('user');
    }

    public function atlet()
    {
        return $this->belongsTo(Atlet::class, 'atlet_id', 'id');
    }

    public function listAtletWithKelas()
{
    return $this->hasMany(ListAtletWithKelas::class, 'list_atlet_in_team_id');
}

}
