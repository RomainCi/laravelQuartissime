<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comite;

class Association extends Model
{
    use HasFactory;
    protected $table = 'associations';

    public function comites(): BelongsTo

    {
        return $this->BelongsTo(Comite::class, "comite_id", "id");
    }
}
