<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'MV_categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre_categoria',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}