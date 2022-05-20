<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comite extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function userComite(): BelongsTo
    {
        return $this->belongsTo(UserComite::class, 'user_comite_id', 'id');
    }
}
