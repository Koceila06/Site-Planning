<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'mdp',
        'type',
        'formation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mdp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    //protected $attributes=['type'=>''];

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->mdp;
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function isStudent()
    {
        return ($this->type == 'etudiant' || $this->type == 'admin');
    }

    public function isProf()
    {
        return ($this->type == 'enseignant' || $this->type == 'admin');
    }
    function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    function cours()
    {
        if ($this->isProf()) {
            return  $this->hasOne(Cours::class);
        }
        return $this->belongsToMany(Cours::class, 'cours_users');
    }
}
