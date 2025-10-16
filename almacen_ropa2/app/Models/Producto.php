<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'MV_productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio',
        'stock',
        'id_categoria',
        'imagen',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'id_producto', 'id_producto');
    }

    /**
     * Devuelve la URL de la imagen del producto.
     * Si el campo imagen es una URL externa, la devuelve tal cual.
     * Si es un nombre de archivo, devuelve asset('storage/products/...').
     */
    public function imagenUrl()
    {
        if (empty($this->imagen)) {
            return null;
        }

        // Si ya es una URL completa
        if (preg_match('#^https?://#i', $this->imagen)) {
            return $this->imagen;
        }

        return asset('storage/products/' . $this->imagen);
    }
}
