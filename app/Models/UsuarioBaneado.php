<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UsuarioBaneado extends Model
{
    use HasFactory;

    protected $table = 'usuarios_baneados';
    protected $primaryKey = 'id_ban';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'motivo',
        'fecha_ban',
        'duracion_dias',
        'baneado_por',
        'estado',
    ];

    /**
     * Verifica si el baneo sigue activo o expiró.
     */
    public function estaActivo(): bool
    {
        if ($this->estado === 'expirado') {
            return false;
        }

        if (is_null($this->duracion_dias)) {
            // Baneo permanente
            return true;
        }

        $fechaExpira = Carbon::parse($this->fecha_ban)->addDays($this->duracion_dias);
        return Carbon::now()->lessThan($fechaExpira);
    }

    /**
     * Relación inversa con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
