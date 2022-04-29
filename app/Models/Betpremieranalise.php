<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betpremieranalise extends Model
{
    use HasFactory;

    protected $fillable = [
        'dicajogoe_id',
        'dicajogoc_id',
        'dicajogod_id',
        'jogoe_id',
        'jogoc_id',
        'jogod_id',
        'green',
        'tipo',
        'analise',
        'status',
    ];

    public function dicajogoe()
    {
        return $this->belongsTo(Betpremier::class, 'dicajogoe_id', 'id');
    }

    public function dicajogoc()
    {
        return $this->belongsTo(Betpremier::class, 'dicajogoc_id', 'id');
    }

    public function dicajogod()
    {
        return $this->belongsTo(Betpremier::class, 'dicajogod_id', 'id');
    }

    public function jogoe()
    {
        return $this->belongsTo(Betpremier::class, 'jogoe_id', 'id');
    }

    public function jogoc()
    {
        return $this->belongsTo(Betpremier::class, 'jogoc_id', 'id');
    }

    public function jogod()
    {
        return $this->belongsTo(Betpremier::class, 'jogod_id', 'id');
    }
}
