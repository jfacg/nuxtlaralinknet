<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'nick_name',
        'password',
        'empresa_id'
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

    public function rules($id = '', $method = '')
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            // 'nick_name' => ['string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'min:3', 'max:255', "unique:users,email,{$id},id"],
            'password' => ['required', 'string', 'min:6', 'max:16'],
        ];

        if ($method == 'PUT') {
            $rules['password'] = ['nullable', 'string', 'min:6', 'max:16'];
        }

        return $rules;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function empresa ()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id'); 
    }

    public function rolesAvailable($filter = null)
    {
        $roles = Role::whereNotIn('roles.id', function($query) {
            $query->select('role_user.role_id');
            $query->from('role_user');
            $query->whereRaw("role_user.user_id={$this->id}");
        })
        ->where(function ($queryFilter) use ($filter) {
            if ($filter)
                $queryFilter->where('roles.name', 'LIKE', "%{$filter}%");
        })->get();
        // ->paginate();

        return $roles;
    }
}
