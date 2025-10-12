<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Asumo que la tabla mantiene el prefijo MV_ como las demás tablas del proyecto
    protected $table = 'MV_pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'total',
        'estado',
        'canal',
        'fecha_pedido',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_pedido' => 'datetime',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_pedido', 'id_pedido');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
