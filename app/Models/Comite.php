<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
///use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Association;


class Comite extends Model
{
    use HasFactory;
/*
    public function associations(): HasMany
    
    {
        return $this->hasMany(Association::class, "Comite_id" , "id");
    }
*/
    protected $guarded = ['id'];

    public function userComite(): BelongsTo
    {
        return $this->belongsTo(UserComite::class, 'user_comite_id', 'id');
    }
}
