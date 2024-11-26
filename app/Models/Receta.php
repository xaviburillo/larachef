<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'duracion',
        'ingredientes',
        'pasos',
        'imagen',
        'published_at',
        'rejected',
        'user_id',
    ];

    protected $casts = [
        'ingredientes' => 'array',
        'pasos' => 'array',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function valoraciones() : HasMany {
        return $this->hasMany(Valoracion::class);
    }

    public function categorias() : BelongsToMany {
        return $this->belongsToMany(Categoria::class);
    }   

    public function hasCategoria($categoriaId) : bool {

        foreach ($this->categorias as $categoria) {
            if ($categoria->id == $categoriaId) {
                return true;
            }
        }

        return false;
    }

    public function usuariosFavoritos() : BelongsToMany {
        return $this->belongsToMany(User::class, 'favoritos');
    }

    public function scopeNoPublicadasNoRechazadas(Builder $query) : Builder|QueryBuilder {
        return $query->where('published_at', '=', null)
                    ->where('rejected', '=', false);
    }

    public function scopePublicadas(Builder $query) : Builder|QueryBuilder {
        return $query->where('published_at', '!=', null);
    }

    public function scopeRechazadas(Builder $query) : Builder|QueryBuilder {
        return $query->where('rejected', '=', true);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null) : Builder|QueryBuilder {
        return $query->withAvg([
            'valoraciones' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating');
    }

    private function dateRangeFilter(Builder $query, $from = null, $to = null) {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } else if (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } else if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
