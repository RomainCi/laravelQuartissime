<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comite;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'events';


    public function comites(): BelongsTo
    
    {
        return $this->belongsTo(Comite::class, "comite_id" , "id");
    }
}
