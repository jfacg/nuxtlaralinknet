<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientixc extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'cliente';

    public function pesquisar($request)
    {
        $key_search = $request;

        return $this
            ->where('razao', 'LIKE', "%{$key_search}%")
            ->get();
    }

    public function city()
    {
        return $this->belongsTo(Cidade::class, 'cidade');
    }

    public function contracts()
    {
        return $this->hasMany(Contrato::class, 'id_cliente');
    }

    public function logins()
    {
        return $this->hasMany(Login::class, 'id_cliente');
    }
}
