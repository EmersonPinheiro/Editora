<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $table = 'Usuario';
    protected $primaryKey = 'cod_usuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'Pessoa_cod_pessoa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pessoa()
    {
      return $this->belongsTo('App\Models\Pessoa', 'Pessoa_cod_pessoa');
    }

    public function usuario_propositor()
    {
      return $this->hasMany('App\Models\UsuarioPropositor', 'Usuario_cod_usuario');
    }

    public function usuario_parecerista()
    {
      return $this->hasMany('App\Models\UsuarioParecerista', 'Usuario_cod_usuario');
    }

    public function usuario_admin()
    {
      return $this->hasMany('App\Models\UsuarioAdmin', 'Usuario_cod_usuario');
    }




}
