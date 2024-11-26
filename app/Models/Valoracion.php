<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valoracion extends Model {
    
    use HasFactory, SoftDeletes;

    protected $table = 'valoraciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'texto',
        'rating',
        'user_id',
        'receta_id',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function receta() : BelongsTo {
        return $this->belongsTo(Receta::class);
    }
}
