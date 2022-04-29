<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betsuper extends Model
{
    use HasFactory;

    protected $fillable = [
        'liga',
        'data',
        'hora',
        'minuto',
        'placar',
    ];

    public function verificarPlacar($placar, $tipo)
    {
        $naoAmbas = [   "0-0", "0-1", "0-2", "0-3", "0-4", "0-5", "0-6", 
                        "1-0", "2-0", "3-0", "4-0", "5-0", "6-0"];

        $naoOver = [   "0-0", "0-1", "0-2", "1-0", "1-1", "2-0"];
        $resultado = true;

        if ($tipo == 'ambas') {
            foreach ($naoAmbas as $value) {
                if ($placar == $value) {
                    return false;
                }
            }
            return true;
        }

        
    }
}
