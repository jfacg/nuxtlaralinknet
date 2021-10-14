<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanoIXC extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'vd_contratos';

    // public function search($request, $totalPage = 10)
    // {
    //     $key_search = $request->key_search;

    //     return $this
    //         ->where('razao', 'LIKE', "%{$key_search}%")
    //         ->paginate($totalPage);
    // }

    // public function city()
    // {
    //     return $this->belongsTo(Cidade::class, 'cidade');
    // }

    // public function contracts()
    // {
    //     return $this->hasMany(Contrato::class, 'id_cliente');
    // }

    // public function logins()
    // {
    //     return $this->hasMany(Login::class, 'id_cliente');
    // }
}
