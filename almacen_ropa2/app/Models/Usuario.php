<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'MV_usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    /** Campos asignables */
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'rol',
        'contrasena',
    ];

    /** Campos ocultos */
    protected $hidden = [
        'contrasena',
    ];

    /** Relaciones */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }
}
