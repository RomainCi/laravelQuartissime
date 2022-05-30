<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comite;
=======
use App\Models\Comite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> sali2

class Association extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = 'associations';

    public function comites(): BelongsTo
    
    {
        return $this->BelongsTo(Comite::class, "comite_id" , "id");
    }


    
    
=======
    protected $guarded = ['id'];
    protected $table = 'associations';

    public function comites(): BelongsTo

    {
        return $this->BelongsTo(Comite::class, "comite_id", "id");
    }
>>>>>>> sali2
}
