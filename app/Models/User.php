<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail 
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'url_facebook',
        'url_twitter',
        'url_linkedin',
        'url_email',
        'url_website',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() : BelongsToMany {
        return $this->belongsToMany(Role::class);
    }

    public function recetas() : HasMany {
        return $this->hasMany(Receta::class);
    }

    public function valoraciones() : HasMany {
        return $this->hasMany(Valoracion::class);
    }

    public function favoritas() : BelongsToMany {
        return $this->belongsToMany(Receta::class, 'favoritos');
    }

    public function isRecetaFavorita($recetaId) : bool {

        foreach ($this->favoritas as $favorita) {
            if ($favorita->id == $recetaId) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($roleNames) : bool {

        if (!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        foreach ($this->roles as $role) {
            if (in_array($role->role, $roleNames)) {
                return true;
            }
        }

        return false;
    }

    public function remainingRoles() {

        $actualRoles = $this->roles;
        $roles = Role::all()->except(5);
        
        return $roles->diff($actualRoles);
    }

    public function isRecetaOwner(Receta $receta) : bool {
        return $this->id == $receta->user_id;
    }

    public function isValoracionOwner(Valoracion $valoracion) : bool {
        return $this->id == $valoracion->user_id;
    }
}
