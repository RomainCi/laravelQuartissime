<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Association;


class Comite extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'comites';



    public function userComite(): BelongsTo
    {
        return $this->belongsTo(UserComite::class, 'user_comite_id', 'id');
    }


    public function associations(): HasMany

    {
        return $this->hasMany(Association::class, "comite_id", "id");
    }

    public function events(): HasMany

    {
        return $this->hasMany(Event::class, "comite_id" , "id");
    }
}
