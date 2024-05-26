<?php

namespace App\Models;

use App\Models\List\ListAtletInTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atlet extends Model
{
    use HasFactory;

    protected $table = 'atlet';

    protected $guarded = [];
}
