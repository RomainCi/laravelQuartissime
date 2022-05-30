<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'events';


    public function comites(): BelongsTo

    {
        return $this->BelongsTo(Comite::class, "comite_id" , "id");
    }
}
