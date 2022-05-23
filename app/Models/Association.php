<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
///use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Comite;

class Association extends Model
{
    use HasFactory;
/*
    public function Comite(): BelongsTo
    {
        return $this->belongsTo(Comite::class)->where($id);
    }
    */
}
