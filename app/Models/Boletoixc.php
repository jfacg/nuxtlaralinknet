<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boletoixc extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'fn_areceber';

    protected $fillable = [
        'id_cliente',
    ];

    public function clientIxc()
    {
        return $this->belongsTo(Clientixc::class, 'id_cliente', 'id');
    }

    
}
