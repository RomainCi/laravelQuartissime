<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifAssocPhotos extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function verifAssoc()
    {
        return $this->hasMany(VerifAssoc::class, 'id', 'assoc_verif_id');
    }
}
