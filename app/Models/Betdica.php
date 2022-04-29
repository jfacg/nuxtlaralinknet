<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betdica extends Model
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
        'status',
    ];

    public function dicajogoe()
    {
        return $this->belongsTo(Bet::class, 'dicajogoe_id', 'id');
    }

    public function dicajogoc()
    {
        return $this->belongsTo(Bet::class, 'dicajogoc_id', 'id');
    }

    public function dicajogod()
    {
        return $this->belongsTo(Bet::class, 'dicajogod_id', 'id');
    }

    public function jogoe()
    {
        return $this->belongsTo(Bet::class, 'jogoe_id', 'id');
    }

    public function jogoc()
    {
        return $this->belongsTo(Bet::class, 'jogoc_id', 'id');
    }

    public function jogod()
    {
        return $this->belongsTo(Bet::class, 'jogod_id', 'id');
    }

   


}
