<?php

namespace App\Models;

use App\Models\Comite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Association extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'associations';

    public function comites(): BelongsTo

    {
        return $this->BelongsTo(Comite::class, "comite_id", "id");
    }
}
